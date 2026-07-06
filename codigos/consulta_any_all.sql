USE trabalho_bd;

-- Lista os alunos que possuem nota maior ou igual
-- a pelo menos uma nota registrada no sistema.

SELECT
    nome,
    curso
FROM alunos
WHERE id_aluno = ANY (
    SELECT id_aluno
    FROM aluno_atividade
    WHERE nota >= 8.0
);
