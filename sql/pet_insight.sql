-- criar banco
DROP DATABASE if EXISTS pet_insight;

CREATE DATABASE pet_insight;

USE pet_insight;

-- tabela cliente
 
CREATE TABLE cliente (
	id_cliente	INT 		NOT NULL AUTO_INCREMENT,
	id_telefone	INT		NOT NULL,
	nome 			VARCHAR	(60)	NOT NULL,	
	email 		VARCHAR	(20)	NOT NULL UNIQUE,
	cpf			VARCHAR 	(11)	NOT NULL UNIQUE,
	datNasc		DATE				NOT NULL,	
	PRIMARY	KEY	(id_cliente)
	);
	
-- tabela senha

CREATE TABLE senha (
	id_senha	INT NOT NULL AUTO_INCREMENT,
	id_cliente INT NOT NULL,
	senha 	VARCHAR 	(16)	NOT NULL,
	PRIMARY KEY (id_senha)
	);
	
-- tabela endereço
	
CREATE TABLE endereco (
	id_endereco	INT		NOT NULL AUTO_INCREMENT,
	id_cliente	INT		NOT NULL,
	cep			VARCHAR	(8)	NOT NULL,
	bairro		VARCHAR	(60)	NOT NULL,
	uf				VARCHAR	(2)	NOT NULL,
	rua			VARCHAR	(60)	NOT NULL,
	cidade		VARCHAR	(20)	NOT NULL,
	complemento	VARCHAR	(60)	NULL,
	numero		INT		(3)	NULL,
	PRIMARY	KEY	(id_endereco)
	);
	
CREATE TABLE telefone (
	id_telefone	INT		NOT NULL AUTO_INCREMENT,
	numero		INT		(9) NOT null,
	ddd			INT		(2) NOT NULL, 
	PRIMARY KEY (id_telefone)
	);
	
CREATE TABLE produto (
	id_produto 	INT 							NOT NULL AUTO_INCREMENT,
	id_cliente 	INT 							NOT NULL,
	tipo			VARCHAR	(30)				NOT NULL,
	descricao	VARCHAR 	(60) 				NOT NULL,
	valor			DECIMAL 	(10, 2)		NOT NULL,
	PRIMARY KEY (id_produto)
	);

CREATE TABLE 
	  
-- chave estrangeiras

	ALTER TABLE endereco ADD FOREIGN KEY 	(id_cliente) 	REFERENCES cliente(id_cliente);
	ALTER TABLE endereco ADD CONSTRAINT 	fk_endereco_01	FOREIGN KEY (id_cliente) 	REFERENCES cliente(id_cliente);
	
	ALTER TABLE	cliente 	ADD FOREIGN KEY 	(id_telefone)	REFERENCES	telefone(id_telefone);
	ALTER TABLE	cliente	ADD CONSTRAINT 	fk_cliente_01	FOREIGN KEY	(id_telefone)	REFERENCES	telefone(id_telefone); 
	
	ALTER TABLE senha 	ADD FOREIGN KEY 	(id_cliente )	REFERENCES 	cliente(id_cliente);
	ALTER TABLE senha 	ADD CONSTRAINT 	fk_senha_01		FOREIGN KEY (id_cliente)		REFERENCES cliente(id_cliente);
	
	ALTER TABLE produto ADD FOREIGN KEY 	(id_cliente) 	REFERENCES 	cliente(id_cliente);
	ALTER TABLE produto 	ADD CONSTRAINT 	fk_produto_01	FOREIGN KEY (id_cliente)		REFERENCES cliente(id_cliente);