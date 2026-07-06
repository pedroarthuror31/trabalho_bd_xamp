USE trabalho_bd;

INSERT INTO alunos (nome, email, curso, data_nascimento)
VALUES
('Pedro Arthur', 'pedro@email.com', 'Engenharia de Computação', '2005-05-31'),
('Felipe Nascimento', 'felipe@email.com', 'Engenharia de Computação', '2004-09-12'),
('Bruna Kamille', 'bruna@email.com', 'Engenharia de Computação', '2005-03-28'),
('João Silva', 'joao@email.com', 'Engenharia de Produção', '2003-11-20'),
('Maria Souza', 'maria@email.com', 'Engenharia de Computação', '2004-06-15');

INSERT INTO atividades (nome_atividade, professor_responsavel, valor, data_prevista)
VALUES
('Trabalho de Banco de Dados', 'Prof. Marcelo', 10.00, '2026-07-01'),
('Lista de Programação', 'Prof. Alexandre', 8.00, '2026-06-28'),
('Projeto Web', 'Prof. Ana', 10.00, '2026-07-10'),
('Seminário de Sistemas', 'Prof. Carlos', 7.00, '2026-07-15'),
('Atividade de SQL', 'Prof. Marcelo', 9.00, '2026-07-20');

INSERT INTO aluno_atividade (id_aluno, id_atividade, data_entrega, nota)
VALUES
(1, 1, '2026-07-01', 9.5),
(2, 1, '2026-07-01', 8.0),
(3, 2, '2026-06-28', 8.5),
(4, 3, NULL, NULL),
(5, 4, '2026-07-14', 7.0);
