<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
require_once __DIR__ . '/../../includes/validacoes.php';

if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    header('Location: ' . BASE_URL . '/public/login.php');
    exit;
}

$erros = [];
$erro_sistema = "";

$idEncrypted = $_GET['id'] ?? null;
$id = aes_decrypt($idEncrypted);
if (!$id || !is_numeric($id)) { header('Location: lista.php'); exit; }
$id = (int) $id;

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $ligacao->prepare("SELECT * FROM localizacoes WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $loc = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$loc) { header('Location: lista.php'); exit; }
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edificio = ucwords(strtolower(trim($_POST["edificio"] ?? "")));
    $piso     = trim($_POST["piso"] ?? "");
    $servico  = ucwords(strtolower(trim($_POST["servico"] ?? "")));
    $sala     = trim($_POST["sala"] ?? "");

    /*
    if (empty($servico)) $erros[] = "O campo Serviço / Departamento é obrigatório.";
    */
    $erros = validar_obrigatorio($servico, 'Serviço / Departamento');

    if (empty($erros)) {
        try {
            $sql = "UPDATE localizacoes SET nome = :nome, descricao = :descricao, piso = :piso, ala = :ala, updated_at = NOW() WHERE id = :id";
            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':nome'      => $servico,
                ':descricao' => $sala,
                ':piso'      => $piso,
                ':ala'       => $edificio,
                ':id'        => $id,
            ]);
            header('Location: lista.php');
            exit;
        } catch (PDOException $err) {
            $erro_sistema = "Erro ao gravar os dados: " . $err->getMessage();
        }
    }
    $loc->ala      = $edificio;
    $loc->piso     = $piso;
    $loc->nome     = $servico;
    $loc->descricao = $sala;
}

$ligacao = null;
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

            <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
                <div class="d-flex justify-content-center">
                    <div class="card w-100 border-0 shadow-sm" style="max-width: 700px;">
                        <div class="card-body">
                            <h2 class="mb-4 fw-bold" style="color: #004f63;"><i class="fas fa-pen-to-square me-2"></i> Editar Localização</h2>
                            <hr>
                            <?php if (!empty($erros)): ?>
                                <div class="alert alert-danger">
                                    <strong><i class="fas fa-triangle-exclamation me-2"></i>Por favor corrija os seguintes erros:</strong>
                                    <ul class="mb-0 mt-2">
                                        <?php foreach ($erros as $erro): ?>
                                            <li><?= htmlspecialchars($erro) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($erro_sistema)): ?>
                                <div class="alert alert-danger">
                                    <strong><i class="fas fa-circle-xmark me-2"></i>Erro do sistema:</strong>
                                    <p class="mb-0 mt-1"><?= htmlspecialchars($erro_sistema) ?></p>
                                </div>
                            <?php endif; ?>
                            <form action="editar.php?id=<?= aes_encrypt($id) ?>" method="post" novalidate id="formEditar">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="edificio" class="form-label fw-semibold">Edifício</label>
                                        <input type="text" class="form-control" id="edificio" name="edificio" value="<?= htmlspecialchars($loc->ala ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="piso" class="form-label fw-semibold">Piso</label>
                                        <input type="text" class="form-control" id="piso" name="piso" value="<?= htmlspecialchars($loc->piso ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="servico" class="form-label fw-semibold">Serviço / Departamento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="servico" name="servico" value="<?= htmlspecialchars($loc->nome ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sala" class="form-label fw-semibold">Sala / Gabinete</label>
                                        <input type="text" class="form-control" id="sala" name="sala" value="<?= htmlspecialchars($loc->descricao ?? '') ?>">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="lista.php" class="btn btn-outline-secondary"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Alterações
                                    </button>
                                </div>
                                <div class="alert alert-danger mt-3 d-none" id="erroForm">
                                    <i class="fas fa-triangle-exclamation me-2"></i> O campo Serviço é obrigatório.
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script>
    document.getElementById('formEditar').addEventListener('submit', function (e) {
        const servico = document.getElementById('servico');
        if (!servico.value.trim()) {
            e.preventDefault();
            servico.classList.add('is-invalid');
            document.getElementById('erroForm').classList.remove('d-none');
        } else {
            servico.classList.remove('is-invalid');
            document.getElementById('erroForm').classList.add('d-none');
        }
    });
</script>

<?php include '../../includes/footer.php'; ?>
