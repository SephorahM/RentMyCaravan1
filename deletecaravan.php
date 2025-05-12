<?php
session_start();

    include("connectregister.php");
    include("check_login.php");

    $user_data = check_login($con);

// Handle delete request
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $con->query("DELETE FROM caravan_db WHERE id = $id");
    header("Location: deletecaravan.php"); // refresh page
    exit();
}

// Fetch all caravans
$result = $con->query("SELECT * FROM caravan_db");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Caravan</title>
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
      max-width: 900px;
      margin: 50px auto;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px #aaa;
    }
    h1 {
      text-align: center;
      color: #e2785b;
    }
    .caravan-card {
      background: #fff6f1;
      border: 1px solid #f0c0a0;
      padding: 20px;
      margin: 20px 0;
      border-radius: 10px;
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .caravan-card img {
      width: 150px;
      height: 100px;
      object-fit: cover;
      border-radius: 10px;
    }
    .caravan-info {
      flex: 1;
    }
    .delete-btn {
      padding: 10px 15px;
      background: #ff7f7f;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      font-weight: bold;
    }
    .delete-btn:hover {
      background: #e25a5a;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>🗑 Delete Caravan Listings</h1>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="caravan-card">
        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Caravan">
        <div class="caravan-info">
          <h3><?= htmlspecialchars($row['name']) ?></h3>
          <p>📍 <?= htmlspecialchars($row['location']) ?></p>
        </div>
        <a href="?delete_id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this caravan?')">Delete</a>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center;">🚫 No caravans found.</p>
  <?php endif; ?>

</div>

</body>
</html>

<?php $conn->close(); ?>