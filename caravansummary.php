<?php
session_start();

include("connectregister.php");
include("check_login.php");

$user_data = check_login($con);
$user_id = $_SESSION['user_id'];

// Fetch all caravans
$result = $con->query("SELECT * FROM caravan_db");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Caravan Summary</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://www.retreatcaravans.com.au/wp-content/uploads/2017/03/Happy-Retreat-Caravaners.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #333;
    }
    .container {
      background: rgba(255, 255, 255, 0.9);
      max-width: 1000px;
      margin: 50px auto;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
    }
    h1 {
      text-align: center;
      color: #5e90aa;
    }
    .caravan-card {
      background: #f3f8ff;
      border: 1px solid #c0d7ec;
      padding: 20px;
      margin: 20px 0;
      border-radius: 12px;
      display: flex;
      align-items: center;
      gap: 20px;
      transition: transform 0.2s ease;
    }
    .caravan-card:hover {
      transform: scale(1.02);
    }
    .caravan-card img {
      width: 160px;
      height: 100px;
      object-fit: cover;
      border-radius: 10px;
    }
    .caravan-info {
      flex: 1;
    }
    .caravan-info h3 {
      margin: 0;
      color: #34577c;
    }
    .caravan-info p {
      margin: 5px 0 0;
      color: #666;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>🚐 Caravan Listings Summary</h1>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="caravan-card">
        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Caravan">
        <div class="caravan-info">
          <h3><?= htmlspecialchars($row['name']) ?></h3>
          <p>📍 <?= htmlspecialchars($row['location']) ?></p>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center;">🚫 No caravans available.</p>
  <?php endif; ?>

</div>

</body>
</html>

<?php $conn->close(); ?>