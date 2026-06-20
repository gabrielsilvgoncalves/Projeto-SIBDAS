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
                    <p class="text-muted">Tem a certeza que pretende remover esta localização?</p>
                    <div class="info-item">
                        <strong>Edifício:</strong> Edifício Principal<br>
                        <strong>Piso:</strong> Piso 3<br>
                        <strong>Serviço:</strong> Unidade de Cuidados Intensivos<br>
                        <strong>Sala:</strong> Sala UCI-03
                    </div>
                    <div class="alert alert-warning py-2 px-3 mt-3 small text-start">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Esta localização está associada a 148 equipamentos. Os equipamentos ficarão sem localização atribuída.
                    </div>
                    <div class="botoes mt-4">
                        <a href="lista.php" class="botao-cancelar"><i class="fas fa-xmark me-1"></i> Cancelar</a>
                        <a href="lista.php" class="botao-confirmar" onclick="confirmar(event)"><i class="fas fa-trash-can me-1"></i> Confirmar</a>
                    </div>
                </div>
            </main>
        </div>
<script>
        function confirmar(e) {
            e.preventDefault();
            if (confirm('Confirma a remoção desta localização?')) {
                alert('Localização removida com sucesso.');
                window.location.href = 'lista.php';
            }
        }
    </script>

<?php include '../../includes/footer.php'; ?>
