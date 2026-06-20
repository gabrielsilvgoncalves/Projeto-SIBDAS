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
                <h2 class="mb-1 fw-bold" style="color: #004f63;">
                    <i class="fas fa-globe me-2"></i> Gestão da Área Pública
                </h2>
                <p class="text-muted mb-4">Edite os conteúdos apresentados na página pública sem alterar o HTML diretamente.</p>

                <div class="alert alert-info d-flex align-items-center mb-4 py-2" role="alert">
                    <i class="fas fa-info-circle me-2 fs-5"></i>
                    <div>As alterações guardadas aqui serão refletidas na <a href="../../../public/index.php" target="_blank" class="alert-link">página pública</a>.</div>
                </div>

                <!-- SECÇÃO: TEXTO SOBRE NÓS -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                        <i class="fas fa-pen-to-square me-2"></i> Secção "Sobre Nós"
                    </div>
                    <div class="card-body">
                        <form id="formSobreNos">
                            <div class="mb-3">
                                <label for="textoSobreNos1" class="form-label fw-semibold">Parágrafo 1</label>
                                <textarea class="form-control" id="textoSobreNos1" rows="3">A MedStock nasceu da intersecção entre tecnologia de informação e a realidade clínica diária. Compreendemos que a gestão de um parque tecnológico hospitalar vai muito além de contar máquinas — trata-se de garantir que cada dispositivo está operacional, seguro e calibrado para quando é mais necessário: no momento do cuidado ao doente.</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="textoSobreNos2" class="form-label fw-semibold">Parágrafo 2</label>
                                <textarea class="form-control" id="textoSobreNos2" rows="2">A nossa plataforma web serve de base a futuras implementações de sistemas CMMS/GMAC, apoiando o ciclo de vida completo dos equipamentos médicos: desde a aquisição até ao abate.</textarea>
                            </div>
                            <button type="button" class="btn btn-sm text-white fw-semibold" style="background-color: #00b8d9;" onclick="guardar('formSobreNos')">
                                <i class="fas fa-floppy-disk me-1"></i> Guardar alterações
                            </button>
                        </form>
                    </div>
                </div>

                <!-- SECÇÃO: CONTACTOS -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                        <i class="fas fa-address-book me-2"></i> Informações de Contacto
                    </div>
                    <div class="card-body">
                        <form id="formContactos">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="emailPublico" class="form-label fw-semibold">Email público</label>
                                    <input type="email" class="form-control" id="emailPublico" value="geral@medstock.pt">
                                </div>
                                <div class="col-md-6">
                                    <label for="telefonePublico" class="form-label fw-semibold">Telefone</label>
                                    <input type="tel" class="form-control" id="telefonePublico" value="+351 912 345 567">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="moradaPublica" class="form-label fw-semibold">Morada</label>
                                <input type="text" class="form-control" id="moradaPublica" value="Rua Dr. António Bernardino de Almeida, 431, 4249-015 Porto">
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="horarioSemana" class="form-label fw-semibold">Horário (2ª a 6ª)</label>
                                    <input type="text" class="form-control" id="horarioSemana" value="9h — 18h">
                                </div>
                                <div class="col-md-4">
                                    <label for="horarioSabado" class="form-label fw-semibold">Horário (Sábado)</label>
                                    <input type="text" class="form-control" id="horarioSabado" value="10h — 13h">
                                </div>
                                <div class="col-md-4">
                                    <label for="horarioDomingo" class="form-label fw-semibold">Horário (Domingo/Feriados)</label>
                                    <input type="text" class="form-control" id="horarioDomingo" value="Encerrado">
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm text-white fw-semibold" style="background-color: #00b8d9;" onclick="guardar('formContactos')">
                                <i class="fas fa-floppy-disk me-1"></i> Guardar alterações
                            </button>
                        </form>
                    </div>
                </div>

                <!-- SECÇÃO: SERVIÇOS -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header fw-bold text-white" style="background-color: #004f63;">
                        <i class="fas fa-list-check me-2"></i> Serviços Apresentados
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Gerir os títulos e descrições dos serviços exibidos na área pública.</p>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Ícone</th>
                                        <th>Título</th>
                                        <th>Descrição</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fa-solid fa-clipboard-list text-muted"></i></td>
                                        <td>Inventário Centralizado</td>
                                        <td class="text-muted small">Registe, organize e consulte todos os equipamentos...</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-warning" onclick="editarServico(this)"><i class="fas fa-pen-to-square"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa-solid fa-map-location-dot text-muted"></i></td>
                                        <td>Localização em Tempo Real</td>
                                        <td class="text-muted small">Saiba em qualquer momento onde se encontra...</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-warning" onclick="editarServico(this)"><i class="fas fa-pen-to-square"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa-solid fa-truck text-muted"></i></td>
                                        <td>Gestão de Fornecedores</td>
                                        <td class="text-muted small">Associe fabricantes, distribuidores e empresas...</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-warning" onclick="editarServico(this)"><i class="fas fa-pen-to-square"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Toast de confirmação -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastGuardar" class="toast align-items-center text-white border-0" role="alert" style="background-color: #004f63;">
            <div class="d-flex">
                <div class="toast-body"><i class="fas fa-circle-check me-2"></i> Alterações guardadas com sucesso.</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
<script src="../../assets/js/1231236.js"></script>
    <script>
        function guardar(formId) {
            const toast = new bootstrap.Toast(document.getElementById('toastGuardar'), { delay: 3000 });
            toast.show();
        }
        function editarServico(btn) {
            const row = btn.closest('tr');
            const titulo = row.cells[1].textContent;
            alert('Edição do serviço "' + titulo + '" — funcionalidade disponível com backend PHP.');
        }
    </script>

<?php include '../../includes/footer.php'; ?>
