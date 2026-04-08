<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha");
    $stmt->execute(['usuario' => $usuario, 'senha' => $senha]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $user['usuario'];
        header("Location: listagem.php");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Cadastro de Funcionários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-cinza">
    <div class="login-container">
        <div class="login-box">
            <h2>Cadastro de Funcionários</h2>
            <?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
            <form method="POST">
                <div class="input-group">
                    <input type="text" name="usuario" placeholder="Usuário" required>
                </div>
                <div class="input-group">
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
                <button type="submit" class="btn-azul">Entrar</button>
            </form>
            <a href="#" class="link-esqueci">Esqueci minha senha</a>
        </div>
    </div>
</body>
</html>