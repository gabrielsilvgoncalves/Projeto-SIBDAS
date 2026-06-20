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
        SELECT l.*, COUNT(e.id) AS total_equipamentos
        FROM localizacoes l
        LEFT JOIN equipamentos e ON e.id_localizacao = l.id
        GROUP BY l.id
        ORDER BY l.piso
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
                <h2 class="mb-0 fw-bold" style="color: #004f63;"><i class="fas fa-map-marker-alt me-2"></i> Localizações</h2>
                <a href="novo.php" class="btn text-white fw-semibold" style="background-color: #00b8d9;">
                    <i class="fas fa-plus me-1"></i> Nova Localização
                </a>
            </div>
            <hr>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tabela-localizacoes" class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr><th>Edifício</th><th>Piso</th><th>Serviço / Departamento</th><th>Sala / Gabinete</th><th class="text-center">Nº Equip.</th><th class="text-center">Ações</th></tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($erro)): ?>
                                    <tr><td colspan="6" class="text-center text-danger py-3"><?= htmlspecialchars($erro) ?></td></tr>
                                <?php elseif (empty($resultados)): ?>
                                    <tr><td colspan="6" class="text-center text-muted py-3">Nenhuma localização encontrada.</td></tr>
                                <?php else: foreach ($resultados as $l): ?>
                                <tr>
                                    <td><?= htmlspecialchars($l->ala ?? '—') ?></td>
                                    <td>Piso <?= htmlspecialchars($l->piso) ?></td>
                                    <td><?= htmlspecialchars($l->nome) ?></td>
                                    <td><?= htmlspecialchars($l->descricao ?? '—') ?></td>
                                    <td class="text-center"><?= $l->total_equipamentos ?></td>
                                    <td class="text-center">
                                        <a href="editar.php?id=<?= $l->id ?>" class="btn btn-sm btn-outline-warning me-1"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php?id=<?= $l->id ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted small d-flex justify-content-between">
                    <span><?= count($resultados) ?> localização(ões) registada(s)</span>
                    <span>Ordenado por: <strong>Piso</strong></span>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tabela-localizacoes').DataTable({
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
        $('#tabela-localizacoes').closest('.card').after(
            $('#tabela-localizacoes_paginate').addClass('mt-2 d-flex justify-content-end px-1')
        );
    });
</script>

<?php include '../../includes/footer.php'; ?>
