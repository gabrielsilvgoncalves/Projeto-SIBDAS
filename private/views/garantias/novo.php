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
                                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="data_fim" class="form-label fw-semibold">Data de Fim <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="data_fim" name="data_fim" required>
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
                                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Informação adicional relevante sobre a garantia ou contrato..."></textarea>
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
            e.preventDefault();
            const obrigatorios = ['equipamento', 'data_inicio', 'data_fim'];
            let valido = true;
            obrigatorios.forEach(function (id) {
                const campo = document.getElementById(id);
                if (!campo.value.trim()) { campo.classList.add('is-invalid'); valido = false; }
                else { campo.classList.remove('is-invalid'); }
            });
            if (!valido) {
                document.getElementById('erroForm').classList.remove('d-none');
                return;
            }
            const inicio = new Date(document.getElementById('data_inicio').value);
            const fim = new Date(document.getElementById('data_fim').value);
            if (fim <= inicio) {
                document.getElementById('data_fim').classList.add('is-invalid');
                document.getElementById('erroForm').innerHTML = '<i class="fas fa-triangle-exclamation me-2"></i> A data de fim deve ser posterior à data de início.';
                document.getElementById('erroForm').classList.remove('d-none');
                return;
            }
            alert('Garantia registada com sucesso!');
            window.location.href = 'lista.php';
        });
    </script>

<?php include '../../includes/footer.php'; ?>
