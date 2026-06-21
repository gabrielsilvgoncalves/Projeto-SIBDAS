<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$erros = [];
$erro_sistema = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recolher dados
    $equipamento   = $_POST["equipamento"] ?? "";
    $data_inicio   = $_POST["data_inicio"] ?? "";
    $data_fim      = $_POST["data_fim"] ?? "";
    $tem_contrato  = $_POST["tem_contrato"] ?? "";
    $tipo_contrato = $_POST["tipo_contrato"] ?? "";
    $periodicidade = $_POST["periodicidade"] ?? "";
    $entidade      = $_POST["entidade"] ?? "";
    $num_contrato  = $_POST["num_contrato"] ?? "";
    $observacoes   = $_POST["observacoes"] ?? "";

    // 3. Validar
    if (empty($equipamento)) $erros[] = "O campo Equipamento é obrigatório.";
    if (empty($data_inicio)) {
        $erros[] = "A Data de Início é obrigatória.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_inicio)) {
        $erros[] = "Formato de data de início inválido. Use AAAA-MM-DD.";
    } else {
        $partes = explode('-', $data_inicio);
        if (!checkdate((int)$partes[1], (int)$partes[2], (int)$partes[0])) {
            $erros[] = "Data de início inválida.";
        }
    }
    if (empty($data_fim)) {
        $erros[] = "A Data de Fim é obrigatória.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_fim)) {
        $erros[] = "Formato de data de fim inválido. Use AAAA-MM-DD.";
    } else {
        $partes = explode('-', $data_fim);
        if (!checkdate((int)$partes[1], (int)$partes[2], (int)$partes[0])) {
            $erros[] = "Data de fim inválida.";
        } elseif (!empty($data_inicio) && $data_fim <= $data_inicio) {
            $erros[] = "A Data de Fim deve ser posterior à Data de Início.";
        }
    }

    // 4. Depuração: mostrar erros recolhidos
    /*
    echo "<pre>"; print_r($erros); echo "</pre>";
    */

    // 5. Normalizar entrada
    $num_contrato = strtoupper($num_contrato);

    /*
    echo "<p><strong>Dados normalizados:</strong></p>";
    echo "<ul>";
    echo "<li>Nº Contrato: $num_contrato</li>";
    echo "<li>Data Início: $data_inicio</li>";
    echo "<li>Data Fim: $data_fim</li>";
    echo "</ul>";
    */

    // 6. Gravar na base de dados
    if (empty($erros)) {
        $tipo_garantia = ($tem_contrato === 'sim') ? 'Contrato de manutenção' : 'Fabricante';
        $codigo_eq     = trim(explode('—', $equipamento)[0]);
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );
            $sql = "INSERT INTO garantias (id_equipamento, tipo, data_inicio, data_fim, created_at, updated_at)
                VALUES (
                    (SELECT id FROM equipamentos WHERE codigo = :codigo_eq LIMIT 1),
                    :tipo, :data_inicio, :data_fim, NOW(), NOW()
                )";
            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':codigo_eq'   => $codigo_eq,
                ':tipo'        => $tipo_garantia,
                ':data_inicio' => $data_inicio,
                ':data_fim'    => $data_fim,
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
                    <div class="card w-100 border-0 shadow-sm" style="max-width: 800px;">
                        <div class="card-body">
                            <h2 class="mb-4 fw-bold" style="color: #004f63;"><i class="fas fa-plus me-2"></i> Registar Garantia / Contrato</h2>
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
                            <form action="#" method="post" novalidate id="formGarantia">

                                <!-- SECÇÃO: Equipamento -->
                                <h6 class="fw-bold text-uppercase mb-3" style="color: #007fa3; letter-spacing: 0.05em;">
                                    <i class="fas fa-stethoscope me-2"></i>Equipamento
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="equipamento" class="form-label fw-semibold">Equipamento Associado <span class="text-danger">*</span></label>
                                        <select class="form-select" id="equipamento" name="equipamento" required>
                                            <option value="">-- Selecionar equipamento --</option>
                                            <option>04.002.00 — Monitor multiparamétrico (Philips MP5)</option>
                                            <option>06.001.00 — Ventilador pulmonar (Dräger Evita V500)</option>
                                            <option>03.005.00 — Bomba de infusão (B. Braun Infusomat)</option>
                                            <option>02.003.00 — Desfibrilhador (Zoll R Series)</option>
                                            <option>09.001.00 — Ecógrafo (GE Vivid S70)</option>
                                        </select>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- SECÇÃO: Garantia -->
                                <h6 class="fw-bold text-uppercase mb-3" style="color: #007fa3; letter-spacing: 0.05em;">
                                    <i class="fas fa-shield-alt me-2"></i>Período de Garantia
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="data_inicio" class="form-label fw-semibold">Data de Início <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="data_inicio" name="data_inicio" placeholder="AAAA-MM-DD" value="<?= htmlspecialchars($_POST['data_inicio'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="data_fim" class="form-label fw-semibold">Data de Fim <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="data_fim" name="data_fim" placeholder="AAAA-MM-DD" value="<?= htmlspecialchars($_POST['data_fim'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- SECÇÃO: Contrato de Manutenção -->
                                <h6 class="fw-bold text-uppercase mb-3" style="color: #007fa3; letter-spacing: 0.05em;">
                                    <i class="fas fa-file-contract me-2"></i>Contrato de Manutenção
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold d-block">Existe contrato de manutenção?</label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tem_contrato" id="contrato_sim" value="sim" onchange="toggleContrato()">
                                                <label class="form-check-label" for="contrato_sim">Sim</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tem_contrato" id="contrato_nao" value="nao" checked onchange="toggleContrato()">
                                                <label class="form-check-label" for="contrato_nao">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="camposContrato" class="d-none">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="tipo_contrato" class="form-label fw-semibold">Tipo de Contrato</label>
                                            <select class="form-select" id="tipo_contrato" name="tipo_contrato">
                                                <option value="">-- Selecionar --</option>
                                                <option>Anual</option>
                                                <option>Plurianual</option>
                                                <option>Por chamada</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="periodicidade" class="form-label fw-semibold">Periodicidade</label>
                                            <select class="form-select" id="periodicidade" name="periodicidade">
                                                <option value="">-- Selecionar --</option>
                                                <option>Mensal</option>
                                                <option>Trimestral</option>
                                                <option>Semestral</option>
                                                <option>Anual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="entidade" class="form-label fw-semibold">Entidade Responsável</label>
                                            <select class="form-select" id="entidade" name="entidade">
                                                <option value="">— Nenhuma —</option>
                                                <option>Philips Healthcare Portugal</option>
                                                <option>Dräger Medical Portugal</option>
                                                <option>MedTech Services</option>
                                                <option>B. Braun Portugal</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="num_contrato" class="form-label fw-semibold">Nº do Contrato</label>
                                            <input type="text" class="form-control" id="num_contrato" name="num_contrato" placeholder="ex: CT-2024-0042">
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- SECÇÃO: Observações -->
                                <h6 class="fw-bold text-uppercase mb-3" style="color: #007fa3; letter-spacing: 0.05em;">
                                    <i class="fas fa-note-sticky me-2"></i>Observações
                                </h6>
                                <div class="mb-3">
                                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Informação adicional relevante sobre a garantia ou contrato..."><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="lista.php" class="btn btn-outline-secondary"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Garantia
                                    </button>
                                </div>
                                <div class="alert alert-danger mt-3 d-none" id="erroForm">
                                    <i class="fas fa-triangle-exclamation me-2"></i> Preencha os campos obrigatórios: Equipamento, Data de Início e Data de Fim.
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script>
        function toggleContrato() {
            const temContrato = document.getElementById('contrato_sim').checked;
            document.getElementById('camposContrato').classList.toggle('d-none', !temContrato);
        }

        document.getElementById('formGarantia').addEventListener('submit', function (e) {
            const obrigatorios = ['equipamento', 'data_inicio', 'data_fim'];
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
            const fim = new Date(document.getElementById('data_fim').value);
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
