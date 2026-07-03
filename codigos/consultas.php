<?php
include "conexao.php";

$pesquisa = "";

if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != "") {
    $pesquisa = $_GET['pesquisa'];

    $sql = "SELECT
                alunos.nome,
                atividades.nome_atividade,
                atividades.professor_responsavel,
                aluno_atividade.nota
            FROM aluno_atividade
            INNER JOIN alunos
                ON aluno_atividade.id_aluno = alunos.id_aluno
            INNER JOIN atividades
                ON aluno_atividade.id_atividade = atividades.id_atividade
            WHERE atividades.nome_atividade LIKE '%$pesquisa%'
            ORDER BY alunos.nome";
} else {
    $sql = "SELECT
                alunos.nome,
                atividades.nome_atividade,
                atividades.professor_responsavel,
                aluno_atividade.nota
            FROM aluno_atividade
            INNER JOIN alunos
                ON aluno_atividade.id_aluno = alunos.id_aluno
            INNER JOIN atividades
                ON aluno_atividade.id_atividade = atividades.id_atividade
            ORDER BY atividades.nome_atividade, alunos.nome";
}

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Consultas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Consulta de Notas por Atividade</h1>

<a href="index.php">Voltar</a>

<h2>Pesquisar por atividade</h2>

<form method="GET">
    <input
        type="text"
        name="pesquisa"
        placeholder="Nome da atividade"
        value="<?php echo $pesquisa; ?>"
    >

    <button type="submit">Pesquisar</button>
</form>

<br>

<table>
    <tr>
        <th>Aluno</th>
        <th>Atividade</th>
        <th>Professor Responsável</th>
        <th>Nota</th>
    </tr>

    <?php while ($linha = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $linha['nome']; ?></td>
            <td><?php echo $linha['nome_atividade']; ?></td>
            <td><?php echo $linha['professor_responsavel']; ?></td>
            <td>
                <?php
                if ($linha['nota'] == NULL) {
                    echo "Sem nota";
                } else {
                    echo $linha['nota'];
                }
                ?>
            </td>
        </tr>
    <?php } ?>

</table>

</div>

</body>
</html>
