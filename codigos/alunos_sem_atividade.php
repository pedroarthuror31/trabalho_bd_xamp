<<?php
include "conexao.php";

$pesquisa = "";

if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != "") {
    $pesquisa = $_GET['pesquisa'];

    $sql = "SELECT *
            FROM alunos
            WHERE nome LIKE '%$pesquisa%'
            AND id_aluno NOT IN (
                SELECT id_aluno
                FROM aluno_atividade
            )
            ORDER BY nome";
} else {
    $sql = "SELECT *
            FROM alunos
            WHERE id_aluno NOT IN (
                SELECT id_aluno
                FROM aluno_atividade
            )
            ORDER BY nome";
}

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
            <th>Data de Nascimento</th>
        </tr>

        <?php $contador = 1; ?>

        <?php if ($resultado->num_rows > 0) { ?>

            <?php while ($aluno = $resultado->fetch_assoc()) { ?>

                <tr>
                    <td><?php echo $contador++; ?></td>
                    <td><?php echo $aluno['nome']; ?></td>
                    <td><?php echo $aluno['email']; ?></td>
                    <td><?php echo $aluno['curso']; ?></td>
                    <td><?php echo $aluno['data_nascimento']; ?></td>
                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="5">
                    Nenhum aluno sem atividade foi encontrado.
                </td>
            </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
</html>
