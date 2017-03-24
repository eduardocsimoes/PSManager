CREATE TABLE pelada (
  id_pelada bigint(20) NOT NULL AUTO_INCREMENT,
  nome_pelada varchar(100) NOT NULL,
  data_cadastro date NOT NULL,
  id_peladeiro int(11) NOT NULL,
  PRIMARY KEY (id_pelada)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

CREATE TABLE posicao (
  id_posicao int(11) NOT NULL AUTO_INCREMENT,
  nome_posicao varchar(50) NOT NULL,
  data_cadastro date NOT NULL,
  PRIMARY KEY (id_posicao)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

CREATE TABLE habilidade (
  id_habilidade int(11) NOT NULL AUTO_INCREMENT,
  nome_habilidade varchar(50) NOT NULL,
  data_cadastro date NOT NULL,
  PRIMARY KEY (id_habilidade)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

CREATE TABLE pelada (
  id_pelada bigint(20) NOT NULL AUTO_INCREMENT,
  nome_pelada varchar(100) NOT NULL,
  data_cadastro date NOT NULL,
  id_peladeiro int(11) NOT NULL,
  PRIMARY KEY (id_pelada)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

CREATE TABLE pelada_agendamento (
  id_agendamento bigint(20) NOT NULL AUTO_INCREMENT,
  id_pelada bigint(20) NOT NULL,
  data_agendamento date NOT NULL,
  hora_agendamento time NOT NULL,
  data_cadastro date NOT NULL,
  nome_local varchar(100) NOT NULL,
  qtd_peladeiro_time int(11) NOT NULL,
  situacao_pelada enum(A Confirmar,Confirmada,Cancelada) NOT NULL,
  PRIMARY KEY (id_agendamento)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

CREATE TABLE pelada_agendamento_equipe (
  id_equipe bigint(20) NOT NULL AUTO_INCREMENT,
  id_pelada_agendamento bigint(20) NOT NULL,
  id_time bigint(20) NOT NULL,
  id_peladeiro bigint(20) NOT NULL,
  PRIMARY KEY (id_equipe)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE pelada_agendamento_peladeiro (
  id_agendamento bigint(20) NOT NULL AUTO_INCREMENT,
  id_peladeiro bigint(20) NOT NULL,
  PRIMARY KEY (id_agendamento,id_peladeiro)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

CREATE TABLE pelada_peladeiro (
  id_pelada bigint(20) NOT NULL,
  id_peladeiro bigint(20) NOT NULL,
  data_cadastro date NOT NULL,
  PRIMARY KEY (id_pelada,id_peladeiro)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE peladeiro_habilidade (
  id_peladeiro bigint(20) NOT NULL,
  id_habilidade int(11) NOT NULL,
  nivel decimal(4,2) DEFAULT NULL,
  data_cadastro date NOT NULL,
  PRIMARY KEY (id_peladeiro,id_habilidade)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE peladeiro_posicao (
  id_peladeiro bigint(20) NOT NULL,
  id_posicao int(11) NOT NULL,
  data_cadastro date NOT NULL,
  PRIMARY KEY (id_peladeiro,id_posicao)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
