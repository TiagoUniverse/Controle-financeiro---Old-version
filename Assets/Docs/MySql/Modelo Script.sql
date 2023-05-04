
/**
* ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
* ║ 1-                                          Usuario	    	       	                                          ║
* ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
*
* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │ @description: All the users from the system		                                                              │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

Create table Usuario (
id 			INT  NOT NULL PRIMARY KEY  AUTO_INCREMENT,
nome		VARCHAR(300) 	NOT NULL,
email	VARCHAR(300)	NOT NULL, 
senha VARCHAR(300) NOT NULL,
status 	VARCHAR(300) 	NOT NULL DEFAULT 'ATIVO' ,
created	DATETIME NOT NULL  DEFAULT NOW(),
updated DATETIME NULL

);

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │ INSERT INTO										                                                              │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
insert into usuario (nome, email, senha) values ('Tiago', 'tiagocesar68@gmail.com',  sha1('tiago123')    ) ;

Select * from Usuario where email = 'teste@gmail.com' and senha = sha1( 'teste123' )


/**
* ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
* ║ 2-                                         Status_despensas                          	                      ║
* ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
*
* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │ @description: Status from a specific "despensa"	                                                              │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

Create table Status_despensas (
id 			INT  NOT NULL PRIMARY KEY AUTO_INCREMENT,
nome		VARCHAR(300) 	NOT NULL,
descricao	VARCHAR(300) 	NOT NULL,
created	DATETIME NOT NULL DEFAULT NOW()

);

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │ INSERT INTO										                                                              │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
insert into status_despensas (nome, descricao) values ('Despensas: Entrada da casa' , '');
insert into status_despensas (nome, descricao) values ('Despensas: Saida da casa' , '');

insert into status_despensas (nome, descricao) values ('Despensas: Entrada dos gastos pessoais' , '');
insert into status_despensas (nome, descricao) values ('Despensas: Saída dos gastos pessoais' , '');

insert into status_despensas (nome, descricao) values ('Poupanca: Entrada da casa' , '');
insert into status_despensas (nome, descricao) values ('Poupanca: Saida da casa' , '');

insert into status_despensas (nome, descricao) values ('Despensas: Entrada dos gastos pessoais' , '');
insert into status_despensas (nome, descricao) values ('Despensas: Saída dos gastos pessoais' , '');


/**
* ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
* ║ 3-                                         Status_mes		                          	                      ║
* ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
*
* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │ @description: The month from the year			                                                              │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

Create table Status_mes (
id 			INT  NOT NULL PRIMARY KEY AUTO_INCREMENT,
nome		VARCHAR(300) 	NOT NULL,
created	DATETIME NOT NULL DEFAULT NOW()

);

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │ INSERT INTO										                                                              │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

insert into status_mes ( nome ) values (' Janeiro ' );


/**
* ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
* ║ 4-                                         Despensas		                          	                      ║
* ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
*
* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │ @description: Money spend and recieved in a specific date                                                     │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

Create table Despensas (
id 			INT  NOT NULL PRIMARY KEY AUTO_INCREMENT,
descricao		VARCHAR(300) 	NOT NULL,
valor	float	NOT NULL, 
dataDespensa 	date 	NOT NULL,
/* Ano vai ser usado pelo sistema  */
ano     VARCHAR(300) NOT NULL,
quinzena VARCHAR(300) NOT NULL,
status 	VARCHAR(300) 	NOT NULL DEFAULT 'ATIVO' ,
created	DATETIME NOT NULL DEFAULT NOW(),
updated DATETIME NULL,
IdStatus_mes INT NOT NULL,
idStatus_despensa INT NOT NULL,


FOREIGN KEY (IdStatus_mes) REFERENCES status_mes(id),
FOREIGN KEY (idStatus_despensa) REFERENCES status_despensas(id)

);


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │ SELECT																										  |
  | Description: Busca de despensa de gasto pessoais da quinzena 1 de janeiro/2023 								  │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

Select * from despensas where status = "ATIVO" and ano = "2023"  and IdStatus_mes = "1" and quinzena = "Quinzena 01" and ( idStatus_despensa = 3 OR idstatus_despensa = 4 );



/**
* ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
* ║ 5-                                         Poupancas		                          	                      ║
* ╚═══════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
*
* ┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │ @description: Register of the money saved in the bank	                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
Create table poupancas (
id 				INT  NOT NULL PRIMARY KEY AUTO_INCREMENT,
descricao		VARCHAR(300) 	NOT NULL DEFAULT '',
valor			float	 	    NOT NULL,
dataPoupanca	DATE 	        NOT NULL ,
ano				VARCHAR(300) 	NOT NULL DEFAULT '',
status			VARCHAR(300) 	NOT NULL DEFAULT 'ATIVO',
created			DATETIME	 	NOT NULL default NOW(),
updated			DATETIME 			NULL,

idUsuario INT,
idStatus_despensa INT,

Foreign key (idUsuario) references Usuario(id) ,
FOREIGN KEY (idStatus_despensa) references Status_despensas(id)

);
