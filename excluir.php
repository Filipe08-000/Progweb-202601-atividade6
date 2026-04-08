<?php
session_start();
if (!isset($_SESSION['logado'])) { header("Location: index.php"); exit; }
require 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM funcionarios WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: listagem.php");
exit;
?>