<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$erros = [];
$erro_sistema = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { header('Location: lista.php'); exit; }

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $stmt = $ligacao->prepare("SELECT * FROM fornecedores WHERE id = :id AND deleted_at IS NULL LIMIT 1");
    $stmt->execute([':id' => $id]);
    $f = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$f) { header('Location: lista.php'); exit; }
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome     = ucwords(strtolower(trim($_POST["nome"] ?? "")));
    $nif      = trim($_POST["nif"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $email    = strtolower(trim($_POST["email"] ?? ""));
    $morada   = trim($_POST["morada"] ?? "");
    $website  = trim($_POST["website"] ?? "");

    if (empty($nome)) {
        $erros[] = "O campo Nome é obrigatório.";
    } elseif (preg_match('/\d/', $nome)) {
        $erros[] = "O campo Nome não pode conter números.";
    }
    if (empty($nif)) {
        $erros[] = "O campo NIF é obrigatório.";
    } elseif (!preg_match('/^\d{9}$/', $nif)) {
        $erros[] = "O NIF deve ter exatamente 9 dígitos numéricos.";
    }
    if (!empty($telefone) && !preg_match('/^9\d{8}$/', $telefone)) {
        $erros[] = "O número de telefone não é válido. Deve começar por 9 e ter 9 dígitos.";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O endereço de email não é válido.";
    }

    if (empty($erros)) {
        try {
            $sql = "UPDATE fornecedores SET nome = :nome, nif = :nif, email = :email, telefone = :telefone, morada = :morada, website = :website, updated_at = NOW() WHERE id = :id";
            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':nome'     => $nome,
                ':nif'      => $nif,
                ':email'    => $email,
                ':telefone' => $telefone,
                ':morada'   => $morada,
                ':website'  => $website,
                ':id'       => $id,
            ]);
            header('Location: lista.php');
            exit;
        } catch (PDOException $err) {
            $erro_sistema = "Erro ao gravar os dados: " . $err->getMessage();
        }
    }
    $f->nome     = $nome;
    $f->nif      = $nif;
    $f->email    = $email;
    $f->telefone = $telefone;
    $f->morada   = $morada;
    $f->website  = $website;
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
                    <div class="card w-100 border-0 shadow-sm" style="max-width: 900px;">
                        <div class="card-body">
                            <h2 class="mb-4 fw-bold" style="color: #004f63;"><i class="fas fa-pen-to-square me-2"></i> Editar Fornecedor</h2>
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
                            <form action="editar.php?id=<?= $id ?>" method="post" novalidate id="formEditar">
                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-building me-2"></i> Dados da Empresa</h5>
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label for="nome" class="form-label fw-semibold">Nome da Empresa <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($f->nome ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="nif" class="form-label fw-semibold">NIF <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nif" name="nif" value="<?= htmlspecialchars($f->nif ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="morada" class="form-label fw-semibold">Morada</label>
                                    <input type="text" class="form-control" id="morada" name="morada" value="<?= htmlspecialchars($f->morada ?? '') ?>">
                                </div>
                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-phone me-2"></i> Contactos</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="telefone" class="form-label fw-semibold">Telefone</label>
                                        <input type="tel" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($f->telefone ?? '') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($f->email ?? '') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="website" class="form-label fw-semibold">Website</label>
                                        <input type="url" class="form-control" id="website" name="website" value="<?= htmlspecialchars($f->website ?? '') ?>">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="lista.php" class="btn btn-outline-secondary"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Alterações
                                    </button>
                                </div>
                                <div class="alert alert-danger mt-3 d-none" id="erroForm">
                                    <i class="fas fa-triangle-exclamation me-2"></i> Preencha os campos obrigatórios.
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
        const obrigatorios = ['nome', 'nif'];
        let valido = true;
        obrigatorios.forEach(function (id) {
            const campo = document.getElementById(id);
            if (!campo.value.trim()) { campo.classList.add('is-invalid'); valido = false; }
            else { campo.classList.remove('is-invalid'); }
        });
        if (!valido) {
            e.preventDefault();
            document.getElementById('erroForm').classList.remove('d-none');
        } else {
            document.getElementById('erroForm').classList.add('d-none');
        }
    });
</script>

<?php include '../../includes/footer.php'; ?>
