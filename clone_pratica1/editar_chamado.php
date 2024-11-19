<?php
include 'db.php'; // Inclui a conexão ao banco de dados

// Verificar se o id foi passado
if (!isset($_GET['id'])) {
    die('Chamado não encontrado.');
}

$chamado_id = $_GET['id'];

// Buscar o chamado
$stmt = $pdo->prepare("SELECT * FROM chamados WHERE id = ?");
$stmt->execute([$chamado_id]);
$chamado = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $colaborador_responsavel = $_POST['colaborador_responsavel'];

    // Atualizar o chamado
    $stmt = $pdo->prepare("UPDATE chamados SET status = ?, colaborador_responsavel = ? WHERE id = ?");
    $stmt->execute([$status, $colaborador_responsavel, $chamado_id]);

    echo "Chamado atualizado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Chamado</title>
</head>
<body>
    <h2>Editar Chamado</h2>
    <form action="editar_chamado.php?id=<?= $chamado['id'] ?>" method="POST">
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="Aberto" <?= $chamado['status'] == 'Aberto' ? 'selected' : '' ?>>Aberto</option>
            <option value="Em progresso" <?= $chamado['status'] == 'Em progresso' ? 'selected' : '' ?>>Em progresso</option>
            <option value="Fechado" <?= $chamado['status'] == 'Fechado' ? 'selected' : '' ?>>Fechado</option>
        </select><br><br>

        <label for="colaborador_responsavel">Colaborador Responsável:</label>
        <input type="text" name="colaborador_responsavel" value="<?= $chamado['colaborador_responsavel'] ?>" required><br><br>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
