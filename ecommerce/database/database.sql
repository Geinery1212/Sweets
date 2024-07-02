DROP DATABASE IF EXISTS id22394051_ecommerce_php_sweets;

CREATE DATABASE IF NOT EXISTS id22394051_ecommerce_php_sweets CHARACTER SET = 'latin1' COLLATE = 'latin1_spanish_ci';

USE id22394051_ecommerce_php_sweets;

CREATE TABLE usuarios (
    id INT(255) AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20),
    imagenes VARCHAR(255),
    CONSTRAINT pk_usuarios PRIMARY KEY (id),
    CONSTRAINT uq_email UNIQUE (email)
) Engine = InnoDB;

INSERT INTO
    usuarios
VALUES (
        NULL,
        'admin',
        'admin',
        'admin@admin.com',
        '$2y$04$vR.znvSkMTn0ZQZcfifqeu6cg7bItD3r1YLVojR9Q/PDdlQM2l2De',
        'admin',
        NUll
    );

CREATE TABLE categorias (
    id INT(255) AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    CONSTRAINT pk_categorias PRIMARY KEY (id)
) Engine = InnoDB;

INSERT INTO `categorias` VALUES (1,'Caramelos y Golosinas'),(3,'Chocolates'),(11,'Snacks Crujientes'),(12,'Dulces tradicionales'),(14,'Snacks Crujientes'),(15,'Galletas');

CREATE TABLE productos (
    id INT(255) AUTO_INCREMENT NOT NULL,
    categoria_id INT(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio FLOAT(100, 2) NOT NULL,
    stock INT(255) NOT NULL,
    oferta VARCHAR(2),
    fecha DATE NOT NULL,
    imagen VARCHAR(255),
    CONSTRAINT pk_productos PRIMARY KEY (id),
    CONSTRAINT fk_productos_categorias FOREIGN KEY (categoria_id) REFERENCES categorias (id)
) Engine = InnoDB;

INSERT INTO `productos` VALUES (1,3,'GANSITO',' Pastelito Marinela Gansito 50 g                 ',19.00,9,NULL,'2024-06-26','667c8ae78ca2e_gansito.jpg'),(2,1,'HALLS',' Halls Relief Bolsa Con 200 Pastillas Sabor Cereza        ',50.00,112,NULL,'2024-06-26','667c8adbe0cc3_halls.jpg'),(3,1,' Icee ',' Icee Paleta De Caramelo Suave Bisabor bolsa con 38 piezas        ',55.00,550,NULL,'2024-06-26','667c8ad4c392c_icee.jpg'),(4,11,'Carameladas',' Palomitas Pop Carameladas        ',19.00,45,NULL,'2024-06-26','667c8ac2eca36_karameladas.jpg'),(5,3,'Kisses',' Hersheys Chocolate Con Leche Kisses 809g             ',184.00,66,NULL,'2024-06-26','667c8abc0188e_KISSES.jpg'),(6,1,'Lucas Muecas',' Lucas Muecas Mango        ',8.00,123,NULL,'2024-06-26','667c8ab46cc12_LUCASMUECAS.jpg'),(7,14,'Panditas rojos','  Panditas Cursis Ricolino Con Corazones De Gomita 330G.                ',10.00,123,NULL,'2024-06-26','667c8aab9f222_panditasrojos.jpg'),(8,3,'Pinguinos','    Marinela Pingüinos Pastelitos De Chocolate Relleno Con Crema                               ',19.00,67,NULL,'2024-06-26','667c8a79d6fa6_pinguinos.jpg');

CREATE TABLE pedidos (
    id INT(255) AUTO_INCREMENT NOT NULL,
    usuario_id INT(255) NOT NULL,
    municipio VARCHAR(100) NOT NULL,
    localidad VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    referencia TEXT,
    numeroTel VARCHAR(100) NOT NULL,
    coste FLOAT(200, 2) NOT NULL,
    estado VARCHAR(20) NOT NULL,
    fecha DATE,
    hora TIME,
    CONSTRAINT pk_pedidos PRIMARY KEY (id),
    CONSTRAINT pk_pedidos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
) Engine = InnoDB;

CREATE TABLE lineas_pedidos (
    id INT(255) AUTO_INCREMENT NOT NULL,
    pedido_id INT(255) NOT NULL,
    producto_id INT(255) NOT NULL,
    unidades INT(255) NOT NULL,
    CONSTRAINT pk_lineas_pedidos PRIMARY KEY (id),
    CONSTRAINT fk_linea_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos (id),
    CONSTRAINT fk_linea_producto FOREIGN KEY (producto_id) REFERENCES productos (id)
) Engine = InnoDB;