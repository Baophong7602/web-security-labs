
<?php

$host = 'db';
$dbname = 'oracle_lab';
$user = 'root';
$password = 'root';

/** @var PDO|null $pdo */
$pdo = null;

for ($i = 0; $i < 30; $i++) {
    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $user,
            $password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        break;
    } catch (PDOException $e) {
        sleep(2);
    }
}

if (!$pdo instanceof PDO) {
    die('Không thể kết nối database.');
}

// Tạo bảng sản phẩm
$pdo->exec("
    CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        description TEXT,
        category VARCHAR(100),
        released INT
    )
");

// Mô phỏng bảng DUAL của Oracle
$pdo->exec("
    CREATE TABLE IF NOT EXISTS `dual` (
        dummy VARCHAR(1)
    )
");

if ((int) $pdo->query("SELECT COUNT(*) FROM `dual`")->fetchColumn() === 0) {
    $pdo->exec("INSERT INTO `dual` (dummy) VALUES ('X')");
}

// Mô phỏng bảng V$VERSION của Oracle
$pdo->exec("
    CREATE TABLE IF NOT EXISTS v_version (
        BANNER VARCHAR(255)
    )
");

if ((int) $pdo->query("SELECT COUNT(*) FROM v_version")->fetchColumn() === 0) {
    $pdo->exec("
        INSERT INTO v_version (BANNER)
        VALUES ('Oracle Database 19c Enterprise Edition Release 19.0.0.0.0')
    ");
}

if ((int) $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn() === 0) {
    $pdo->exec("
        INSERT INTO products (name, description, category, released)
        VALUES
        ('Gift Box', 'A nice gift box', 'Gifts', 1),
        ('Flower Basket', 'Beautiful flowers', 'Gifts', 1),
        ('Secret Gift', 'Unreleased gift', 'Gifts', 0),
        ('Fashion Shirt', 'A stylish shirt', 'Fashion', 1),
        ('Hidden Fashion Item', 'Unreleased fashion item', 'Fashion', 0)
    ");
}
