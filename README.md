# Progweb-202601-atividade6
Atividade 6- Montar Sistema Web em PHP - Completo

Aqui está uma proposta de README.md completa, organizada e profissional para o seu projeto, baseada na estrutura de arquivos e no banco de dados que construímos.

**Sistema de Gestão de Funcionários**
Este é um sistema web completo desenvolvido em PHP para a gestão de funcionários, incluindo autenticação de usuários, operações de CRUD (Criar, Ler, Atualizar e Deletar), busca filtrada e paginação.

📋 Funcionalidades
Autenticação: Sistema de login seguro com controle de sessão.

Gestão de Funcionários:

Listagem com paginação (5 registros por página).

Busca em tempo real por nome.

Cadastro de novos funcionários.

Edição de dados existentes.

Exclusão com confirmação.

Interface Responsiva: Design moderno utilizando Flexbox e ícones do Font Awesome.

Segurança: Uso de PDO com Prepared Statements para evitar SQL Injection.

🛠️ Tecnologias Utilizadas
Linguagem: PHP 8+ (compatível com versões anteriores).

Banco de Dados: PostgreSQL (ou MySQL, via PDO).

Frontend: HTML5, CSS3 (Customizado).

Ícones: Font Awesome 6.0.

🗄️ Estrutura do Banco de Dados
Para configurar o ambiente, execute os seguintes comandos SQL:

SQL
-- Criação do banco de dados
CREATE DATABASE sistema_funcionarios;

-- Tabela de usuários para autenticação
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Tabela de cadastro de funcionários
CREATE TABLE funcionarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cargo VARCHAR(50),
    email VARCHAR(100),
    telefone VARCHAR(20),
    situacao VARCHAR(10) DEFAULT 'Ativo'
);

-- Inserção do usuário administrador padrão
INSERT INTO usuarios (usuario, senha) VALUES ('admin', '123');
📂 Estrutura de Arquivos
index.php: Tela de login.

conexao.php: Configuração da conexão PDO com o banco de dados.

listagem.php: Painel principal com a tabela de dados e busca.

cadastro.php: Formulário para inserção de novos registros.

editar.php: Lógica e formulário de edição.

excluir.php: Lógica para remoção de registros.

logout.php: Encerramento da sessão.

style.css: Estilização completa do sistema.

🚀 Como Executar o Projeto
Certifique-se de ter um servidor local instalado (XAMPP, WAMP ou Laragon).

Clone ou copie os arquivos para a pasta raiz do servidor (htdocs ou www).

Configure as credenciais do seu banco de dados no arquivo conexao.php.

Importe o script SQL fornecido acima.

Acesse no navegador: http://localhost/nome-da-sua-pasta/.

Credenciais Padrão:

Usuário: admin

Senha: 123

🖋️ Autor
Desenvolvido como parte da Atividade 6 da disciplina de Programação Web (2026).
