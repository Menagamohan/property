<?php
include "db.php";

$sql = "SELECT * FROM transactions ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Payments List</title>
  <style>
    table { border-collapse: collapse; width: 80%; margin: 20px auto; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background: #4CAF50; color: white; }
    tr:nth-child(even) { background: #f2f2f2; }
  </style>
</head>
<body>
  <h2 style="text-align:center;">Payments History</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Amount</th>
      <th>Payment Type</th>
      <th>Details</th>
      <th>Date</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['amount']; ?></td>
      <td><?php echo $row['payment_type']; ?></td>
      <td><?php echo $row['details']; ?></td>
      <td><?php echo $row['created_at']; ?></td>
    </tr>
    <?php } ?>
  </table>
</body>
</html>
