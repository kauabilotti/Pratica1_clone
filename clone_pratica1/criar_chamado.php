<?php
// Inclui a conexão com o banco de dados
include 'db.php';

// Carrega todos os colaboradores
$stmt_colaboradores = $pdo->query("SELECT * FROM Colaboradores");
$colaboradores = $stmt_colaboradores->fetchAll(PDO::FETCH_ASSOC);

// Carrega todos os clientes
$stmt_clientes = $pdo->query("SELECT * FROM Clientes");
$clientes = $stmt_clientes->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $id_cliente = $_POST['id_cliente'];
    $id_colaborador = $_POST['id_colaborador'];
    $descricao = $_POST['descricao'];
    $criticidade = $_POST['criticidade'];

    try {
        // Prepara e executa a query para inserir o chamado
        $stmt = $pdo->prepare("INSERT INTO Chamados (ID_cliente, ID_colaborador, Descricao, Criticidade) 
                               VALUES (:id_cliente, :id_colaborador, :descricao, :criticidade)");

        $stmt->execute([
            ':id_cliente' => $id_cliente,
            ':id_colaborador' => $id_colaborador,
            ':descricao' => $descricao,
            ':criticidade' => $criticidade
        ]);

        echo "<p>Chamado criado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p>Erro ao criar chamado: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Chamado</title>
</head>
<body>
    <h2>Criar Chamado</h2>

    <form method="POST" action="criar_chamado.php">
        <label for="id_cliente">Cliente:</label>
        <select name="id_cliente" id="id_cliente" required>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente['ID_cliente'] ?>"><?= $cliente['Nome'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="id_colaborador">Colaborador:</label>
        <select name="id_colaborador" id="id_colaborador" required>
            <?php foreach ($colaboradores as $colaborador): ?>
                <option value="<?= $colaborador['ID_colaborador'] ?>"><?= $colaborador['Nome'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="descricao">Descrição do Chamado:</label><br>
        <textarea name="descricao" id="descricao" required></textarea><br><br>

        <label for="criticidade">Criticidade:</label>
        <select name="criticidade" id="criticidade" required>
            <option value="baixa">Baixa</option>
            <option value="média">Média</option>
            <option value="alta">Alta</option>
        </select><br><br>

        <button type="submit">Criar Chamado</button>
    </form>

    <br>
    <a href="index.php">Voltar para a página inicial</a>
</body>
</html>
