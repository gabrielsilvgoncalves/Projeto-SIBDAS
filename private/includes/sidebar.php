<!-- ===== SIDEBAR ===== -->
<aside class="col-md-3 col-lg-2 min-vh-100 p-3 text-white" style="background-color: #212529;">
    <h5 class="fw-bold mt-2 mb-3" style="color: #00b8d9;">Menu</h5>
    <nav>
        <a href="/SIBDAS_projeto_final/private/index.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <?php if ($_SESSION['profile'] == 'admin') : ?>
        <a href="/SIBDAS_projeto_final/private/views/equipamentos/lista.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-stethoscope me-2"></i> Equipamentos
        </a>
        <a href="/SIBDAS_projeto_final/private/views/fornecedores/lista.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-truck me-2"></i> Fornecedores
        </a>
        <a href="/SIBDAS_projeto_final/private/views/localizacoes/lista.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-map-marker-alt me-2"></i> Localizações
        </a>
        <a href="/SIBDAS_projeto_final/private/views/documentos/lista.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-file-medical me-2"></i> Documentos
        </a>
        <a href="/SIBDAS_projeto_final/private/views/garantias/lista.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-shield-alt me-2"></i> Garantias
        </a>
        <a href="/SIBDAS_projeto_final/private/views/backoffice/conteudo.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-globe me-2"></i> Área Pública
        </a>
        <?php endif; ?>
        <?php if ($_SESSION['profile'] == 'agent') : ?>
        <a href="/SIBDAS_projeto_final/private/views/equipamentos/lista.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-stethoscope me-2"></i> Equipamentos
        </a>
        <a href="/SIBDAS_projeto_final/private/views/documentos/lista.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-file-medical me-2"></i> Documentos
        </a>
        <a href="/SIBDAS_projeto_final/private/views/garantias/lista.php" class="nav-link text-white px-2 mb-1 d-block rounded">
            <i class="fas fa-shield-alt me-2"></i> Garantias
        </a>
        <?php endif; ?>
    </nav>
</aside>
