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
                <h2 class="mb-0 fw-bold" style="color: #004f63;">
                    <i class="fas fa-truck me-2"></i> Listagem de Fornecedores
                </h2>
                <a href="novo.php" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                    <i class="fas fa-plus me-1"></i> Novo Fornecedor
                </a>
            </div>
            <hr>

            <!-- FILTROS -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body py-3">
                    <form class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Pesquisar</label>
                            <input type="text" class="form-control form-control-sm" id="pesquisa"
                                placeholder="Nome, NIF, contacto...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Tipo de Fornecedor</label>
                            <select class="form-select form-select-sm" id="filtroTipo">
                                <option value="">Todos</option>
                                <option>Fabricante</option>
                                <option>Distribuidor / Fornecedor comercial</option>
                                <option>Empresa de assistência técnica</option>
                                <option>Fornecedor de consumíveis</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm text-white" style="background-color: #00b8d9;"
                                onclick="pesquisar()">
                                <i class="fas fa-search me-1"></i> Pesquisar
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
                                    <th>Nome da Empresa</th>
                                    <th>NIF</th>
                                    <th>Tipo</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>Pessoa de Contacto</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tabelaCorpo">
                                <tr>
                                    <td><strong>Philips Healthcare Portugal</strong></td>
                                    <td>500 123 456</td>
                                    <td><span class="badge bg-primary">Fabricante</span></td>
                                    <td>+351 21 345 6789</td>
                                    <td>info@philips.pt</td>
                                    <td>Ana Rodrigues</td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1" title="Ver"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1" title="Editar"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger" title="Remover"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Dräger Medical Portugal</strong></td>
                                    <td>502 987 654</td>
                                    <td><span class="badge bg-primary">Fabricante</span></td>
                                    <td>+351 21 456 7890</td>
                                    <td>contacto@draeger.pt</td>
                                    <td>Carlos Mendes</td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>MedTech Services</strong></td>
                                    <td>508 654 321</td>
                                    <td><span class="badge bg-success">Assistência técnica</span></td>
                                    <td>+351 22 567 8901</td>
                                    <td>servicos@medtech.pt</td>
                                    <td>Rita Ferreira</td>
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>B. Braun Portugal</strong></td>
                                    <td>501 333 222</td>
                                    <td><span class="badge bg-secondary">Distribuidor</span></td>
                                    <td>+351 21 678 9012</td>
                                    <td>info@bbraun.pt</td>
                                    <td>João Oliveira</td>
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
                <div class="card-footer text-muted small">A mostrar 4 fornecedores</div>
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
