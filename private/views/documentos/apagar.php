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
        "SELECT d.tipo, d.titulo, d.data_documento, e.codigo AS eq_codigo, e.designacao AS eq_designacao
         FROM documentos d
         LEFT JOIN equipamentos e ON d.id_equipamento = e.id
         WHERE d.id = :id AND d.deleted_at IS NULL LIMIT 1"
    );
    $stmt->execute([':id' => $id]);
    $doc = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$doc) { header('Location: lista.php'); exit; }
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
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
                <p class="text-muted">Tem a certeza que pretende remover o seguinte documento?</p>
                <p class="text-muted small">O registo ficará desativado e deixará de aparecer nas listagens.</p>

                <div class="info-item">
                    <strong>Tipo:</strong> <?= htmlspecialchars($doc->tipo) ?><br>
                    <strong>Nome:</strong> <?= htmlspecialchars($doc->titulo) ?><br>
                    <strong>Equipamento:</strong> <?= htmlspecialchars($doc->eq_codigo ?? '—') ?> — <?= htmlspecialchars($doc->eq_designacao ?? '—') ?><br>
                    <strong>Data:</strong> <?= $doc->data_documento ? date('d/m/Y', strtotime($doc->data_documento)) : '—' ?>
                </div>

                <div class="botoes mt-4">
                    <a href="lista.php" class="botao-cancelar"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                    <a href="confirmar_apagar.php?id=<?= urlencode($idEncrypted) ?>" class="botao-confirmar">
                        <i class="fas fa-trash-can me-1"></i> Confirmar Remoção
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
