<?php
include "conexao.php";

if (isset($_POST['cadastrar'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $nota = $_POST['nota'];
    $data_entrega = $_POST['data_entrega'];
    $id_aluno = $_POST['id_aluno'];

    $sql = "INSERT INTO atividades (titulo, descricao, nota, data_entrega, id_aluno)
            VALUES ('$titulo', '$descricao', '$nota', '$data_entrega', '$id_aluno')";

    $conn->query($sql);

    header("Location: atividades.php");
    exit;
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    $sql = "DELETE FROM atividades WHERE id_atividade = $id";
    $conn->query($sql);

    header("Location: atividades.php");
    exit;
}

$pesquisa = "";

if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != "") {
    $pesquisa = $_GET['pesquisa'];

    $sql = "SELECT atividades.*, alunos.nome
            FROM atividades
            INNER JOIN alunos ON atividades.id_aluno = alunos.id_aluno
            WHERE atividades.titulo LIKE '%$pesquisa%'
            ORDER BY atividades.titulo";
} else {
    $sql = "SELECT atividades.*, alunos.nome
            FROM atividades
            INNER JOIN alunos ON atividades.id_aluno = alunos.id_aluno
            ORDER BY atividades.titulo";
}

$resultado = $conn->query($sql);

$alunos = $conn->query("SELECT * FROM alunos ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Atividades</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Sistema de Gerenciamento de Atividades</h1>

<a href="index.php">Voltar</a>

<h2>Cadastrar Atividade</h2>

<form method="POST">
    <input type="text" name="titulo" placeholder="Título" required>
    <br><br>

    <input type="text" name="descricao" placeholder="Descrição" required>
    <br><br>

    <input type="number" step="0.01" name="nota" placeholder="Nota" required>
    <br><br>

    <input type="date" name="data_entrega" required>
    <br><br>

    <select name="id_aluno" required>
        <option value="">Selecione o aluno</option>

        <?php while ($aluno = $alunos->fetch_assoc()) { ?>
            <option value="<?php echo $aluno['id_aluno']; ?>">
                <?php echo $aluno['nome']; ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <button type="submit" name="cadastrar">Cadastrar</button>
</form>

<h2>Pesquisar Atividade</h2>

<form method="GET">
    <input
        type="text"
        name="pesquisa"
        placeholder="Pesquisar por título"
        value="<?php echo $pesquisa; ?>"
    >

    <button type="submit">Pesquisar</button>
</form>

<h2>Lista de Atividades</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Descrição</th>
        <th>Nota</th>
        <th>Data de Entrega</th>
        <th>Aluno</th>
        <th>Ações</th>
    </tr>

    <?php $contador = 1; ?>

    <?php while ($atividade = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $contador++; ?></td>
            <td><?php echo $atividade['titulo']; ?></td>
            <td><?php echo $atividade['descricao']; ?></td>
            <td><?php echo $atividade['nota']; ?></td>
            <td><?php echo $atividade['data_entrega']; ?></td>
            <td><?php echo $atividade['nome']; ?></td>
            <td>
                <a href="editar_atividade.php?id=<?php echo $atividade['id_atividade']; ?>">
                    Editar
                </a>
                |
                <a
                    href="atividades.php?excluir=<?php echo $atividade['id_atividade']; ?>"
                    onclick="return confirm('Deseja excluir esta atividade?')"
                >
                    Excluir
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

</div>

</body>
</html>
