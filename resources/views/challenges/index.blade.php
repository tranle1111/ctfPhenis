<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenges - CTF Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
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
        
        .challenge-box {
            max-width: 800px;
            margin: 20px auto;
            background: #1e1e2f;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 255, 170, 0.5);
        }
        
        .challenge-item {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            transition: 0.3s;
            cursor: pointer;
        }
        
        .solved { background-color: #28a745; }
        .unsolved { background-color:rgb(69, 69, 69); }
        
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(30, 30, 50, 0.95);
            padding: 25px;
            border-radius: 12px;
            z-index: 1000;
            width: 90%;
            max-width: 600px;
            color: white;
            box-shadow: 0 0 20px rgba(0, 255, 170, 0.6);
            border: 2px solid #00ff99;
        }

        .popup h2 {
            font-size: 24px;
            margin-bottom: 15px;
            text-align: center;
            color: #00ff99;
        }

        .popup p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .popup strong {
            color: #00bfff;
        }

        .popup input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 2px solid #00ff99;
            border-radius: 5px;
            background: #1e1e2f;
            color: white;
            font-size: 16px;
        }

        .popup button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: #00bfff;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .popup button:hover {
            background: #008cff;
            box-shadow: 0 0 10px #00bfff;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }

        .close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    font-weight: bold;
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

.close-btn:hover {
    color: #ff4d4d;
    transform: scale(1.2);
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
        <h1>Danh sách thử thách</h1>
        <div class="challenge-box">
            @foreach($userChallenges as $challenge)
                <div class="challenge-item {{ $challenge['solved'] ? 'solved' : 'unsolved' }}" 
                    onclick="openPopup({{ json_encode($challenge) }})">
                    <strong>{{ $challenge['name'] }}</strong> - {{ $challenge['points'] }} điểm
                </div>
            @endforeach
        </div>
    </div>

    <!-- Popup -->
    <div id="message-box" style="display: none; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: rgba(0, 255, 0, 0.9); color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; z-index: 1000;"></div>
    <div class="overlay" id="overlay" onclick="closePopup()"></div>
    <div class="popup" id="popup">
    <span class="close-btn" onclick="closePopup()">&times;</span> <!-- Nút X -->
    <h2 id="popup-name"></h2>
    <p><strong>Điểm:</strong> <span id="popup-points"></span></p></br></br>
    <p><strong>Mô tả:</strong> <span id="popup-description"></span></p></br>
    <p><strong>Gợi ý:</strong> <span id="popup-hints"></span></p></br></br>
    <p><strong>Link:</strong> <span id="popup-link">tại đây</span></p></br>
    <input type="text" id="answer-input" placeholder="Nhập câu trả lời...">
    <button onclick="submitAnswer()">Gửi đáp án</button>
</div>


    <!-- Footer -->
    <footer class="footer">
        &copy; 2025 PHENIKAA INFORMATION SECURITY CLUB. All Rights Reserved.
    </footer>

    <script>
        function openPopup(challenge) {
            document.getElementById('popup-name').innerText = challenge.name;
            document.getElementById('popup-points').innerText = challenge.points;
            
            // Chuyển đổi link trong mô tả thành thẻ <a> mở tab mới
            document.getElementById('popup-description').innerHTML = challenge.description.replace(
                /(https?:\/\/[^\s]+)/g,
                '<a href="$1" target="_blank" style="color: #007bff; text-decoration: underline;">$1</a>'
            );

            document.getElementById('popup-hints').innerText = challenge.hints;

            // Xử lý link trong popup
            const popupLink = document.getElementById('popup-link');
            if (challenge.link) {
                popupLink.innerHTML = `<a href="${challenge.link}" target="_blank" style="color: #007bff; text-decoration: underline;">tại đây</a>`;
            } else {
                popupLink.innerHTML = "Không có link";
            }

            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function showMessage(message, success) {
        const messageBox = document.getElementById('message-box');
        messageBox.innerText = message;
        messageBox.style.background = success ? "rgba(0, 255, 0, 0.9)" : "rgba(255, 0, 0, 0.9)";
        messageBox.style.display = "block";

        setTimeout(() => {
            messageBox.style.display = "none";
            if (success) {
                window.location.href = "{{ route('challenges') }}"; // Tải lại trang nếu đúng
            }
        }, 1500);
    }

    function submitAnswer() {
        const challengeName = document.getElementById('popup-name').innerText;
        const answer = document.getElementById('answer-input').value;

        fetch("{{ route('challenges.check') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ name: challengeName, answer: answer })
        })
        .then(response => response.json())
        .then(data => {
            showMessage(data.message, data.success);
        })
        .catch(error => console.error("Error:", error));
    }
    </script>
</body>
</html>
