<?=template_header('Place Order')?>

<style>
    .placeorder {
        text-align: center;
    }

    .placeorder button {
        background-color: #007bff; /* Change the button color to blue */
        color: #fff; /* Change the text color to white */
        height: 40px; /* Change the button height to your desired value */
        border-radius: 5px; /* Add border radius for rounded corners */
    }
</style>

<div class="placeorder content-wrapper">
    <h1>Your Order Has Been Placed After did Payment</h1>
    <p>Thank you for ordering with us! We'll contact you by email with your order details.</p>
    <a href="../payment">
    <button>Do Payment</button>
</a>
</div>

<?=template_footer()?>