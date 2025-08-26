-- Cria o banco de dados
CREATE DATABASE IF NOT EXISTS gestao;
USE gestao;

-- Tabela de Empresas
CREATE TABLE empresa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) UNIQUE NOT NULL,
    token VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Tabela de Campos (depende da empresa)
CREATE TABLE campo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    nivel_acesso INT NOT NULL,
    nivel INT DEFAULT 0,            -- Coluna adicionada para compatibilidade com PHP
    cor VARCHAR(7),
    id_empresa INT NOT NULL,
    FOREIGN KEY (id_empresa) REFERENCES empresa(id)
) ENGINE=InnoDB;

-- Tabela de Módulos (depende do campo e da empresa)
CREATE TABLE modulo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    id_campo INT NOT NULL,
    id_empresa INT NOT NULL,
    FOREIGN KEY (id_campo) REFERENCES campo(id),
    FOREIGN KEY (id_empresa) REFERENCES empresa(id)
) ENGINE=InnoDB;

-- Tabela de Valores
CREATE TABLE valor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    id_campo INT,
    id_empresa INT
) 

CREATE TABLE cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    id_modulo INT NOT NULL,
    FOREIGN KEY (id_modulo) REFERENCES modulo(id) ON DELETE CASCADE
)ENGINE=InnoDB;

CREATE TABLE dados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valor VARCHAR(255) NOT NULL,
    id_card INT NOT NULL,
    FOREIGN KEY (id_card) REFERENCES cards(id) ON DELETE CASCADE ON UPDATE CASCADE
); ENGINE=InnoDB;
