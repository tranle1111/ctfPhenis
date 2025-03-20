<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rules - CTF Panel</title>
    <style>
        /* ===== RESET CSS ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #0f0f0f;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: linear-gradient(90deg, #00bfff, #00ff99);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand img {
            height: 50px;
            filter: drop-shadow(0 0 5px #00ff99);
        }

        .navbar-nav {
            display: flex;
            gap: 20px;
            list-style: none;
        }

        .navbar-nav .nav-link {
            color: #ffffff;
            font-size: 1rem;
            text-decoration: none;
            padding: 5px 10px;
            transition: background 0.3s;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .logout-btn {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #ff1a1a;
            box-shadow: 0 0 10px #ff4d4d;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            padding: 50px 20px;
            text-align: center;
        }

        .main-content h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #00bfff, #00ff99);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .rules-list {
            max-width: 600px;
            margin: 0 auto;
            text-align: left;
            font-size: 1.2rem;
            line-height: 1.8;
        }

        .rules-list li {
            margin-bottom: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            transition: 0.3s;
        }

        .rules-list li:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #00bfff;
            color: #ffffff;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-back:hover {
            background-color: #00ff99;
            color: #000000;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="Logo">
        </a>
        <ul class="navbar-nav">
            <li><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li><a class="nav-link" href="{{ route('rules') }}">Rules</a></li>
            <li><a class="nav-link" href="{{ route('teams') }}">Teams</a></li>
            <li><a class="nav-link" href="{{ route('scoreboard') }}">Scoreboard</a></li>
            <li><a class="nav-link" href="{{ route('challenges') }}">Challenges</a></li>
        </ul>
        @if(session()->has('firebase_user'))
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @else
            <a href="{{ route('register') }}" class="nav-link">Register</a>
            <a href="{{ route('login') }}" class="nav-link">Login</a>
        @endif
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Competition Rules</h2>
        <ul class="rules-list">
            <li>Rule 1: No cheating.</li>
            <li>Rule 2: Respect all participants.</li>
            <li>Rule 3: No external help.</li>
        </ul>
        <a href="{{ route('home') }}" class="btn-back">Back to Home</a>
    </div>
</body>
</html>
