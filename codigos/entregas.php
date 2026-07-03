<?php
include "conexao.php";

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
        ORDER BY alunos.nome";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Entregas de Atividades</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Gerenciar Entregas</h1>

<a href="index.php">Voltar</a>

<h2>Tabela Aluno_Atividade</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Aluno</th>
        <th>Atividade</th>
        <th>Professor</th>
        <th>Data Prevista</th>
        <th>Data Entregue</th>
        <th>Nota</th>
        <th>Ação</th>
    </tr>

    <?php $contador = 1; ?>

    <?php while ($linha = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $contador++; ?></td>
            <td><?php echo $linha['nome']; ?></td>
            <td><?php echo $linha['nome_atividade']; ?></td>
            <td><?php echo $linha['professor_responsavel']; ?></td>
            <td><?php echo $linha['data_prevista']; ?></td>

            <td>
                <?php
                if ($linha['data_entrega'] == NULL) {
                    echo "Não entregue";
                } else {
                    echo $linha['data_entrega'];
                }
                ?>
            </td>

            <td>
                <?php
                if ($linha['nota'] == NULL) {
                    echo "Sem nota";
                } else {
                    echo $linha['nota'];
                }
                ?>
            </td>

            <td>
                <a href="editar_entrega.php?id=<?php echo $linha['id_aluno_atividade']; ?>">
                    Editar entrega
                </a>
            </td>
        </tr>
    <?php } ?>

</table>

</div>

</body>
</html>
