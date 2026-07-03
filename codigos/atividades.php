<?php
include "conexao.php";

if (isset($_POST['cadastrar'])) {
    $nome_atividade = $_POST['nome_atividade'];
    $professor_responsavel = $_POST['professor_responsavel'];
    $valor = $_POST['valor'];
    $data_prevista = $_POST['data_prevista'];

    $sql_verifica = "SELECT COUNT(*) AS total
                     FROM atividades
                     WHERE nome_atividade = '$nome_atividade'";

    $resultado_verifica = $conn->query($sql_verifica);
    $dados = $resultado_verifica->fetch_assoc();

    if ($dados['total'] > 0) {
        header("Location: atividades.php?erro=duplicada");
        exit;
    }

    if (isset($_POST['alunos'])) {
        $alunos_selecionados = $_POST['alunos'];

        $sql = "INSERT INTO atividades (nome_atividade, professor_responsavel, valor, data_prevista)
                VALUES ('$nome_atividade', '$professor_responsavel', '$valor', '$data_prevista')";

        $conn->query($sql);

        $id_atividade = $conn->insert_id;

        foreach ($alunos_selecionados as $id_aluno) {
            $sql = "INSERT INTO aluno_atividade (id_aluno, id_atividade, data_entrega)
                    VALUES ('$id_aluno', '$id_atividade', NULL)";

            $conn->query($sql);
        }

        header("Location: atividades.php?sucesso=1");
        exit;
    } else {
        header("Location: atividades.php?erro=aluno");
        exit;
    }
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

    $sql = "SELECT 
                atividades.id_atividade,
                atividades.nome_atividade,
                atividades.professor_responsavel,
                atividades.valor,
                atividades.data_prevista,
                GROUP_CONCAT(alunos.nome SEPARATOR ', ') AS alunos
            FROM atividades
            INNER JOIN aluno_atividade 
                ON atividades.id_atividade = aluno_atividade.id_atividade
            INNER JOIN alunos 
                ON aluno_atividade.id_aluno = alunos.id_aluno
            WHERE atividades.nome_atividade LIKE '%$pesquisa%'
            GROUP BY atividades.id_atividade
            ORDER BY atividades.nome_atividade";
} else {
    $sql = "SELECT 
                atividades.id_atividade,
                atividades.nome_atividade,
                atividades.professor_responsavel,
                atividades.valor,
                atividades.data_prevista,
                GROUP_CONCAT(alunos.nome SEPARATOR ', ') AS alunos
            FROM atividades
            INNER JOIN aluno_atividade 
                ON atividades.id_atividade = aluno_atividade.id_atividade
            INNER JOIN alunos 
                ON aluno_atividade.id_aluno = alunos.id_aluno
            GROUP BY atividades.id_atividade
            ORDER BY atividades.nome_atividade";
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

<?php if (isset($_GET['erro']) && $_GET['erro'] == 'duplicada') { ?>
    <div class="mensagem erro">
        Já existe uma atividade cadastrada com esse nome.
    </div>
<?php } ?>

<?php if (isset($_GET['erro']) && $_GET['erro'] == 'aluno') { ?>
    <div class="mensagem erro">
        Selecione pelo menos um aluno para cadastrar a atividade.
    </div>
<?php } ?>

<?php if (isset($_GET['sucesso'])) { ?>
    <div class="mensagem sucesso">
        Atividade cadastrada com sucesso!
    </div>
<?php } ?>

<a href="index.php">Voltar</a>

<h2>Cadastrar Atividade</h2>

<form method="POST">
    <input type="text" name="nome_atividade" placeholder="Nome da atividade" required>
    <br><br>

    <input type="text" name="professor_responsavel" placeholder="Professor responsável" required>
    <br><br>

    <input type="number" step="0.01" name="valor" placeholder="Valor" required>
    <br><br>

    <label>Data prevista:</label>
    <br>
    <input type="date" name="data_prevista" required>
    <br><br>

    <h3>Selecione os alunos</h3>

    <?php while ($aluno = $alunos->fetch_assoc()) { ?>
        <label>
            <input type="checkbox" name="alunos[]" value="<?php echo $aluno['id_aluno']; ?>">
            <?php echo $aluno['nome']; ?>
        </label>
        <br>
    <?php } ?>

    <br>

    <button type="submit" name="cadastrar">Cadastrar</button>
</form>

<h2>Pesquisar Atividade</h2>

<form method="GET">
    <input
        type="text"
        name="pesquisa"
        placeholder="Pesquisar por nome da atividade"
        value="<?php echo $pesquisa; ?>"
    >

    <button type="submit">Pesquisar</button>
</form>

<h2>Lista de Atividades</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Atividade</th>
        <th>Professor</th>
        <th>Valor</th>
        <th>Data Prevista</th>
        <th>Alunos</th>
        <th>Ações</th>
    </tr>

    <?php $contador = 1; ?>

    <?php while ($atividade = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $contador++; ?></td>
            <td><?php echo $atividade['nome_atividade']; ?></td>
            <td><?php echo $atividade['professor_responsavel']; ?></td>
            <td><?php echo $atividade['valor']; ?></td>
            <td><?php echo $atividade['data_prevista']; ?></td>
            <td><?php echo $atividade['alunos']; ?></td>
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
