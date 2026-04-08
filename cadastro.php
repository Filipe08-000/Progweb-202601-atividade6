<?php
session_start();
if (!isset($_SESSION['logado'])) { header("Location: index.php"); exit; }
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO funcionarios (nome, cargo, email, telefone, situacao) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['nome'], $_POST['cargo'], $_POST['email'], $_POST['telefone'], $_POST['situacao']]);
    header("Location: listagem.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Funcionários</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header-azul">
        <div class="logo-area"><i class="fas fa-globe"></i> Cadastro de Funcionários</div>
        
        <nav>
            <a href="listagem.php">Início</a> 
            <a href="listagem.php" class="ativo">Listagem</a>
        </nav>

        <div class="user-info" id="userDropdown">
            <span>Olá, <strong><?php echo $_SESSION['usuario']; ?></strong></span>
            <i class="fas fa-caret-down"></i>
            <div class="dropdown-menu" id="myDropdown">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <div class="card-header">
            <div class="titulo-com-icone">
                <i class="fas fa-user-plus"></i> 
                <span>Cadastro de Funcionários</span>
            </div>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="grid-form">
                        <div class="field-group">
                            <label>Nome</label>
                            <input type="text" name="nome" placeholder="Nome completo" required>
                        </div>
                        <div class="field-group">
                            <label>Cargo</label>
                            <select name="cargo">
                                <option value="Administrador">Administrador</option>
                                <option value="Gerente">Gerente</option>
                                <option value="Assistente">Assistente</option>
                            </select>
                        </div>
                        <div class="field-group">
                            <label>E-mail</label>
                            <input type="email" name="email" placeholder="email@exemplo.com">
                        </div>
                        <div class="field-group">
                            <label>Telefone</label>
                            <input type="text" name="telefone" placeholder="(00) 00000-0000">
                        </div>
                        <div class="field-group">
                            <label>Situação</label>
                            <div class="radio-group">
                                <label class="radio-item"><input type="radio" name="situacao" value="Ativo" checked> Ativo</label>
                                <label class="radio-item"><input type="radio" name="situacao" value="Inativo"> Inativo</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn-save">Salvar</button>
                        <a href="listagem.php" class="btn-form">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const userBtn = document.getElementById("userDropdown");
        const menu = document.getElementById("myDropdown");
        userBtn.addEventListener("click", function(e) {
            menu.classList.toggle("show");
            e.stopPropagation(); 
        });
        window.onclick = function(event) {
            if (!userBtn.contains(event.target)) { menu.classList.remove("show"); }
        }
    </script>
</body>
</html>