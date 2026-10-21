
<?php

require_once __DIR__ . '/db.php';

$category = $_GET['category'] ?? null;

$products = [];
$error = null;

try {

    /*
    CODE CÓ LỖ HỔNG SQL INJECTION

    if ($category === null) {
        $sql = "SELECT name, category FROM products WHERE released = 1";
    } else {
        $sql = "SELECT name, category FROM products
                WHERE category = '$category' AND released = 1";
    }

    error_log("SQL QUERY: " . $sql);

    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    */


   
    // CODE FIX SQL INJECTION
 

    if ($category === null) {
        $sql = "SELECT name, category FROM products WHERE released = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    } else {
        $sql = "SELECT name, category FROM products
                WHERE category = :category AND released = 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['category' => $category]);
    }

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    http_response_code(500);
    error_log("SQL ERROR: " . $e->getMessage());
    $error = "Không thể tải danh sách sản phẩm.";
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>SQL Injection Lab</title>
</head>
<body>

    <h2>Product List</h2>

    <p>
        Category:
        <a href="/">All</a> |
        <a href="?category=Gifts">Gifts</a> |
        <a href="?category=Fashion">Fashion</a>
    </p>

    <?php if ($error !== null): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Product Name</th>
                <th>Category</th>
            </tr>

            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>
</html>