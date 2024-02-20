<?php
include('config.php');

$sql = "SELECT * FROM payments";
$result = $mysqli->query($sql);

// Check for errors in query execution
if (!$result) {
    die("Error executing the query: " . $mysqli->error);
}

$estate = $result->fetch_all(MYSQLI_ASSOC);

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cancel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/payment.css">
</head>
<body>

<div class="container">

<h2>customers</h2>
<table>
    
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Product Name</th>
        <th>Reference code</th>
    </tr>

<?php foreach ($estate as $row): ?>
    <tr>
        <td><?php echo $row['first_name']; ?></td>
        <td><?php echo $row['last_name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['reference_code']; ?></td>
    </tr>
<?php endforeach; ?>

</table>
 
</div>

</body>
</html>
