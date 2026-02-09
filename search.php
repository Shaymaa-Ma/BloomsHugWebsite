<?php
include 'config.php'; // database connection

$valid_categories = [
    'wedding bouquets',
    'seasonal blooms',
    'graduation blooms',
    'random bouquets',
    'luxury collection'
];

$search = "";
$results = [];

if (isset($_GET['query'])) {
    $search = strtolower(trim($_GET['query']));

    // Normalize "luxury collection" to just "luxury" if needed
    if ($search === 'luxury collection') {
        $search = 'luxury';
    }

    // Check if the search is in valid categories
    $matched_category = null;
    foreach ($valid_categories as $category) {
        if (strpos(strtolower($category), $search) !== false || $search === strtolower($category)) {
            $matched_category = ucfirst(str_replace("collection", "", $category));
            break;
        }
    }

    if ($matched_category) {
        // Find category_id by name
        $stmt = $conn->prepare("SELECT id FROM categories WHERE LOWER(name) LIKE ?");
        $like = "%" . $search . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $category_result = $stmt->get_result();

        if ($category_row = $category_result->fetch_assoc()) {
            $category_id = $category_row['id'];

            $product_stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
            $product_stmt->bind_param("i", $category_id);
            $product_stmt->execute();
            $results = $product_stmt->get_result();
        }
    } else {
        echo "<script>alert('Category not found. Please enter a valid occasion.'); window.location.href='index.html';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results - Bloom Flower Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h2 class="mb-4">Results for: <em><?= htmlspecialchars(ucwords($search)) ?></em></h2>

        <?php if ($results && $results->num_rows > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php while ($product = $results->fetch_assoc()): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="images/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...</p>
                                <p class="card-text text-success fw-bold">$<?= number_format($product['price'], 2) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No products found in this category.</div>
        <?php endif; ?>
    </div>
</body>
</html>
