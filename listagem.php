<?php
session_start();
if (!isset($_SESSION['logado'])) { header("Location: index.php"); exit; }
require 'conexao.php';

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';

if ($busca) {
    $stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE nome ILIKE :busca");
    $stmt->execute(['busca' => "%$busca%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM funcionarios ORDER BY id ASC");
}
$funcionarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem - Funcionários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-cinza">
    <header class="header-azul">
        <div class="logo">Cadastro de Funcionários</div>
        <nav>
            <a href="#">Início</a>
            <a href="listagem.php" class="ativo">Listagem</a>
            <span>Olá, <?php echo $_SESSION['usuario']; ?></span>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <div class="container">
        <div class="card">
            <h2>Listagem de Funcionários</h2>
            
            <div class="acoes-topo">
                <form method="GET" class="form-busca">
                    <input type="text" name="busca" placeholder="Buscar funcionário..." value="<?php echo htmlspecialchars($busca); ?>">
                    <button type="submit" class="btn-azul">Pesquisar</button>
                </form>
                <a href="cadastro.php" class="btn-azul">Novo Funcionário</a>
            </div>

            <table class="tabela">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cargo</th>
                        <th>E-mail</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($funcionarios as $f): ?>
                    <tr>
                        <td><?php echo $f['id']; ?></td>
                        <td><?php echo htmlspecialchars($f['nome']); ?></td>
                        <td><?php echo htmlspecialchars($f['cargo']); ?></td>
                        <td><?php echo htmlspecialchars($f['email']); ?></td>
                        <td>
                            <span class="badge <?php echo $f['situacao'] == 'Ativo' ? 'badge-ativo' : 'badge-inativo'; ?>">
                                <?php echo $f['situacao']; ?>
                            </span>
                        </td>
                        <td>
                            <button>Editar</button> <button>Deletar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>