<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

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
    $stmt = $ligacao->prepare(
        "SELECT g.*, e.codigo AS eq_codigo, e.designacao AS eq_designacao
         FROM garantias g
         LEFT JOIN equipamentos e ON g.id_equipamento = e.id
         WHERE g.id = :id
         LIMIT 1"
    );
    $stmt->execute([':id' => $id]);
    $g = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$g) { header('Location: lista.php'); exit; }
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_inicio = $_POST["data_inicio"] ?? "";
    $data_fim    = $_POST["data_fim"] ?? "";
    $tem_contrato = $_POST["tem_contrato"] ?? "nao";

    if (empty($data_inicio)) {
        $erros[] = "A Data de Início é obrigatória.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_inicio)) {
        $erros[] = "Formato de data de início inválido.";
    } else {
        $p = explode('-', $data_inicio);
        if (!checkdate((int)$p[1], (int)$p[2], (int)$p[0])) $erros[] = "Data de início inválida.";
    }
    if (empty($data_fim)) {
        $erros[] = "A Data de Fim é obrigatória.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_fim)) {
        $erros[] = "Formato de data de fim inválido.";
    } else {
        $p = explode('-', $data_fim);
        if (!checkdate((int)$p[1], (int)$p[2], (int)$p[0])) {
            $erros[] = "Data de fim inválida.";
        } elseif (!empty($data_inicio) && $data_fim <= $data_inicio) {
            $erros[] = "A Data de Fim deve ser posterior à Data de Início.";
        }
    }

    if (empty($erros)) {
        $tipo_garantia = ($tem_contrato === 'sim') ? 'Contrato de manutenção' : 'Fabricante';
        try {
            $sql = "UPDATE garantias SET tipo = :tipo, data_inicio = :data_inicio, data_fim = :data_fim, updated_at = NOW() WHERE id = :id";
            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':tipo'        => $tipo_garantia,
                ':data_inicio' => $data_inicio,
                ':data_fim'    => $data_fim,
                ':id'          => $id,
            ]);
            header('Location: lista.php');
            exit;
        } catch (PDOException $err) {
            $erro_sistema = "Erro ao gravar os dados: " . $err->getMessage();
        }
    }
    $g->data_inicio  = $data_inicio;
    $g->data_fim     = $data_fim;
    $g->tem_contrato = $tem_contrato;
}

$ligacao = null;

$tem_contrato_atual = ($g->tipo === 'Contrato de manutenção') ? 'sim' : 'nao';
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
                            <h2 class="mb-4 fw-bold" style="color: #004f63;"><i class="fas fa-pen-to-square me-2"></i> Editar Garantia</h2>
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
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Equipamento Associado</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars(($g->eq_codigo ?? '') . ' — ' . ($g->eq_designacao ?? '')) ?>" disabled>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="data_inicio" class="form-label fw-semibold">Data de Início <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="data_inicio" name="data_inicio" placeholder="AAAA-MM-DD" value="<?= htmlspecialchars($g->data_inicio ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="data_fim" class="form-label fw-semibold">Data de Fim <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="data_fim" name="data_fim" placeholder="AAAA-MM-DD" value="<?= htmlspecialchars($g->data_fim ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold d-block">Existe contrato de manutenção?</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tem_contrato" id="contrato_sim" value="sim" <?= ($tem_contrato_atual === 'sim') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="contrato_sim">Sim</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tem_contrato" id="contrato_nao" value="nao" <?= ($tem_contrato_atual === 'nao') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="contrato_nao">Não</label>
                                        </div>
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
        const obrigatorios = ['data_inicio', 'data_fim'];
        let valido = true;
        obrigatorios.forEach(function (id) {
            const campo = document.getElementById(id);
            if (!campo.value.trim()) { campo.classList.add('is-invalid'); valido = false; }
            else { campo.classList.remove('is-invalid'); }
        });
        if (!valido) {
            e.preventDefault();
            document.getElementById('erroForm').classList.remove('d-none');
            return;
        }
        const inicio = new Date(document.getElementById('data_inicio').value);
        const fim    = new Date(document.getElementById('data_fim').value);
        if (fim <= inicio) {
            e.preventDefault();
            document.getElementById('data_fim').classList.add('is-invalid');
            document.getElementById('erroForm').innerHTML = '<i class="fas fa-triangle-exclamation me-2"></i> A data de fim deve ser posterior à data de início.';
            document.getElementById('erroForm').classList.remove('d-none');
            return;
        }
        document.getElementById('erroForm').classList.add('d-none');
    });
</script>

<script>
    flatpickr("#data_inicio", { dateFormat: "Y-m-d" });
    flatpickr("#data_fim",    { dateFormat: "Y-m-d" });
</script>

<?php include '../../includes/footer.php'; ?>
