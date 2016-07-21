create table pelada(
	id_pelada bigint not null auto_increment,
    nome_pelada varchar(100) not null,
    data_cadastro date not null,
    id_peladeiro int not null,
    primary key(id_pelada)
);

create table peladeiro(
	id_peladeiro bigint not null auto_increment,
    nome_peladeiro varchar(50) not null,
	posicao_predominante int not null,
    email varchar(50) not null,
    data_nascimento date not null,
    altura numeric(5,2),
    peso numeric(5,2),
    data_cadastro date not null,
    primary key(id_peladeiro)
);

create table pelada_peladeiro(
    id_pelada bigint not null,
    id_peladeiro bigint not null,
    data_cadastro date not null,
    primary key(id_pelada, id_peladeiro)
);

create table posicao(
	id_posicao int not null auto_increment,
    nome_posicao varchar(50) not null,
    data_cadastro date not null,
    primary key(id_posicao)
);

create table peladeiro_posicao(
    id_peladeiro bigint not null,
    id_posicao int not null,
    data_cadastro date not null,
    primary key(id_peladeiro, id_posicao)
);

create table habilidade(
	id_habilidade int not null auto_increment,
    nome_habilidade varchar(50) not null,
    data_cadastro date not null,
	primary key(id_habilidade)
);

create table peladeiro_habilidade(
	id_peladeiro bigint not null,
    id_habilidade int not null,
    nivel numeric(4,2),
    data_cadastro date not null,
    primary key(id_peladeiro, id_habilidade)
);

create table pelada_agendamento(
	id_agendamento bigint not null auto_increment,
    id_pelada bigint not null,
    data_agendamento date not null,
    hora_agendamento time not null,
    data_cadastro date not null,
    nome_local varchar(100) not null,
    qtd_peladeiro_time int not null,
    situacao_pelada ENUM('A Confirmar', 'Confirmada', 'Cancelada') not null,
    primary key(id_agendamento)
);

create table pelada_agendamento_peladeiro(
	id_agendamento bigint not null auto_increment,
    id_peladeiro bigint not null,
    primary key(id_agendamento, id_peladeiro)
);

create table pelada_agendamento_equipe(
    id_equipe bigint not null auto_increment,
    id_pelada_agendamento bigint not null,
    id_time bigint not null,
    id_peladeiro bigint not null,
    primary key(id_equipe)
);

create table controle_usuarios(
	id_peladeiro bigint not null auto_increment,
    login varchar(50) not null,
    pass varchar(50) not null,
	primary key(id_peladeiro)
);