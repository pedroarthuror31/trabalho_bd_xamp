<?php
include "conexao.php";

$id = $_GET['id'];

$sql = "SELECT * FROM atividades WHERE id_atividade = $id";
$resultado = $conn->query($sql);
$atividade = $resultado->fetch_assoc();

$alunos = $conn->query("SELECT * FROM alunos ORDER BY nome");

$alunos_marcados = [];

$sql_marcados = "SELECT id_aluno FROM aluno_atividade WHERE id_atividade = $id";
$resultado_marcados = $conn->query($sql_marcados);

while ($linha = $resultado_marcados->fetch_assoc()) {
    $alunos_marcados[] = $linha['id_aluno'];
}

if (isset($_POST['atualizar'])) {
    $nome_atividade = $_POST['nome_atividade'];
    $professor_responsavel = $_POST['professor_responsavel'];
    $valor = $_POST['valor'];
    $data_prevista = $_POST['data_prevista'];

    $sql = "UPDATE atividades
            SET nome_atividade = '$nome_atividade',
                professor_responsavel = '$professor_responsavel',
                valor = '$valor',
                data_prevista = '$data_prevista'
            WHERE id_atividade = $id";

    $conn->query($sql);

    $sql = "DELETE FROM aluno_atividade WHERE id_atividade = $id";
    $conn->query($sql);

    if (isset($_POST['alunos'])) {
        foreach ($_POST['alunos'] as $id_aluno) {
            $sql = "INSERT INTO aluno_atividade (id_aluno, id_atividade, data_entrega)
                    VALUES ('$id_aluno', '$id', NULL)";
            $conn->query($sql);
        }
    }

    header("Location: atividades.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Atividade</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Editar Atividade</h1>

<p><strong>ID interno da atividade:</strong> <?php echo $atividade['id_atividade']; ?></p>

<form method="POST">

    <input
        type="text"
        name="nome_atividade"
        value="<?php echo $atividade['nome_atividade']; ?>"
        required
    >
    <br><br>

    <input
        type="text"
        name="professor_responsavel"
        value="<?php echo $atividade['professor_responsavel']; ?>"
        required
    >
    <br><br>

    <input
        type="number"
        step="0.01"
        name="valor"
        value="<?php echo $atividade['valor']; ?>"
        required
    >
    <br><br>

    <label>Data prevista:</label>
    <br>
    <input
        type="date"
        name="data_prevista"
        value="<?php echo $atividade['data_prevista']; ?>"
        required
    >
    <br><br>

    <h3>Alunos vinculados</h3>

    <?php while ($aluno = $alunos->fetch_assoc()) { ?>
        <label>
            <input
                type="checkbox"
                name="alunos[]"
                value="<?php echo $aluno['id_aluno']; ?>"
                <?php if (in_array($aluno['id_aluno'], $alunos_marcados)) echo "checked"; ?>
            >
            <?php echo $aluno['nome']; ?>
        </label>
        <br>
    <?php } ?>

    <br>

    <button type="submit" name="atualizar">Atualizar</button>

</form>

<br>

<a href="atividades.php">Voltar</a>

</div>

</body>
</html>
