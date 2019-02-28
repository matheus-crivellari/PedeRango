-- Database
create database rango
    charset=utf8 collate=utf8_general_ci;

-- Tabela usuarios
create table usuarios_tb(
    codigo_usuario int(10) not null primary key auto_increment,

    username varchar(20) not null,
    nome_completo text not null,
    endereco text not null,
    estado_cod int(10),
    cidade_cod int(10),
    senha varchar(8) not null,
    tipo enum('adm', 'com', 'ent') -- administrador, comum, entregador
);

insert into usuarios_tb values (0, 'admin', 'Administrador Usuário',   'Rua Nome da Rua, 999 - Bairro', 1, 1, '123', 'adm');
insert into usuarios_tb values (0, 'comum', 'Usuário Comum',           'Rua Nome da Rua, 999 - Bairro', 1, 1, '123', 'com');
insert into usuarios_tb values (0, 'entregador', 'Usuário Entregador', 'Rua Nome da Rua, 999 - Bairro', 1, 1, '123', 'ent');

-- Tabela produtos
create table produtos_tb(
    codigo_produto int(10) not null primary key auto_increment,

    nome_prod varchar(50) not null,
    resumo_prod varchar(255) not null,
    valor_prod decimal(3,2) not null,
    descricao_prod text,
    imagem_prod text
);

-- Tabela pedidos
create table pedidos_tb(
    id_pedido int(10) not null primary key auto_increment,
    cod_usuario int(10) not null,

    data_pedido datetime not null,
    data_fechamento datetime,
    status_pedido enum('aguardando', 'em preparacao', 'entrega', 'pago'),

    foreign key(cod_usuario) references usuarios_tb(codigo_usuario)
);

-- Tabela pedidos/produtos
create table produtos_pedidos(
    id int(10) not null primary key auto_increment,
    cod_pedido int(10) not null,
    cod_produto int(10) not null,

    qtd_produto int(2) not null,

    foreign key(cod_pedido) references pedidos_tb(id_pedido),
    foreign key(cod_produto) references produtos_tb(codigo_produto)
);

-- Tabela estado
create table tb_estado(
    id int(10) not null primary key auto_increment,
    nome varchar(64)
);

-- Tabela cidade
create table tb_cidade(
    id int(10) not null primary key auto_increment,
    estado_cod int(10),
    nome varchar(64)
);