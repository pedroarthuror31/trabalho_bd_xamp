<?php
include "conexao.php";

if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $data_nascimento = $_POST['data_nascimento'];

    $sql = "INSERT INTO alunos (nome, email, curso, data_nascimento)
            VALUES ('$nome', '$email', '$curso', '$data_nascimento')";

    $conn->query($sql);

    header("Location: alunos.php");
    exit;
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    $sql = "DELETE FROM alunos WHERE id_aluno = $id";
    $conn->query($sql);

    header("Location: alunos.php");
    exit;
}

$pesquisa = "";

if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != "") {
    $pesquisa = $_GET['pesquisa'];

    $sql = "SELECT *
            FROM alunos
            WHERE nome LIKE '%$pesquisa%'
            ORDER BY nome";
} else {
    $sql = "SELECT *
            FROM alunos
            ORDER BY nome";
}

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gerenciamento de Alunos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Sistema de Gerenciamento de Alunos</h1>

<a href="index.php">Voltar</a>

<h2>Cadastrar Aluno</h2>

<form method="POST">

    <input
        type="text"
        name="nome"
        placeholder="Nome"
        required
    >
    <br><br>

    <input
        type="email"
        name="email"
        placeholder="Email"
        required
    >
    <br><br>

    <input
        type="text"
        name="curso"
        placeholder="Curso"
        required
    >
    <br><br>

    <input
        type="date"
        name="data_nascimento"
        required
    >
    <br><br>

    <button type="submit" name="cadastrar">
        Cadastrar
    </button>

</form>

<h2>Pesquisar Aluno</h2>

<form method="GET">

    <input
        type="text"
        name="pesquisa"
        placeholder="Pesquisar por nome"
        value="<?php echo $pesquisa; ?>"
    >

    <button type="submit">
        Pesquisar
    </button>

</form>

<h2>Lista de Alunos</h2>

<table>

    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Curso</th>
        <th>Data de Nascimento</th>
        <th>Ações</th>
    </tr>

    <?php $contador = 1; ?>

    <?php while ($aluno = $resultado->fetch_assoc()) { ?>

        <tr>

            <!-- ID apenas visual -->
            <td><?php echo $contador++; ?></td>

            <td><?php echo $aluno['nome']; ?></td>

            <td><?php echo $aluno['email']; ?></td>

            <td><?php echo $aluno['curso']; ?></td>

            <td><?php echo $aluno['data_nascimento']; ?></td>

            <td>

                <a href="editar_aluno.php?id=<?php echo $aluno['id_aluno']; ?>">
                    Editar
                </a>

                |

                <a
                    href="alunos.php?excluir=<?php echo $aluno['id_aluno']; ?>"
                    onclick="return confirm('Deseja excluir este aluno?')"
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
