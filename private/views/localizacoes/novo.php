<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$erros = [];
$erro_sistema = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recolher dados
    $edificio = $_POST["edificio"] ?? "";
    $piso     = $_POST["piso"] ?? "";
    $servico  = $_POST["servico"] ?? "";
    $sala     = $_POST["sala"] ?? "";

    // 2. Trim
    $servico = trim($servico);

    // 3. Validar
    if (empty($servico)) $erros[] = "O campo Serviço / Departamento é obrigatório.";

    // 4. Depuração: mostrar erros recolhidos
    /*
    echo "<pre>"; print_r($erros); echo "</pre>";
    */

    // 5. Normalizar entrada
    $servico  = ucwords(strtolower($servico));
    $edificio = ucwords(strtolower($edificio));

    /*
    echo "<p><strong>Dados normalizados:</strong></p>";
    echo "<ul>";
    echo "<li>Edifício: $edificio</li>";
    echo "<li>Serviço: $servico</li>";
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
            $sql = "INSERT INTO localizacoes (nome, descricao, piso, ala, created_at, updated_at)
                VALUES (:nome, :descricao, :piso, :ala, NOW(), NOW())";
            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':nome'      => $servico,
                ':descricao' => $sala,
                ':piso'      => $piso,
                ':ala'       => $edificio,
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
                    <div class="card w-100 border-0 shadow-sm" style="max-width: 700px;">
                        <div class="card-body">
                            <h2 class="mb-4 fw-bold" style="color: #004f63;"><i class="fas fa-plus me-2"></i> Nova Localização</h2>
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
                            <form action="#" method="post" novalidate id="formLocalizacao">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="edificio" class="form-label fw-semibold">Edifício</label>
                                        <input type="text" class="form-control" id="edificio" name="edificio" placeholder="ex: Edifício Principal" value="<?= htmlspecialchars($_POST['edificio'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="piso" class="form-label fw-semibold">Piso</label>
                                        <input type="text" class="form-control" id="piso" name="piso" placeholder="ex: Piso 2" value="<?= htmlspecialchars($_POST['piso'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="servico" class="form-label fw-semibold">Serviço / Departamento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="servico" name="servico" placeholder="ex: Urgência Geral" value="<?= htmlspecialchars($_POST['servico'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sala" class="form-label fw-semibold">Sala / Gabinete</label>
                                        <input type="text" class="form-control" id="sala" name="sala" placeholder="ex: Sala 203" value="<?= htmlspecialchars($_POST['sala'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="lista.php" class="btn btn-outline-secondary"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar
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
        document.getElementById('formLocalizacao').addEventListener('submit', function (e) {
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
