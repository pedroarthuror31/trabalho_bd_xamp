USE trabalho_bd;

-- Inserção de alunos
INSERT INTO alunos (nome, email, curso, data_nascimento)
VALUES
('Pedro Arthur', 'pedro@email.com', 'Engenharia de Computação', '2005-05-31'),
('Bruna Kamille', 'bruna@email.com', 'Engenharia de Computação', '2005-03-28');

-- Inserção de atividades
INSERT INTO atividades
(nome_atividade, professor_responsavel, valor, data_prevista)
VALUES
('Trabalho de Banco de Dados', 'Prof. Marcelo', 10.00, '2026-07-01'),
('Lista de Programação', 'Prof. Alexandre', 10.00, '2026-06-28');

-- Relação entre alunos e atividades
INSERT INTO aluno_atividade
(id_aluno, id_atividade, data_entrega, nota)
VALUES
(1, 1, '2026-07-01', 9.5),
(2, 2, '2026-06-28', 8.0);
