-- Active: 1745938207932@@127.0.0.1@3306@pet_insight
-- criar banco
DROP DATABASE if EXISTS pet_insight;

CREATE DATABASE pet_insight;

USE pet_insight;

-- tabela cliente

CREATE TABLE cliente (
    id_cliente INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(60) NOT NULL,
    email VARCHAR(90) NOT NULL UNIQUE,
    datNasc DATE NOT NULL,
    telefone VARCHAR(11) NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id_cliente)
);

-- tabela funcionário

CREATE TABLE funcionario(
id_funcionario INT AUTO_INCREMENT NOT NULL,
nome VARCHAR(60),
email VARCHAR(90) NOT NULL UNIQUE,
senha VARCHAR(255),
datNasc DATE NOT NULL,
telefone VARCHAR(11) NOT NULL,
foto VARCHAR(255) DEFAULT NULL,
PRIMARY KEY (id_funcionario)
);

-- tabela senha

CREATE TABLE senha (
    id_senha INT NOT NULL AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    senha VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_senha)
);

-- tabela endereço

CREATE TABLE endereco (
    id_endereco INT NOT NULL AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    cep VARCHAR(9) NOT NULL,
    rua VARCHAR(60) NOT NULL,
    bairro VARCHAR(60) NOT NULL,
    cidade VARCHAR(20) NOT NULL,
    complemento VARCHAR(60) NULL,
    numero INT(3) NULL,
    PRIMARY KEY (id_endereco)
);

CREATE TABLE produto (
    id_produto INT NOT NULL AUTO_INCREMENT,
    nome_produto VARCHAR(100) NOT NULL,
    tipo ENUM(
        "Rações",
        "Aperitivos",
        "Higiene",
        "Brinquedos",
        "Coleiras"
    ) NOT NULL,
    descricaoMenor VARCHAR(200) NOT NULL,
    descricaoMaior VARCHAR(500) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    quantidade INT(10) NOT NULL,
    marca VARCHAR(30) NOT NULL,
    PRIMARY KEY (id_produto)
);

CREATE TABLE imagem_produto(
id_imagens INT AUTO_INCREMENT NOT NULL,
id_produto INT,
nome_imagem TEXT NOT NULL,
PRIMARY KEY (id_imagens),
FOREIGN KEY (id_produto) REFERENCES produto (id_produto)
);

CREATE TABLE pedido (
    id_pedido INT NOT NULL AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    id_produto INT NOT NULL,
    data_pedido DATETIME NOT NULL,
    total DECIMAL NOT NULL,
    PRIMARY KEY (id_pedido)
);

CREATE TABLE formaPagamento (
    id_formaPagamento INT NOT NULL AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    tipo ENUM(
        "Pix",
        "Cartão de crédito",
        "Boleto bancário"
    ) NOT NULL,
    PRIMARY KEY (id_formaPagamento)
);

CREATE TABLE itemPedido (
    id_itemPedido INT NOT NULL AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id_itemPedido)
);

-- chave estrangeiras

-- id cliente no endereco
ALTER TABLE endereco
ADD FOREIGN KEY (id_cliente) REFERENCES cliente (id_cliente);

ALTER TABLE endereco
ADD CONSTRAINT fk_endereco_01 FOREIGN KEY (id_cliente) REFERENCES cliente (id_cliente) ON DELETE CASCADE;


-- id cliente na senha
ALTER TABLE senha
ADD FOREIGN KEY (id_cliente) REFERENCES cliente (id_cliente);

ALTER TABLE senha
ADD CONSTRAINT fk_senha_01 FOREIGN KEY (id_cliente) REFERENCES cliente (id_cliente) ON DELETE cascade;


-- id cliente NO pedido
ALTER TABLE pedido
ADD FOREIGN KEY (id_cliente) REFERENCES cliente (id_cliente);

ALTER TABLE pedido
ADD CONSTRAINT fk_pedido_01 FOREIGN KEY (id_cliente) REFERENCES cliente (id_cliente) ON DELETE cascade;

-- id produto NO pedido
ALTER TABLE pedido
ADD FOREIGN KEY (id_produto) REFERENCES produto (id_produto);

ALTER TABLE pedido
ADD CONSTRAINT fk_pedido_02 FOREIGN KEY (id_produto) REFERENCES produto (id_produto) ON DELETE cascade;

-- id pedido na forma de pagamento
ALTER TABLE formaPagamento
ADD FOREIGN KEY (id_pedido) REFERENCES pedido (id_pedido);

ALTER TABLE formaPagamento
ADD CONSTRAINT fk_formaPagamento_01 FOREIGN KEY (id_pedido) REFERENCES pedido (id_pedido) ON DELETE cascade;

-- id pedido NO item pedido
ALTER TABLE itemPedido
ADD FOREIGN KEY (id_pedido) REFERENCES pedido (id_pedido);

ALTER TABLE itemPedido
ADD CONSTRAINT fk_itemPedido_01 FOREIGN KEY (id_pedido) REFERENCES pedido (id_pedido) ON DELETE cascade;

-- id produto NO item pedido
ALTER TABLE itemPedido
ADD FOREIGN KEY (id_produto) REFERENCES produto (id_produto);

ALTER TABLE itemPedido
ADD CONSTRAINT fk_itemPedido_02 FOREIGN KEY (id_produto) REFERENCES produto (id_produto) ON DELETE CASCADE;

