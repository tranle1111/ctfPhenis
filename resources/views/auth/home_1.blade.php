<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - CTF Panel</title>
    <style>
        /* ===== RESET CSS ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Ngăn trang bị tràn ngang */
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
            background-color: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background-color: #161b22;
            box-shadow: 0 2px 10px rgba(0, 255, 170, 0.5);
            width: 100%;
            flex-wrap: wrap;
        }

        .navbar-brand img {
            max-height: 40px;
            filter: drop-shadow(0 0 5px #0ef);
            max-width: 100%;
        }

        .navbar-center {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .navbar-nav {
            display: flex;
            gap: 15px;
            list-style: none;
            padding: 0;
            flex-wrap: wrap;
        }

        .navbar-nav .nav-link {
            color: #9acdff;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            white-space: nowrap;
        }

        .navbar-nav .nav-link:hover {
            color: #00ff99;
            text-shadow: 0 0 5px #00ff99;
            background: rgba(0, 255, 170, 0.2);
        }

        .navbar-right {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .navbar-right .nav-link {
            color: #9acdff;
            font-weight: bold;
            transition: 0.3s;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .navbar-right .nav-link:hover {
            color: #00ff99;
            text-shadow: 0 0 5px #00ff99;
            background: rgba(0, 255, 170, 0.2);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            padding: 50px 20px;
            text-align: center;
        }

        .main-content h1 {
            font-size: 4rem;
            font-weight: bold;
        }

        .animated-text {
            display: inline-block;
            background: linear-gradient(to right, #00bfff, #fff);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: colorAnimation 3s infinite alternate;
        }

        .main-content p {
            font-size: 1.5rem;
            margin-top: 15px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .main-content a {
            display: inline-block;
            margin-top: 20px;
            color: #00bfff;
            text-decoration: none;
            font-weight: bold;
        }

        .social-icons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icons img {
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="Logo">
        </a>

        <div class="navbar-center">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('home_guest') }}">Home</a></li>
                @if(session()->has('firebase_user'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('rules') }}">Rules</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('teams') }}">Teams</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('scoreboard') }}">Scoreboard</a></li>
                @endif
            </ul>
        </div>

        <div class="navbar-right">
            <a class="nav-link" href="{{ route('register') }}">Register</a>
            <a class="nav-link" href="{{ route('login') }}">Login</a>
        </div>
    </nav>

    <!-- Nội dung chính -->
    <div class="main-content">
        <h1 class="animated-text">Uncover the Secrets of <br>
        <span class="animated-text">Virtual Seas!</span></h1>
        <p>Cyberlabs, IIT(ISM) Dhanbad presents Pearl CTF — the ultimate test of your cyber-savvy skills! Following the triumph of Jade CTF, we're back with a fresh wave of challenges to thrill and perplex. Brace yourself for an adrenaline-fueled journey through cryptic codes, network mazes, and many more.</p>
        <a href="#">Infra sponsored by goo.gl/ctfsponsorship</a>
        <div class="social-icons">
            <img src="images/discord.png" alt="Discord">
            <img src="images/logo.png" alt="Logo">
            <img src="images/facebook.png" alt="Facebook">
        </div>
    </div>
</body>
</html>
