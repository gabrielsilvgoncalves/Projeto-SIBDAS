<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$idEncrypted = $_GET['id'] ?? null;
$id = aes_decrypt($idEncrypted);
if (!$id || !is_numeric($id)) { header('Location: lista.php'); exit; }
$id = (int) $id;

try {
    $ligacao = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DATABASE.";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $ligacao->prepare("SELECT nome, ala, piso, descricao FROM localizacoes WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $loc = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$loc) { header('Location: lista.php'); exit; }
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['confirmar'] ?? '') === '1') {
    try {
        $stmt = $ligacao->prepare("DELETE FROM localizacoes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $ligacao = null;
        header('Location: lista.php');
        exit;
    } catch (PDOException $err) {
        die("Erro ao remover: " . $err->getMessage());
    }
}

$ligacao = null;
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4 d-flex align-items-start justify-content-center" style="background-color: #f2f2f2;">
            <div class="caixa-apagar">
                <div class="icone-alerta"><i class="fas fa-triangle-exclamation"></i></div>
                <h4 class="fw-bold mb-2">Confirmar Remoção</h4>
                <p class="text-muted">Tem a certeza que pretende remover esta localização?</p>
                <p class="text-muted small">Os equipamentos associados ficarão sem localização atribuída.</p>

                <div class="info-item">
                    <strong>Edifício:</strong> <?= htmlspecialchars($loc->ala ?? '—') ?><br>
                    <strong>Piso:</strong> <?= htmlspecialchars($loc->piso ?? '—') ?><br>
                    <strong>Serviço:</strong> <?= htmlspecialchars($loc->nome) ?><br>
                    <strong>Sala:</strong> <?= htmlspecialchars($loc->descricao ?? '—') ?>
                </div>

                <div class="botoes mt-4">
                    <a href="lista.php" class="botao-cancelar"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                    <form method="post" action="apagar.php?id=<?= aes_encrypt($id) ?>" class="d-inline">
                        <input type="hidden" name="confirmar" value="1">
                        <button type="submit" class="botao-confirmar">
                            <i class="fas fa-trash-can me-1"></i> Confirmar
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
