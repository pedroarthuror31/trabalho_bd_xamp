USE trabalho_bd;

-- Listar todos os alunos
SELECT * FROM alunos;

-- Listar todas as atividades
SELECT * FROM atividades;

-- Listar todos os registros da tabela associativa
SELECT * FROM aluno_atividade;

-- Pesquisar aluno por nome
SELECT *
FROM alunos
WHERE nome LIKE '%Pedro%';

-- Pesquisar atividade por nome
SELECT *
FROM atividades
WHERE nome_atividade LIKE '%Banco%';

-- Consulta com INNER JOIN: alunos, atividades, professor, data de entrega e nota
SELECT
    alunos.nome AS nome_aluno,
    atividades.nome_atividade,
    atividades.professor_responsavel,
    atividades.data_prevista,
    aluno_atividade.data_entrega,
    aluno_atividade.nota
FROM aluno_atividade
INNER JOIN alunos
    ON aluno_atividade.id_aluno = alunos.id_aluno
INNER JOIN atividades
    ON aluno_atividade.id_atividade = atividades.id_atividade;

-- Consulta por atividade mostrando alunos e notas
SELECT
    alunos.nome AS nome_aluno,
    atividades.nome_atividade,
    aluno_atividade.nota
FROM aluno_atividade
INNER JOIN alunos
    ON aluno_atividade.id_aluno = alunos.id_aluno
INNER JOIN atividades
    ON aluno_atividade.id_atividade = atividades.id_atividade
WHERE atividades.nome_atividade LIKE '%Banco%';
