
<?php
require_once __DIR__ . '/db.php';

// Xử lý logic
$category = $_GET['category'] ?? null;
$products = [];

if ($category !== null) {
    // Cố ý tạo lỗ hổng SQL Injection để thực hành
    // $sql = "SELECT * FROM products
    //         WHERE category = '$category'
    //         AND released = 1";

    // $stmt = $pdo->query($sql);

    // bẢNG FIX
    $stmt = $pdo->prepare(
    "SELECT * FROM products WHERE category = ? AND released = 1"
    );
    $stmt->execute([$category]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Product Store</title>
</head>
<body>

<h1>Product Store</h1>

<?php if ($category === null): ?>

    <h2>Danh mục sản phẩm</h2>

    <a href="?category=Gifts">Gifts</a>
    <br><br>
    <a href="?category=Fashion">Fashion</a>

<?php else: ?>

    <a href="/">Quay lại danh mục</a>

    <h2>Danh mục: <?= htmlspecialchars($category) ?></h2>

    <?php foreach ($products as $product): ?>

        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0; width: 250px;">

            <h3><?= htmlspecialchars($product['name']) ?></h3>

            <p>
                Danh mục:
                <?= htmlspecialchars($product['category']) ?>
            </p>

            <p>
                Trạng thái:
                <?= $product['released'] == 1
                    ? 'Đã phát hành'
                    : 'Sản phẩm chưa phát hành' ?>
            </p>

        </div>

    <?php endforeach; ?>

    <?php if (empty($products)): ?>
        <p>Không tìm thấy sản phẩm.</p>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>
