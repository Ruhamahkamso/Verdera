<?php
include("config.php");

session_start();

if (!$_GET["successfullypaid"]) {
    header("Location: log.php");
    exit;
} else {
    $reference = $_GET["successfullypaid"];
}

// Check if session keys are set before accessing them
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$amount = isset($_SESSION['price']) ? $_SESSION['price'] : '';
$product_name = isset($_SESSION['product_name']) ? $_SESSION['product_name'] : '';



// Insert into database
$sql = "INSERT INTO payments(first_name, last_name, phone, email, product_name, price, reference) VALUES (?, ?, ?, ?, ?, ?, ?)";

if ($stmt = mysqli_prepare($con, $sql)) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssssss", $first_name, $last_name, $phone, $email, $product_name, $amount, $reference);

    // Attempt to execute
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Your payment went through! ')</script>";
        // Prevent resubmission
        session_unset();
        session_destroy();
    } else {
        die("Sorry, something went wrong!");
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($con);
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Success</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/payment.css">
</head>
<body>

<div class="container">
  <h2> <strong>Success!</strong> Payment has been successful</h2> <br>
  <a class="go-home" href="index.php" style="color:white; text-decoration:none; background:blue; border-radius:5px;padding:8px; margin-top:5px; font-weight:bold;">Go Home</a>
  <!-- <table>
    <tr>
      <th>Summary</th>
    </tr>

    <tr>
      <td>First Name: <?php echo $first_name ?></td>
    </tr>
    <tr>
      <td>Last Name: <?php echo $last_name ?> </td>
    </tr>
    <tr>
      <td>Email: <?php echo $email ?></td>
    </tr>
    <tr>
      <td>Phone: <?php echo $phone ?></td>
    </tr>
    <tr>
      <td>Price: <?php echo $amount ?></td>
    </tr>
    <tr>
      <td>Product Name: <?php echo $product_name ?></td>
    </tr>
    <tr>
      <td>Reference code: <?php echo $reference  ?></td>
    </tr>
    <tr>
      <td></td>
    </tr>
  

  </table> -->


</div>

</body>
</html>
