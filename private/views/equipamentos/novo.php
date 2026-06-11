<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

        <!-- CONTEÚDO -->
        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-center">
                <div class="card w-100 border-0 shadow-sm" style="max-width: 1000px;">
                    <div class="card-body">
                        <h2 class="mb-4 fw-bold" style="color: #004f63;">
                            <i class="fas fa-plus me-2"></i> Inserir Novo Equipamento
                        </h2>
                        <hr>
                        <form action="#" method="post" novalidate id="formEquipamento">

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-tag me-2"></i> Identificação</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="codigo" class="form-label fw-semibold">Código Interno <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="ex: 04.002.00" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="designacao" class="form-label fw-semibold">Designação do Equipamento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="designacao" name="designacao" placeholder="Nome completo do equipamento" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="categoria" class="form-label fw-semibold">Categoria <span class="text-danger">*</span></label>
                                    <select class="form-select" id="categoria" name="categoria" required>
                                        <option value="">-- Selecionar --</option>
                                        <option>Monitorização</option>
                                        <option>Suporte de vida</option>
                                        <option>Terapia</option>
                                        <option>Diagnóstico</option>
                                        <option>Laboratório</option>
                                        <option>Esterilização</option>
                                        <option>Reabilitação</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="">-- Selecionar --</option>
                                        <option>Ativo</option>
                                        <option>Em manutenção</option>
                                        <option>Em calibração</option>
                                        <option>Em quarentena</option>
                                        <option>Inativo</option>
                                        <option>Abatido</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="criticidade" class="form-label fw-semibold">Criticidade <span class="text-danger">*</span></label>
                                    <select class="form-select" id="criticidade" name="criticidade" required>
                                        <option value="">-- Selecionar --</option>
                                        <option>Baixa</option>
                                        <option>Média</option>
                                        <option>Alta</option>
                                        <option>Suporte de vida</option>
                                    </select>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-industry me-2"></i> Fabricante e Modelo</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="marca" class="form-label fw-semibold">Marca <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="marca" name="marca" placeholder="ex: Philips" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="modelo" class="form-label fw-semibold">Modelo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="modelo" name="modelo" placeholder="ex: IntelliVue MP5" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="fabricante" class="form-label fw-semibold">Fabricante</label>
                                    <input type="text" class="form-control" id="fabricante" name="fabricante" placeholder="Nome do fabricante">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="num_serie" class="form-label fw-semibold">Número de Série <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="num_serie" name="num_serie" placeholder="ex: MP5-2022-45873" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="ano_fabrico" class="form-label fw-semibold">Ano de Fabrico</label>
                                    <input type="number" class="form-control" id="ano_fabrico" name="ano_fabrico" placeholder="ex: 2022" min="1990" max="2030">
                                </div>
                                <div class="col-md-4">
                                    <label for="data_aquisicao" class="form-label fw-semibold">Data de Aquisição</label>
                                    <input type="date" class="form-control" id="data_aquisicao" name="data_aquisicao">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="custo" class="form-label fw-semibold">Custo de Aquisição (€)</label>
                                    <input type="number" class="form-control" id="custo" name="custo" placeholder="ex: 15000.00" step="0.01" min="0">
                                </div>
                                <div class="col-md-4">
                                    <label for="tipo_entrada" class="form-label fw-semibold">Tipo de Entrada</label>
                                    <select class="form-select" id="tipo_entrada" name="tipo_entrada">
                                        <option value="">-- Selecionar --</option>
                                        <option>Compra</option>
                                        <option>Doação</option>
                                        <option>Aluguer</option>
                                        <option>Empréstimo</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="fornecedor" class="form-label fw-semibold">Fornecedor Principal</label>
                                    <select class="form-select" id="fornecedor" name="fornecedor">
                                        <option value="">-- Selecionar --</option>
                                        <option>Philips Healthcare</option>
                                        <option>Dräger Medical</option>
                                        <option>B. Braun Portugal</option>
                                        <option>Zoll Medical</option>
                                        <option>GE Healthcare</option>
                                    </select>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-map-marker-alt me-2"></i> Localização</h5>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="edificio" class="form-label fw-semibold">Edifício</label>
                                    <input type="text" class="form-control" id="edificio" name="edificio" placeholder="ex: Edifício Principal">
                                </div>
                                <div class="col-md-3">
                                    <label for="piso" class="form-label fw-semibold">Piso</label>
                                    <input type="text" class="form-control" id="piso" name="piso" placeholder="ex: Piso 2">
                                </div>
                                <div class="col-md-3">
                                    <label for="servico" class="form-label fw-semibold">Serviço / Departamento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="servico" name="servico" placeholder="ex: UCI" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="sala" class="form-label fw-semibold">Sala / Gabinete</label>
                                    <input type="text" class="form-control" id="sala" name="sala" placeholder="ex: Sala 203">
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-note-sticky me-2"></i> Observações</h5>
                            <div class="mb-4">
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="3"
                                    placeholder="Informações adicionais relevantes sobre o equipamento..."></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="lista.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-xmark me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                    <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Equipamento
                                </button>
                            </div>

                            <div class="alert alert-danger mt-3 d-none" id="erroForm" role="alert">
                                <i class="fas fa-triangle-exclamation me-2"></i>
                                Por favor, preencha todos os campos obrigatórios assinalados com (*).
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    document.getElementById('formEquipamento').addEventListener('submit', function (e) {
        e.preventDefault();
        const obrigatorios = ['codigo', 'designacao', 'categoria', 'estado', 'criticidade', 'marca', 'modelo', 'num_serie', 'servico'];
        let valido = true;
        obrigatorios.forEach(function (id) {
            const campo = document.getElementById(id);
            if (!campo.value.trim()) { campo.classList.add('is-invalid'); valido = false; }
            else { campo.classList.remove('is-invalid'); }
        });
        if (!valido) {
            document.getElementById('erroForm').classList.remove('d-none');
        } else {
            document.getElementById('erroForm').classList.add('d-none');
            alert('Equipamento guardado com sucesso!');
            window.location.href = 'lista.php';
        }
    });
</script>

<?php include '../../includes/footer.php'; ?>
