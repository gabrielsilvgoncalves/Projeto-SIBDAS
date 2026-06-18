<?php
require_once 'includes/funcoes.php';
start_session();

if (check_session()) {
    header('Location: /SIBDAS_projeto_final/private/home.php');
} else {
    header('Location: /SIBDAS_projeto_final/public/login.php');
}
exit;
