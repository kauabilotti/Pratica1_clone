 create database pratica1;
 use pratica1;
 
CREATE TABLE Clientes (
    ID_cliente INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(80) NOT NULL,
    Email VARCHAR(80) NOT NULL UNIQUE,
    Telefone CHAR(9) NOT NULL
);
 
CREATE TABLE Colaboradores (
    ID_colaborador INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(80) NOT NULL,
    Email VARCHAR(80) NOT NULL UNIQUE,
    Telefone CHAR(9) NOT NULL
);
 
CREATE TABLE Chamados (
    ID_chamado INT AUTO_INCREMENT PRIMARY KEY,
    ID_cliente INT ,
    ID_colaborador INT,
    Descricao TEXT NOT NULL,
    Criticidade ENUM('baixa', 'média', 'alta') NOT NULL,
    Statu_ ENUM('aberto', 'em andamento', 'resolvido') DEFAULT 'aberto',
    Data_abertura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Data_resolucao TIMESTAMP NULL,
    FOREIGN KEY (ID_cliente) REFERENCES Clientes(ID_cliente),
    FOREIGN KEY (ID_colaborador) REFERENCES Colaboradores(ID_colaborador) ON DELETE SET NULL
);

 
 