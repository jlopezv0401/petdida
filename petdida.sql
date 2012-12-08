    DROP TABLE IF EXISTS Usuario;
    CREATE TABLE  Usuario(
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		password VARCHAR(100) COLLATE utf8_bin DEFAULT NULL,
		tipo_usuario ENUM('Persona','Cliente') COLLATE utf8_bin DEFAULT NULL,
        PRIMARY KEY(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

    DROP TABLE IF EXISTS Cliente;
    CREATE TABLE  Cliente(
        id BIGINT(20) NOT NULL,
		tipo_cliente ENUM('Refugio','Veterinaria') COLLATE utf8_bin DEFAULT NULL,
		giro VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		propietario VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		latitud VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		longitud VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		direccion VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		colonia VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		delegacion VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		telefono VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		email VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		url VARCHAR(100) COLLATE utf8_bin DEFAULT NULL,
        CONSTRAINT cliente_usuario_fk FOREIGN KEY(id) REFERENCES Usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

    DROP TABLE IF EXISTS Persona;
    CREATE TABLE  Persona(
		id_usuario BIGINT(20),
        CONSTRAINT persona_usuario_fk FOREIGN KEY(id_usuario) REFERENCES Usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;


    DROP TABLE IF EXISTS Reporte;
    CREATE TABLE  Reporte(
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        tipo_reporte ENUM('Perdido','Encontrado','Adopcion') COLLATE utf8_bin DEFAULT NULL,
        nombre VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		url_imagen VARCHAR(100) COLLATE utf8_bin DEFAULT NULL,
		procedencia VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		tipo VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		raza VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		sexo VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		descripcion VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		fecha DATETIME DEFAULT NULL,
		latitud DOUBLE DEFAULT NULL,
		longitud DOUBLE DEFAULT NULL,
		colonia VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		delegacion VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		telefono VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
		email VARCHAR(50) COLLATE utf8_bin DEFAULT NULL,
        id_usuario BIGINT(20),
        PRIMARY KEY(id),
        CONSTRAINT reporte_usuario_fk FOREIGN KEY(id_usuario) REFERENCES Usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

    CREATE INDEX latitud_index ON Reporte (latitud) USING BTREE;
    CREATE INDEX longitud_index ON Reporte (longitud) USING BTREE;

    DROP TABLE IF EXISTS Perdido;
    CREATE TABLE  Perdido(
        id_reporte BIGINT(20) NOT NULL,
        CONSTRAINT reporte_perdido_fk FOREIGN KEY(id_reporte) REFERENCES Reporte(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

    DROP TABLE IF EXISTS Encontrado;
    CREATE TABLE  Encontrado(
        id_reporte BIGINT(20) NOT NULL,
        CONSTRAINT reporte_encontrado_fk FOREIGN KEY(id_reporte) REFERENCES Reporte(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

    DROP TABLE IF EXISTS Adopcion;
    CREATE TABLE  Adopcion(
        id_reporte BIGINT(20) NOT NULL,
		edad INT(2) DEFAULT NULL,
        CONSTRAINT reporte_adopcion_fk FOREIGN KEY(id_reporte) REFERENCES Reporte(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

    DROP TABLE IF EXISTS Comentario;
    CREATE TABLE  Comentario(
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
		comentario VARCHAR(140) COLLATE utf8_bin DEFAULT NULL,
		id_reporte BIGINT(20) NOT NULL,
        id_usuario BIGINT(20) NOT NULL,
        PRIMARY KEY(id),
        CONSTRAINT reporte_comentario_fk FOREIGN KEY(id_reporte) REFERENCES Reporte(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;


DELIMITER ;
DROP TRIGGER IF EXISTS `insertar_usuario`;
DELIMITER //
CREATE TRIGGER `insertar_usuario` AFTER INSERT ON `Usuario`
 FOR EACH ROW BEGIN
            DECLARE tipoUsuario VARCHAR(15);
            SET tipoUsuario = NEW.tipo_usuario;
            IF tipoUsuario = 'Cliente' THEN
                INSERT INTO Cliente VALUES (NEW.id, '', '', '', '', '', '', '', '', '', '', '');
            ELSEIF tipoUsuario = 'Persona' THEN
                INSERT INTO Persona VALUES (NEW.id);
            END IF;
        END
//
DELIMITER ;


DELIMITER ;
DROP TRIGGER IF EXISTS `insertar_reporte`;
DELIMITER //
CREATE TRIGGER `insertar_reporte` AFTER INSERT ON `Reporte`
 FOR EACH ROW BEGIN
            DECLARE tipoReporte VARCHAR(15);
            SET tipoReporte = NEW.tipo_reporte;
            IF tipoReporte = 'Perdido' THEN
                INSERT INTO Perdido VALUES (NEW.id, '');
            ELSEIF tipoReporte = 'Encontrado' THEN
                INSERT INTO Encontrado VALUES (NEW.id);
            ELSEIF tipoReporte = 'Adopcion' THEN
                INSERT INTO Adopcion VALUES (NEW.id, '');
            END IF;
        END
//
DELIMITER ;