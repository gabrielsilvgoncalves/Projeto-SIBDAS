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
        "SELECT g.*, e.id AS eq_id, e.codigo AS eq_codigo, e.designacao AS eq_designacao, e.marca AS eq_marca, e.modelo AS eq_modelo
         FROM garantias g
         LEFT JOIN equipamentos e ON g.id_equipamento = e.id
         WHERE g.id = :id LIMIT 1"
    );
    $stmt->execute([':id' => $id]);
    $g = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$g) { header('Location: lista.php'); exit; }
    $ligacao = null;
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}

$hoje = date('Y-m-d');
$diasFim = (strtotime($g->data_fim) - time()) / 86400;
if ($g->data_fim < $hoje) {
    $estadoBadge = '<span class="badge bg-danger">Expirada</span>';
    $fimClass = 'text-danger fw-semibold';
} elseif ($diasFim <= 30) {
    $estadoBadge = '<span class="badge bg-warning text-dark">A expirar</span>';
    $fimClass = 'text-warning fw-semibold';
} else {
    $estadoBadge = '<span class="badge bg-success">Válida</span>';
    $fimClass = '';
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
                    <i class="fas fa-shield-alt me-2"></i> Detalhes da Garantia
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
                        <h4 class="fw-bold mb-1" style="color: #004f63;"><?= htmlspecialchars($g->eq_designacao ?? '—') ?></h4>
                        <p class="text-muted mb-0">Código: <code><?= htmlspecialchars($g->eq_codigo ?? '—') ?></code></p>
                    </div>
                    <?= $estadoBadge ?>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                            <i class="fas fa-calendar-alt me-2"></i> Período da Garantia
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Início</td><td><?= date('d/m/Y', strtotime($g->data_inicio)) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Fim</td><td class="<?= $fimClass ?>"><?= date('d/m/Y', strtotime($g->data_fim)) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Tipo</td><td><?= htmlspecialchars($g->tipo) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Estado</td><td><?= $estadoBadge ?></td></tr>
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
                            <?php if ($g->eq_id): ?>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td class="text-muted fw-semibold" style="width:45%">Código</td><td><code><?= htmlspecialchars($g->eq_codigo) ?></code></td></tr>
                                    <tr><td class="text-muted fw-semibold">Designação</td><td><?= htmlspecialchars($g->eq_designacao) ?></td></tr>
                                    <tr><td class="text-muted fw-semibold">Marca / Modelo</td><td><?= htmlspecialchars($g->eq_marca) ?> / <?= htmlspecialchars($g->eq_modelo) ?></td></tr>
                                </table>
                                <a href="../equipamentos/detalhes.php?id=<?= aes_encrypt($g->eq_id) ?>" class="btn btn-sm btn-outline-secondary mt-2">
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
                    <i class="fas fa-pen-to-square me-1"></i> Editar Garantia
                </a>
                <a href="lista.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Voltar à lista
                </a>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
