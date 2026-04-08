<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :u AND senha = :s");
    $stmt->execute(['u' => $_POST['usuario'], 's' => $_POST['senha']]);
    if ($user = $stmt->fetch()) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $user['usuario'];
        header("Location: listagem.php"); exit;
    } else { $erro = "Usuário ou senha inválidos!"; }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Cadastro de Funcionários</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2 class="titulo-com-icone">
                <i class="fas fa-user-circle"></i> 
                <span>Cadastro de Funcionários</span>
            </h2>

            <?php if(isset($erro)) echo "<p style='color:red; margin-bottom:10px;'>$erro</p>"; ?>

            <form method="POST">
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="usuario" placeholder="Usuário" required>
                </div>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
                <button type="submit" class="btn-entrar">Entrar</button>
            </form>
            <a href="esqueci_senha.php" class="link-esqueci">Esqueci minha senha</a>
        </div>
    </div>
</body>
</html>