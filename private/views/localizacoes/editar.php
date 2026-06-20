<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

            <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
                <div class="d-flex justify-content-center">
                    <div class="card w-100 border-0 shadow-sm" style="max-width: 700px;">
                        <div class="card-body">
                            <h2 class="mb-4 fw-bold" style="color: #004f63;"><i class="fas fa-pen-to-square me-2"></i> Editar Localização</h2>
                            <hr>
                            <form action="#" method="post" novalidate id="formEditar">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="edificio" class="form-label fw-semibold">Edifício</label>
                                        <input type="text" class="form-control" id="edificio" name="edificio" value="Edifício Principal">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="piso" class="form-label fw-semibold">Piso</label>
                                        <input type="text" class="form-control" id="piso" name="piso" value="Piso 3">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="servico" class="form-label fw-semibold">Serviço / Departamento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="servico" name="servico" value="Unidade de Cuidados Intensivos" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="sala" class="form-label fw-semibold">Sala / Gabinete</label>
                                        <input type="text" class="form-control" id="sala" name="sala" value="Sala UCI-03">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="lista.php" class="btn btn-outline-secondary"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Alterações
                                    </button>
                                </div>
                                <div class="alert alert-danger mt-3 d-none" id="erroForm">
                                    <i class="fas fa-triangle-exclamation me-2"></i> O campo Serviço é obrigatório.
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
            const servico = document.getElementById('servico');
            if (!servico.value.trim()) {
                servico.classList.add('is-invalid');
                document.getElementById('erroForm').classList.remove('d-none');
            } else {
                alert('Localização atualizada com sucesso!');
                window.location.href = 'lista.php';
            }
        });
    </script>

<?php include '../../includes/footer.php'; ?>
