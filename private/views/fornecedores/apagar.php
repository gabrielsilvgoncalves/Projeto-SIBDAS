<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>

            <main class="col-md-9 col-lg-10 p-4 d-flex align-items-start justify-content-center" style="background-color: #f2f2f2;">
                <div class="caixa-apagar">
                    <div class="icone-alerta"><i class="fas fa-triangle-exclamation"></i></div>
                    <h4 class="fw-bold mb-2">Confirmar Remoção</h4>
                    <p class="text-muted">Tem a certeza que pretende remover este fornecedor?</p>
                    <div class="info-item">
                        <strong>Empresa:</strong> Philips Healthcare Portugal<br>
                        <strong>NIF:</strong> 500 123 456<br>
                        <strong>Tipo:</strong> Fabricante
                    </div>
                    <div class="alert alert-warning py-2 px-3 mt-3 small text-start">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Este fornecedor está associado a 2 equipamentos. A associação será removida.
                    </div>
                    <div class="botoes mt-4">
                        <a href="lista.php" class="botao-cancelar"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                        <a href="lista.php" class="botao-confirmar" onclick="confirmar(event)"><i class="fas fa-trash-can me-1"></i> Confirmar</a>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script>
        function confirmar(e) {
            e.preventDefault();
            if (confirm('Confirma a remoção deste fornecedor?')) {
                alert('Fornecedor removido com sucesso.');
                window.location.href = 'lista.php';
            }
        }
    </script>

<?php include '../../includes/footer.php'; ?>
