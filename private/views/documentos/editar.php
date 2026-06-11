<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>


            <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0 fw-bold" style="color: #004f63;">
                        <i class="fas fa-pen-to-square me-2"></i> Editar Documento
                    </h2>
                    <a href="lista.php" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                </div>
                <hr>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form id="formEditar" novalidate>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tipoDoc" class="form-label fw-semibold">Tipo de Documento <span class="text-danger">*</span></label>
                                    <select class="form-select" id="tipoDoc" required>
                                        <option value="manual_utilizador" selected>Manual de utilizador</option>
                                        <option value="manual_servico">Manual de serviço</option>
                                        <option value="cert_calibracao">Certificado de calibração</option>
                                        <option value="contrato_manutencao">Contrato de manutenção</option>
                                        <option value="fatura">Fatura / Guia de aquisição</option>
                                        <option value="declaracao">Declaração de conformidade</option>
                                        <option value="relatorio">Relatório técnico</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="nomeDoc" class="form-label fw-semibold">Nome do Documento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nomeDoc" value="Manual IntelliVue MP5 PT" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="equipamento" class="form-label fw-semibold">Equipamento Associado <span class="text-danger">*</span></label>
                                    <select class="form-select" id="equipamento" required>
                                        <option value="04.002.00" selected>04.002.00 — Monitor multiparamétrico (Philips IntelliVue MP5)</option>
                                        <option value="06.001.00">06.001.00 — Ventilador Dräger Evita V500</option>
                                        <option value="03.005.00">03.005.00 — Bomba de infusão B.Braun</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="dataDoc" class="form-label fw-semibold">Data do Documento</label>
                                    <input type="date" class="form-control" id="dataDoc" value="2022-03-15">
                                </div>
                                <div class="col-md-4">
                                    <label for="validade" class="form-label fw-semibold">Validade</label>
                                    <input type="date" class="form-control" id="validade">
                                </div>
                                <div class="col-md-4">
                                    <label for="formato" class="form-label fw-semibold">Formato</label>
                                    <select class="form-select" id="formato">
                                        <option value="pdf" selected>PDF</option>
                                        <option value="docx">DOCX</option>
                                        <option value="xlsx">XLSX</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="observacoes" class="form-label fw-semibold">Observações</label>
                                    <textarea class="form-control" id="observacoes" rows="3">Manual em língua portuguesa. Inclui instruções de operação, manutenção preventiva e resolução de problemas.</textarea>
                                </div>
                                <div class="col-12 d-flex gap-2 mt-2">
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fas fa-floppy-disk me-1"></i> Guardar alterações
                                    </button>
                                    <a href="detalhes.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-xmark me-1"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script src="../../assets/js/1231236.js"></script>
    <script>
        document.getElementById('formEditar').addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Documento atualizado com sucesso.');
            window.location.href = 'detalhes.php';
        });
    </script>

<?php include '../../includes/footer.php'; ?>
