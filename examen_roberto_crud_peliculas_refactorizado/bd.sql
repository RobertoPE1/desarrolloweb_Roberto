-- Creamos la base de datos
CREATE DATABASE IF NOT EXISTS cine;
USE cine;

-- Creamos la tabla de videojuegos
CREATE TABLE IF NOT EXISTS peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,   -- Identificador único
    titulo VARCHAR(150) NOT NULL,        -- Título del videojuego
    director VARCHAR(100) NOT NULL, -- Empresa desarrolladora
    duracion VARCHAR(50) NOT NULL,     -- Plataforma (PC, PS5, etc.)
    genero VARCHAR(50) NOT NULL,         -- Género del juego
    anio INT NOT NULL                    -- Año de lanzamiento
);
