<?php
require_once 'includes/funcoes.php';
redirect_if_not_logged();
start_session();
$success_message = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);

try {
    $ligacao = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DATABASE.";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $kpis = [];

    // Total de equipamentos
    $kpis['total'] = (int) $ligacao->query("SELECT COUNT(*) FROM equipamentos WHERE deleted_at IS NULL")->fetchColumn();

    // Ativos
    $kpis['ativos'] = (int) $ligacao->query("SELECT COUNT(*) FROM equipamentos WHERE estado = 'Ativo' AND deleted_at IS NULL")->fetchColumn();

    // Em manutenção
    $kpis['manutencao'] = (int) $ligacao->query("SELECT COUNT(*) FROM equipamentos WHERE estado = 'Em manutenção' AND deleted_at IS NULL")->fetchColumn();

    // Inativos / Abatidos
    $kpis['inativos'] = (int) $ligacao->query("SELECT COUNT(*) FROM equipamentos WHERE estado IN ('Inativo','Abatido') AND deleted_at IS NULL")->fetchColumn();

    // Garantias expiradas
    $kpis['gar_expiradas'] = (int) $ligacao->query("SELECT COUNT(*) FROM garantias WHERE data_fim < CURDATE()")->fetchColumn();

    // Sem documentação
    $kpis['sem_docs'] = (int) $ligacao->query(
        "SELECT COUNT(*) FROM equipamentos WHERE deleted_at IS NULL
         AND id NOT IN (SELECT DISTINCT id_equipamento FROM documentos WHERE deleted_at IS NULL)"
    )->fetchColumn();

    // Garantias a expirar nos próximos 30 dias
    $kpis['gar_30dias'] = (int) $ligacao->query(
        "SELECT COUNT(*) FROM garantias WHERE data_fim >= CURDATE() AND data_fim <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)"
    )->fetchColumn();

    // Alta criticidade
    $kpis['alta_critico'] = (int) $ligacao->query("SELECT COUNT(*) FROM equipamentos WHERE criticidade = 'Alta' AND deleted_at IS NULL")->fetchColumn();

    // Suporte de vida
    $kpis['suporte_vida'] = (int) $ligacao->query("SELECT COUNT(*) FROM equipamentos WHERE criticidade = 'Suporte de vida' AND deleted_at IS NULL")->fetchColumn();

    // Serviços / Departamentos
    $kpis['servicos'] = (int) $ligacao->query("SELECT COUNT(*) FROM localizacoes")->fetchColumn();

    // Equipamentos por serviço
    $stmtServicos = $ligacao->query(
        "SELECT l.nome AS servico, COUNT(e.id) AS total
         FROM localizacoes l
         LEFT JOIN equipamentos e ON e.id_localizacao = l.id AND e.deleted_at IS NULL
         GROUP BY l.id, l.nome
         ORDER BY total DESC
         LIMIT 8"
    );
    $equip_por_servico = $stmtServicos->fetchAll(PDO::FETCH_OBJ);

    // Garantias a expirar em breve (alertas)
    $stmtAlertas = $ligacao->query(
        "SELECT e.designacao, e.marca, e.modelo, g.data_fim,
                DATEDIFF(g.data_fim, CURDATE()) AS dias_restantes
         FROM garantias g
         JOIN equipamentos e ON g.id_equipamento = e.id AND e.deleted_at IS NULL
         WHERE g.data_fim >= CURDATE() AND g.data_fim <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
         ORDER BY g.data_fim ASC
         LIMIT 5"
    );
    $alertas_garantias = $stmtAlertas->fetchAll(PDO::FETCH_OBJ);

    // Equipamentos em manutenção (alertas)
    $stmtManutencao = $ligacao->query(
        "SELECT designacao, marca, modelo, updated_at
         FROM equipamentos
         WHERE estado = 'Em manutenção' AND deleted_at IS NULL
         ORDER BY updated_at ASC
         LIMIT 3"
    );
    $alertas_manutencao = $stmtManutencao->fetchAll(PDO::FETCH_OBJ);

    $ligacao = null;
} catch (PDOException $err) {
    $kpis = array_fill_keys(['total','ativos','manutencao','inativos','gar_expiradas','sem_docs','gar_30dias','alta_critico','suporte_vida','servicos'], 0);
    $equip_por_servico = [];
    $alertas_garantias = [];
    $alertas_manutencao = [];
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

<?php if (!empty($success_message)) : ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div id="toastSuccess" class="toast align-items-center text-bg-success border-0 show" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <?= htmlspecialchars($success_message) ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <h2 class="mb-1 fw-bold" style="color: #004f63;">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </h2>
            <p class="text-muted mb-4">Visão geral do inventário hospitalar</p>

            <!-- KPIs - LINHA 1 -->
            <div class="row g-3 mb-4">
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card">
                        <div class="kpi-numero"><?= number_format($kpis['total'], 0, ',', ' ') ?></div>
                        <div class="kpi-label">Total de Equipamentos</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card">
                        <div class="kpi-numero"><?= number_format($kpis['ativos'], 0, ',', ' ') ?></div>
                        <div class="kpi-label">Equipamentos Ativos</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card kpi-warning">
                        <div class="kpi-numero"><?= $kpis['manutencao'] ?></div>
                        <div class="kpi-label">Em Manutenção</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card kpi-danger">
                        <div class="kpi-numero"><?= $kpis['inativos'] ?></div>
                        <div class="kpi-label">Inativos / Abatidos</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card kpi-warning">
                        <div class="kpi-numero"><?= $kpis['gar_expiradas'] ?></div>
                        <div class="kpi-label">Garantias Expiradas</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card kpi-info">
                        <div class="kpi-numero"><?= $kpis['sem_docs'] ?></div>
                        <div class="kpi-label">Sem Documentação</div>
                    </div>
                </div>
            </div>

            <!-- KPIs - LINHA 2 -->
            <div class="row g-3 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card kpi-warning">
                        <div class="kpi-numero"><?= $kpis['gar_30dias'] ?></div>
                        <div class="kpi-label">Garantias a Expirar (30 dias)</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card kpi-danger">
                        <div class="kpi-numero"><?= $kpis['alta_critico'] ?></div>
                        <div class="kpi-label">Equipamentos de Alta Criticidade</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card">
                        <div class="kpi-numero"><?= $kpis['suporte_vida'] ?></div>
                        <div class="kpi-label">Suporte de Vida</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card kpi-info">
                        <div class="kpi-numero"><?= $kpis['servicos'] ?></div>
                        <div class="kpi-label">Serviços / Departamentos</div>
                    </div>
                </div>
            </div>

            <!-- TABELA + ALERTAS -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header text-white fw-bold" style="background-color: #004f63;">
                            <i class="fas fa-chart-bar me-2"></i> Equipamentos por Serviço
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Serviço</th>
                                        <th class="text-center">Nº Equipamentos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($equip_por_servico)): ?>
                                        <tr><td colspan="2" class="text-center text-muted py-3">Sem dados disponíveis.</td></tr>
                                    <?php else: foreach ($equip_por_servico as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row->servico) ?></td>
                                            <td class="text-center"><?= $row->total ?></td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header text-white fw-bold" style="background-color: #004f63;">
                            <i class="fas fa-exclamation-triangle me-2"></i> Alertas Recentes
                        </div>
                        <div class="card-body">
                            <?php foreach ($alertas_garantias as $a): ?>
                                <div class="alert alert-warning py-2 px-3 mb-2 small">
                                    <i class="fas fa-clock me-1"></i>
                                    <strong><?= htmlspecialchars($a->designacao) ?> (<?= htmlspecialchars($a->marca) ?>)</strong>
                                    — Garantia expira em <?= $a->dias_restantes ?> dia(s)
                                </div>
                            <?php endforeach; ?>
                            <?php foreach ($alertas_manutencao as $a): ?>
                                <div class="alert alert-danger py-2 px-3 mb-2 small">
                                    <i class="fas fa-tools me-1"></i>
                                    <strong><?= htmlspecialchars($a->designacao) ?> (<?= htmlspecialchars($a->marca) ?>)</strong>
                                    — Em manutenção
                                </div>
                            <?php endforeach; ?>
                            <?php if (empty($alertas_garantias) && empty($alertas_manutencao)): ?>
                                <p class="text-muted mb-0 small"><i class="fas fa-check-circle text-success me-1"></i> Sem alertas ativos de momento.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACESSO RÁPIDO -->
            <div class="card border-0 shadow-sm">
                <div class="card-header text-white fw-bold" style="background-color: #004f63;">
                    <i class="fas fa-bolt me-2"></i> Acesso Rápido
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="views/equipamentos/novo.php" class="btn btn-sm text-white fw-semibold" style="background-color: #00b8d9;">
                            <i class="fas fa-plus me-1"></i> Novo Equipamento
                        </a>
                        <a href="views/fornecedores/novo.php" class="btn btn-sm btn-outline-secondary fw-semibold">
                            <i class="fas fa-plus me-1"></i> Novo Fornecedor
                        </a>
                        <a href="views/localizacoes/novo.php" class="btn btn-sm btn-outline-secondary fw-semibold">
                            <i class="fas fa-plus me-1"></i> Nova Localização
                        </a>
                        <a href="views/documentos/novo.php" class="btn btn-sm btn-outline-secondary fw-semibold">
                            <i class="fas fa-plus me-1"></i> Novo Documento
                        </a>
                        <a href="views/equipamentos/lista.php" class="btn btn-sm btn-outline-dark fw-semibold">
                            <i class="fas fa-list me-1"></i> Listar Equipamentos
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
