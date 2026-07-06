<?php
include "conexao.php";

$sql = "SELECT
            nome,
            email,
            curso
        FROM alunos
        WHERE id_aluno = ANY (
            SELECT id_aluno
            FROM aluno_atividade
            WHERE nota >= 6
        )
        ORDER BY nome";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alunos Aprovados</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Alunos Aprovados (Nota ≥ 6)</h1>

<a href="index.php">Voltar</a>

<p>
Esta consulta utiliza uma subconsulta com <strong>ANY</strong> para listar os alunos
que possuem pelo menos uma nota maior ou igual a <strong>6,0</strong>.
</p>

<table>

<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>E-mail</th>
    <th>Curso</th>
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

</tr>

<?php
    }

} else {
?>

<tr>
    <td colspan="4">
        Nenhum aluno possui nota maior ou igual a 6.
    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>
