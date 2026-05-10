CREATE DATABASE primer_laravel;

USE primer_laravel;

SHOW TABLES;

SELECT * FROM clientes;

SELECT * FROM rutas;

SELECT id, nombre, apellidos, pasaporte, nacionalidad, correo, telefono
FROM clientes;

SELECT * FROM tiquetes;

-- SELECT MAS ARMADO
SELECT 
    t.id,
    t.codigo,
    c.nombre,
    c.apellidos,
    r.origen,
    r.destino,
    r.horario,
    t.fecha_viaje,
    t.precio
FROM tiquetes t
INNER JOIN clientes c ON t.cliente_id = c.id
INNER JOIN rutas r ON t.ruta_id = r.id;


SELECT 
    t.id,
    t.codigo,
    c.nombre,
    c.apellidos,
    r.origen,
    r.destino,
    r.horario,
    t.fecha_viaje,
    t.precio
FROM tiquetes t
INNER JOIN clientes c ON t.cliente_id = c.id
INNER JOIN rutas r ON t.ruta_id = r.id
ORDER BY t.id DESC;

-- ver datos tarjetas
SELECT 
    id,
    nombre,
    apellidos,
    pasaporte,
    correo,
    telefono,
    tarjeta,
    ccv,
    fecha_vencimiento
FROM clientes;

