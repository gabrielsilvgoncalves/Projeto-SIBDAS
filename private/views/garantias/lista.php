<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<?php
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $resultados = $ligacao->query("
        SELECT g.*, e.codigo, e.designacao, f.nome AS fornecedor_nome
        FROM garantias g
        LEFT JOIN equipamentos e ON g.id_equipamento = e.id
        LEFT JOIN fornecedores f ON g.id_fornecedor = f.id
        ORDER BY g.data_fim ASC
    ")->fetchAll(PDO::FETCH_OBJ);
    $erro = '';
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
}
$ligacao = null;
$hoje = date('Y-m-d');
$em30dias = date('Y-m-d', strtotime('+30 days'));
?>

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
                        <table id="tabela-garantias" class="table table-striped table-hover align-middle mb-0">
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
                                <?php if (!empty($erro)): ?>
                                    <tr><td colspan="8" class="text-center text-danger py-3"><?= htmlspecialchars($erro) ?></td></tr>
                                <?php elseif (empty($resultados)): ?>
                                    <tr><td colspan="8" class="text-center text-muted py-3">Nenhuma garantia encontrada.</td></tr>
                                <?php else: foreach ($resultados as $g):
                                    if ($g->data_fim < $hoje) {
                                        $estadoBadge = '<span class="badge bg-danger">Expirada</span>';
                                        $fimClass = 'text-danger fw-semibold';
                                    } elseif ($g->data_fim <= $em30dias) {
                                        $estadoBadge = '<span class="badge bg-warning text-dark">A expirar</span>';
                                        $fimClass = 'text-warning fw-semibold';
                                    } else {
                                        $estadoBadge = '<span class="badge bg-success">Válida</span>';
                                        $fimClass = '';
                                    }
                                ?>
                                <tr>
                                    <td><a href="../equipamentos/detalhes.php?id=<?= aes_encrypt($g->id_equipamento) ?>"><strong><?= htmlspecialchars($g->codigo) ?></strong> — <?= htmlspecialchars($g->designacao) ?></a></td>
                                    <td><?= date('d/m/Y', strtotime($g->data_inicio)) ?></td>
                                    <td class="<?= $fimClass ?>"><?= date('d/m/Y', strtotime($g->data_fim)) ?></td>
                                    <td><?= htmlspecialchars($g->tipo) ?></td>
                                    <td><?= htmlspecialchars($g->tipo) ?></td>
                                    <td><?= htmlspecialchars($g->fornecedor_nome ?? '—') ?></td>
                                    <td><?= $estadoBadge ?></td>
                                    <td class="text-center">
                                        <a href="detalhes.php?id=<?= aes_encrypt($g->id) ?>" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php?id=<?= aes_encrypt($g->id) ?>" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php?id=<?= aes_encrypt($g->id) ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted small d-flex justify-content-between">
                    <span><?= count($resultados) ?> registo(s) de garantia</span>
                    <span>Ordenado por: <strong>Fim de Garantia</strong></span>
                </div>
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

<script>
    $(document).ready(function () {
        $('#tabela-garantias').DataTable({
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
            pagingType: "full_numbers",
            order: [],
            language: {
                decimal: "",
                emptyTable: "Sem dados disponíveis na tabela.",
                info: "Mostrando _START_ até _END_ de _TOTAL_ registos",
                infoEmpty: "Mostrando 0 até 0 de 0 registos",
                infoFiltered: "(Filtrando _MAX_ total de registos)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrando _MENU_ registos por página.",
                loadingRecords: "A carregar...",
                processing: "A processar...",
                search: "Filtrar:",
                zeroRecords: "Nenhum registo encontrado.",
                paginate: {
                    first: "Primeira",
                    last: "Última",
                    next: "Seguinte",
                    previous: "Anterior"
                },
                aria: {
                    sortAscending: ": ative para ordenar a coluna de forma crescente.",
                    sortDescending: ": ative para ordenar a coluna de forma decrescente."
                }
            }
        });
        $('#tabela-garantias').closest('.card').after(
            $('#tabela-garantias_paginate').addClass('mt-2 d-flex justify-content-end px-1')
        );
    });
</script>

<?php include '../../includes/footer.php'; ?>
