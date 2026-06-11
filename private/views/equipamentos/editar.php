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
                        <form action="#" method="post" novalidate id="formEditar">

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-tag me-2"></i> Identificação</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="codigo" class="form-label fw-semibold">Código Interno <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" value="04.002.00" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="designacao" class="form-label fw-semibold">Designação <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="designacao" name="designacao" value="Monitor multiparamétrico" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="categoria" class="form-label fw-semibold">Categoria <span class="text-danger">*</span></label>
                                    <select class="form-select" id="categoria" name="categoria" required>
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
                                        <option selected>Ativo</option>
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
                                        <option>Baixa</option>
                                        <option>Média</option>
                                        <option selected>Alta</option>
                                        <option>Suporte de vida</option>
                                    </select>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-industry me-2"></i> Fabricante e Modelo</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="marca" class="form-label fw-semibold">Marca <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="marca" name="marca" value="Philips" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="modelo" class="form-label fw-semibold">Modelo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="modelo" name="modelo" value="IntelliVue MP5" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="num_serie" class="form-label fw-semibold">Nº Série <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="num_serie" name="num_serie" value="MP5-2022-45873" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="ano_fabrico" class="form-label fw-semibold">Ano de Fabrico</label>
                                    <input type="number" class="form-control" id="ano_fabrico" name="ano_fabrico" value="2022">
                                </div>
                                <div class="col-md-4">
                                    <label for="data_aquisicao" class="form-label fw-semibold">Data de Aquisição</label>
                                    <input type="date" class="form-control" id="data_aquisicao" name="data_aquisicao" value="2022-03-15">
                                </div>
                                <div class="col-md-4">
                                    <label for="custo" class="form-label fw-semibold">Custo de Aquisição (€)</label>
                                    <input type="number" class="form-control" id="custo" name="custo" value="22500.00" step="0.01">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="tipo_entrada" class="form-label fw-semibold">Tipo de Entrada</label>
                                    <select class="form-select" id="tipo_entrada" name="tipo_entrada">
                                        <option selected>Compra</option>
                                        <option>Doação</option>
                                        <option>Aluguer</option>
                                        <option>Empréstimo</option>
                                    </select>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-map-marker-alt me-2"></i> Localização</h5>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="edificio" class="form-label fw-semibold">Edifício</label>
                                    <input type="text" class="form-control" id="edificio" name="edificio" value="Edifício Principal">
                                </div>
                                <div class="col-md-3">
                                    <label for="piso" class="form-label fw-semibold">Piso</label>
                                    <input type="text" class="form-control" id="piso" name="piso" value="Piso 3">
                                </div>
                                <div class="col-md-3">
                                    <label for="servico" class="form-label fw-semibold">Serviço <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="servico" name="servico" value="Unidade de Cuidados Intensivos" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="sala" class="form-label fw-semibold">Sala</label>
                                    <input type="text" class="form-control" id="sala" name="sala" value="Sala UCI-03">
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-note-sticky me-2"></i> Observações</h5>
                            <div class="mb-4">
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="3">Equipamento em boas condições de funcionamento. Última manutenção preventiva realizada em Janeiro 2025. Necessita de certificado de calibração até Junho 2025.</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="detalhes.php" class="btn btn-outline-secondary">
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
            alert('Alterações guardadas com sucesso!');
            window.location.href = 'detalhes.php';
        }
    });
</script>

<?php include '../../includes/footer.php'; ?>
