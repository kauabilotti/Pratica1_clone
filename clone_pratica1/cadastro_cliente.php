<?php
// Inclui a conexão com o banco de dados
include 'db.php'; 

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Verifica se o email já existe no banco de dados (para garantir a restrição UNIQUE)
    try {
        // Prepara a consulta SQL
        $stmt = $pdo->prepare("INSERT INTO Clientes (Nome, Email, Telefone) VALUES (:nome, :email, :telefone)");

        // Executa a consulta
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':telefone' => $telefone
        ]);

        // Mensagem de sucesso
        echo "<p>Cadastro realizado com sucesso!</p>";
    } catch (PDOException $e) {
        // Exibe erro específico, se houver
        echo "<p>Erro ao cadastrar cliente: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
</head>
<body>
    <h2>Cadastro de Cliente</h2>

    <form method="POST" action="cadastro_cliente.php">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="index.php">Voltar para a página inicial</a>
</body>
</html>
