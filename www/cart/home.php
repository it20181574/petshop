<?php
// Create a MySQLi connection
$mysqli = new mysqli('db', 'pet', 'pet', 'petshop');

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the 4 most recently added products
$query = "SELECT * FROM products ORDER BY date_added DESC LIMIT 4";
$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    $recently_added_products = $result->fetch_all(MYSQLI_ASSOC);
    $result->close();
} else {
    echo "Error: " . $mysqli->error;
}

// Close the MySQLi connection
$mysqli->close();
?>
<?=template_header('Home')?>

<div class="featured">
    <h2>All Spice Products</h2>
    <p>Essential gadgets for everyday use</p>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
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
</div>

<?=template_footer()?>