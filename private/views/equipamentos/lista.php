<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

        <!-- CONTEÚDO -->
        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 fw-bold" style="color: #004f63;">
                    <i class="fas fa-stethoscope me-2"></i> Listagem de Equipamentos
                </h2>
                <a href="novo.php" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                    <i class="fas fa-plus me-1"></i> Novo Equipamento
                </a>
            </div>
            <hr>

            <!-- FILTROS / PESQUISA -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body py-3">
                    <form class="row g-2 align-items-end" id="formPesquisa">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Pesquisar</label>
                            <input type="text" class="form-control form-control-sm" id="pesquisa"
                                placeholder="Designação, marca, modelo...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold mb-1">Estado</label>
                            <select class="form-select form-select-sm" id="filtroEstado">
                                <option value="">Todos</option>
                                <option>Ativo</option>
                                <option>Em manutenção</option>
                                <option>Em calibração</option>
                                <option>Em quarentena</option>
                                <option>Inativo</option>
                                <option>Abatido</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold mb-1">Criticidade</label>
                            <select class="form-select form-select-sm" id="filtroCriticidade">
                                <option value="">Todas</option>
                                <option>Baixa</option>
                                <option>Média</option>
                                <option>Alta</option>
                                <option>Suporte de vida</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold mb-1">Categoria</label>
                            <select class="form-select form-select-sm" id="filtroCategoria">
                                <option value="">Todas</option>
                                <option>Monitorização</option>
                                <option>Suporte de vida</option>
                                <option>Terapia</option>
                                <option>Diagnóstico</option>
                                <option>Laboratório</option>
                                <option>Esterilização</option>
                                <option>Reabilitação</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold mb-1">Serviço</label>
                            <input type="text" class="form-control form-control-sm" id="filtroServico" placeholder="Serviço/Departamento">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm w-100 text-white" style="background-color: #00b8d9;"
                                onclick="pesquisar()">
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
                                    <th>Código</th>
                                    <th>Designação</th>
                                    <th>Marca / Modelo</th>
                                    <th>Nº Série</th>
                                    <th>Serviço</th>
                                    <th>Estado</th>
                                    <th>Criticidade</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tabelaCorpo">
                                <tr>
                                    <td><code>04.002.00</code></td>
                                    <td>Monitor multiparamétrico</td>
                                    <td>Philips / IntelliVue MP5</td>
                                    <td>MP5-2022-45873</td>
                                    <td>UCI</td>
                                    <td><span class="estado-badge badge-ativo">Ativo</span></td>
                                    <td><span class="critico-badge badge-critico-alta">Alta</span></td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1" title="Ver detalhes"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1" title="Editar"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger" title="Remover"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><code>06.001.00</code></td>
                                    <td>Ventilador pulmonar</td>
                                    <td>Dräger / Evita V500</td>
                                    <td>EV500-2021-9934</td>
                                    <td>UCI</td>
                                    <td><span class="estado-badge badge-ativo">Ativo</span></td>
                                    <td><span class="critico-badge badge-critico-vida">Suporte de vida</span></td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><code>03.005.00</code></td>
                                    <td>Bomba de infusão</td>
                                    <td>B. Braun / Infusomat Space</td>
                                    <td>INF-2020-88321</td>
                                    <td>Medicina Interna</td>
                                    <td><span class="estado-badge badge-manutencao">Em manutenção</span></td>
                                    <td><span class="critico-badge badge-critico-media">Média</span></td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><code>02.003.00</code></td>
                                    <td>Desfibrilhador</td>
                                    <td>Zoll / R Series</td>
                                    <td>ZR-2021-7712</td>
                                    <td>Urgência</td>
                                    <td><span class="estado-badge badge-ativo">Ativo</span></td>
                                    <td><span class="critico-badge badge-critico-vida">Suporte de vida</span></td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><code>09.001.00</code></td>
                                    <td>Ecógrafo</td>
                                    <td>GE / Vivid S70</td>
                                    <td>GE-2019-33201</td>
                                    <td>Cardiologia</td>
                                    <td><span class="estado-badge badge-calibracao">Em calibração</span></td>
                                    <td><span class="critico-badge badge-critico-alta">Alta</span></td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted small d-flex justify-content-between">
                    <span>A mostrar 5 de 1 487 equipamentos</span>
                    <span>Ordenar por: <strong>Código</strong></span>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    function pesquisar() {
        const texto = document.getElementById('pesquisa').value.toLowerCase();
        const estado = document.getElementById('filtroEstado').value.toLowerCase();
        const critico = document.getElementById('filtroCriticidade').value.toLowerCase();
        const servico = document.getElementById('filtroServico').value.toLowerCase();
        const linhas = document.querySelectorAll('#tabelaCorpo tr');
        linhas.forEach(function (linha) {
            const textoLinha = linha.textContent.toLowerCase();
            const visivel =
                (!texto || textoLinha.includes(texto)) &&
                (!estado || textoLinha.includes(estado)) &&
                (!critico || textoLinha.includes(critico)) &&
                (!servico || textoLinha.includes(servico));
            linha.style.display = visivel ? '' : 'none';
        });
    }
    document.getElementById('pesquisa').addEventListener('keyup', pesquisar);
</script>

<?php include '../../includes/footer.php'; ?>
