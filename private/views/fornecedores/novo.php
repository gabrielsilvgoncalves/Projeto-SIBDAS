<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
require_once __DIR__ . '/../../includes/validacoes.php';

$erros = [];
$erro_sistema = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recolher dados
    $nome            = $_POST["nome"] ?? "";
    $nif             = $_POST["nif"] ?? "";
    $tipo            = $_POST["tipo"] ?? "";
    $morada          = $_POST["morada"] ?? "";
    $telefone        = $_POST["telefone"] ?? "";
    $email           = $_POST["email"] ?? "";
    $website         = $_POST["website"] ?? "";
    $pessoa_contacto = $_POST["pessoa_contacto"] ?? "";
    $tel_contacto    = $_POST["tel_contacto"] ?? "";
    $observacoes     = $_POST["observacoes"] ?? "";

    // 2. Trim
    $nome     = trim($nome);
    $nif      = trim($nif);
    $telefone = trim($telefone);
    $email    = trim($email);

    // 3. Validar
    /*
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
    if (empty($tipo)) $erros[] = "O campo Tipo de Fornecedor é obrigatório.";
    if (!empty($telefone) && !preg_match('/^9\d{8}$/', $telefone)) {
        $erros[] = "O número de telefone não é válido. Deve começar por 9 e ter 9 dígitos.";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O endereço de email não é válido.";
    }
    */
    $erros = validar_nome($nome);
    $erros = array_merge($erros, validar_nif($nif));
    $erros = array_merge($erros, validar_obrigatorio($tipo, 'Tipo de Fornecedor'));
    $erros = array_merge($erros, validar_telefone_opcional($telefone));
    $erros = array_merge($erros, validar_email_opcional($email));

    // 4. Depuração: mostrar erros recolhidos
    /*
    echo "<pre>"; print_r($erros); echo "</pre>";
    */

    // 5. Normalizar entrada
    $nome            = ucwords(strtolower($nome));
    $email           = strtolower($email);
    $pessoa_contacto = ucwords(strtolower($pessoa_contacto));

    /*
    echo "<p><strong>Dados normalizados:</strong></p>";
    echo "<ul>";
    echo "<li>Nome: $nome</li>";
    echo "<li>Email: $email</li>";
    echo "<li>Pessoa de Contacto: $pessoa_contacto</li>";
    echo "</ul>";
    */

    // 6. Gravar na base de dados
    if (empty($erros)) {
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );
            $sql = "INSERT INTO fornecedores (nome, nif, email, telefone, morada, website, created_at, updated_at)
                VALUES (:nome, :nif, :email, :telefone, :morada, :website, NOW(), NOW())";
            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':nome'     => $nome,
                ':nif'      => $nif,
                ':email'    => $email,
                ':telefone' => $telefone,
                ':morada'   => $morada,
                ':website'  => $website,
            ]);
            header('Location: lista.php');
            exit;
        } catch (PDOException $err) {
            $erro_sistema = "Erro ao gravar os dados: " . $err->getMessage();
        }
        $ligacao = null;
    }
}
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
                            <h2 class="mb-4 fw-bold" style="color: #004f63;">
                                <i class="fas fa-plus me-2"></i> Inserir Novo Fornecedor
                            </h2>
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
                            <form action="#" method="post" novalidate id="formFornecedor">

                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-building me-2"></i> Dados da Empresa</h5>
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label for="nome" class="form-label fw-semibold">Nome da Empresa <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo da empresa" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="nif" class="form-label fw-semibold">NIF <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nif" name="nif" placeholder="ex: 500123456" value="<?= htmlspecialchars($_POST['nif'] ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="tipo" class="form-label fw-semibold">Tipo de Fornecedor <span class="text-danger">*</span></label>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option value="">-- Selecionar --</option>
                                            <option>Fabricante</option>
                                            <option>Distribuidor / Fornecedor comercial</option>
                                            <option>Empresa de assistência técnica</option>
                                            <option>Fornecedor de consumíveis</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="morada" class="form-label fw-semibold">Morada</label>
                                        <input type="text" class="form-control" id="morada" name="morada" placeholder="Rua, nº porta, código-postal, cidade" value="<?= htmlspecialchars($_POST['morada'] ?? '') ?>">
                                    </div>
                                </div>

                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-phone me-2"></i> Contactos</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="telefone" class="form-label fw-semibold">Telefone</label>
                                        <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="9XXXXXXXX" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="email@empresa.pt" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="website" class="form-label fw-semibold">Website</label>
                                        <input type="url" class="form-control" id="website" name="website" placeholder="https://www.empresa.pt">
                                    </div>
                                </div>

                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-user-tie me-2"></i> Pessoa de Contacto</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="pessoa_contacto" class="form-label fw-semibold">Nome</label>
                                        <input type="text" class="form-control" id="pessoa_contacto" name="pessoa_contacto" placeholder="Nome do responsável" value="<?= htmlspecialchars($_POST['pessoa_contacto'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tel_contacto" class="form-label fw-semibold">Telefone Direto</label>
                                        <input type="tel" class="form-control" id="tel_contacto" name="tel_contacto" placeholder="+351 9xx xxx xxx">
                                    </div>
                                </div>

                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-note-sticky me-2"></i> Observações</h5>
                                <div class="mb-4">
                                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3"
                                        placeholder="Informações adicionais sobre o fornecedor..."><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="lista.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-xmark me-1"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Fornecedor
                                    </button>
                                </div>

                                <div class="alert alert-danger mt-3 d-none" id="erroForm">
                                    <i class="fas fa-triangle-exclamation me-2"></i> Preencha os campos obrigatórios: Nome, NIF e Tipo.
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script>
        document.getElementById('formFornecedor').addEventListener('submit', function (e) {
            const obrigatorios = ['nome', 'nif', 'tipo'];
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
