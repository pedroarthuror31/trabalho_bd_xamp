USE trabalho_bd;

-- Lista os alunos que possuem pelo menos uma atividade vinculada.

SELECT
    alunos.nome,
    alunos.email,
    alunos.curso
FROM alunos
WHERE EXISTS (
    SELECT *
    FROM aluno_atividade
    WHERE aluno_atividade.id_aluno = alunos.id_aluno
);
