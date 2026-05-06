USE primer_laravel;

SHOW TABLES;

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

-- Ver datos de registros de clientes
SELECT
    id,
    nombre,
    apellidos,
    pasaporte,
    nacionalidad,
    correo,
    telefono,
    tarjeta,
    ccv,
    fecha_vencimiento,
    password AS contrasena,
    created_at AS fecha_registro
FROM clientes;