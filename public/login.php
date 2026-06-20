<?php
// Inicia a sessão (necessário para usar $_SESSION)
session_start();
// Inicializa a variável que irá conter os erros de validação
$validation_errors = [];
// --------------------------------------------------------------------
// RECOLHA DE MENSAGENS TEMPORÁRIAS DA SESSÃO
// --------------------------------------------------------------------
// Verifica se existem erros de validação guardados na sessão
if (!empty($_SESSION['validation_errors'])) {
    // Se existirem, copia-os para a variável local
    $validation_errors = $_SESSION['validation_errors'];
    // Remove os erros da sessão para que não apareçam novamente numa recarga de página
    unset($_SESSION['validation_errors']);
}
// Inicializa a variável que irá conter erros de servidor
$server_error = [];
// Verifica se existe algum erro de servidor guardado na sessão
if (!empty($_SESSION['server_error'])) {
    // Se existir, copia-o para a variável local
    $server_error = $_SESSION['server_error'];
    // Remove o erro da sessão após ser lido
    unset($_SESSION['server_error']);
}
?>
<?php include '../private/includes/header.php'; ?>

    <main class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="col-lg-4 col-md-6 col-sm-8 col-11">

            <div class="card p-4 p-md-5 shadow-sm">

                <div class="d-flex align-items-center justify-content-center mb-4 gap-3">
                    <img src="/SIBDAS_projeto_final/public/assets/img/Logo.png" alt="Logo MedStock" height="55">
                    <h2 class="mb-0 logo-titulo"><?php echo APP_NAME; ?></h2>
                </div>

                <p class="text-center text-muted small mb-4">Introduza as suas credenciais para aceder ao sistema.</p>

                <form action="../private/processa_login.php" method="post" id="formLogin" novalidate>
                    <div class="mb-3">
                        <label for="utilizador" class="form-label fw-semibold">
                            <i class="fa-regular fa-user me-1"></i> Utilizador
                        </label>
                        <input type="text" class="form-control" id="utilizador" name="text_username"
                            placeholder="utilizador@hospital.pt" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">
                            <i class="fa-solid fa-lock me-1"></i> Password
                        </label>
                        <input type="password" class="form-control" id="password" name="text_password" placeholder="********"
                            required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-login">
                            Entrar <i class="fa-solid fa-right-to-bracket ms-2"></i>
                        </button>
                    </div>
                    <div class="d-grid">
                        <a href="/SIBDAS_projeto_final/public/index.php" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao início
                        </a>
                    </div>

                    <!-- -------------------------------------------------------------------- -->
                    <!-- APRESENTAÇÃO DE MENSAGENS DE ERRO (VALIDAÇÃO E SERVIDOR) -->
                    <!-- -------------------------------------------------------------------- -->
                    <!-- Verifica se existem erros de validação -->
                    <?php if (!empty($validation_errors)) : ?>
                        <!-- Se existirem, apresenta um alerta de erro (vermelho) usando as classes do Bootstrap -->
                        <div class="alert alert-danger p-2 text-center">
                            <!-- Percorre todos os erros de validação -->
                            <?php foreach ($validation_errors as $error) : ?>
                                <!-- Mostra cada erro dentro de uma <div>, escapando caracteres especiais para segurança -->
                                <div><?= htmlspecialchars($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <!-- Verifica se existe um erro de servidor -->
                    <?php if (!empty($server_error)) : ?>
                        <!-- Apresenta também num alerta de erro (vermelho) -->
                        <div class="alert alert-danger p-2 text-center">
                            <!-- Mostra o erro do servidor, também escapado com htmlspecialchars -->
                            <div><?= htmlspecialchars($server_error) ?></div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('formLogin').addEventListener('submit', function (e) {
            const user = document.getElementById('utilizador').value.trim();
            const pass = document.getElementById('password').value.trim();
            if (!user || !pass) {
                e.preventDefault();
                document.getElementById('erroLogin').classList.remove('d-none');
            }
        });
    </script>

<?php include '../private/includes/footer.php'; ?>
