CREATE DATABASE EscuelaDeportivaDAW;

USE EscuelaDeportivaDAW;

CREATE TABLE DEPORTES(
		IdDeporte tinyint unsigned PRIMARY KEY AUTO_INCREMENT,
		Nombre varchar(30) not null UNIQUE,
		Tipo ENUM('I','C') not null
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
CREATE TABLE ALUMNO(
		IdAlumno smallint unsigned PRIMARY KEY AUTO_INCREMENT,
		Nombre varchar(60) not null,
		Direccion varchar(60)  null,
		Poblacion varchar(60) not null DEFAULT 'Badajoz',
		Telefono char(09) null,
		Correo  varchar(60) not null,
		FechaNacimiento date not null,
		EstudiaGuadalupe boolean  
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		/*Si el jugador no estudia se guarda NULL en EstudiaGuadalupe*/
		
		
CREATE TABLE EQUIPOS(
		IdDeporteColectivo tinyint unsigned,
		CodEquipo tinyint unsigned not null UNIQUE,
		Nombre varchar(30) not null,
		Edad tinyint not null,
		PRIMARY KEY (IdDeporteColectivo,CodEquipo),
		CONSTRAINT FK_COLECTIVO FOREIGN KEY (IdDeporteColectivo) 
		           REFERENCES DEPORTES(IdDeporte) ON UPDATE CASCADE ON DELETE RESTRICT
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
CREATE TABLE ALUMNOS_DEPORTE(
		IdDeporte tinyint unsigned,
		IdAlumno smallint unsigned,
		PRIMARY KEY (IdDeporte,IdAlumno),
		CONSTRAINT FK_ALUMNO FOREIGN KEY (IdAlumno) REFERENCES ALUMNO(IdAlumno)ON UPDATE CASCADE ON DELETE RESTRICT ,
		CONSTRAINT FK_DEPORTE FOREIGN KEY (IdDeporte) REFERENCES DEPORTES(IdDeporte) ON UPDATE CASCADE ON DELETE RESTRICT
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
CREATE TABLE ALUMNOS_EQUIPO(
		IdDeporteColectivo tinyint unsigned,
		IdAlumno smallint unsigned,
		CodEquipo tinyint unsigned not null,
		PRIMARY KEY (IdDeporteColectivo, IdAlumno),
		CONSTRAINT FK_IDALUMNO FOREIGN KEY (IdDeporteColectivo,IdAlumno) REFERENCES ALUMNOS_DEPORTE(IdDeporte,IdAlumno) ON UPDATE CASCADE ON DELETE RESTRICT,
		CONSTRAINT FK_IDCOLECTIVO FOREIGN KEY(IdDeporteColectivo,CodEquipo) REFERENCES EQUIPOS(IdDeporteColectivo,CodEquipo)ON UPDATE CASCADE ON DELETE RESTRICT
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;
