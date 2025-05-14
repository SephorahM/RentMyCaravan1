<?php
session_start();

include("connectregister.php");
include("check_login.php");

$user_data = check_login($con);
$user_id = $_SESSION['user_id'];

// Get caravan ID from URL
if (!isset($_GET['id'])) {
    echo "<div style='text-align:center; color: red; margin-top: 20px;'>No caravan selected for deletion.</div>";
    exit;
}

$caravan_id = intval($_GET['id']);

// Fetch the specific caravan
$stmt = $con->prepare("SELECT * FROM caravan_db WHERE id = ? AND user_id = ?");
$stmt->bind_param("is", $caravan_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div style='text-align:center; color: red; margin-top: 20px;'>Caravan not found or access denied.</div>";
    exit;
}

$row = $result->fetch_assoc();
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
      background: url('https://www.scottishtourer.co.uk/desktop/web/ckfinder/userfiles/files/IMG_2576(1).JPG') no-repeat center center fixed;
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
      color: #c0392b;
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
      margin: 5px 0;
      color: #666;
    }
    .buttons {
      display: flex;
      justify-content: center;
      margin-top: 20px;
      gap: 20px;
    }
    .buttons button, .buttons a {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      cursor: pointer;
    }
    .buttons button {
      background-color: #e74c3c;
      color: white;
    }
    .buttons a {
      background-color: #7f8c8d;
      color: white;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Are You Sure You Want to Delete This Caravan?</h1>

  <div class="caravan-card">
    <img src="<?= htmlspecialchars($row['caravan_image']) ?>" alt="Caravan Image">
    <div class="caravan-info">
      <h3><?= htmlspecialchars($row['caravan_make'] . ' ' . $row['caravan_model']) ?> (<?= htmlspecialchars($row['caravan_year']) ?>)</h3>
      <p><?= nl2br(htmlspecialchars($row['caravan_details'])) ?></p>
      <p>📞 <?= htmlspecialchars($row['mobile_number']) ?></p>
    </div>
  </div>

  <form action="deletecaravan_confirm.php" method="post" class="buttons">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <button type="submit">Yes, Delete</button>
    <a href="caravanlist.php">Cancel</a>
  </form>
</div>

</body>
</html>