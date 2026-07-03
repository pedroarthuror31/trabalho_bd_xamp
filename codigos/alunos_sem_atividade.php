<?php
include "conexao.php";

$sql = "SELECT *
        FROM alunos
        WHERE id_aluno NOT IN (
            SELECT id_aluno
            FROM aluno_atividade
        )
        ORDER BY nome";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alunos sem Atividades</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Alunos sem Atividades</h1>

    <a href="index.php">Voltar</a>

    <p>
        Esta consulta utiliza uma subconsulta com <strong>NOT IN</strong>
        para listar os alunos que não estão vinculados a nenhuma atividade.
    </p>

    <table>

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Curso</th>
            <th>Data de Nascimento</th>
        </tr>

        <?php
        $contador = 1;

        if ($resultado->num_rows > 0) {
            while ($aluno = $resultado->fetch_assoc()) {
        ?>

        <tr>

            <td><?php echo $contador++; ?></td>

            <td><?php echo $aluno['nome']; ?></td>

            <td><?php echo $aluno['email']; ?></td>

            <td><?php echo $aluno['curso']; ?></td>

            <td><?php echo $aluno['data_nascimento']; ?></td>

        </tr>

        <?php
            }
        } else {
        ?>

        <tr>
            <td colspan="5">
                Todos os alunos estão vinculados a pelo menos uma atividade.
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
