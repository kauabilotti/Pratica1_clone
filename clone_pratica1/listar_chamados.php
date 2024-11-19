<?php
// Inclui a conexão com o banco de dados
include 'db.php';

// Carrega todos os chamados
$stmt_chamados = $pdo->query("SELECT * FROM Chamados");
$chamados = $stmt_chamados->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualiza os dados do chamado
    $id_chamado = $_POST['id_chamado'];
    $criticidade = $_POST['criticidade'];
    $id_colaborador = $_POST['id_colaborador'];

    try {
        $stmt_update = $pdo->prepare("UPDATE Chamados 
                                      SET Criticidade = :criticidade, ID_colaborador = :id_colaborador 
                                      WHERE ID_chamado = :id_chamado");

        $stmt_update->execute([
            ':criticidade' => $criticidade,
            ':id_colaborador' => $id_colaborador,
            ':id_chamado' => $id_chamado
        ]);

        echo "<p>Chamado atualizado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p>Erro ao atualizar chamado: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Chamados</title>
</head>
<body>
    <h2>Lista de Chamados</h2>

    <?php foreach ($chamados as $chamado): ?>
        <p>
            <strong>ID:</strong> <?= $chamado['ID_chamado'] ?><br>
            <strong>Cliente:</strong> <?= $chamado['ID_cliente'] ?><br>
            <strong>Descrição:</strong> <?= $chamado['Descricao'] ?><br>
            <strong>Criticidade:</strong> <?= $chamado['Criticidade'] ?><br>
            <strong>Status:</strong> <?= $chamado['Statu_'] ?><br>
            <strong>Data Abertura:</strong> <?= $chamado['Data_abertura'] ?><br>
            <form method="POST" action="listar_chamados.php">
                <input type="hidden" name="id_chamado" value="<?= $chamado['ID_chamado'] ?>">
                <label for="criticidade">Criticidade:</label>
                <select name="criticidade" required>
                    <option value="baixa" <?= ($chamado['Criticidade'] == 'baixa') ? 'selected' : '' ?>>Baixa</option>
                    <option value="média" <?= ($chamado['Criticidade'] == 'média') ? 'selected' : '' ?>>Média</option>
                    <option value="alta" <?= ($chamado['Criticidade'] == 'alta') ? 'selected' : '' ?>>Alta</option>
                </select><br><br>
                <label for="id_colaborador">Colaborador:</label>
                <select name="id_colaborador" required>
                    <?php foreach ($colaboradores as $colaborador): ?>
                        <option value="<?= $colaborador['ID_colaborador'] ?>" <?= ($chamado['ID_colaborador'] == $colaborador['ID_colaborador']) ? 'selected' : '' ?>>
                            <?= $colaborador['Nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
                <button type="submit">Atualizar</button>
            </form>
        </p>
        <hr>
    <?php endforeach; ?>

</body>
</html>
