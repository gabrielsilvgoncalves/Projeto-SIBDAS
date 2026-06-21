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
    $stmt = $ligacao->prepare(
        "SELECT g.tipo, g.data_inicio, g.data_fim, e.codigo AS eq_codigo, e.designacao AS eq_designacao
         FROM garantias g
         LEFT JOIN equipamentos e ON g.id_equipamento = e.id
         WHERE g.id = :id LIMIT 1"
    );
    $stmt->execute([':id' => $id]);
    $gar = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$gar) { header('Location: lista.php'); exit; }
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['confirmar'] ?? '') === '1') {
    try {
        $stmt = $ligacao->prepare("DELETE FROM garantias WHERE id = :id");
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
                <p class="text-muted">Tem a certeza que pretende remover o seguinte registo de garantia?</p>
                <p class="text-muted small">Esta ação é irreversível.</p>

                <div class="info-item">
                    <strong>Equipamento:</strong> <?= htmlspecialchars($gar->eq_designacao ?? '—') ?><br>
                    <strong>Código:</strong> <?= htmlspecialchars($gar->eq_codigo ?? '—') ?><br>
                    <strong>Período:</strong> <?= date('d/m/Y', strtotime($gar->data_inicio)) ?> — <?= date('d/m/Y', strtotime($gar->data_fim)) ?><br>
                    <strong>Tipo:</strong> <?= htmlspecialchars($gar->tipo) ?>
                </div>

                <div class="botoes mt-4">
                    <a href="lista.php" class="botao-cancelar"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                    <form method="post" action="apagar.php?id=<?= aes_encrypt($id) ?>" class="d-inline">
                        <input type="hidden" name="confirmar" value="1">
                        <button type="submit" class="botao-confirmar">
                            <i class="fas fa-trash-can me-1"></i> Confirmar Remoção
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
