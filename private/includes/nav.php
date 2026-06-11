<!-- ===== CABEÇALHO ===== -->
<header class="container-fluid text-white" style="background-color: #004f63;">
    <div class="row align-items-center">
        <div class="col-6 d-flex align-items-center p-3">
            <a href="/SIBDAS_projeto_final/private/index.php">
                <img src="/SIBDAS_projeto_final/private/assets/img/Logo.png" alt="Logo MedStock" height="50" class="me-3">
            </a>
            <h3 class="mb-0 fw-bold"><?php echo APP_NAME; ?></h3>
        </div>
        <div class="col-6 text-end p-3">
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa-regular fa-user me-2"></i> Utilizador
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-key me-2"></i>Alterar password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/SIBDAS_projeto_final/public/login.php">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>Sair
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
