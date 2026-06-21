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
    $stmt = $ligacao->prepare("SELECT * FROM fornecedores WHERE id = :id AND deleted_at IS NULL LIMIT 1");
    $stmt->execute([':id' => $id]);
    $f = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$f) { header('Location: lista.php'); exit; }
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
                <h2 class="mb-0 fw-bold" style="color: #004f63;"><i class="fas fa-truck me-2"></i> Ficha do Fornecedor</h2>
                <div class="d-flex gap-2">
                    <a href="editar.php?id=<?= aes_encrypt($id) ?>" class="btn btn-warning btn-sm fw-semibold"><i class="fas fa-pen-to-square me-1"></i> Editar</a>
                    <a href="lista.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Voltar</a>
                </div>
            </div>
            <hr>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #004f63;"><?= htmlspecialchars($f->nome) ?></h4>
                        <p class="text-muted mb-0">NIF: <?= htmlspecialchars($f->nif ?? '—') ?></p>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold text-white" style="background-color: #004f63;"><i class="fas fa-building me-2"></i> Dados da Empresa</div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:40%">Nome</td><td><?= htmlspecialchars($f->nome) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">NIF</td><td><?= htmlspecialchars($f->nif ?? '—') ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Morada</td><td><?= htmlspecialchars($f->morada ?? '—') ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Website</td><td><?= $f->website ? '<a href="'.htmlspecialchars($f->website).'" target="_blank">'.htmlspecialchars($f->website).'</a>' : '—' ?></td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold text-white" style="background-color: #004f63;"><i class="fas fa-phone me-2"></i> Contactos</div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:40%">Telefone</td><td><?= htmlspecialchars($f->telefone ?? '—') ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Email</td><td><?= $f->email ? '<a href="mailto:'.htmlspecialchars($f->email).'">'.htmlspecialchars($f->email).'</a>' : '—' ?></td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="editar.php?id=<?= aes_encrypt($id) ?>" class="btn btn-warning fw-semibold"><i class="fas fa-pen-to-square me-1"></i> Editar</a>
                <a href="lista.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Voltar</a>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
