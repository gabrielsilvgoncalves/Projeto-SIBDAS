<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$idEncrypted = $_GET['id'] ?? null;
$id = aes_decrypt($idEncrypted);
if (!$id || !is_numeric($id)) { header('Location: lista.php'); exit; }
$id = (int) $id;

try {
    $ligacao = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DATABASE.";charset=utf8", MYSQL_USERNAME, MYSQL_PASSWORD);
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $ligacao->prepare("UPDATE fornecedores SET deleted_at = NOW() WHERE id = :id AND deleted_at IS NULL");
    $stmt->execute([':id' => $id]);
    $ligacao = null;
    header('Location: lista.php');
    exit;
} catch (PDOException $err) {
    die("Erro ao remover: " . $err->getMessage());
}
