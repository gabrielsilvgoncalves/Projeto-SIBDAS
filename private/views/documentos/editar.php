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
    $stmt = $ligacao->prepare(
        "SELECT d.*, e.codigo AS eq_codigo, e.designacao AS eq_designacao
         FROM documentos d
         LEFT JOIN equipamentos e ON d.id_equipamento = e.id
         WHERE d.id = :id AND d.deleted_at IS NULL
         LIMIT 1"
    );
    $stmt->execute([':id' => $id]);
    $doc = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$doc) { header('Location: lista.php'); exit; }
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo     = $_POST["tipo"] ?? "";
    $nome_doc = ucwords(strtolower(trim($_POST["nome_doc"] ?? "")));
    $data_doc = $_POST["data_doc"] ?? "";

    $tiposMap = [
        'Manual de utilizador'       => 'Manual',
        'Manual de serviço'          => 'Manual',
        'Certificado de calibração'  => 'Certificado de calibração',
        'Contrato de manutenção'     => 'Contrato',
        'Fatura / Guia de aquisição' => 'Outro',
        'Declaração de conformidade' => 'Outro',
        'Relatório técnico'          => 'Relatório técnico',
    ];
    $tipo_db = $tiposMap[$tipo] ?? 'Outro';

    if (empty($tipo))     $erros[] = "O campo Tipo de Documento é obrigatório.";
    if (empty($nome_doc)) $erros[] = "O campo Nome do Documento é obrigatório.";
    if (!empty($data_doc)) {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_doc)) {
            $erros[] = "Formato de data inválido. Use AAAA-MM-DD.";
        } else {
            $p = explode('-', $data_doc);
            if (!checkdate((int)$p[1], (int)$p[2], (int)$p[0])) $erros[] = "Data do documento inválida.";
        }
    }

    if (empty($erros)) {
        try {
            $sql = "UPDATE documentos SET tipo = :tipo, titulo = :titulo, data_documento = :data_documento, updated_at = NOW() WHERE id = :id";
            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':tipo'           => $tipo_db,
                ':titulo'         => $nome_doc,
                ':data_documento' => !empty($data_doc) ? $data_doc : null,
                ':id'             => $id,
            ]);
            header('Location: lista.php');
            exit;
        } catch (PDOException $err) {
            $erro_sistema = "Erro ao gravar os dados: " . $err->getMessage();
        }
    }
    $doc->tipo           = $tipo_db;
    $doc->titulo         = $nome_doc;
    $doc->data_documento = $data_doc;
}

$ligacao = null;

$tiposReverso = [
    'Manual'                    => 'Manual de utilizador',
    'Certificado de calibração' => 'Certificado de calibração',
    'Contrato'                  => 'Contrato de manutenção',
    'Relatório técnico'         => 'Relatório técnico',
    'Outro'                     => 'Fatura / Guia de aquisição',
];
$tipo_form = $tiposReverso[$doc->tipo] ?? '';
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

            <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
                <div class="d-flex justify-content-center">
                    <div class="card w-100 border-0 shadow-sm" style="max-width: 800px;">
                        <div class="card-body">
                            <h2 class="mb-4 fw-bold" style="color: #004f63;"><i class="fas fa-pen-to-square me-2"></i> Editar Documento</h2>
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
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tipo" class="form-label fw-semibold">Tipo de Documento <span class="text-danger">*</span></label>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option value="">-- Selecionar --</option>
                                            <?php foreach (['Manual de utilizador','Manual de serviço','Certificado de calibração','Contrato de manutenção','Fatura / Guia de aquisição','Declaração de conformidade','Relatório técnico'] as $op): ?>
                                                <option <?= $tipo_form === $op ? 'selected' : '' ?>><?= $op ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nome_doc" class="form-label fw-semibold">Nome do Documento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome_doc" name="nome_doc" value="<?= htmlspecialchars($doc->titulo ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Equipamento Associado</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars(($doc->eq_codigo ?? '') . ' — ' . ($doc->eq_designacao ?? '')) ?>" disabled>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="data_doc" class="form-label fw-semibold">Data do Documento</label>
                                        <input type="text" class="form-control" id="data_doc" name="data_doc" placeholder="AAAA-MM-DD" value="<?= htmlspecialchars($doc->data_documento ?? '') ?>">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4">
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
        const obrigatorios = ['tipo', 'nome_doc'];
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

<script>
    flatpickr("#data_doc", { dateFormat: "Y-m-d" });
</script>

<?php include '../../includes/footer.php'; ?>
