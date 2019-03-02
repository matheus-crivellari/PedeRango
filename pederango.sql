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
insert into usuarios_tb values (0, 'comum', 'Usuário Comum',           'Rua Nome da Rua, 999 - Bairro', 26, 1, '123', 'com');
insert into usuarios_tb values (0, 'entregador', 'Usuário Entregador', 'Rua Nome da Rua, 999 - Bairro', 26, 1, '123', 'ent');

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

alter table tb_estado
    add uf varchar(2) not null;

insert into tb_estado (`id`, `nome`, `uf`) values
(1, 'Acre', 'AC'),
(2, 'Alagoas', 'AL'),
(3, 'Amazonas', 'AM'),
(4, 'Amapá', 'AP'),
(5, 'Bahia', 'BA'),
(6, 'Ceará', 'CE'),
(7, 'Distrito Federal', 'DF'),
(8, 'Espírito Santo', 'ES'),
(9, 'Goiás', 'GO'),
(10, 'Maranhão', 'MA'),
(11, 'Minas Gerais', 'MG'),
(12, 'Mato Grosso do Sul', 'MS'),
(13, 'Mato Grosso', 'MT'),
(14, 'Pará', 'PA'),
(15, 'Paraíba', 'PB'),
(16, 'Pernambuco', 'PE'),
(17, 'Piauí', 'PI'),
(18, 'Paraná', 'PR'),
(19, 'Rio de Janeiro', 'RJ'),
(20, 'Rio Grande do Norte', 'RN'),
(21, 'Rondônia', 'RO'),
(22, 'Roraima', 'RR'),
(23, 'Rio Grande do Sul', 'RS'),
(24, 'Santa Catarina', 'SC'),
(25, 'Sergipe', 'SE'),
(26, 'São Paulo', 'SP'),
(27, 'Tocantins', 'TO');

-- Tabela cidade
create table tb_cidade(
    id int(10) not null primary key auto_increment,
    estado_cod int(10),
    nome varchar(64)
);