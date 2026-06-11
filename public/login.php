<?php include '../private/includes/header.php'; ?>

    <main class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="col-lg-4 col-md-6 col-sm-8 col-11">

            <div class="card p-4 p-md-5 shadow-sm">

                <div class="d-flex align-items-center justify-content-center mb-4 gap-3">
                    <img src="/SIBDAS_projeto_final/public/assets/img/Logo.png" alt="Logo MedStock" height="55">
                    <h2 class="mb-0 logo-titulo">MedStock</h2>
                </div>

                <p class="text-center text-muted small mb-4">Introduza as suas credenciais para aceder ao sistema.</p>

                <form action="/SIBDAS_projeto_final/private/index.php" method="get" id="formLogin" novalidate>
                    <div class="mb-3">
                        <label for="utilizador" class="form-label fw-semibold">
                            <i class="fa-regular fa-user me-1"></i> Utilizador
                        </label>
                        <input type="text" class="form-control" id="utilizador" name="utilizador"
                            placeholder="utilizador@hospital.pt" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">
                            <i class="fa-solid fa-lock me-1"></i> Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="********"
                            required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-login">
                            Entrar <i class="fa-solid fa-right-to-bracket ms-2"></i>
                        </button>
                    </div>

                    <div class="alert alert-danger p-2 text-center small d-none" id="erroLogin">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Credenciais inválidas. Tente novamente.
                    </div>
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
