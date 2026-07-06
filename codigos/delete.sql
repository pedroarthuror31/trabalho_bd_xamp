USE trabalho_bd;

-- Apaga primeiro a tabela associativa
DELETE FROM aluno_atividade;

-- Depois as tabelas principais
DELETE FROM atividades;
DELETE FROM alunos;
