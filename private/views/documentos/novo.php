<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$erros = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recolher dados
    $tipo           = $_POST["tipo"] ?? "";
    $nome_doc       = $_POST["nome_doc"] ?? "";
    $equipamento    = $_POST["equipamento"] ?? "";
    $fornecedor_doc = $_POST["fornecedor_doc"] ?? "";
    $data_doc       = $_POST["data_doc"] ?? "";
    $data_validade  = $_POST["data_validade"] ?? "";
    $modo_doc       = $_POST["modo_doc"] ?? "";
    $link_doc       = $_POST["link_doc"] ?? "";

    // 2. Trim
    $nome_doc = trim($nome_doc);

    // 3. Validar
    if (empty($tipo))        $erros[] = "O campo Tipo de Documento é obrigatório.";
    if (empty($nome_doc))    $erros[] = "O campo Nome do Documento é obrigatório.";
    if (empty($equipamento)) $erros[] = "O campo Equipamento Associado é obrigatório.";

    // 4. Depuração: mostrar erros recolhidos
    /*
    echo "<pre>"; print_r($erros); echo "</pre>";
    */

    // 5. Normalizar entrada
    $nome_doc = ucwords(strtolower($nome_doc));

    /*
    echo "<p><strong>Dados normalizados:</strong></p>";
    echo "<ul>";
    echo "<li>Nome do Documento: $nome_doc</li>";
    echo "</ul>";
    */
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
                            <h2 class="mb-4 fw-bold" style="color: #004f63;"><i class="fas fa-plus me-2"></i> Associar Documento</h2>
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
                            <form action="#" method="post" novalidate id="formDocumento" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tipo" class="form-label fw-semibold">Tipo de Documento <span class="text-danger">*</span></label>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option value="">-- Selecionar --</option>
                                            <option>Manual de utilizador</option>
                                            <option>Manual de serviço</option>
                                            <option>Certificado de calibração</option>
                                            <option>Contrato de manutenção</option>
                                            <option>Fatura / Guia de aquisição</option>
                                            <option>Declaração de conformidade</option>
                                            <option>Relatório técnico</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nome_doc" class="form-label fw-semibold">Nome do Documento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome_doc" name="nome_doc" placeholder="ex: Manual Utilizador IntelliVue MP5" value="<?= htmlspecialchars($_POST['nome_doc'] ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <label for="fornecedor_doc" class="form-label fw-semibold">Fornecedor Associado</label>
                                        <select class="form-select" id="fornecedor_doc" name="fornecedor_doc">
                                            <option value="">— Nenhum —</option>
                                            <option>Philips Healthcare Portugal</option>
                                            <option>Dräger Medical Portugal</option>
                                            <option>MedTech Services</option>
                                            <option>B. Braun Portugal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="data_doc" class="form-label fw-semibold">Data do Documento</label>
                                        <input type="date" class="form-control" id="data_doc" name="data_doc">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="data_validade" class="form-label fw-semibold">Data de Validade</label>
                                        <input type="date" class="form-control" id="data_validade" name="data_validade">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Ficheiro / Referência</label>
                                    <div class="d-flex gap-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="modo_doc" id="modo_upload" value="upload" checked onchange="alternarModo()">
                                            <label class="form-check-label" for="modo_upload">Upload de ficheiro</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="modo_doc" id="modo_link" value="link" onchange="alternarModo()">
                                            <label class="form-check-label" for="modo_link">Caminho / Hiperligação</label>
                                        </div>
                                    </div>
                                    <div id="campoUpload">
                                        <input type="file" class="form-control" id="ficheiro" name="ficheiro" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                        <div class="form-text">Formatos aceites: PDF, DOC, DOCX, XLS, XLSX</div>
                                    </div>
                                    <div id="campoLink" class="d-none">
                                        <input type="text" class="form-control" id="link_doc" name="link_doc" placeholder="ex: /documentos/manual_mp5.pdf ou https://...">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="lista.php" class="btn btn-outline-secondary"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Documento
                                    </button>
                                </div>
                                <div class="alert alert-danger mt-3 d-none" id="erroForm">
                                    <i class="fas fa-triangle-exclamation me-2"></i> Preencha os campos obrigatórios: Tipo, Nome e Equipamento.
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script>
        function alternarModo() {
            const isUpload = document.getElementById('modo_upload').checked;
            document.getElementById('campoUpload').classList.toggle('d-none', !isUpload);
            document.getElementById('campoLink').classList.toggle('d-none', isUpload);
        }
        document.getElementById('formDocumento').addEventListener('submit', function (e) {
            const obrigatorios = ['tipo', 'nome_doc', 'equipamento'];
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
