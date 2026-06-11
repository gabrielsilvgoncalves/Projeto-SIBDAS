<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>


            <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0 fw-bold" style="color: #004f63;">
                        <i class="fas fa-shield-alt me-2"></i> Detalhes da Garantia
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
                            <h4 class="fw-bold mb-1" style="color: #004f63;">Monitor multiparamétrico — Philips IntelliVue MP5</h4>
                            <p class="text-muted mb-0">Código: <code>04.002.00</code></p>
                        </div>
                        <span class="badge bg-warning text-dark fs-6">A expirar</span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                                <i class="fas fa-calendar-alt me-2"></i> Período da Garantia
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td class="text-muted fw-semibold" style="width:45%">Início</td><td>15/03/2022</td></tr>
                                    <tr><td class="text-muted fw-semibold">Fim</td><td><span class="text-warning fw-semibold">28/05/2025</span></td></tr>
                                    <tr><td class="text-muted fw-semibold">Estado</td><td><span class="badge bg-warning text-dark">A expirar</span></td></tr>
                                    <tr><td class="text-muted fw-semibold">Dias restantes</td><td class="text-warning fw-semibold">8 dias</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                                <i class="fas fa-file-contract me-2"></i> Contrato de Manutenção
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td class="text-muted fw-semibold" style="width:45%">Tipo</td><td>Anual</td></tr>
                                    <tr><td class="text-muted fw-semibold">Entidade</td><td>Philips Healthcare Portugal</td></tr>
                                    <tr><td class="text-muted fw-semibold">Contacto</td><td>+351 21 770 00 00</td></tr>
                                    <tr><td class="text-muted fw-semibold">Nº Contrato</td><td>PHC-2022-4521</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                                <i class="fas fa-note-sticky me-2"></i> Observações
                            </div>
                            <div class="card-body">
                                <p class="mb-0 text-muted">Contrato de manutenção anual com visita preventiva incluída. Renovação prevista para Junho 2025.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="editar.php" class="btn btn-warning fw-semibold">
                        <i class="fas fa-pen-to-square me-1"></i> Editar Garantia
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
<script src="../../assets/js/1231236.js"></script>

<?php include '../../includes/footer.php'; ?>
