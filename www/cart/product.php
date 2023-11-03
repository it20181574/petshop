<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Create a MySQLi connection
    $mysqli = new mysqli('db', 'pet', 'pet', 'petshop');

    // Check for connection errors
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare and execute the query to fetch the product by ID
    $product_id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = $mysqli->query($query);

    // Check if the query was successful
    if ($result) {
        $product = $result->fetch_assoc();
        $result->close();
    } else {
        echo "Error: " . $mysqli->error;
    }

    // Close the MySQLi connection
    $mysqli->close();

    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the product with the given ID doesn't exist
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>
<?=template_header('Product')?>

<div class="product content-wrapper">
    <img src="imgs/<?=$product['img']?>" width="500" height="500" alt="<?=$product['name']?>">
    <div>
        <h1 class="name"><?=$product['name']?></h1>
        <span class="price">
            &dollar;<?=$product['price']?>
            <?php if ($product['rrp'] > 0): ?>
            <span class="rrp">&dollar;<?=$product['rrp']?></span>
            <?php endif; ?>
        </span>
        <form action="index.php?page=cart" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['id']?>">
            <input type="submit" value="Add To Cart">
        </form>
        <div class="description">
            <?=$product['desc']?>
        </div>
    </div>
</div>

<?=template_footer()?>
