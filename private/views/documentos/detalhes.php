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
        "SELECT d.*, e.id AS eq_id, e.codigo AS eq_codigo, e.designacao AS eq_designacao, e.marca AS eq_marca, e.modelo AS eq_modelo
         FROM documentos d
         LEFT JOIN equipamentos e ON d.id_equipamento = e.id
         WHERE d.id = :id AND d.deleted_at IS NULL LIMIT 1"
    );
    $stmt->execute([':id' => $id]);
    $doc = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$doc) { header('Location: lista.php'); exit; }
    $ligacao = null;
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 fw-bold" style="color: #004f63;">
                    <i class="fas fa-file-medical me-2"></i> Detalhes do Documento
                </h2>
                <div class="d-flex gap-2">
                    <a href="editar.php?id=<?= aes_encrypt($id) ?>" class="btn btn-warning btn-sm fw-semibold">
                        <i class="fas fa-pen-to-square me-1"></i> Editar
                    </a>
                    <a href="lista.php" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </div>
            <hr>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #004f63;"><?= htmlspecialchars($doc->titulo) ?></h4>
                        <p class="text-muted mb-0">Equipamento:
                            <?php if ($doc->eq_id): ?>
                                <a href="../equipamentos/detalhes.php?id=<?= aes_encrypt($doc->eq_id) ?>">
                                    <?= htmlspecialchars($doc->eq_codigo) ?> — <?= htmlspecialchars($doc->eq_designacao) ?>
                                </a>
                            <?php else: ?>—<?php endif; ?>
                        </p>
                    </div>
                    <span class="badge bg-info text-dark fs-6"><?= htmlspecialchars($doc->tipo) ?></span>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                            <i class="fas fa-tag me-2"></i> Informações do Documento
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Tipo</td><td><span class="badge bg-info text-dark"><?= htmlspecialchars($doc->tipo) ?></span></td></tr>
                                <tr><td class="text-muted fw-semibold">Nome</td><td><?= htmlspecialchars($doc->titulo) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Data do Doc.</td><td><?= $doc->data_documento ? date('d/m/Y', strtotime($doc->data_documento)) : '—' ?></td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                            <i class="fas fa-stethoscope me-2"></i> Equipamento Associado
                        </div>
                        <div class="card-body">
                            <?php if ($doc->eq_id): ?>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td class="text-muted fw-semibold" style="width:45%">Código</td><td><code><?= htmlspecialchars($doc->eq_codigo) ?></code></td></tr>
                                    <tr><td class="text-muted fw-semibold">Designação</td><td><?= htmlspecialchars($doc->eq_designacao) ?></td></tr>
                                    <tr><td class="text-muted fw-semibold">Marca / Modelo</td><td><?= htmlspecialchars($doc->eq_marca) ?> / <?= htmlspecialchars($doc->eq_modelo) ?></td></tr>
                                </table>
                                <a href="../equipamentos/detalhes.php?id=<?= aes_encrypt($doc->eq_id) ?>" class="btn btn-sm btn-outline-secondary mt-2">
                                    <i class="fas fa-arrow-up-right-from-square me-1"></i> Ver equipamento
                                </a>
                            <?php else: ?>
                                <p class="text-muted mb-0">Equipamento não associado.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="editar.php?id=<?= aes_encrypt($id) ?>" class="btn btn-warning fw-semibold">
                    <i class="fas fa-pen-to-square me-1"></i> Editar Documento
                </a>
                <a href="lista.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Voltar à lista
                </a>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
