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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 fw-bold" style="color: #004f63;"><i class="fas fa-file-medical me-2"></i> Documentos Técnicos</h2>
                <a href="novo.php" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                    <i class="fas fa-plus me-1"></i> Associar Documento
                </a>
            </div>
            <hr>

            <!-- FILTROS -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body py-3">
                    <form class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Pesquisar equipamento</label>
                            <input type="text" class="form-control form-control-sm" id="pesquisa" placeholder="Código, designação...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Tipo de Documento</label>
                            <select class="form-select form-select-sm" id="filtroTipo">
                                <option value="">Todos</option>
                                <option>Manual de utilizador</option>
                                <option>Manual de serviço</option>
                                <option>Certificado de calibração</option>
                                <option>Contrato de manutenção</option>
                                <option>Fatura / Guia de aquisição</option>
                                <option>Declaração de conformidade</option>
                                <option>Relatório técnico</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm text-white" style="background-color: #00b8d9;" onclick="pesquisar()">
                                <i class="fas fa-search me-1"></i> Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TABELA -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Tipo de Documento</th>
                                    <th>Nome do Documento</th>
                                    <th>Equipamento Associado</th>
                                    <th>Data do Doc.</th>
                                    <th>Validade</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tabelaCorpo">
                                <tr>
                                    <td><span class="badge bg-info text-dark">Manual de utilizador</span></td>
                                    <td>Manual IntelliVue MP5 PT</td>
                                    <td><a href="../equipamentos/detalhes.php">04.002.00 — Monitor multiparamétrico</a></td>
                                    <td>15/03/2022</td>
                                    <td class="text-muted">—</td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-warning text-dark">Cert. calibração</span></td>
                                    <td>Calibração Bomba Infusão 2024</td>
                                    <td><a href="../equipamentos/detalhes.php">03.005.00 — Bomba de infusão</a></td>
                                    <td>10/01/2024</td>
                                    <td class="text-danger fw-semibold">10/01/2025 <i class="fas fa-exclamation-circle ms-1"></i></td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-secondary">Contrato manutenção</span></td>
                                    <td>Contrato Philips 2024-2025</td>
                                    <td><a href="../equipamentos/detalhes.php">04.002.00 — Monitor multiparamétrico</a></td>
                                    <td>01/01/2024</td>
                                    <td class="text-warning fw-semibold">31/12/2025</td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-primary">Manual de serviço</span></td>
                                    <td>Service Manual Evita V500</td>
                                    <td><a href="../equipamentos/detalhes.php">06.001.00 — Ventilador pulmonar</a></td>
                                    <td>20/06/2021</td>
                                    <td class="text-muted">—</td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-dark">Fatura / Aquisição</span></td>
                                    <td>Fatura Desfibrilhador Zoll 2021</td>
                                    <td><a href="../equipamentos/detalhes.php">02.003.00 — Desfibrilhador</a></td>
                                    <td>05/09/2021</td>
                                    <td class="text-muted">—</td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted small">5 documentos registados</div>
            </div>
        </main>
    </div>
</div>

<script>
    function pesquisar() {
        const texto = document.getElementById('pesquisa').value.toLowerCase();
        const tipo = document.getElementById('filtroTipo').value.toLowerCase();
        document.querySelectorAll('#tabelaCorpo tr').forEach(function (linha) {
            const txt = linha.textContent.toLowerCase();
            linha.style.display = (!texto || txt.includes(texto)) && (!tipo || txt.includes(tipo)) ? '' : 'none';
        });
    }
    document.getElementById('pesquisa').addEventListener('keyup', pesquisar);
</script>

<?php include '../../includes/footer.php'; ?>
