<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - CKM City</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-card { background: #fff; width: 100%; max-width: 400px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; }
        .login-header { background: linear-gradient(135deg, #3a8b45 0%, #24582a 100%); padding: 40px 20px; text-align: center; color: #fff; }
        .login-header h1 { margin: 0; font-size: 24px; font-weight: 800; }
        .login-header p { margin: 10px 0 0 0; font-size: 14px; opacity: 0.8; }
        .login-body { padding: 40px 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; font-weight: 800; color: #555; margin-bottom: 8px; text-transform: uppercase; }
        .form-control { width: 100%; box-sizing: border-box; padding: 14px 15px; border-radius: 8px; border: 1px solid #ccc; font-size: 14px; outline: none; transition: 0.2s; }
        .form-control:focus { border-color: #31743a; }
        .btn-login { width: 100%; background: #31743a; color: #fff; padding: 14px; border: none; border-radius: 8px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.2s; margin-top: 10px; }
        .btn-login:hover { background: #24582a; }
        .alert-error { background: #f8d7da; color: #842029; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; font-weight: 600; border: 1px solid #f5c2c7; text-align: center; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <h1>Panel Admin</h1>
            <p>CKM City Karawang</p>
        </div>
        <div class="login-body">
            @if($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email admin..." value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
                </div>
                <button type="submit" class="btn-login">Login Sekarang</button>
            </form>
        </div>
    </div>

</body>
</html>
