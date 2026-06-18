<?php
// Inicia a sessão para poder usar a variável $_SESSION
session_start();
// --------------------------------------------------------------------
// SEGURANÇA: Impede que o utilizador aceda diretamente a este script.
// Este ficheiro deve ser acedido apenas através de submissão de formulário (POST).
// Se for acedido diretamente (por URL), será redirecionado para o login.
// --------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // Redireciona para o formulário de login (interface pública)
    header('Location: ../public/login.php');
    // Encerra a execução do script imediatamente após o redirecionamento
    return;
}
// --------------------------------------------------------------------
// RECOLHA DE DADOS DO FORMULÁRIO
// --------------------------------------------------------------------
// Verifica se o campo 'text_username' foi enviado via POST.
// Se sim, guarda-o na variável $username. Caso contrário, usa string vazia.
$username = isset($_POST['text_username']) ? $_POST['text_username'] : '';
// O mesmo para o campo da password.
$password = isset($_POST['text_password']) ? $_POST['text_password'] : '';
// --------------------------------------------------------------------
// VALIDAÇÃO DOS DADOS
// --------------------------------------------------------------------
// Inicializa um array vazio para guardar mensagens de erro de validação
$validation_errors = [];
// Verifica se o nome de utilizador (username) é um endereço de email válido
// Se não for, adiciona uma mensagem de erro ao array
if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
    $validation_errors[] = 'O username tem que ser um email válido.';
}
// Verifica se o nome de utilizador tem um comprimento entre 5 e 50 caracteres
if (strlen($username) < 5 || strlen($username) > 50) {
    $validation_errors[] = 'O username deve ter entre 5 e 50 caracteres.';
}
// Verifica se a password tem um comprimento entre 6 e 12 caracteres
if (strlen($password) < 6 || strlen($password) > 12) {
    $validation_errors[] = 'A password deve ter entre 6 e 12 caracteres.';
}
// Se existirem erros de validação, guarda-os na sessão e redireciona para o login
if (!empty($validation_errors)) {
    $_SESSION['validation_errors'] = $validation_errors;
    header('Location: ../public/login.php');
    exit;
}
// --------------------------------------------------------------------
// SIMULAÇÃO DE RESULTADO DE LOGIN (antes da ligação real à base de dados)
// --------------------------------------------------------------------
// Simula o resultado que viria de uma verificação à base de dados
// Neste caso, assume-se que o login é válido (status = 1)
// Mais tarde, esta variável será substituída por um resultado real vindo da BD
$result['status'] = 1; // 1 = login válido, 0 = inválido

// Verifica se o status retornado indica login inválido
if (!$result['status']) {
    // Se o login for inválido, guarda uma mensagem de erro na sessão
    $_SESSION['server_error'] = 'Login inválido';

    // Redireciona o utilizador novamente para o formulário de login
    header('Location: ../public/login.php');

    // Encerra o script para não continuar o processamento
    return;
}
// -------------------------------------------------------------------
// LOGIN BEM-SUCEDIDO: Guardar o utilizador na sessão
// -------------------------------------------------------------------
// Guarda o nome de utilizador na sessão para identificar o utilizador autenticado
$_SESSION['utilizador'] = $username;
// Agora código da área privada
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <!-- ===== CONTEÚDO PRINCIPAL ===== -->
        <main class="col-md-9 col-lg-10 p-4" style="background-color: #f2f2f2;">
            <h2 class="mb-1 fw-bold" style="color: #004f63;">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </h2>
            <p class="text-muted mb-4">Visão geral do inventário hospitalar</p>

            <!-- ===== APRESENTAÇÃO TEMPORÁRIA DE DADOS (apenas para testes) ===== -->
            <div class="alert alert-info mb-4">
                <strong>Dados submetidos (temporário — remover em produção):</strong><br>
                Username: <?= htmlspecialchars($username) ?><br>
                Password: <?= htmlspecialchars($password) ?>
            </div>

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
