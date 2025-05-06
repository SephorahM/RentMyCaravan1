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
    <title>Caravan Summary</title>
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

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-image: url('https://s-media-cache-ak0.pinimg.com/736x/51/a2/0b/51a20b40312986fa94cf8764607cd3aa.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      color: white;
    }

    .section-title {
      font-size: 2rem;
      text-align: center;
      margin-top: 20px;
      text-shadow: 2px 2px 4px #000;
    }

    .caravan-section {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 30px;
    }

    .caravan-card {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      margin: 15px;
      width: 280px;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
      transition: transform 0.3s ease;
    }

    .caravan-card:hover {
      transform: scale(1.03);
    }

    .caravan-card img {
      width: 100%;
      height: 180px;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .caravan-card .caption {
      padding: 15px;
      color: #333;
      font-weight: bold;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.7);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: linear-gradient(to right, #ffe6f0, #e0f7fa);
      padding: 25px;
      border-radius: 10px;
      width: 70%;
      max-width: 600px;
      color: #000;
      text-align: left;
      box-shadow: 0 0 10px #000;
      max-height: 90%;
      overflow-y: auto;
      position: relative;
    }

    .modal-content img {
      width: 100%;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 22px;
      font-weight: bold;
      color: #333;
      cursor: pointer;
    }

    .close-btn:hover {
      color: red;
    }

    .modal-buttons {
      margin-top: 15px;
      text-align: center;
    }

    .book-btn, .cancel-btn, .submit-btn {
      background-color: #007BFF;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      margin: 10px;
      font-size: 16px;
      border: none;
    }

    .cancel-btn {
      background-color: #dc3545;
    }

    .book-btn:hover {
      background-color: #0056b3;
    }

    .cancel-btn:hover {
      background-color: #c82333;
    }

    .booking-form {
      display: none;
      background-color: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
      margin-top: 15px;
      color: #000;
    }

    .booking-form input {
      width: 100%;
      padding: 8px;
      margin: 6px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .booking-form label {
      font-weight: bold;
      margin-top: 8px;
      display: block;
    }

    #success-message {
      display: none;
      color: green;
      font-weight: bold;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <h2 class="section-title">Caravan Listings</h2>
  <div class="caravan-section" id="caravan-list"></div>

  <div id="caravanModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h3 id="modal-title"></h3>
      <img id="modal-img" src="" alt="">
      <p id="modal-desc"></p>

      <div class="modal-buttons">
        <button class="book-btn" onclick="confirmBooking()">Book Now</button>
        <button class="cancel-btn" onclick="closeModal()">Cancel</button>
      </div>

      <div id="booking-form" class="booking-form">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" placeholder="Enter your full name">

        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="Enter your email">

        <label for="bank">Bank Account Number:</label>
        <input type="text" id="bank" placeholder="Enter your bank account number">

        <label for="sort">Sort Code:</label>
        <input type="text" id="sort" placeholder="Enter sort code">

        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date">

        <label for="end-date">End Date:</label>
        <input type="date" id="end-date">

        <button class="submit-btn" onclick="submitForm()">Submit</button>
        <div id="success-message">✅ Payment Successful! Thank you for booking.</div>
      </div>
    </div>
  </div>

  <script>
    const caravans = [
      {
        title: "Devon Classic Caravan",
        img: "https://th.bing.com/th/id/OIP.v17sBrkEcxr9ekS822bHJwHaFb?rs=1&pid=ImgDetMain",
        desc: "🌍 Location: Devon\n💷 Price: £45/night\n🛏 Sleeps: 4 members\n✨ Pet-friendly and eco-built. This countryside retreat is perfect for those who love rustic charm and sustainability."
      },
      {
        title: "Beachside Mobile Home",
        img: "https://th.bing.com/th/id/OIP.RsWPiGfztuRGLKXqbM1vngHaE8?w=1024&h=683&rs=1&pid=ImgDetMain",
        desc: "🌍 Location: Brighton\n💷 Price: £55/night\n🛏 Sleeps: 3 members\n✨ Walk to the beach from this cozy seaside mobile home. Equipped with modern conveniences and stylish interiors."
      },
      {
        title: "Seaside Caravan",
        img: "https://th.bing.com/th/id/OIP.fn5EBDLBwpzHBPe30BoRtQHaE8?rs=1&pid=ImgDetMain",
        desc: "🌍 Location: Cornwall\n💷 Price: £60/night\n🛏 Sleeps: 5 members\n✨ Enjoy stunning sea views from this well-furnished seaside caravan."
      },
      {
        title: "Mountain View Caravan",
        img: "https://th.bing.com/th/id/OIP.t-hYWvT6PZnAuVqwj-irKgHaE6?w=1700&h=1129&rs=1&pid=ImgDetMain",
        desc: "🌍 Location: Snowdonia\n💷 Price: £70/night\n🛏 Sleeps: 4 members\n✨ Surrounded by peaks and nature, this mountain caravan offers peace and hiking access."
      },
      {
        title: "Luxury Swift Elegance",
        img: "https://www.practicalcaravan.com/wp-content/uploads/2018/08/7901075-scaled.jpg",
        desc: "🌍 Location: Yorkshire\n💷 Price: £110/night\n🛏 Sleeps: 6 members\n✨ This premium caravan is fitted with entertainment systems, a modern kitchen, and a lounge."
      },
      {
        title: "Deluxe Touring Caravan",
        img: "https://th.bing.com/th/id/OIP.RZa_7rohsbwm4L-sFraOGAHaE8?rs=1&pid=ImgDetMain",
        desc: "🌍 Location: Norfolk\n💷 Price: £95/night\n🛏 Sleeps: 5 members\n✨ Designed for long trips, this caravan includes family-friendly features and storage."
      },
      {
        title: "Luxury Holiday Caravan",
        img: "https://th.bing.com/th/id/OIP.frI6OkHuR4IowpFpBUIQggHaEL?w=747&h=421&rs=1&pid=ImgDetMain",
        desc: "🌍 Location: Isle of Wight\n💷 Price: £120/night\n🛏 Sleeps: 6 members\n✨ A luxurious home on wheels near beaches and parks with a full kitchen and plush beds."
      },
      {
        title: "Executive Caravan",
        img: "https://th.bing.com/th/id/OIP.bWyQDk8pmm-Lo_7beRCsSAHaES?w=726&h=420&rs=1&pid=ImgDetMain",
        desc: "🌍 Location: Scotland\n💷 Price: £150/night\n🛏 Sleeps: 7 members\n✨ This top-tier caravan offers amenities, scenic views, and unbeatable comfort in nature."
      }
    ];

    const container = document.getElementById('caravan-list');
    const modal = document.getElementById('caravanModal');
    const title = document.getElementById('modal-title');
    const img = document.getElementById('modal-img');
    const desc = document.getElementById('modal-desc');
    const bookingForm = document.getElementById('booking-form');
    const successMessage = document.getElementById('success-message');

    function renderCards() {
      caravans.forEach(caravan => {
        const card = document.createElement('div');
        card.className = 'caravan-card';
        card.innerHTML = `
          <img src="${caravan.img}" alt="${caravan.title}">
          <div class="caption">${caravan.title}</div>
        `;
        card.onclick = () => showModal(caravan);
        container.appendChild(card);
      });
    }

    function showModal(caravan) {
      title.innerText = caravan.title;
      img.src = caravan.img;
      desc.innerText = caravan.desc;
      bookingForm.style.display = 'none';
      successMessage.style.display = 'none';
      modal.style.display = 'flex';
    }

    function closeModal() {
      modal.style.display = 'none';
    }

    function confirmBooking() {
      if (confirm("Do you want to book this caravan?")) {
        bookingForm.style.display = 'block';
      }
    }

    function submitForm() {
      const fullname = document.getElementById('fullname').value.trim();
      const email = document.getElementById('email').value.trim();
      const bank = document.getElementById('bank').value.trim();
      const sort = document.getElementById('sort').value.trim();
      const startDate = document.getElementById('start-date').value;
      const endDate = document.getElementById('end-date').value;

      if (!fullname || !email || !bank || !sort || !startDate || !endDate) {
        alert("Please fill in all fields before submitting.");
        return;
      }

      successMessage.style.display = 'block';
    }

    renderCards();
  </script>
  <script src="script.js"></script>
</body>
</html>