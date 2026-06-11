<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedStock - Login</title>

    <!-- Bootstrap CSS & custom CSS -->
    <link rel="stylesheet" href="/SIBDAS_projeto_final/public/assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/SIBDAS_projeto_final/public/assets/css/1231236.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/SIBDAS_projeto_final/public/assets/img/Logo.png" type="image/png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/SIBDAS_projeto_final/private/assets/fontawesome/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;700&display=swap" rel="stylesheet">

    <style>
    .link-voltar { color: #00b8d9; text-decoration: none; font-size: 0.88em; }
    </style>
</head>

<body>
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

    <script src="/SIBDAS_projeto_final/private/assets/bootstrap/bootstrap.bundle.min.js"></script>
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
</body>

</html>
