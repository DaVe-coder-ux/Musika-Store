<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musika Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Segoe+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="labWeb.css">
    <style>
        .username-greeting {
            font-family: 'Segoe Script', cursive;
            color: #fff;
            margin-left: 15px;
        }
    </style>
</head>
<body>
    <header class="bg">
        <nav class="menu"></nav>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <ul class="menu">
            <li><a class="nav_link" href="labWeb.php">Home</a></li>
            <li><a class="nav_link" href="labWeb3D.html">Products</a></li>
            <li><a class="nav_link" href="shopNow.php">Shop Now!</a></li>
            <li><a class="nav_link" href="labWebAbout.html">About</a></li>

            <?php if (isset($_SESSION['username'])): ?>
                <li class="username-greeting">
                    <?php
                        if (isset($_SESSION['registered'])) {
                            echo "Hello! " . htmlspecialchars($_SESSION['username']);
                        } else {
                            echo "Welcome! " . htmlspecialchars($_SESSION['username']);
                        }
                    ?>
                </li>
                <li><a class="nav_link" href="/musika_store/logout.php">Logout</a></li>
            <?php else: ?>
                <li><label for="modal-togle" class="nav_link">Log-In</label></li>
            <?php endif; ?>
        </ul>
    </header>

    <input type="checkbox" id="modal-togle" class="modal-togle">
    <div class="container">
        <div class="curved-shape"></div>
        <div class="curved-shape2"></div>
        <div class="form-box login">
            <label class="close-btn login-close animation" style="--D:0; --S:21;" onclick="document.getElementById('modal-togle').checked = false">&times;</label>
            <h2 class="animation" style="--D:1; --S:22;">Login</h2>
            <form action="/musika_store/login.php" method="post">
                <div class="input-box animation" style="--D:2; --S:23;">
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box animation" style="--D:3; --S:24;">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="input-box animation" style="--D:4; --S:25">
                    <button class="btn" type="submit">Login</button>
                </div>
                <div class="reg-link animation" style="--D:5; --S:26;">
                    <p>Don't have an account? <a href="#" class="signUpLink">Sign Up</a></p>
                </div>
            </form>
        </div>
        <div class="info-content login">
            <h2 class="animation" style="--D:0; --S:20;">WELCOME BACK!</h2>
            <p class="animation" style="--D:1; --S:21;">We're excited to have you with us again!</p>
        </div>
        <div class="form-box reg">
            <label class="close-btn reg-close animation" style="--li:17; --S:0;" onclick="document.getElementById('modal-togle').checked = false">&times;</label>
            <h2 class="animation" style="--li:18; --S:1;">Register</h2>
            <form action="/musika_store/register.php" method="post">
                <div class="input-box animation" style="--li:19; --S:2;">
                    <input type="email" name="email" required autocomplete="off" placeholder=" ">
                    <label>Email Address</label>
                </div>
                <div class="input-box animation" style="--li:20; --S:3;">
                    <input type="text" name="name" required>
                    <label>First Name</label>
                </div>
                <div class="input-box animation" style="--li:21; --S:4;">
                    <input type="text" name="lastname" required>
                    <label>Last Name</label>
                </div>
                <div class="input-box animation" style="--li:22; --S:5;">
                    <input type="date" name="birthdate" required>
                    <label>Birthdate</label>
                </div>
                <div class="input-box animation" style="--li:23; --S:6;">
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box animation" style="--li:24; --S:7;">
                    <input type="password" name="password" required>
                    <label>Password</label>
                    <i class="fa fa-eye toggle-password"></i>
                </div>
                <div class="input-box animation" style="--li:25; --S:8;">
                    <button class="btn" type="submit">Register</button>
                </div>
                <div class="reg-link animation" style="--li:26; --S:9;">
                    <p>Already have an account?<br><a href="#" class="signInLink">Sign In</a></p>
                </div>
            </form>
        </div>
        <div class="info-content reg">
            <h2 class="animation" style="--li:17; --S:0;">hello!</h2>
            <p class="animation" style="--li:18; --S:1;">Great to see you here. Let's get started!</p>
        </div>
    </div>

    <header>
        <div class="nav">
            <a href="pic.html"><img src="IMG_20241012_131430.jpg" class="logo"></a>
            <nav></nav>
        </div>
    </header> 

    <section class="special-offers">
        <h1 class="string">Welcome to Musika Store!</h1>
        <p class="string">These high-value offers are only available in Musika Store. Enjoy!</p>
        <div id="outerbox">
            <div id="sliderbox">
                <img src="Photoroom-20241021_202052.png">
                <img src="Photoroom-20241021_203340.png">
                <img src="Photoroom-20241021_204749.png">
                <img src="Photoroom-20241021_202033.png">                
                <img src="Photoroom-20241021_204556.png">
                <img src="Photoroom-20241021_204711.png">
                <img src="Photoroom-20241021_204132.png">
                <img src="Photoroom-20241021_204204.png">
                <img src="Photoroom-20241021_203945.png">                
                <img src="Photoroom-20241021_204052.png">
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Musika. All rights reserved.</p>
    </footer>

    <script src="log.js"></script>
</body>
</html>
