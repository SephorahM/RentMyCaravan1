function showSection(sectionId) {
    document.querySelectorAll('.container').forEach(section => {
        section.style.display = 'none'; // Hide all sections
    });
    document.getElementById(sectionId).style.display = 'block'; // Show the selected section
}

const users = JSON.parse(localStorage.getItem("users")) || [];
const caravans = JSON.parse(localStorage.getItem("caravans")) || [];
let editIndex = null; // Track the index of the caravan being edited

function validateLogin() {
    const username = document.getElementById("login-username").value.trim();
    const password = document.getElementById("login-password").value.trim();
    const confirmPassword = document.getElementById("login-confirm-password").value.trim();
    const errorMessage = document.getElementById("login-error");

    if (!username || !password || !confirmPassword) {
        errorMessage.innerHTML = "All fields are required!";
        return false;
    }

    if (password !== confirmPassword) {
        errorMessage.innerHTML = "Passwords do not match!";
        return false;
    }

    const user = users.find(user => user.username === username && user.password === password);
    if (!user) {
        errorMessage.innerHTML = "Invalid username or password!";
        return false;
    }

    errorMessage.innerHTML = "";
    alert(`Welcome back, ${user.firstname} ${user.lastname}!`);
    populateUserCaravans(username);
    showSection('manage-caravans'); // Show the manage caravans section after login
    return true;
}

function validateAndSaveRegisterForm() {
    const firstname = document.getElementById("register-firstname").value.trim();
    const lastname = document.getElementById("register-lastname").value.trim();
    const username = document.getElementById("register-username").value.trim();
    const password = document.getElementById("register-password").value.trim();
    const errorMessage = document.getElementById("register-error");

    if (!firstname || !lastname || !username || !password) {
        errorMessage.innerHTML = "All fields are required!";
        return false;
    }

    if (!/^[a-zA-Z]+$/.test(firstname) || !/^[a-zA-Z]+$/.test(lastname)) {
        errorMessage.innerHTML = "First and Last Name can only contain letters!";
        return false;
    }

    if (!/^[a-zA-Z0-9]+$/.test(username)) {
        errorMessage.innerHTML = "Username can only contain letters and numbers!";
        return false;
    }

    if (password.length < 8) {
        errorMessage.innerHTML = "Password must be at least 8 characters long!";
        return false;
    }

    if (users.some(user => user.username === username)) {
        errorMessage.innerHTML = "Username already exists!";
        return false;
    }

    users.push({ firstname, lastname, username, password });
    localStorage.setItem("users", JSON.stringify(users));

    errorMessage.innerHTML = "";
    alert("Registration successful! Redirecting to login page...");
    showSection('login');
    return true;
}

function showCaravans() {
    document.querySelectorAll('.container').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById('caravan-selection').classList.add('active');
}

function selectCaravan(caravanType) {
    alert(`You have selected the ${caravanType}.`);
}

function searchCaravans() {
    const query = document.getElementById("search-caravan").value.trim().toLowerCase();
    const caravanItems = document.querySelectorAll(".caravan-item");

    caravanItems.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(query)) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
}

function showCaravanDetails(caravanType) {
    

    // Filter caravans by type
    const filteredOptions = caravanOptions.filter(option => option.type.toLowerCase() === caravanType.toLowerCase());
    const optionsContainer = document.getElementById("caravan-options");
    optionsContainer.innerHTML = "";

    filteredOptions.forEach(option => {
        const optionDiv = document.createElement("div");
        optionDiv.classList.add("caravan-item");
        optionDiv.innerHTML = `
            <img src="${option.image || ''}" alt="${option.name}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">
            <p>${option.name}</p>
            ${option.available
                ? <button class="btn" onclick="alert('${option.name} booked successfully!')">Book Now</button>
                : <p style="color: red;">Unavailable</p>}
        `;
        optionsContainer.appendChild(optionDiv);
    });

    // Hide all other sections and show only the caravan details section
    document.querySelectorAll('.container').forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById("caravan-details").style.display = "block";
}

function goBackToBooking() {
    document.querySelectorAll('.container').forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById("booking").style.display = "block";
}

function populateUserCaravans(username) {
    const userCaravans = caravans.filter(caravan => caravan.owner === username);
    const userCaravansContainer = document.getElementById("user-caravans");
    userCaravansContainer.innerHTML = "";

    if (userCaravans.length === 0) {
        userCaravansContainer.innerHTML = "<p>No caravans added yet.</p>";
        return;
    }

    userCaravans.forEach((caravan, index) => {
        const caravanDiv = document.createElement("div");
        caravanDiv.classList.add("caravan-item");
        caravanDiv.innerHTML = `
            <img src="${caravan.image}" alt="${caravan.name}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">
            <p><strong>${caravan.name}</strong></p>
            <p>${caravan.description}</p>
            <div class="button-group">
                <button class="btn" onclick="editCaravan(${index})">Edit</button>
                <button class="btn" style="background: red;" onclick="deleteCaravan(${index})">Delete</button>
            </div>
        `;
        userCaravansContainer.appendChild(caravanDiv);
    });
}

function addCaravan() {
    const name = document.getElementById("caravan-name").value.trim();
    const type = document.getElementById("caravan-type").value.trim();
    const image = document.getElementById("caravan-image").value.trim();
    const description = document.getElementById("caravan-description").value.trim();
    const errorMessage = document.getElementById("add-caravan-error");

    if (!name || !type || !image || !description) {
        errorMessage.innerHTML = "All fields are required!";
        return false;
    }

    const username = document.getElementById("login-username").value.trim();
    const newCaravan = { name, type, image, description, owner: username };

    if (editIndex !== null) {
        caravans[editIndex] = newCaravan; // Update the existing caravan
        editIndex = null; // Reset the edit index
    } else {
        caravans.push(newCaravan); // Add a new caravan
    }

    localStorage.setItem("caravans", JSON.stringify(caravans));

    errorMessage.innerHTML = "";
    alert("Caravan saved successfully!");
    document.getElementById("add-caravan-form").reset();
    populateUserCaravans(username);
    showSection('manage-caravans');
    return false; // Prevent form submission
}

function editCaravan(index) {
    const caravan = caravans[index];
    document.getElementById("caravan-name").value = caravan.name;
    document.getElementById("caravan-type").value = caravan.type;
    document.getElementById("caravan-image").value = caravan.image;
    document.getElementById("caravan-description").value = caravan.description;

    editIndex = index; // Store the index of the caravan being edited
    showSection('add-caravan');
}

function deleteCaravan(index) {
    if (confirm("Are you sure you want to delete this caravan?")) {
        caravans.splice(index, 1);
        localStorage.setItem("caravans", JSON.stringify(caravans));
        const username = document.getElementById("login-username").value.trim();
        populateUserCaravans(username);
    }
}

let currentSlide = 0;

function nextSlide() {
    const carouselInner = document.querySelector('.carousel-inner');
    const slides = carouselInner.children.length;
    currentSlide = (currentSlide + 1) % slides;
    carouselInner.style.transform = `translateX(-${currentSlide * 100}%)`;
}

function prevSlide() {
    const carouselInner = document.querySelector('.carousel-inner');
    const slides = carouselInner.children.length;
    currentSlide = (currentSlide - 1 + slides) % slides;
    carouselInner.style.transform = `translateX(-${currentSlide * 100}%)`;
}

function userIsLoggedIn() {
    document.body.classList.add("logged-in");
    document.body.classList.remove("logged-out");
}
