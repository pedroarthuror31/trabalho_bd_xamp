
CREATE DATABASE IF NOT EXISTS trabalho_bd;
USE trabalho_bd;

DROP TABLE IF EXISTS aluno_atividade;
DROP TABLE IF EXISTS atividades;
DROP TABLE IF EXISTS alunos;

CREATE TABLE alunos (
    id_aluno INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    curso VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL
);

CREATE TABLE atividades (
    id_atividade INT AUTO_INCREMENT PRIMARY KEY,
    nome_atividade VARCHAR(100) NOT NULL,
    professor_responsavel VARCHAR(100) NOT NULL,
    valor DECIMAL(5,2) NOT NULL,
    data_prevista DATE NOT NULL
);

CREATE TABLE aluno_atividade (
    id_aluno_atividade INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT NOT NULL,
    id_atividade INT NOT NULL,
    data_entrega DATE,
    nota DECIMAL(4,2),

    FOREIGN KEY (id_aluno)
        REFERENCES alunos(id_aluno)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    FOREIGN KEY (id_atividade)
        REFERENCES atividades(id_atividade)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
