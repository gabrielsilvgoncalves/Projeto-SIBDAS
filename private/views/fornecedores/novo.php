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
                    <div class="card w-100 border-0 shadow-sm" style="max-width: 900px;">
                        <div class="card-body">
                            <h2 class="mb-4 fw-bold" style="color: #004f63;">
                                <i class="fas fa-plus me-2"></i> Inserir Novo Fornecedor
                            </h2>
                            <hr>
                            <form action="#" method="post" novalidate id="formFornecedor">

                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-building me-2"></i> Dados da Empresa</h5>
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label for="nome" class="form-label fw-semibold">Nome da Empresa <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo da empresa" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="nif" class="form-label fw-semibold">NIF <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nif" name="nif" placeholder="ex: 500 123 456" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="tipo" class="form-label fw-semibold">Tipo de Fornecedor <span class="text-danger">*</span></label>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option value="">-- Selecionar --</option>
                                            <option>Fabricante</option>
                                            <option>Distribuidor / Fornecedor comercial</option>
                                            <option>Empresa de assistência técnica</option>
                                            <option>Fornecedor de consumíveis</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="morada" class="form-label fw-semibold">Morada</label>
                                        <input type="text" class="form-control" id="morada" name="morada" placeholder="Rua, nº porta, código-postal, cidade">
                                    </div>
                                </div>

                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-phone me-2"></i> Contactos</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="telefone" class="form-label fw-semibold">Telefone</label>
                                        <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="+351 21 xxx xxxx">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="email@empresa.pt">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="website" class="form-label fw-semibold">Website</label>
                                        <input type="url" class="form-control" id="website" name="website" placeholder="https://www.empresa.pt">
                                    </div>
                                </div>

                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-user-tie me-2"></i> Pessoa de Contacto</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="pessoa_contacto" class="form-label fw-semibold">Nome</label>
                                        <input type="text" class="form-control" id="pessoa_contacto" name="pessoa_contacto" placeholder="Nome do responsável">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tel_contacto" class="form-label fw-semibold">Telefone Direto</label>
                                        <input type="tel" class="form-control" id="tel_contacto" name="tel_contacto" placeholder="+351 9xx xxx xxx">
                                    </div>
                                </div>

                                <h5 class="fw-bold mb-3 mt-4" style="color: #007fa3;"><i class="fas fa-note-sticky me-2"></i> Observações</h5>
                                <div class="mb-4">
                                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3"
                                        placeholder="Informações adicionais sobre o fornecedor..."></textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="lista.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-xmark me-1"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                                        <i class="fa-regular fa-floppy-disk me-1"></i> Guardar Fornecedor
                                    </button>
                                </div>

                                <div class="alert alert-danger mt-3 d-none" id="erroForm">
                                    <i class="fas fa-triangle-exclamation me-2"></i> Preencha os campos obrigatórios: Nome, NIF e Tipo.
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script>
        document.getElementById('formFornecedor').addEventListener('submit', function (e) {
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
                alert('Fornecedor guardado com sucesso!');
                window.location.href = 'lista.php';
            }
        });
    </script>

<?php include '../../includes/footer.php'; ?>
