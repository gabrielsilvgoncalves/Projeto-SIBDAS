<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$idEncrypted = $_GET['id'] ?? null;
$id = aes_decrypt($idEncrypted);
if (!$id || !is_numeric($id)) { header('Location: lista.php'); exit; }
$id = (int) $id;

try {
    $ligacao = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DATABASE.";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $ligacao->prepare(
        "SELECT e.*, l.nome AS loc_nome, l.descricao AS loc_descricao, l.piso AS loc_piso, l.ala AS loc_ala
         FROM equipamentos e
         LEFT JOIN localizacoes l ON e.id_localizacao = l.id
         WHERE e.id = :id AND e.deleted_at IS NULL LIMIT 1"
    );
    $stmt->execute([':id' => $id]);
    $eq = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$eq) { header('Location: lista.php'); exit; }

    $stmtDocs = $ligacao->prepare("SELECT COUNT(*) FROM documentos WHERE id_equipamento = :id AND deleted_at IS NULL");
    $stmtDocs->execute([':id' => $id]);
    $numDocs = (int) $stmtDocs->fetchColumn();

    $stmtGar = $ligacao->prepare("SELECT * FROM garantias WHERE id_equipamento = :id ORDER BY data_fim DESC LIMIT 1");
    $stmtGar->execute([':id' => $id]);
    $gar = $stmtGar->fetch(PDO::FETCH_OBJ);

    $ligacao = null;
} catch (PDOException $err) {
    die("Erro de ligação: " . $err->getMessage());
}

$estadoClasses = [
    'Ativo' => 'badge-ativo', 'Em manutenção' => 'badge-manutencao',
    'Em calibração' => 'badge-calibracao', 'Em quarentena' => 'badge-quarentena',
    'Inativo' => 'badge-inativo', 'Abatido' => 'badge-abatido',
];
$criticoClasses = [
    'Baixa' => 'badge-critico-baixa', 'Média' => 'badge-critico-media',
    'Alta' => 'badge-critico-alta', 'Suporte de vida' => 'badge-critico-vida',
];
$estadoClass = $estadoClasses[$eq->estado] ?? '';
$criticoClass = $criticoClasses[$eq->criticidade] ?? '';

$garBadge = '';
if ($gar) {
    $hoje = date('Y-m-d');
    $diasFim = (strtotime($gar->data_fim) - time()) / 86400;
    if ($gar->data_fim < $hoje) {
        $garBadge = '<span class="badge bg-danger">Expirada</span>';
    } elseif ($diasFim <= 30) {
        $garBadge = '<span class="badge bg-warning text-dark">A expirar</span>';
    } else {
        $garBadge = '<span class="badge bg-success">Válida</span>';
    }
}
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 fw-bold" style="color: #004f63;">
                    <i class="fas fa-stethoscope me-2"></i> Ficha do Equipamento
                </h2>
                <div class="d-flex gap-2">
                    <a href="editar.php?id=<?= aes_encrypt($id) ?>" class="btn btn-warning btn-sm fw-semibold">
                        <i class="fas fa-pen-to-square me-1"></i> Editar
                    </a>
                    <a href="lista.php" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </div>
            <hr>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #004f63;"><?= htmlspecialchars($eq->designacao) ?></h4>
                        <p class="text-muted mb-0"><?= htmlspecialchars($eq->marca) ?> — <?= htmlspecialchars($eq->modelo) ?> &nbsp;|&nbsp; <code><?= htmlspecialchars($eq->codigo) ?></code></p>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="estado-badge <?= $estadoClass ?>"><?= htmlspecialchars($eq->estado) ?></span>
                        <span class="critico-badge <?= $criticoClass ?>"><?= htmlspecialchars($eq->criticidade) ?> criticidade</span>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-tag me-2"></i> Identificação
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Código Interno</td><td><code><?= htmlspecialchars($eq->codigo) ?></code></td></tr>
                                <tr><td class="text-muted fw-semibold">Designação</td><td><?= htmlspecialchars($eq->designacao) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Categoria</td><td><?= htmlspecialchars($eq->categoria) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Estado</td><td><span class="estado-badge <?= $estadoClass ?>"><?= htmlspecialchars($eq->estado) ?></span></td></tr>
                                <tr><td class="text-muted fw-semibold">Criticidade</td><td><span class="critico-badge <?= $criticoClass ?>"><?= htmlspecialchars($eq->criticidade) ?></span></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-industry me-2"></i> Fabricante e Modelo
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Marca</td><td><?= htmlspecialchars($eq->marca) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Modelo</td><td><?= htmlspecialchars($eq->modelo) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Nº Série</td><td><?= htmlspecialchars($eq->numero_serie) ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Data de Aquisição</td><td><?= $eq->data_aquisicao ? date('d/m/Y', strtotime($eq->data_aquisicao)) : '—' ?></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-map-marker-alt me-2"></i> Localização
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted fw-semibold" style="width:45%">Edifício</td><td><?= htmlspecialchars($eq->loc_ala ?? '—') ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Piso</td><td><?= htmlspecialchars($eq->loc_piso ?? '—') ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Serviço</td><td><?= htmlspecialchars($eq->loc_nome ?? '—') ?></td></tr>
                                <tr><td class="text-muted fw-semibold">Sala</td><td><?= htmlspecialchars($eq->loc_descricao ?? '—') ?></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-shield-alt me-2"></i> Garantia
                        </div>
                        <div class="card-body">
                            <?php if ($gar): ?>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td class="text-muted fw-semibold" style="width:45%">Início</td><td><?= date('d/m/Y', strtotime($gar->data_inicio)) ?></td></tr>
                                    <tr><td class="text-muted fw-semibold">Fim</td><td><?= date('d/m/Y', strtotime($gar->data_fim)) ?></td></tr>
                                    <tr><td class="text-muted fw-semibold">Tipo</td><td><?= htmlspecialchars($gar->tipo) ?></td></tr>
                                    <tr><td class="text-muted fw-semibold">Estado</td><td><?= $garBadge ?></td></tr>
                                </table>
                            <?php else: ?>
                                <p class="text-muted mb-0">Sem garantia registada.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header fw-bold" style="background-color: #004f63; color: white;">
                            <i class="fas fa-file-medical me-2"></i> Documentação
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><?= $numDocs > 0 ? "<strong>$numDocs documento(s)</strong> associado(s) a este equipamento." : '<span class="text-muted">Sem documentos associados.</span>' ?></p>
                            <a href="../documentos/novo.php" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-plus me-1"></i> Adicionar documento
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="editar.php?id=<?= aes_encrypt($id) ?>" class="btn btn-warning fw-semibold">
                    <i class="fas fa-pen-to-square me-1"></i> Editar Equipamento
                </a>
                <a href="lista.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Voltar à lista
                </a>
            </div>
        </main>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
