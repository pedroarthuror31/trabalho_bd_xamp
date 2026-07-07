<?php
include "conexao.php";

if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $data_nascimento = $_POST['data_nascimento'];

    $verifica_nome = "SELECT COUNT(*) AS total FROM alunos WHERE nome = '$nome'";
    $resultado_nome = $conn->query($verifica_nome);
    $dados_nome = $resultado_nome->fetch_assoc();

    if ($dados_nome['total'] > 0) {
        header("Location: alunos.php?erro=nome");
        exit;
    }

    $verifica_email = "SELECT COUNT(*) AS total FROM alunos WHERE email = '$email'";
    $resultado_email = $conn->query($verifica_email);
    $dados_email = $resultado_email->fetch_assoc();

    if ($dados_email['total'] > 0) {
        header("Location: alunos.php?erro=email");
        exit;
    }

    $sql = "INSERT INTO alunos (nome, email, curso, data_nascimento)
            VALUES ('$nome', '$email', '$curso', '$data_nascimento')";

    $conn->query($sql);

    header("Location: alunos.php?sucesso=cadastro");
    exit;
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    $sql = "SELECT COUNT(*) AS total
            FROM aluno_atividade
            WHERE id_aluno = $id";

    $resultado_verificacao = $conn->query($sql);
    $dados = $resultado_verificacao->fetch_assoc();

    if ($dados['total'] > 0) {
        header("Location: alunos.php?erro=atividade");
        exit;
    } else {
        $sql = "DELETE FROM alunos WHERE id_aluno = $id";
        $conn->query($sql);

        header("Location: alunos.php?sucesso=exclusao");
        exit;
    }
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

<?php if (isset($_GET['erro']) && $_GET['erro'] == 'nome') { ?>
    <div class="mensagem erro">
        Já existe um aluno cadastrado com esse nome.
    </div>
<?php } ?>

<?php if (isset($_GET['erro']) && $_GET['erro'] == 'email') { ?>
    <div class="mensagem erro">
        Já existe um aluno cadastrado com esse e-mail.
    </div>
<?php } ?>

<?php if (isset($_GET['erro']) && $_GET['erro'] == 'atividade') { ?>
    <div class="mensagem erro">
        Este aluno não pode ser excluído porque possui atividades cadastradas.
    </div>
<?php } ?>

<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'cadastro') { ?>
    <div class="mensagem sucesso">
        Aluno cadastrado com sucesso!
    </div>
<?php } ?>

<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'exclusao') { ?>
    <div class="mensagem sucesso">
        Aluno excluído com sucesso!
    </div>
<?php } ?>

<a href="index.php">Voltar</a>

<h2>Cadastrar Aluno</h2>

<form method="POST">

    <input type="text" name="nome" placeholder="Nome" required>
    <br><br>

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <select name="curso" required>
        <option value="">Selecione um curso</option>
        <option value="Engenharia de Computação">Engenharia de Computação</option>
        <option value="Engenharia de Produção">Engenharia de Produção</option>
    </select>

    <br><br>

    <label><strong>Data de nascimento:</strong></label>
    <br>

    <input type="date" name="data_nascimento" required>

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
</body>
</html>
