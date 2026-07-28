<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | POS Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#0f766e,#14b8a6,#5eead4);
        }

        .login-card{
            width:420px;
            background:#fff;
            padding:40px;
            border-radius:20px;
            box-shadow:0 20px 50px rgba(0,0,0,.15);
        }

        .logo{
            width:90px;
            height:90px;
            border-radius:50%;
            background:#ccfbf1;
            color:#0f766e;
            display:flex;
            justify-content:center;
            align-items:center;
            margin:auto;
            font-size:40px;
        }

        h2{
            color:#0f172a;
            font-weight:700;
            margin-top:20px;
        }

        .subtitle{
            color:#64748b;
            margin-bottom:30px;
        }

        label{
            font-weight:600;
            color:#334155;
            margin-bottom:6px;
        }

        .input-group-text{
            background:#f8fafc;
            border:1px solid #cbd5e1;
        }

        .form-control{
            height:50px;
            border:1px solid #cbd5e1;
        }

        .form-control:focus{
            border-color:#14b8a6;
            box-shadow:0 0 0 .2rem rgba(20,184,166,.25);
        }

        .btn-login{
            width:100%;
            height:50px;
            background:#0f766e;
            color:white;
            border:none;
            border-radius:12px;
            font-weight:600;
            transition:.3s;
        }

        .btn-login:hover{
            background:#115e59;
            transform:translateY(-2px);
        }

        .alert{
            border-radius:10px;
        }

        .footer{
            margin-top:20px;
            text-align:center;
            color:#64748b;
            font-size:14px;
        }
    </style>

</head>
<body>

<div class="login-card">

    <div class="text-center">

        <div class="logo">
            <i class="bi bi-cart4"></i>
        </div>

        <h2>POS Management</h2>

        <p class="subtitle">
            Selamat datang, silakan login
        </p>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif

    <form action="{{ route('auth') }}" method="POST">

        @csrf

        <div class="mb-3">

            <label>Email</label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-envelope-fill"></i>
                </span>

                <input
                    type="email"
                    class="form-control"
                    name="email"
                    placeholder="Masukkan email"
                    required>

            </div>

        </div>

        <div class="mb-4">

            <label>Password</label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-lock-fill"></i>
                </span>

                <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="Masukkan password"
                    required>

                <button class="btn btn-light" type="button" onclick="togglePassword()">
                    <i class="bi bi-eye" id="icon"></i>
                </button>

            </div>

        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right"></i>
            Login
        </button>

    </form>

    <div class="footer">
        © {{ date('Y') }} POS Management System
    </div>

</div>

<script>
function togglePassword(){

    const password = document.getElementById('password');
    const icon = document.getElementById('icon');

    if(password.type === "password"){
        password.type = "text";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }else{
        password.type = "password";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }

}
</script>

</body>
</html>