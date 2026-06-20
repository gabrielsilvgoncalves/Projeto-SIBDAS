<?php
require_once 'includes/funcoes.php';
redirect_if_not_logged();
start_session();
$success_message = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);
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

        <!-- ===== CONTEÚDO PRINCIPAL ===== -->
        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <h2 class="mb-1 fw-bold" style="color: #004f63;">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </h2>
            <p class="text-muted mb-4">Visão geral do inventário hospitalar</p>

            <!-- ===== KPIs - LINHA 1 ===== -->
            <div class="row g-3 mb-4">
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card">
                        <div class="kpi-numero">1 487</div>
                        <div class="kpi-label">Total de Equipamentos</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card">
                        <div class="kpi-numero">1 312</div>
                        <div class="kpi-label">Equipamentos Ativos</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card kpi-warning">
                        <div class="kpi-numero">98</div>
                        <div class="kpi-label">Em Manutenção</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card kpi-danger">
                        <div class="kpi-numero">77</div>
                        <div class="kpi-label">Inativos / Abatidos</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card kpi-warning">
                        <div class="kpi-numero">43</div>
                        <div class="kpi-label">Garantias Expiradas</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="kpi-card kpi-info">
                        <div class="kpi-numero">115</div>
                        <div class="kpi-label">Sem Documentação</div>
                    </div>
                </div>
            </div>

            <!-- ===== KPIs - LINHA 2 ===== -->
            <div class="row g-3 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card kpi-warning">
                        <div class="kpi-numero">12</div>
                        <div class="kpi-label">Garantias a Expirar (30 dias)</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card kpi-danger">
                        <div class="kpi-numero">234</div>
                        <div class="kpi-label">Equipamentos de Alta Criticidade</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card">
                        <div class="kpi-numero">87</div>
                        <div class="kpi-label">Suporte de Vida</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card kpi-info">
                        <div class="kpi-numero">18</div>
                        <div class="kpi-label">Serviços / Departamentos</div>
                    </div>
                </div>
            </div>

            <!-- ===== TABELA: EQUIPAMENTOS POR SERVIÇO ===== -->
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
                                    <tr><td>Unidade de Cuidados Intensivos</td><td class="text-center">148</td></tr>
                                    <tr><td>Bloco Operatório</td><td class="text-center">212</td></tr>
                                    <tr><td>Urgência Geral</td><td class="text-center">183</td></tr>
                                    <tr><td>Medicina Interna</td><td class="text-center">96</td></tr>
                                    <tr><td>Cardiologia</td><td class="text-center">74</td></tr>
                                    <tr><td>Fisioterapia</td><td class="text-center">61</td></tr>
                                    <tr><td>Outros Serviços</td><td class="text-center">713</td></tr>
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
                            <div class="alert alert-warning py-2 px-3 mb-2 small">
                                <i class="fas fa-clock me-1"></i>
                                <strong>Monitor Philips MP5</strong> — Garantia expira em 8 dias
                            </div>
                            <div class="alert alert-warning py-2 px-3 mb-2 small">
                                <i class="fas fa-clock me-1"></i>
                                <strong>Ventilador Dräger Evita V500</strong> — Garantia expira em 15 dias
                            </div>
                            <div class="alert alert-danger py-2 px-3 mb-2 small">
                                <i class="fas fa-tools me-1"></i>
                                <strong>Bomba B.Braun (INF-2020-88321)</strong> — Em manutenção há 12 dias
                            </div>
                            <div class="alert alert-info py-2 px-3 mb-2 small">
                                <i class="fas fa-file-medical me-1"></i>
                                <strong>Desfibrilhador Zoll R Series</strong> — Sem certificado de calibração
                            </div>
                            <div class="alert alert-warning py-2 px-3 mb-0 small">
                                <i class="fas fa-clock me-1"></i>
                                <strong>Ecógrafo GE Vivid S70</strong> — Garantia expira em 28 dias
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== ACESSO RÁPIDO ===== -->
            <div class="card border-0 shadow-sm">
                <div class="card-header text-white fw-bold" style="background-color: #004f63;">
                    <i class="fas fa-bolt me-2"></i> Acesso Rápido
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="views/equipamentos/novo.php" class="btn btn-sm text-white fw-semibold"
                            style="background-color: #00b8d9;">
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
