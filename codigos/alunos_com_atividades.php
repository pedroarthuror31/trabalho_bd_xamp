<?php
include "conexao.php";

$pesquisa = "";

if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != "") {
    $pesquisa = $_GET['pesquisa'];

    $sql = "SELECT
                alunos.nome,
                alunos.email,
                alunos.curso
            FROM alunos
            WHERE alunos.nome LIKE '%$pesquisa%'
            AND EXISTS (
                SELECT *
                FROM aluno_atividade
                WHERE aluno_atividade.id_aluno = alunos.id_aluno
            )
            ORDER BY alunos.nome";
} else {
    $sql = "SELECT
                alunos.nome,
                alunos.email,
                alunos.curso
            FROM alunos
            WHERE EXISTS (
                SELECT *
                FROM aluno_atividade
                WHERE aluno_atividade.id_aluno = alunos.id_aluno
            )
            ORDER BY alunos.nome";
}

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alunos com Atividades</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Alunos com Atividades</h1>

<a href="index.php">Voltar</a>

<p>
Esta consulta utiliza uma subconsulta com <strong>EXISTS</strong>
para listar os alunos que possuem pelo menos uma atividade vinculada.
</p>

<h2>Pesquisar Aluno</h2>

<form method="GET">
    <input
        type="text"
        name="pesquisa"
        placeholder="Digite o nome do aluno"
        value="<?php echo $pesquisa; ?>"
    >

    <button type="submit">Pesquisar</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Curso</th>
    </tr>

    <?php $contador = 1; ?>

    <?php if ($resultado->num_rows > 0) { ?>

        <?php while ($aluno = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $contador++; ?></td>
                <td><?php echo $aluno['nome']; ?></td>
                <td><?php echo $aluno['email']; ?></td>
                <td><?php echo $aluno['curso']; ?></td>
            </tr>
        <?php } ?>

    <?php } else { ?>

        <tr>
            <td colspan="4">Nenhum aluno com atividade encontrado.</td>
        </tr>

    <?php } ?>
</table>

</div>

</body>
</html>
