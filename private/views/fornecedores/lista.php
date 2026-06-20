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
    $resultados = $ligacao->query("SELECT * FROM fornecedores WHERE deleted_at IS NULL ORDER BY nome")->fetchAll(PDO::FETCH_OBJ);
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
                                    <th>País</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>Cidade</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tabelaCorpo">
                                <?php if (!empty($erro)): ?>
                                    <tr><td colspan="7" class="text-center text-danger py-3"><?= htmlspecialchars($erro) ?></td></tr>
                                <?php elseif (empty($resultados)): ?>
                                    <tr><td colspan="7" class="text-center text-muted py-3">Nenhum fornecedor encontrado.</td></tr>
                                <?php else: foreach ($resultados as $f): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($f->nome) ?></strong></td>
                                    <td><?= htmlspecialchars($f->nif ?? '—') ?></td>
                                    <td><?= htmlspecialchars($f->pais ?? '—') ?></td>
                                    <td><?= htmlspecialchars($f->telefone ?? '—') ?></td>
                                    <td><?= htmlspecialchars($f->email ?? '—') ?></td>
                                    <td><?= htmlspecialchars($f->cidade ?? '—') ?></td>
                                    <td class="text-center">
                                        <a href="detalhes.php?id=<?= $f->id ?>" class="btn btn-sm btn-outline-primary me-1" title="Ver"><i class="fas fa-eye"></i></a>
                                        <a href="editar.php?id=<?= $f->id ?>" class="btn btn-sm btn-outline-warning me-1" title="Editar"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="apagar.php?id=<?= $f->id ?>" class="btn btn-sm btn-outline-danger" title="Remover"><i class="fas fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted small">A mostrar <?= count($resultados) ?> fornecedor(es)</div>
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
