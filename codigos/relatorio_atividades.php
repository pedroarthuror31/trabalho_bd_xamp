<?php
include "conexao.php";

$sql = "SELECT
            atividades.nome_atividade,
            atividades.professor_responsavel,
            COUNT(aluno_atividade.id_aluno) AS quantidade_alunos,
            AVG(aluno_atividade.nota) AS media_notas
        FROM atividades
        INNER JOIN aluno_atividade
            ON atividades.id_atividade = aluno_atividade.id_atividade
        WHERE atividades.valor >= 6
        GROUP BY atividades.nome_atividade, atividades.professor_responsavel
        ORDER BY atividades.nome_atividade";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Atividades</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Relatório de Atividades</h1>

<a href="index.php">Voltar</a>

<p>
Esta consulta utiliza <strong>INNER JOIN</strong>, <strong>WHERE</strong>,
<strong>COUNT</strong>, <strong>AVG</strong> e <strong>GROUP BY</strong>.
</p>

<table>
    <tr>
        <th>ID</th>
        <th>Atividade</th>
        <th>Professor</th>
        <th>Quantidade de Alunos</th>
        <th>Média das Notas</th>
    </tr>

    <?php $contador = 1; ?>

    <?php while ($linha = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $contador++; ?></td>
            <td><?php echo $linha['nome_atividade']; ?></td>
            <td><?php echo $linha['professor_responsavel']; ?></td>
            <td><?php echo $linha['quantidade_alunos']; ?></td>
            <td>
                <?php
                if ($linha['media_notas'] == NULL) {
                    echo "Sem notas";
                } else {
                    echo number_format($linha['media_notas'], 2, ',', '.');
                }
                ?>
            </td>
        </tr>
    <?php } ?>
</table>

</div>

</body>
</html>
