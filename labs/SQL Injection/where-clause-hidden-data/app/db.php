<?php

$pdo = new PDO(
    "mysql:host=db;dbname=sqli_lab;charset=utf8mb4",
    "root",
    "root",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

$pdo->exec("
    CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        category VARCHAR(50) NOT NULL,
        released INT NOT NULL
    )
");


$pdo->exec("DELETE FROM products");

$pdo->exec("
    INSERT INTO products (name, category, released) VALUES
    ('Gift Box', 'Gifts', 1),
    ('Flower Basket', 'Gifts', 1),
    ('Secret Gift', 'Gifts', 0),
    ('Fashion Shirt', 'Fashion', 1),
    ('Hidden Fashion Item', 'Fashion', 0)
");
