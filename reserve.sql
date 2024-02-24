CREATE TABLE salas (
    id_sala SERIAL PRIMARY KEY,
    nome_sala VARCHAR(255) NOT NULL,
    capacidade INT NOT NULL,
    descricao TEXT,
    imagem_url VARCHAR(255)
);

CREATE TABLE reservas (
    id_reserva SERIAL PRIMARY KEY,
    id_sala INT NOT NULL,
    data_hora_inicio TIMESTAMP NOT NULL,
    data_hora_fim TIMESTAMP NOT NULL,
    nome_representante VARCHAR(255),
    nome_equipe VARCHAR(255),
    FOREIGN KEY (id_sala) REFERENCES salas(id_sala)
);


CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    limite_reservas INTEGER DEFAULT 30,
    auth_key VARCHAR(255)
);


ALTER TABLE reservas
ADD COLUMN users_id INTEGER;


ALTER TABLE reservas
ADD CONSTRAINT fk_reservas_usuario
FOREIGN KEY (users_id) REFERENCES users(id);
