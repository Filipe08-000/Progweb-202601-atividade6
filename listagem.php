<?php
session_start();
if (!isset($_SESSION['logado'])) { header("Location: index.php"); exit; }
require 'conexao.php';

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$limite = 5; 
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $limite;

if ($busca) {
    $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM funcionarios WHERE nome ILIKE :busca");
    $stmt_count->execute(['busca' => "%$busca%"]);
    $total_registros = $stmt_count->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE nome ILIKE :busca ORDER BY id ASC LIMIT :limite OFFSET :inicio");
    $stmt->bindValue(':busca', "%$busca%");
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $total_registros = $pdo->query("SELECT COUNT(*) FROM funcionarios")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM funcionarios ORDER BY id ASC LIMIT :limite OFFSET :inicio");
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
    $stmt->execute();
}

$funcionarios = $stmt->fetchAll();
$total_paginas = ceil($total_registros / $limite);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem - Funcionários</title>
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
                <div class="search-bar">
                    <form method="GET" style="display:flex; gap:10px; flex-grow:1;">
                        <input type="text" name="busca" placeholder="Buscar funcionário..." value="<?php echo htmlspecialchars($busca); ?>">
                        <button type="submit" class="btn-save" style="padding: 10px 20px; border-radius: 4px;">Pesquisar</button>
                    </form>
                    <a href="cadastro.php" class="btn-save" style="padding: 10px 20px; border-radius: 4px; text-decoration: none;">Novo Funcionário</a>
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
                            <td><?php echo $f['id']; ?>.</td>
                            <td style="color: #2c529b;"><?php echo htmlspecialchars($f['nome']); ?></td>
                            <td><?php echo htmlspecialchars($f['cargo']); ?></td>
                            <td style="font-style: italic; color: #555;"><?php echo htmlspecialchars($f['email']); ?></td>
                            <td>
                                <span class="badge <?php echo $f['situacao'] == 'Ativo' ? 'badge-ativo' : 'badge-inativo'; ?>">
                                    <?php echo $f['situacao']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="editar.php?id=<?php echo $f['id']; ?>" class="btn-action"><i class="fas fa-pencil-alt"></i></a>
                                <a href="excluir.php?id=<?php echo $f['id']; ?>" class="btn-action" onclick="return confirm('Deseja excluir?')"><i class="fas fa-trash btn-delete"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($total_paginas > 1): ?>
                <div class="paginacao">
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="?pagina=<?php echo $i; ?><?php echo $busca ? '&busca='.$busca : ''; ?>" class="page-link <?php echo $pagina == $i ? 'ativo' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
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