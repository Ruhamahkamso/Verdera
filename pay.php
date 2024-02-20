<?php
include("config.php");

$amount = 140;

// Sanitize form inputs from users
$sanitizer = filter_var_array($_POST, FILTER_SANITIZE_STRING);

// Collect user's inputs from the form into regular variables
$first_name = isset($sanitizer['first_name']) ? $sanitizer['first_name'] : '';
$last_name = isset($sanitizer['last_name']) ? $sanitizer['last_name'] : '';
$phone = isset($sanitizer['phone']) ? $sanitizer['phone'] : '';
$email = isset($sanitizer['email']) ? $sanitizer['email'] : '';
$product_name = "Verbum Estate Agency";

// Make sure all fields are filled in
if (empty($first_name) || empty($last_name) || empty($phone) || empty($email)) {
    // Redirect to log.php with an error message, or handle it in some way.
    // header("Location: log.php?error");
} else {
    session_start();
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;
    $_SESSION['product_name'] = $product_name;
    $_SESSION['price'] = $amount;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verdera - Paystack Integration</title>
    <link rel="stylesheet" href="./css/payment.css">
</head>
<body>
    <div class="container"> 
        <h2>Hi, <?php echo $first_name . ' ' . $last_name; ?> </h2>
    </div>

    <form>
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <button type="button" onclick="payWithPaystack()">Proceed</button>
    </form>

    <script>
        function payWithPaystack() {
            const api = "pk_test_0b88590db09df32937102374f459f7ad2572db9d";
            var handler = PaystackPop.setup({
                key: api,
                email: '<?php echo $email; ?>',
                amount: <?php echo $amount; ?>,
                currency: "NGN",
                ref: '' + Math.floor((Math.random() * 1000000000) + 1),
                firstname: '<?php echo $first_name; ?>',
                lastname: '<?php echo $last_name; ?>',
                metadata: {
                    custom_fields: [
                        {
                            display_name: "<?php echo $first_name; ?>",
                            variable_name: "<?php echo $last_name; ?>",
                            value: "<?php echo $phone; ?>",
                        }
                    ]
                },
                callback: function(response){
                    const referenced = response.reference;
                    window.location.href='success.php?successfullypaid='+referenced;   
                },
                onclose: function(){
                    alert('Window closed');
                }
            });
            handler.openIframe();
        }
    </script>
</body>
</html>
