<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>


            <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0 fw-bold" style="color: #004f63;"><i class="fas fa-truck me-2"></i> Ficha do Fornecedor</h2>
                    <div class="d-flex gap-2">
                        <a href="editar.php" class="btn btn-warning btn-sm fw-semibold"><i class="fas fa-pen-to-square me-1"></i> Editar</a>
                        <a href="lista.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Voltar</a>
                    </div>
                </div>
                <hr>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h4 class="fw-bold mb-1" style="color: #004f63;">Philips Healthcare Portugal</h4>
                            <p class="text-muted mb-0">NIF: 500 123 456</p>
                        </div>
                        <span class="badge bg-primary fs-6">Fabricante</span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header fw-bold text-white" style="background-color: #004f63;"><i class="fas fa-building me-2"></i> Dados da Empresa</div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td class="text-muted fw-semibold" style="width:40%">Nome</td><td>Philips Healthcare Portugal</td></tr>
                                    <tr><td class="text-muted fw-semibold">NIF</td><td>500 123 456</td></tr>
                                    <tr><td class="text-muted fw-semibold">Tipo</td><td>Fabricante</td></tr>
                                    <tr><td class="text-muted fw-semibold">Morada</td><td>Av. D. João II, nº 35, 1990-084 Lisboa</td></tr>
                                    <tr><td class="text-muted fw-semibold">Website</td><td><a href="#" target="_blank">www.philips.pt</a></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header fw-bold text-white" style="background-color: #004f63;"><i class="fas fa-phone me-2"></i> Contactos</div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td class="text-muted fw-semibold" style="width:40%">Telefone</td><td>+351 21 345 6789</td></tr>
                                    <tr><td class="text-muted fw-semibold">Email</td><td>info@philips.pt</td></tr>
                                    <tr><td class="text-muted fw-semibold">Pessoa Contacto</td><td>Ana Rodrigues</td></tr>
                                    <tr><td class="text-muted fw-semibold">Tel. Direto</td><td>+351 912 345 678</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold text-white" style="background-color: #004f63;"><i class="fas fa-stethoscope me-2"></i> Equipamentos Associados</div>
                            <div class="card-body p-0">
                                <table class="table table-sm table-striped mb-0">
                                    <thead><tr><th>Código</th><th>Designação</th><th>Modelo</th><th>Estado</th></tr></thead>
                                    <tbody>
                                        <tr><td><code>04.002.00</code></td><td>Monitor multiparamétrico</td><td>IntelliVue MP5</td><td><span class="estado-badge badge-ativo">Ativo</span></td></tr>
                                        <tr><td><code>04.003.00</code></td><td>Monitor multiparamétrico</td><td>IntelliVue MX500</td><td><span class="estado-badge badge-ativo">Ativo</span></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <a href="editar.php" class="btn btn-warning fw-semibold"><i class="fas fa-pen-to-square me-1"></i> Editar</a>
                    <a href="apagar.php" class="btn btn-outline-danger fw-semibold"><i class="fas fa-trash-can me-1"></i> Remover</a>
                    <a href="lista.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Voltar</a>
                </div>
            </main>
        </div>
    </div>
<?php include '../../includes/footer.php'; ?>
