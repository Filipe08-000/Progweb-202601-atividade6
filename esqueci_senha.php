<?php
require 'conexao.php';
$mensagem = '';
$tipo_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $nova_senha = $_POST['nova_senha'];

    // Verifica se o usuário existe no banco
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
    $stmt->execute(['usuario' => $usuario]);
    
    if ($stmt->fetch()) {
        // Atualiza a senha (Nota: em um sistema real, use password_hash)
        $upd = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE usuario = :usuario");
        $upd->execute(['senha' => $nova_senha, 'usuario' => $usuario]);
        $mensagem = "Senha alterada com sucesso!";
        $tipo_msg = "success";
    } else {
        $mensagem = "Usuário não encontrado!";
        $tipo_msg = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .msg-success { color: #155724; background-color: #d4edda; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
        .msg-error { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2 class="titulo-com-icone"><i class="fas fa-key"></i> Recuperar Senha</h2>
            
            <?php if($mensagem): ?>
                <div class="<?php echo $tipo_msg == 'success' ? 'msg-success' : 'msg-error'; ?>">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="usuario" placeholder="Digite seu usuário" required>
                </div>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="nova_senha" placeholder="Digite a nova senha" required>
                </div>
                <button type="submit" class="btn-entrar">Alterar Senha</button>
            </form>
            
            <a href="index.php" class="link-esqueci">Voltar para o Login</a>
        </div>
    </div>
</body>
</html>