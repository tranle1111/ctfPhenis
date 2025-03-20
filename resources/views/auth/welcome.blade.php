<body>

    <!-- Hiển thị thông báo lỗi nếu có -->
    @if(session('error'))
        <div class="alert alert-danger" style="padding: 10px; background-color: red; color: white; text-align: center;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Navbar -->
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="images/logo.jpg" alt="Logo">
        </a>

        <div class="navbar-center">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="">Rules</a></li>
                <li class="nav-item"><a class="nav-link" href="">Teams</a></li>
                <li class="nav-item"><a class="nav-link" href="">Scoreboard</a></li>
                <li class="nav-item"><a class="nav-link" href="">Challenges</a></li>
            </ul>
        </div>

        <div class="navbar-right">
            <a class="nav-link" href="{{ route('register') }}">Register</a>
            <a class="nav-link" href="{{ route('login') }}">Login</a>
        </div>
    </nav>
