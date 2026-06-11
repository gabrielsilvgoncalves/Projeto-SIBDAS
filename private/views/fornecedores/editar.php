<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

            <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
                <div class="d-flex justify-content-center">
                    <div class="card w-100 border-0 shadow-sm" style="max-width: 900px;">
                        <div class="card-body">
                            <h2 class="mb-4 fw-bold" style="color: #004f63;"><i class="fas fa-pen-to-square me-2"></i> Editar Fornecedor</h2>
                            <hr>
                            <form action="#" method="post" novalidate id="formEditar">
                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-building me-2"></i> Dados da Empresa</h5>
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label for="nome" class="form-label fw-semibold">Nome da Empresa <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="Philips Healthcare Portugal" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="nif" class="form-label fw-semibold">NIF <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nif" name="nif" value="500 123 456" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="tipo" class="form-label fw-semibold">Tipo <span class="text-danger">*</span></label>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option selected>Fabricante</option>
                                            <option>Distribuidor / Fornecedor comercial</option>
                                            <option>Empresa de assistência técnica</option>
                                            <option>Fornecedor de consumíveis</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="morada" class="form-label fw-semibold">Morada</label>
                                        <input type="text" class="form-control" id="morada" name="morada" value="Av. D. João II, nº 35, 1990-084 Lisboa">
                                    </div>
                                </div>
                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-phone me-2"></i> Contactos</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="telefone" class="form-label fw-semibold">Telefone</label>
                                        <input type="tel" class="form-control" id="telefone" name="telefone" value="+351 21 345 6789">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="info@philips.pt">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="website" class="form-label fw-semibold">Website</label>
                                        <input type="url" class="form-control" id="website" name="website" value="https://www.philips.pt">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="pessoa_contacto" class="form-label fw-semibold">Pessoa de Contacto</label>
                                        <input type="text" class="form-control" id="pessoa_contacto" name="pessoa_contacto" value="Ana Rodrigues">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tel_contacto" class="form-label fw-semibold">Telefone Direto</label>
                                        <input type="tel" class="form-control" id="tel_contacto" name="tel_contacto" value="+351 912 345 678">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="detalhes.php" class="btn btn-outline-secondary"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Alterações
                                    </button>
                                </div>
                                <div class="alert alert-danger mt-3 d-none" id="erroForm">
                                    <i class="fas fa-triangle-exclamation me-2"></i> Preencha os campos obrigatórios.
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
            const obrigatorios = ['nome', 'nif', 'tipo'];
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
