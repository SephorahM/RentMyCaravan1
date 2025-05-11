<?php
session_start();

    include("connectregister.php");
    include("check_login.php");

    $user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Delete Caravan</title>
</head>
<body>
    <div class="navbar">
        <a href="userhomepage.php">Home</a>
        <div class="dropdown">
            <a class="dropbtn">List Your Caravan</a>
            <div class="dropdown-content">
            <a href="addcaravan.php">Add Caravan</a>
            <a href="deletecaravan.php">Delete Caravan</a>
            </div>
        </div>
        <a href="caravansummary.php">Caravan Summary</a>
        <a href="logout.php">Logout</a>
    </div>
    
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
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const currentUser = localStorage.getItem("loggedInUser");
      const caravanList = JSON.parse(localStorage.getItem("caravanList")) || [];
      const container = document.getElementById("caravanContainer");

      const userCaravans = caravanList.filter(caravan => caravan.user === currentUser);

      if (userCaravans.length === 0) {
        container.innerHTML = "<p style='text-align:center; color:white; text-shadow: 1px 1px 2px black;'>No caravans found for your account.</p>";
      } else {
        userCaravans.forEach((caravan, index) => {
          const card = document.createElement("div");
          card.className = "caravan-card";
          card.innerHTML = `
            <img src="${caravan.image}" alt="Caravan Image">
            <div class="caravan-info">
              <h3>${caravan.name}</h3>
              <p>Location: ${caravan.location}</p>
              <p>Price: ${caravan.price}</p>
            </div>
            <button class="delete-btn">Delete</button>
          `;
          card.querySelector(".delete-btn").addEventListener("click", () => {
            const confirmDelete = confirm("Are you sure you want to delete this caravan?");
            if (confirmDelete) {
              const updatedList = caravanList.filter((_, i) => !(caravanList[i].user === currentUser && i === index));
              localStorage.setItem("caravanList", JSON.stringify(updatedList));
              window.location.reload();
            }
          });
          container.appendChild(card);
        });
      }
    });
  </script>
</head>
<body>
  <h1>Delete Caravan</h1>
  <div id="caravanContainer"></div>
</body>
</html>