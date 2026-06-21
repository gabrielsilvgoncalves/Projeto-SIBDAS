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
        "SELECT e.*, l.nome AS loc_nome, l.descricao AS loc_descricao, l.piso AS loc_piso, l.ala AS loc_ala
         FROM equipamentos e
         LEFT JOIN localizacoes l ON e.id_localizacao = l.id
         WHERE e.id = :id AND e.deleted_at IS NULL
         LIMIT 1"
    );
    $stmt->execute([':id' => $id]);
    $eq = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$eq) { header('Location: lista.php'); exit; }
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo      = trim($_POST["codigo"] ?? "");
    $designacao  = ucwords(strtolower(trim($_POST["designacao"] ?? "")));
    $categoria   = $_POST["categoria"] ?? "";
    $estado      = $_POST["estado"] ?? "";
    $criticidade = $_POST["criticidade"] ?? "";
    $marca       = ucwords(strtolower(trim($_POST["marca"] ?? "")));
    $modelo      = ucwords(strtolower(trim($_POST["modelo"] ?? "")));
    $num_serie   = trim($_POST["num_serie"] ?? "");
    $data_aquisicao = $_POST["data_aquisicao"] ?? "";

    if (empty($codigo))      $erros[] = "O campo Código é obrigatório.";
    if (empty($designacao)) {
        $erros[] = "O campo Designação é obrigatório.";
    } elseif (preg_match('/\d/', $designacao)) {
        $erros[] = "O campo Designação não pode conter números.";
    }
    if (empty($categoria))   $erros[] = "O campo Categoria é obrigatório.";
    if (empty($estado))      $erros[] = "O campo Estado é obrigatório.";
    if (empty($criticidade)) $erros[] = "O campo Criticidade é obrigatório.";
    if (empty($marca))       $erros[] = "O campo Marca é obrigatório.";
    if (empty($modelo))      $erros[] = "O campo Modelo é obrigatório.";
    if (empty($num_serie))   $erros[] = "O campo Número de Série é obrigatório.";
    if (!empty($data_aquisicao)) {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_aquisicao)) {
            $erros[] = "Formato de data de aquisição inválido.";
        } else {
            $p = explode('-', $data_aquisicao);
            if (!checkdate((int)$p[1], (int)$p[2], (int)$p[0])) $erros[] = "Data de aquisição inválida.";
        }
    }

    if (empty($erros)) {
        try {
            $sql = "UPDATE equipamentos SET codigo = :codigo, designacao = :designacao, marca = :marca, modelo = :modelo,
                    numero_serie = :numero_serie, categoria = :categoria, estado = :estado, criticidade = :criticidade,
                    data_aquisicao = :data_aquisicao, updated_at = NOW() WHERE id = :id";
            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':codigo'         => $codigo,
                ':designacao'     => $designacao,
                ':marca'          => $marca,
                ':modelo'         => $modelo,
                ':numero_serie'   => $num_serie,
                ':categoria'      => $categoria,
                ':estado'         => $estado,
                ':criticidade'    => $criticidade,
                ':data_aquisicao' => !empty($data_aquisicao) ? $data_aquisicao : null,
                ':id'             => $id,
            ]);
            header('Location: lista.php');
            exit;
        } catch (PDOException $err) {
            $erro_sistema = "Erro ao gravar os dados: " . $err->getMessage();
        }
    }
    $eq->codigo        = $codigo;
    $eq->designacao    = $designacao;
    $eq->categoria     = $categoria;
    $eq->estado        = $estado;
    $eq->criticidade   = $criticidade;
    $eq->marca         = $marca;
    $eq->modelo        = $modelo;
    $eq->numero_serie  = $num_serie;
    $eq->data_aquisicao = $data_aquisicao;
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
                <div class="card w-100 border-0 shadow-sm" style="max-width: 1000px;">
                    <div class="card-body">
                        <h2 class="mb-4 fw-bold" style="color: #004f63;">
                            <i class="fas fa-pen-to-square me-2"></i> Editar Equipamento
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
                        <form action="editar.php?id=<?= $id ?>" method="post" novalidate id="formEditar">

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-tag me-2"></i> Identificação</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="codigo" class="form-label fw-semibold">Código Interno <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" value="<?= htmlspecialchars($eq->codigo ?? '') ?>" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="designacao" class="form-label fw-semibold">Designação <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="designacao" name="designacao" value="<?= htmlspecialchars($eq->designacao ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="categoria" class="form-label fw-semibold">Categoria <span class="text-danger">*</span></label>
                                    <select class="form-select" id="categoria" name="categoria" required>
                                        <option value="">-- Selecionar --</option>
                                        <?php foreach (['Monitorização','Suporte de vida','Terapia','Diagnóstico','Laboratório','Esterilização','Reabilitação'] as $op): ?>
                                            <option <?= $eq->categoria === $op ? 'selected' : '' ?>><?= $op ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="">-- Selecionar --</option>
                                        <?php foreach (['Ativo','Em manutenção','Em calibração','Em quarentena','Inativo','Abatido'] as $op): ?>
                                            <option <?= $eq->estado === $op ? 'selected' : '' ?>><?= $op ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="criticidade" class="form-label fw-semibold">Criticidade <span class="text-danger">*</span></label>
                                    <select class="form-select" id="criticidade" name="criticidade" required>
                                        <option value="">-- Selecionar --</option>
                                        <?php foreach (['Baixa','Média','Alta','Suporte de vida'] as $op): ?>
                                            <option <?= $eq->criticidade === $op ? 'selected' : '' ?>><?= $op ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-industry me-2"></i> Fabricante e Modelo</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="marca" class="form-label fw-semibold">Marca <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="marca" name="marca" value="<?= htmlspecialchars($eq->marca ?? '') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="modelo" class="form-label fw-semibold">Modelo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="modelo" name="modelo" value="<?= htmlspecialchars($eq->modelo ?? '') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="num_serie" class="form-label fw-semibold">Nº Série <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="num_serie" name="num_serie" value="<?= htmlspecialchars($eq->numero_serie ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="data_aquisicao" class="form-label fw-semibold">Data de Aquisição</label>
                                    <input type="text" class="form-control" id="data_aquisicao" name="data_aquisicao" placeholder="AAAA-MM-DD" value="<?= htmlspecialchars($eq->data_aquisicao ?? '') ?>">
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-map-marker-alt me-2"></i> Localização Atual</h5>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Edifício</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($eq->loc_ala ?? '') ?>" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Piso</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($eq->loc_piso ?? '') ?>" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Serviço</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($eq->loc_nome ?? '') ?>" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Sala</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($eq->loc_descricao ?? '') ?>" disabled>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="lista.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-xmark me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                    <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Alterações
                                </button>
                            </div>

                            <div class="alert alert-danger mt-3 d-none" id="erroForm">
                                <i class="fas fa-triangle-exclamation me-2"></i> Preencha todos os campos obrigatórios.
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
        const obrigatorios = ['codigo', 'designacao', 'categoria', 'estado', 'criticidade', 'marca', 'modelo', 'num_serie'];
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
    flatpickr("#data_aquisicao", { dateFormat: "Y-m-d" });
</script>

<?php include '../../includes/footer.php'; ?>
