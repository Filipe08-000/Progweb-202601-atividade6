<?php
session_start();
if (!isset($_SESSION['logado'])) { header("Location: index.php"); exit; }
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $situacao = $_POST['situacao'];

    $stmt = $pdo->prepare("INSERT INTO funcionarios (nome, cargo, email, telefone, situacao) VALUES (:nome, :cargo, :email, :telefone, :situacao)");
    $stmt->execute([
        'nome' => $nome, 'cargo' => $cargo, 'email' => $email, 'telefone' => $telefone, 'situacao' => $situacao
    ]);

    header("Location: listagem.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Funcionários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-cinza">
    <header class="header-azul">
        <div class="logo">Cadastro de Funcionários</div>
        <nav>
            <a href="#">Início</a>
            <a href="listagem.php">Listagem</a>
            <span>Olá, <?php echo $_SESSION['usuario']; ?></span>
        </nav>
    </header>

    <div class="container">
        <div class="card">
            <h2>Cadastro de Funcionários</h2>
            <form method="POST" class="form-cadastro">
                <div class="grid-2">
                    <div>
                        <label>Nome</label>
                        <input type="text" name="nome" required>
                    </div>
                    <div>
                        <label>Cargo</label>
                        <select name="cargo">
                            <option value="Administrador">Administrador</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Assistente">Assistente</option>
                        </select>
                    </div>
                    <div>
                        <label>E-mail</label>
                        <input type="email" name="email">
                    </div>
                    <div>
                        <label>Telefone</label>
                        <input type="text" name="telefone">
                    </div>
                </div>
                
                <div class="radio-group mt-10">
                    <label>Situação</label>
                    <input type="radio" name="situacao" value="Ativo" checked> Ativo
                    <input type="radio" name="situacao" value="Inativo"> Inativo
                </div>

                <div class="form-acoes mt-20">
                    <button type="submit" class="btn-azul">Salvar</button>
                    <button type="reset" class="btn-cinza">Limpar</button>
                    <a href="listagem.php" class="btn-cinza" style="text-decoration:none; display:inline-block; text-align:center;">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>