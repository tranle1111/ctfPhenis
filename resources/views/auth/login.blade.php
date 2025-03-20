<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTF Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0d1117;
            color: #c9d1d9;
            font-family: "Courier New", monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            max-width: 400px;
            padding: 20px;
            background: #161b22;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 255, 170, 0.5);
            text-align: center;
        }
        h2 {
            color: #0ef;
            text-shadow: 0 0 5px #0ef;
        }
        .form-control {
            background: #0d1117;
            color: #ffffff;
            border: 1px solid #0ef;
        }
        .form-control::placeholder {
            color: #9acdff;
            opacity: 0.7;
        }
        .form-control:focus {
            background: #0d1117;
            color: #fff;
            border-color: #00ff99;
            box-shadow: 0 0 5px #00ff99;
        }
        .btn-custom {
            background-color: #0ef;
            color: #0d1117;
            font-weight: bold;
            border: none;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #00ff99;
            box-shadow: 0 0 10px #00ff99;
        }
        a {
            color: #0ef;
            text-decoration: none;
        }
        a:hover {
            color: #00ff99;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>CTF Login</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                   name="email" placeholder="Email" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                   name="password" placeholder="Mật khẩu" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-custom w-100">Đăng nhập</button>

        <p class="mt-2">
            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
        </p>
    </form>

    <p class="mt-3">
        Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a>
    </p>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
