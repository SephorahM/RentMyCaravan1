<?php
$caravans = [];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rentmycaravan";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT caravan_make, caravan_model, caravan_year, caravan_details, caravan_image, mobile_number FROM caravan_db";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
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
  <title>Caravan Summary</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('https://www.retreatcaravans.com.au/wp-content/uploads/2017/03/Happy-Retreat-Caravaners.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    .navbar {
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #ffe6f0;
      padding: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      font-size: 1.1em;
      flex-wrap: wrap;
    }

    .navbar a, .dropbtn {
      text-decoration: none;
      color: #d65b91;
      padding: 12px 18px;
      margin: 0 5px;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .navbar a:hover, .dropbtn:hover {
      background-color: #fddcef;
      color: #b03e73;
      border-radius: 8px;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #fff8fc;
      min-width: 180px;
      box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
      z-index: 1;
      border-radius: 8px;
    }

    .dropdown-content a {
      color: #d65b91;
      padding: 10px 16px;
      display: block;
      text-align: left;
    }

    .dropdown-content a:hover {
      background-color: #fddcef;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .overlay {
      background-color: rgba(255, 255, 255, 0.85);
      min-height: 100vh;
      padding: 40px 20px;
      text-align: center;
    }

    h1 {
      font-size: 2.5em;
      color: #d65b91;
      margin-bottom: 30px;
      text-shadow: 1px 1px 3px #fff;
    }

    .no-caravans {
      font-size: 1.6em;
      color: #333;
      background: #ffeef1;
      display: inline-block;
      padding: 20px 30px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .card {
      background: #fff8fc;
      border: 2px solid #fddcef;
      border-radius: 12px;
      padding: 20px;
      margin: 20px auto;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 6px 14px rgba(0,0,0,0.2);
      cursor: pointer;
      transition: transform 0.2s;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .card img {
      max-width: 100%;
      border-radius: 12px;
      height: 200px;
      object-fit: cover;
    }

    .card h2 {
      margin-top: 10px;
      color: #d65b91;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      padding-top: 100px;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.6);
    }

    .modal-content {
      background-color: #fff;
      margin: auto;
      padding: 20px;
      width: 90%;
      max-width: 500px;
      border-radius: 12px;
      position: relative;
    }

    .close {
      color: #aaa;
      position: absolute;
      top: 10px;
      right: 20px;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .modal-content img {
      max-width: 100%;
      border-radius: 10px;
      height: 200px;
      object-fit: cover;
    }

    .modal-content p {
      margin: 10px 0;
      text-align: left;
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

<div class="overlay" id="caravanContainer">
  <h1>Caravan Summary</h1>

  <?php if (count($caravans) === 0): ?>
    <div class="no-caravans">
      🚐 No caravans added yet.<br>Please <a href="addcaravan.php">add a caravan</a> first!
    </div>
  <?php else: ?>
    <?php foreach ($caravans as $index => $caravan): ?>
      <div class="card" onclick="openModal(<?= $index ?>)">
        <img src="<?= htmlspecialchars($caravan['caravan_image']) ?>" alt="Caravan">
        <h2>🏕 <?= htmlspecialchars($caravan['caravan_make'] . ' ' . $caravan['caravan_model']) ?></h2>
      </div>

      <div class="modal" id="modal<?= $index ?>">
        <div class="modal-content">
          <span class="close" onclick="closeModal(<?= $index ?>)">&times;</span>
          <img src="<?= htmlspecialchars($caravan['caravan_image']) ?>" alt="Caravan Full View">
          <h2><?= htmlspecialchars($caravan['caravan_make'] . ' ' . $caravan['caravan_model']) ?> 🚐</h2>
          <p><strong>🗓 Year:</strong> <?= htmlspecialchars($caravan['caravan_year']) ?></p>
          <p><strong>📄 Details:</strong> <?= htmlspecialchars($caravan['caravan_details']) ?></p>
          <p><strong>📞 Contact:</strong> <?= htmlspecialchars($caravan['mobile_number']) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<script>
  function openModal(index) {
    document.getElementById('modal' + index).style.display = 'block';
  }

  function closeModal(index) {
    document.getElementById('modal' + index).style.display = 'none';
  }

  window.onclick = function(event) {
    document.querySelectorAll('.modal').forEach((modal) => {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    });
  }
</script>

</body>
</html>