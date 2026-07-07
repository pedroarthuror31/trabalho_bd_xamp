<?php
include "conexao.php";

$id = $_GET['id'];

$sql = "SELECT * FROM alunos WHERE id_aluno = $id";
$resultado = $conn->query($sql);
$aluno = $resultado->fetch_assoc();

if (isset($_POST['atualizar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $data_nascimento = $_POST['data_nascimento'];

    $sql = "UPDATE alunos
            SET nome = '$nome',
                email = '$email',
                curso = '$curso',
                data_nascimento = '$data_nascimento'
            WHERE id_aluno = $id";

    $conn->query($sql);

    header("Location: alunos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<h1>Editar Aluno</h1>

<p><strong>ID interno do aluno:</strong> <?php echo $aluno['id_aluno']; ?></p>

<form method="POST">

    <input
        type="text"
        name="nome"
        value="<?php echo $aluno['nome']; ?>"
        required
    >
    <br><br>

    <input
        type="email"
        name="email"
        value="<?php echo $aluno['email']; ?>"
        required
    >
    <br><br>

    <select name="curso" required>

        <option value="Engenharia de Computação"
            <?php if ($aluno['curso'] == "Engenharia de Computação") echo "selected"; ?>>
            Engenharia de Computação
        </option>

        <option value="Engenharia de Produção"
            <?php if ($aluno['curso'] == "Engenharia de Produção") echo "selected"; ?>>
            Engenharia de Produção
        </option>

    </select>

    <br><br>

    <input
        type="date"
        name="data_nascimento"
        value="<?php echo $aluno['data_nascimento']; ?>"
        required
    >
    <br><br>

    <button type="submit" name="atualizar">
        Atualizar
    </button>

</form>

<br>

<a href="alunos.php">Voltar</a>

</div>

</body>
</html>
