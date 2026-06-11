<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 fw-bold" style="color: #004f63;">
                    <i class="fas fa-stethoscope me-2"></i> Ficha do Equipamento
                </h2>
                <div class="d-flex gap-2">
                    <a href="editar.php" class="btn btn-warning btn-sm fw-semibold">
                        <i class="fas fa-pen-to-square me-1"></i> Editar
                    </a>
                    <a href="lista.php" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </div>
            <hr>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #004f63;">Monitor multiparamétrico</h4>
                        <p class="text-muted mb-0">Philips — IntelliVue MP5 &nbsp;|&nbsp; <code>04.002.00</code></p>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="estado-badge badge-ativo">Ativo</span>
                        <span class="critico-badge badge-critico-alta">Alta criticidade</span>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-tag me-2"></i> Identificação
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Código Interno</td><td><code>04.002.00</code></td></tr>
                                <tr><td class="text-muted fw-semibold">Designação</td><td>Monitor multiparamétrico</td></tr>
                                <tr><td class="text-muted fw-semibold">Categoria</td><td>Monitorização</td></tr>
                                <tr><td class="text-muted fw-semibold">Estado</td><td><span class="estado-badge badge-ativo">Ativo</span></td></tr>
                                <tr><td class="text-muted fw-semibold">Criticidade</td><td><span class="critico-badge badge-critico-alta">Alta</span></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-industry me-2"></i> Fabricante e Modelo
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Marca</td><td>Philips</td></tr>
                                <tr><td class="text-muted fw-semibold">Modelo</td><td>IntelliVue MP5</td></tr>
                                <tr><td class="text-muted fw-semibold">Fabricante</td><td>Philips Healthcare</td></tr>
                                <tr><td class="text-muted fw-semibold">Nº Série</td><td>MP5-2022-45873</td></tr>
                                <tr><td class="text-muted fw-semibold">Ano de Fabrico</td><td>2022</td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-receipt me-2"></i> Aquisição
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Data de Aquisição</td><td>15/03/2022</td></tr>
                                <tr><td class="text-muted fw-semibold">Tipo de Entrada</td><td>Compra</td></tr>
                                <tr><td class="text-muted fw-semibold">Custo de Aquisição</td><td>€ 22 500,00</td></tr>
                                <tr><td class="text-muted fw-semibold">Fornecedor</td><td><a href="../fornecedores/detalhes.php">Philips Healthcare Portugal</a></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-map-marker-alt me-2"></i> Localização
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Edifício</td><td>Edifício Principal</td></tr>
                                <tr><td class="text-muted fw-semibold">Piso</td><td>Piso 3</td></tr>
                                <tr><td class="text-muted fw-semibold">Serviço</td><td>Unidade de Cuidados Intensivos</td></tr>
                                <tr><td class="text-muted fw-semibold">Sala</td><td>Sala UCI-03</td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-shield-alt me-2"></i> Garantia e Contrato
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Início da Garantia</td><td>15/03/2022</td></tr>
                                <tr><td class="text-muted fw-semibold">Fim da Garantia</td><td><span class="text-warning fw-semibold">28/05/2025</span></td></tr>
                                <tr><td class="text-muted fw-semibold">Contrato Manutenção</td><td>Sim — Anual</td></tr>
                                <tr><td class="text-muted fw-semibold">Entidade Responsável</td><td>Philips Healthcare Portugal</td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-file-medical me-2"></i> Documentação
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Manual de utilizador</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Manual de serviço</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Fatura de aquisição</li>
                                <li class="mb-2"><i class="fas fa-times-circle text-danger me-2"></i> Certificado de calibração <small class="text-muted">(em falta)</small></li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Contrato de manutenção</li>
                            </ul>
                            <a href="../documentos/novo.php" class="btn btn-sm btn-outline-secondary mt-2">
                                <i class="fas fa-plus me-1"></i> Adicionar documento
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-note-sticky me-2"></i> Observações
                        </div>
                        <div class="card-body">
                            <p class="mb-0 text-muted">Equipamento em boas condições de funcionamento. Última manutenção preventiva realizada em Janeiro 2025. Necessita de certificado de calibração até Junho 2025.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="editar.php" class="btn btn-warning fw-semibold">
                    <i class="fas fa-pen-to-square me-1"></i> Editar Equipamento
                </a>
                <a href="apagar.php" class="btn btn-outline-danger fw-semibold">
                    <i class="fas fa-trash-can me-1"></i> Remover
                </a>
                <a href="lista.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Voltar à lista
                </a>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
