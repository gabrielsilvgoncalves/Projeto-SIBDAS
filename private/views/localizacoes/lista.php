<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 fw-bold" style="color: #004f63;"><i class="fas fa-map-marker-alt me-2"></i> Localizações</h2>
                <a href="novo.php" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                    <i class="fas fa-plus me-1"></i> Nova Localização
                </a>
            </div>
            <hr>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr><th>Edifício</th><th>Piso</th><th>Serviço / Departamento</th><th>Sala / Gabinete</th><th class="text-center">Nº Equip.</th><th class="text-center">Ações</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Edifício Principal</td><td>Piso 3</td><td>Unidade de Cuidados Intensivos</td><td>Sala UCI-03</td><td class="text-center">148</td>
                                    <td class="text-center">
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Edifício Principal</td><td>Piso 2</td><td>Bloco Operatório</td><td>BO-01</td><td class="text-center">212</td>
                                    <td class="text-center">
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Edifício B</td><td>Piso 0</td><td>Urgência Geral</td><td>Triagem</td><td class="text-center">183</td>
                                    <td class="text-center">
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Edifício Principal</td><td>Piso 4</td><td>Medicina Interna</td><td>Enfermaria A</td><td class="text-center">96</td>
                                    <td class="text-center">
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Edifício C</td><td>Piso 1</td><td>Fisioterapia</td><td>Ginásio Reabilitação</td><td class="text-center">61</td>
                                    <td class="text-center">
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted small">5 localizações registadas</div>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
