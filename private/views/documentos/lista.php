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
        SELECT d.*, e.codigo, e.designacao
        FROM documentos d
        LEFT JOIN equipamentos e ON d.id_equipamento = e.id
        WHERE d.deleted_at IS NULL
        ORDER BY d.data_documento DESC
    ")->fetchAll(PDO::FETCH_OBJ);
    $erro = '';
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
}
$ligacao = null;
?>

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
                        <table id="tabela-documentos" class="table table-striped table-hover align-middle mb-0">
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
                                <?php if (!empty($erro)): ?>
                                    <tr><td colspan="6" class="text-center text-danger py-3"><?= htmlspecialchars($erro) ?></td></tr>
                                <?php elseif (empty($resultados)): ?>
                                    <tr><td colspan="6" class="text-center text-muted py-3">Nenhum documento encontrado.</td></tr>
                                <?php else: foreach ($resultados as $d): ?>
                                <tr>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($d->tipo) ?></span></td>
                                    <td><?= htmlspecialchars($d->titulo) ?></td>
                                    <td><a href="../equipamentos/detalhes.php?id=<?= $d->id_equipamento ?>"><?= htmlspecialchars($d->codigo) ?> — <?= htmlspecialchars($d->designacao) ?></a></td>
                                    <td><?= $d->data_documento ? date('d/m/Y', strtotime($d->data_documento)) : '—' ?></td>
                                    <td class="text-muted">—</td>
                                    <td class="text-center">
                                        <a href="detalhes.php?id=<?= $d->id ?>" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php?id=<?= $d->id ?>" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php?id=<?= $d->id ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted small d-flex justify-content-between">
                    <span><?= count($resultados) ?> documento(s) registado(s)</span>
                    <span>Ordenado por: <strong>Data</strong></span>
                </div>
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

<script>
    $(document).ready(function () {
        $('#tabela-documentos').DataTable({
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
        $('#tabela-documentos').closest('.card').after(
            $('#tabela-documentos_paginate').addClass('mt-2 d-flex justify-content-end px-1')
        );
    });
</script>

<?php include '../../includes/footer.php'; ?>
