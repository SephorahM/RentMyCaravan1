<?php
session_start();
include("connectregister.php");
include("check_login.php");

$user_data = check_login($con);
$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    echo "<script>alert('No caravan selected for deletion.'); window.location.href='caravanlist.php';</script>";
    exit;
}

$caravan_id = intval($_GET['id']);

$stmt = $con->prepare("SELECT * FROM caravan_db WHERE id = ? AND user_id = ?");
$stmt->bind_param("is", $caravan_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Caravan not found or access denied.'); window.location.href='caravanlist.php';</script>";
    exit;
}

$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $delete_stmt = $con->prepare("DELETE FROM caravan_db WHERE id = ? AND user_id = ?");
    $delete_stmt->bind_param("is", $caravan_id, $user_id);
    $delete_stmt->execute();

    if ($delete_stmt->affected_rows > 0) {
        echo "<script>alert('Caravan successfully deleted.'); window.location.href='caravanlist.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to delete caravan.');</script>";
    }
}
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
      color: black;
    }
    .container {
      background-color: teal;
      max-width: 1000px;
      margin: 50px auto;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
      opacity: 1;
    }
    h1 {
      text-align: center;
      color: crimson;
    }
    .caravan-card {
      background-color: aliceblue;
      border: 1px solid lightsteelblue;
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
      color: darkslateblue;
    }
    .caravan-info p {
      margin: 5px 0;
      color: dimgray;
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
      background-color: firebrick;
      color: white;
    }
    .buttons a {
      background-color: slategray;
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

  <form method="post" class="buttons">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <button type="submit">Yes, Delete</button>
    <a href="caravanlist.php">Cancel</a>
  </form>
</div>

</body>
</html>