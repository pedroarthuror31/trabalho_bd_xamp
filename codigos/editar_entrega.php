<?php
include "conexao.php";

$id = $_GET['id'];

$sql = "SELECT
            aluno_atividade.id_aluno_atividade,
            alunos.nome,
            atividades.nome_atividade,
            atividades.professor_responsavel,
            atividades.data_prevista,
            aluno_atividade.data_entrega,
            aluno_atividade.nota
        FROM aluno_atividade
        INNER JOIN alunos
            ON aluno_atividade.id_aluno = alunos.id_aluno
        INNER JOIN atividades
            ON aluno_atividade.id_atividade = atividades.id_atividade
        WHERE aluno_atividade.id_aluno_atividade = $id";

$resultado = $conn->query($sql);
$entrega = $resultado->fetch_assoc();

if (isset($_POST['atualizar'])) {
    $data_entrega = $_POST['data_entrega'];
    $nota = $_POST['nota'];

    $sql = "UPDATE aluno_atividade
            SET data_entrega = '$data_entrega',
                nota = '$nota'
            WHERE id_aluno_atividade = $id";

    $conn->query($sql);

    header("Location: entregas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Entrega</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Editar Entrega</h1>

<p><strong>Aluno:</strong> <?php echo $entrega['nome']; ?></p>
<p><strong>Atividade:</strong> <?php echo $entrega['nome_atividade']; ?></p>
<p><strong>Professor:</strong> <?php echo $entrega['professor_responsavel']; ?></p>
<p><strong>Data prevista:</strong> <?php echo $entrega['data_prevista']; ?></p>

<form method="POST">
    <label>Data entregue:</label>
    <br>
    <input
        type="date"
        name="data_entrega"
        value="<?php echo $entrega['data_entrega']; ?>"
        required
    >

    <br><br>

    <label>Nota:</label>
    <br>
    <input
        type="number"
        step="0.01"
        name="nota"
        value="<?php echo $entrega['nota']; ?>"
        required
    >

    <br><br>

    <button type="submit" name="atualizar">Atualizar entrega</button>
</form>

<br>

<a href="entregas.php">Voltar</a>

</div>

</body>
</html>
