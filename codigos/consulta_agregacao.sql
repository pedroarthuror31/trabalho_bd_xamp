USE trabalho_bd;

SELECT
    atividades.nome_atividade,
    atividades.professor_responsavel,
    COUNT(aluno_atividade.id_aluno) AS quantidade_alunos,
    AVG(aluno_atividade.nota) AS media_notas
FROM atividades
INNER JOIN aluno_atividade
    ON atividades.id_atividade = aluno_atividade.id_atividade
WHERE atividades.valor >= 8
GROUP BY
    atividades.nome_atividade,
    atividades.professor_responsavel;
