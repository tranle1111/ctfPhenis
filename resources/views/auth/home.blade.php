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

        html, body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #0f0f0f;
            color: #ffffff;
            overflow-x: hidden;
        }
        body {
            display: grid;
            grid-template-rows: auto 1fr auto;
            min-height: 100vh;
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

        .main-content h1 {
            font-size: 3.5rem;
            font-weight: bold;
            background: linear-gradient(90deg, #00bfff, #00ff99);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .main-content p {
            font-size: 1.2rem;
            line-height: 1.6;
            max-width: 700px;
            margin: 15px auto;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #00bfff;
            color: #ffffff;
            font-size: 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #00ff99;
            color: #000;
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #161b22;
            color: #9acdff;
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
        <h1>Welcome to CTF PHENIS</h1>
        <p>Đây là trang thông tin chính thức của Câu lạc bộ yêu an toàn thông tin Phenikaa
        </p>
        <p>Chúng tôi tự hào giới thiệu đến bạn cuộc thi CTF Phenikaa - một cuộc thi an toàn thông tin dành cho tất cả các bạn sinh viên trên toàn quốc.
        </p>
        <p>Đến với CTF Phenikaa, bạn sẽ được trải nghiệm những thử thách bảo mật thông tin thú vị, hấp dẫn và đầy thách thức. Hãy tham gia ngay để có cơ hội nhận những phần quà hấp dẫn từ BTC.
        </p>
        <a href="{{ route('challenges') }}" class="btn">Explore Challenges</a>
    </div>

    <!-- Footer -->
    <footer class="footer">
        &copy; 2025 PHENIKAA INFORMATION SECURITY CLUB. All Rights Reserved.
    </footer>
</body>
</html>
