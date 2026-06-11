<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include '../../includes/sidebar.php'; ?>


            <main class="col-md-9 col-lg-10 p-4 d-flex align-items-start justify-content-center" style="background-color: #f2f2f2;">
                <div class="caixa-apagar">
                    <div class="icone-alerta">
                        <i class="fas fa-triangle-exclamation"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Confirmar Remoção</h4>
                    <p class="text-muted">Tem a certeza que pretende remover o seguinte documento?</p>
                    <p class="text-muted small">Esta ação é irreversível.</p>

                    <div class="info-item">
                        <strong>Tipo:</strong> Manual de utilizador<br>
                        <strong>Nome:</strong> Manual IntelliVue MP5 PT<br>
                        <strong>Equipamento:</strong> 04.002.00 — Monitor multiparamétrico<br>
                        <strong>Data:</strong> 15/03/2022
                    </div>

                    <div class="botoes mt-4">
                        <a href="lista.php" class="botao-cancelar">
                            <i class="fas fa-xmark me-1"></i> Cancelar
                        </a>
                        <a href="lista.php" class="botao-confirmar" onclick="confirmarRemocao(event)">
                            <i class="fas fa-trash-can me-1"></i> Confirmar Remoção
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
<script src="../../assets/js/1231236.js"></script>
    <script>
        function confirmarRemocao(e) {
            e.preventDefault();
            if (confirm('Esta ação é irreversível. Confirma a remoção do documento?')) {
                alert('Documento removido com sucesso.');
                window.location.href = 'lista.php';
            }
        }
    </script>

<?php include '../../includes/footer.php'; ?>
