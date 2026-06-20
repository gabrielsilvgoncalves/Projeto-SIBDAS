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
        SELECT e.*, l.nome AS localizacao_nome
        FROM equipamentos e
        LEFT JOIN localizacoes l ON e.id_localizacao = l.id
        ORDER BY e.codigo
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
                                <?php if (!empty($erro)): ?>
                                    <tr><td colspan="8" class="text-center text-danger py-3"><?= htmlspecialchars($erro) ?></td></tr>
                                <?php elseif (empty($resultados)): ?>
                                    <tr><td colspan="8" class="text-center text-muted py-3">Nenhum equipamento encontrado.</td></tr>
                                <?php else: ?>
                                    <?php
                                    $estadoBadges = [
                                        'Ativo'          => 'badge-ativo',
                                        'Em manutenção'  => 'badge-manutencao',
                                        'Em calibração'  => 'badge-calibracao',
                                        'Em quarentena'  => 'badge-quarentena',
                                        'Inativo'        => 'badge-inativo',
                                        'Abatido'        => 'badge-abatido',
                                    ];
                                    $criticoBadges = [
                                        'Baixa'           => 'badge-critico-baixa',
                                        'Média'           => 'badge-critico-media',
                                        'Alta'            => 'badge-critico-alta',
                                        'Suporte de vida' => 'badge-critico-vida',
                                    ];
                                    foreach ($resultados as $eq):
                                        $estadoClass  = $estadoBadges[$eq->estado] ?? '';
                                        $criticoClass = $criticoBadges[$eq->criticidade] ?? '';
                                    ?>
                                    <tr>
                                        <td><code><?= htmlspecialchars($eq->codigo) ?></code></td>
                                        <td><?= htmlspecialchars($eq->designacao) ?></td>
                                        <td><?= htmlspecialchars($eq->marca) ?> / <?= htmlspecialchars($eq->modelo) ?></td>
                                        <td><?= htmlspecialchars($eq->numero_serie) ?></td>
                                        <td><?= htmlspecialchars($eq->localizacao_nome ?? '-') ?></td>
                                        <td><span class="estado-badge <?= $estadoClass ?>"><?= htmlspecialchars($eq->estado) ?></span></td>
                                        <td><span class="critico-badge <?= $criticoClass ?>"><?= htmlspecialchars($eq->criticidade) ?></span></td>
                                        <td class="text-center">
                                            <a href="detalhes.php?id=<?= $eq->id ?>" class="btn btn-sm btn-outline-primary me-1" title="Ver detalhes"><i class="fas fa-eye"></i></a>
                                            <a href="editar.php?id=<?= $eq->id ?>" class="btn btn-sm btn-outline-warning me-1" title="Editar"><i class="fas fa-pen-to-square"></i></a>
                                            <a href="apagar.php?id=<?= $eq->id ?>" class="btn btn-sm btn-outline-danger" title="Remover"><i class="fas fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted small d-flex justify-content-between">
                    <span>A mostrar <?= count($resultados) ?> equipamento(s)</span>
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
