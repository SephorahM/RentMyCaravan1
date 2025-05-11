<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  die("Unauthorized access. Please log in.");
}

$userid = $_SESSION['user_id'];

// DB connection
$servername = "localhost";
$username = "root"; // adjust if needed
$password = "";
$dbname = "rentmycaravan";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
  $delete_id = intval($_POST['delete_id']);
  $conn->query("DELETE FROM caravan_db WHERE id = $delete_id AND user_id = $userid");
  header("Location: delete_caravan.php");
  exit();
}

// Fetch caravans for logged-in user
$sql = "SELECT * FROM caravan_db WHERE user_id = $userid";
$result = $conn->query($sql);
$caravans = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $caravans[] = $row;
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Caravan</title>
  <style>
    @font-face {
      font-family: 'Algerian';
      src: local('Algerian'), url('https://fonts.cdnfonts.com/s/17357/ALGER.TTF') format('truetype');
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://i.pinimg.com/originals/41/d2/c4/41d2c45ce5dcf923b17e3b9ae6a96cdb.jpg') no-repeat center center fixed;
      background-size: cover;
      color: white;
      overflow-y: scroll;
    }

    h1 {
      text-align: center;
      margin: 40px 20px;
      font-size: 48px;
      font-family: 'Algerian', serif;
      color: #fff;
      text-shadow: 2px 2px 5px rgba(0,0,0,0.8);
    }

    .caravan-card {
      margin: 30px 20px;
      padding: 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.3);
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .caravan-card img {
      width: 160px;
      height: 110px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.6);
    }

    .caravan-info h3, .caravan-info p {
      margin: 4px 0;
      color: white;
      text-shadow: 1px 1px 3px black;
    }

    .delete-btn {
      padding: 10px 18px;
      background-color: #c0392b;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      margin-left: auto;
    }

    .delete-btn:hover {
      background-color: #e74c3c;
    }

    @media screen and (max-width: 700px) {
      .caravan-card {
        flex-direction: column;
        align-items: flex-start;
      }
      .delete-btn {
        margin: 15px 0 0;
      }
    }
  </style>
</head>
<body>
  <h1>Delete Caravan</h1>
  <div id="caravanContainer">
    <?php if (empty($caravans)): ?>
      <p style='text-align:center; color:white; text-shadow: 1px 1px 2px black;'>No caravans found for your account.</p>
    <?php else: ?>
      <?php foreach ($caravans as $caravan): ?>
        <div class="caravan-card">
          <img src="<?= htmlspecialchars($caravan['caravan_image']) ?>" alt="Caravan Image">
          <div class="caravan-info">
            <h3><?= htmlspecialchars($caravan['caravan_make']) ?> <?= htmlspecialchars($caravan['caravan_model']) ?></h3>
            <p>Year: <?= htmlspecialchars($caravan['caravan_year']) ?></p>
            <p>Contact: <?= htmlspecialchars($caravan['mobile_number']) ?></p>
          </div>
          <form method="POST" style="margin-left:auto;" onsubmit="return confirm('Are you sure you want to delete this caravan?');">
            <input type="hidden" name="delete_id" value="<?= $caravan['id'] ?>">
            <button type="submit" class="delete-btn">Delete</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>