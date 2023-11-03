<?php
// Initialize the session if not already done
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// If the user clicked the add to cart button on the product page, check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables and make sure they are integers
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Create a MySQLi connection
    $mysqli = new mysqli('db', 'pet', 'pet', 'petshop');

    // Check for connection errors
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare the SQL statement to check if the product exists in the database
    $stmt = $mysqli->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Check if the product exists and the quantity is greater than 0
    if ($product && $quantity > 0) {
        // Product exists in the database, now create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in the cart, so update the quantity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in the cart, so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in the cart, add the first product to the cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }

    // Close the MySQLi connection
    $mysqli->close();

    // Prevent form resubmission
    header('Location: index.php?page=cart');
    exit;
}

// Remove a product from the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in the cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data to update quantities for each product in the cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Check if the ID is numeric, the product exists in the cart, and the quantity is greater than 0
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update the quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission
    header('Location: index.php?page=cart');
    exit;
}

// Send the user to the place order page if they click the "Place Order" button, and the cart is not empty
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=placeorder');
    exit;
}

// Check the session variable for products in the cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

// If there are products in the cart
if ($products_in_cart) {
    // Create a MySQLi connection
    $mysqli = new mysqli('db', 'pet', 'pet', 'petshop');

    // Check for connection errors
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Convert the array keys (product IDs) into a string for the SQL query
    $product_ids = implode(',', array_map('intval', array_keys($products_in_cart)));

    // Prepare and execute the SQL statement to fetch products in the cart
    $query = "SELECT * FROM products WHERE id IN ($product_ids)";
    $result = $mysqli->query($query);

    // Check if the query was successful
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
            $subtotal += (float)$row['price'] * (int)$products_in_cart[$row['id']];
        }
    } else {
        echo "Error: " . $mysqli->error;
    }

    // Close the MySQLi connection
    $mysqli->close();
}

?>
<?=template_header('Cart')?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="index.php?page=cart" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="index.php?page=product&id=<?=$product['id']?>">
                            <img src="imgs/<?=$product['img']?>" width="50" height="50" alt="<?=$product['name']?>">
                        </a>
                    </td>
                    <td>
                        <a href="index.php?page=product&id=<?=$product['id']?>"><?=$product['name']?></a>
                        <br>
                        <a href="index.php?page=cart&remove=<?=$product['id']?>" class="remove">Remove</a>
                    </td>
                    <td class="price">&dollar;<?=$product['price']?></td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
                    </td>
                    <td class="price">&dollar;<?=$product['price'] * $products_in_cart[$product['id']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form>
</div>

<?=template_footer()?>
