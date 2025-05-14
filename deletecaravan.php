<?php
session_start();

include("connectregister.php");
include("check_login.php");

$user_data = check_login($con);

// Delete if confirmed
if (isset($_GET['delete_id']) && isset($_GET['confirm'])) {
    $id = intval($_GET['delete_id']);
    $con->query("DELETE FROM caravan_db WHERE id = $id");
    header("Location: caravanlist.php"); // Redirect after deletion
    exit();
}

// If delete_id is set, fetch that caravan only
$caravan = null;
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $result = $con->query("SELECT * FROM caravan_db WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $caravan = $result->fetch_assoc();
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
      background: url('https://www.retreatcaravans.com.au/wp-content/uploads/2017/03/Happy-Retreat-Caravaners.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #ffffff;
    }

    .navbar {
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 15px;
      font-weight: bold;
      font-size: 16px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .navbar a {
      color: white;
      text-decoration: none;
      padding: 10px 18px;
      margin: 0 8px;
      border-radius: 5px;
      transition: background 0.3s ease;
    }

    .navbar a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropbtn {
      cursor: pointer;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: rgba(0, 0, 0, 0.8);
      min-width: 160px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      z-index: 1;
      border-radius: 5px;
    }

    .dropdown-content a {
      color: white;
      padding: 10px 16px;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: rgba(255,255,255,0.1);
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .container {
      background: rgba(255, 255, 255, 0.9);
      max-width: 900px;
      margin: 60px auto;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      color: #333;
    }

    h1 {
      text-align: center;
      color: #e2785b;
      margin-bottom: 30px;
      font-size: 28px;
      letter-spacing: 1px;
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

    .caravan-info h3 {
      margin: 0;
    }

    .caravan-info p {
      margin: 5px 0 0;
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

    .message {
      text-align: center;
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <a href="userhomepage.php">Home</a>
    <div class="dropdown">
      <a class="dropbtn">List Your Caravan</a>
      <div class="dropdown-content">
        <a href="addcaravan.php">Add Caravan</a>
        <a href="caravanlist.php">Your Caravan List</a>
      </div>
    </div>
    <a href="caravansummary.php">Caravan Summary</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="container">
    <h1>🗑 Delete Caravan Listing</h1>

    <?php if ($caravan): ?>
      <div class="caravan-card">
        <img src="<?= htmlspecialchars($caravan['image_url']) ?>" alt="Caravan">
        <div class="caravan-info">
          <h3><?= htmlspecialchars($caravan['name']) ?></h3>
          <p>📍 <?= htmlspecialchars($caravan['location']) ?></p>
        </div>
        <a href="?delete_id=<?= $caravan['id'] ?>&confirm=1" class="delete-btn" onclick="return confirm('Are you sure you want to delete this caravan?')">Delete</a>
      </div>
    <?php else: ?>
      <p class="message">🚫 No caravan selected.</p>
    <?php endif; ?>
  </div>

</body>
</html>

<?php $con->close(); ?>