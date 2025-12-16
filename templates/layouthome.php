<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bistro Elegance - Fine Dining Experience</title>
    <link rel="stylesheet" href="css/tooplate-bistro-elegance.css">
</head>

<body>
    <!-- navbar -->
    <nav>
        <div class="nav-container">
            <a href="#home" class="logo">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="18" stroke="#e74c3c" stroke-width="2" fill="none" />
                </svg>
                <span>Bistro</span>
            </a>
            <ul class="nav-links">
                <li><a href="#home" class="active">Home</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#booking">Booking</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="/login">login</a></li>

            </ul>
            <div class="menu-toggle">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>
    <!-- end navbar -->
    <!-- home -->
    <section id="home" class="hero">
        <div class="diagonal-grid"></div>
        <div class="static-decoration"></div>
        <div class="bottom-right-decoration"></div>
        <div class="hero-content">
            <h1>Welcome to Bistro Elegance</h1>
            <p>
                <span class="text-option">Experience culinary excellence in an atmosphere of refined sophistication</span>
                <span class="text-option">Discover exquisite flavors crafted with passion and precision</span>
                <span class="text-option">Where fine dining meets unforgettable moments</span>
            </p>
            <a href="#reservation" class="cta-btn">Reserve Your Table</a>
        </div>
    </section>
    <!-- end home -->



    <!-- phần footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>123 Culinary Street...</p>
            </div>
            <div class="footer-section">
                <h3>Opening Hours</h3>
                <p>Monday - Thursday: 5:00 PM...</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <p><a href="#">Facebook</a>...</p>
            </div>
        </div>
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #555; text-align: center;">
            <p>&copy; 2026 Bistro Elegance. All rights reserved.</p>
        </div>
    </footer>
    <div id="ingredientsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle">Dish Ingredients</h3>
            <ul id="ingredientsList" class="ingredient-list"></ul>
        </div>
    </div>

    <script src="js/tooplate-bistro-scripts.js"></script>
</body>

</html>