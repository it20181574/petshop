<?php
// The amounts of products to show on each page
$num_products_on_each_page = 4;
// The current page - in the URL, will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;

// Create a MySQLi connection
$mysqli = new mysqli('db', 'pet', 'pet', 'petshop');

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare and execute the query
$offset = ($current_page - 1) * $num_products_on_each_page;
$query = "SELECT * FROM products ORDER BY date_added DESC LIMIT $offset, $num_products_on_each_page";
$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
} else {
    echo "Error: " . $mysqli->error;
}

// Get the total number of products
$total_products = $mysqli->query('SELECT * FROM products')->num_rows;

// Close the MySQLi connection
$mysqli->close();
?>
<?=template_header('Products')?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?=$total_products?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
        <a href="index.php?page=product&id=<?=$product['id']?>" class="product">
            <img src="imgs/<?=$product['img']?>" width="200" height="200" alt="<?=$product['name']?>">
            <span class="name"><?=$product['name']?></span>
            <span class="price">
                &dollar;<?=$product['price']?>
                <?php if ($product['rrp'] > 0): ?>
                <span class="rrp">&dollar;<?=$product['rrp']?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
        <a href="index.php?page=products&p=<?=$current_page-1?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
        <a href="index.php?page=products&p=<?=$current_page+1?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>
