<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 fw-bold" style="color: #004f63;"><i class="fas fa-shield-alt me-2"></i> Garantias e Contratos</h2>
                <a href="novo.php" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                    <i class="fas fa-plus me-1"></i> Registar Garantia
                </a>
            </div>
            <hr>

            <!-- ALERTA VISUAL -->
            <div class="alert alert-warning d-flex align-items-center mb-3 py-2" role="alert">
                <i class="fas fa-clock me-2 fs-5"></i>
                <div><strong>12 garantias</strong> a expirar nos próximos 30 dias. <a href="#" class="alert-link">Ver detalhes</a></div>
            </div>

            <!-- FILTROS -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body py-3">
                    <form class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Pesquisar</label>
                            <input type="text" class="form-control form-control-sm" id="pesquisa" placeholder="Equipamento, código...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Tipo de Contrato</label>
                            <select class="form-select form-select-sm" id="filtroTipo">
                                <option value="">Todos</option>
                                <option>Anual</option>
                                <option>Plurianual</option>
                                <option>Por chamada</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Estado</label>
                            <select class="form-select form-select-sm" id="filtroEstado">
                                <option value="">Todos</option>
                                <option>Válida</option>
                                <option>A expirar</option>
                                <option>Expirada</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm text-white" style="background-color: #00b8d9;" onclick="pesquisar()">
                                <i class="fas fa-search"></i>
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
                                    <th>Equipamento</th>
                                    <th>Início Garantia</th>
                                    <th>Fim Garantia</th>
                                    <th>Contrato</th>
                                    <th>Tipo</th>
                                    <th>Entidade</th>
                                    <th>Estado</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tabelaCorpo">
                                <tr>
                                    <td><a href="../equipamentos/detalhes.php"><strong>04.002.00</strong> — Monitor Philips MP5</a></td>
                                    <td>15/03/2022</td>
                                    <td class="text-warning fw-semibold">28/05/2025</td>
                                    <td><i class="fas fa-check-circle text-success me-1"></i>Sim — Anual</td>
                                    <td>Anual</td>
                                    <td>Philips Healthcare</td>
                                    <td><span class="badge bg-warning text-dark">A expirar</span></td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="../equipamentos/detalhes.php"><strong>06.001.00</strong> — Ventilador Dräger</a></td>
                                    <td>20/06/2021</td>
                                    <td>20/06/2026</td>
                                    <td><i class="fas fa-check-circle text-success me-1"></i>Sim — Plurianual</td>
                                    <td>Plurianual</td>
                                    <td>Dräger Medical</td>
                                    <td><span class="badge bg-success">Válida</span></td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="../equipamentos/detalhes.php"><strong>03.005.00</strong> — Bomba B. Braun</a></td>
                                    <td>10/08/2020</td>
                                    <td class="text-danger fw-semibold">10/08/2023</td>
                                    <td><i class="fas fa-times-circle text-danger me-1"></i>Não</td>
                                    <td>—</td>
                                    <td>—</td>
                                    <td><span class="badge bg-danger">Expirada</span></td>
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
                <div class="card-footer text-muted small">3 registos de garantia</div>
            </div>
        </main>
    </div>
</div>

<script>
    function pesquisar() {
        const texto = document.getElementById('pesquisa').value.toLowerCase();
        const tipo = document.getElementById('filtroTipo').value.toLowerCase();
        const estado = document.getElementById('filtroEstado').value.toLowerCase();
        document.querySelectorAll('#tabelaCorpo tr').forEach(function (linha) {
            const txt = linha.textContent.toLowerCase();
            linha.style.display = (!texto || txt.includes(texto)) && (!tipo || txt.includes(tipo)) && (!estado || txt.includes(estado)) ? '' : 'none';
        });
    }
    document.getElementById('pesquisa').addEventListener('keyup', pesquisar);
</script>

<?php include '../../includes/footer.php'; ?>
