<?php
session_start();
if (!isset($_SESSION['logado'])) { header("Location: index.php"); exit; }
require 'conexao.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE id = ?");
$stmt->execute([$id]);
$f = $stmt->fetch();

if (!$f) { header("Location: listagem.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("UPDATE funcionarios SET nome=?, cargo=?, email=?, telefone=?, situacao=? WHERE id=?");
    $stmt->execute([$_POST['nome'], $_POST['cargo'], $_POST['email'], $_POST['telefone'], $_POST['situacao'], $id]);
    header("Location: listagem.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header-azul">
        <div class="logo-area"><i class="fas fa-globe"></i> Editar Funcionário</div>
        <nav><a href="listagem.php">Voltar para Listagem</a></nav>
    </header>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="titulo-com-icone">
                    <i class="fas fa-user-edit"></i> Editar: <?php echo htmlspecialchars($f['nome']); ?>
                </div>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="grid-2">
                        <div class="field-group">
                            <label>Nome</label>
                            <input type="text" name="nome" value="<?php echo htmlspecialchars($f['nome']); ?>" required>
                        </div>
                        <div class="field-group">
                            <label>Cargo</label>
                            <select name="cargo">
                                <option value="Administrador" <?php if($f['cargo'] == 'Administrador') echo 'selected'; ?>>Administrador</option>
                                <option value="Gerente" <?php if($f['cargo'] == 'Gerente') echo 'selected'; ?>>Gerente</option>
                                <option value="Assistente" <?php if($f['cargo'] == 'Assistente') echo 'selected'; ?>>Assistente</option>
                            </select>
                        </div>
                        <div class="field-group">
                            <label>E-mail</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($f['email']); ?>">
                        </div>
                        <div class="field-group">
                            <label>Telefone</label>
                            <input type="text" name="telefone" value="<?php echo htmlspecialchars($f['telefone']); ?>">
                        </div>
                        <div class="field-group">
                            <label>Situação</label>
                            <div class="radio-group">
                                <label class="radio-item">
                                    <input type="radio" name="situacao" value="Ativo" <?php if($f['situacao'] == 'Ativo') echo 'checked'; ?>> Ativo
                                </label>
                                <label class="radio-item">
                                    <input type="radio" name="situacao" value="Inativo" <?php if($f['situacao'] == 'Inativo') echo 'checked'; ?>> Inativo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn-save">Salvar Alterações</button>
                        <a href="listagem.php" class="btn-form">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>