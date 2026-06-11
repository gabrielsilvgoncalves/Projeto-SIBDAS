<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>


            <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0 fw-bold" style="color: #004f63;">
                        <i class="fas fa-file-medical me-2"></i> Detalhes do Documento
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
                            <h4 class="fw-bold mb-1" style="color: #004f63;">Manual IntelliVue MP5 PT</h4>
                            <p class="text-muted mb-0">Equipamento: <a href="../equipamentos/detalhes.php">04.002.00 — Monitor multiparamétrico</a></p>
                        </div>
                        <span class="badge bg-info text-dark fs-6">Manual de utilizador</span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                                <i class="fas fa-tag me-2"></i> Informações do Documento
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td class="text-muted fw-semibold" style="width:45%">Tipo</td><td><span class="badge bg-info text-dark">Manual de utilizador</span></td></tr>
                                    <tr><td class="text-muted fw-semibold">Nome</td><td>Manual IntelliVue MP5 PT</td></tr>
                                    <tr><td class="text-muted fw-semibold">Data do Doc.</td><td>15/03/2022</td></tr>
                                    <tr><td class="text-muted fw-semibold">Validade</td><td class="text-muted">—</td></tr>
                                    <tr><td class="text-muted fw-semibold">Formato</td><td>PDF</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                                <i class="fas fa-stethoscope me-2"></i> Equipamento Associado
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td class="text-muted fw-semibold" style="width:45%">Código</td><td><code>04.002.00</code></td></tr>
                                    <tr><td class="text-muted fw-semibold">Designação</td><td>Monitor multiparamétrico</td></tr>
                                    <tr><td class="text-muted fw-semibold">Marca / Modelo</td><td>Philips / IntelliVue MP5</td></tr>
                                    <tr><td class="text-muted fw-semibold">Serviço</td><td>UCI</td></tr>
                                </table>
                                <a href="../equipamentos/detalhes.php" class="btn btn-sm btn-outline-secondary mt-2">
                                    <i class="fas fa-arrow-up-right-from-square me-1"></i> Ver equipamento
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                                <i class="fas fa-note-sticky me-2"></i> Observações
                            </div>
                            <div class="card-body">
                                <p class="mb-0 text-muted">Manual em língua portuguesa. Inclui instruções de operação, manutenção preventiva e resolução de problemas.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="editar.php" class="btn btn-warning fw-semibold">
                        <i class="fas fa-pen-to-square me-1"></i> Editar Documento
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
