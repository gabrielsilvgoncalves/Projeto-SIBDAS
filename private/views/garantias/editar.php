<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>


            <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0 fw-bold" style="color: #004f63;">
                        <i class="fas fa-pen-to-square me-2"></i> Editar Garantia
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
                                <div class="col-md-12">
                                    <label for="equipamento" class="form-label fw-semibold">Equipamento <span class="text-danger">*</span></label>
                                    <select class="form-select" id="equipamento" required>
                                        <option value="04.002.00" selected>04.002.00 — Monitor multiparamétrico (Philips IntelliVue MP5)</option>
                                        <option value="06.001.00">06.001.00 — Ventilador Dräger Evita V500</option>
                                        <option value="03.005.00">03.005.00 — Bomba de infusão B.Braun</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="dataInicio" class="form-label fw-semibold">Data de Início <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dataInicio" value="2022-03-15" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="dataFim" class="form-label fw-semibold">Data de Fim <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dataFim" value="2025-05-28" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="temContrato" class="form-label fw-semibold">Contrato de Manutenção</label>
                                    <select class="form-select" id="temContrato">
                                        <option value="sim" selected>Sim</option>
                                        <option value="nao">Não</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="tipoContrato" class="form-label fw-semibold">Tipo de Contrato</label>
                                    <select class="form-select" id="tipoContrato">
                                        <option value="">— Selecionar —</option>
                                        <option value="anual" selected>Anual</option>
                                        <option value="plurianual">Plurianual</option>
                                        <option value="chamada">Por chamada</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="entidade" class="form-label fw-semibold">Entidade Responsável</label>
                                    <input type="text" class="form-control" id="entidade" value="Philips Healthcare Portugal">
                                </div>
                                <div class="col-md-6">
                                    <label for="numContrato" class="form-label fw-semibold">Nº Contrato</label>
                                    <input type="text" class="form-control" id="numContrato" value="PHC-2022-4521">
                                </div>
                                <div class="col-12">
                                    <label for="observacoes" class="form-label fw-semibold">Observações</label>
                                    <textarea class="form-control" id="observacoes" rows="3">Contrato de manutenção anual com visita preventiva incluída. Renovação prevista para Junho 2025.</textarea>
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
            alert('Garantia atualizada com sucesso.');
            window.location.href = 'detalhes.php';
        });
    </script>

<?php include '../../includes/footer.php'; ?>
