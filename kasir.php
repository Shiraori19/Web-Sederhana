<?php
/**
 * Login Page — Ketoeroenan Doeloe v2
 */
session_start();
require_once __DIR__ . '/../../config/database.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard/index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($conn, $_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Email dan password wajib diisi.';
    } else {
        $stmt = $conn->prepare("SELECT id, nama, email, password, role, is_active FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            if (!$user['is_active']) {
                $error = 'Akun Anda telah dinonaktifkan.';
            } elseif (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nama'] = $user['nama'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Update last login
                $conn->query("UPDATE users SET last_login = NOW() WHERE id = {$user['id']}");
                
                header('Location: ../dashboard/index.php');
                exit;
            } else {
                $error = 'Email atau password salah.';
            }
        } else {
            $error = 'Email atau password salah.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Ketoeroenan Doeloe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1; --primary-dark: #4f46e5; --secondary: #8b5cf6;
            --accent: #06b6d4; --success: #10b981; --dark: #0f172a;
            --dark-2: #1e293b; --border: rgba(99,102,241,0.15);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--dark); min-height:100vh; display:flex; }
        .login-visual {
            flex:1; display:flex; align-items:center; justify-content:center;
            background:linear-gradient(135deg,var(--primary),var(--secondary),var(--accent));
            position:relative; overflow:hidden;
        }
        .login-visual::before {
            content:''; position:absolute; inset:0;
            background:url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h60v60H0z' fill='none'/%3E%3Cpath d='M30 0v60M0 30h60' stroke='rgba(255,255,255,0.05)' stroke-width='1'/%3E%3C/svg%3E") repeat;
        }
        .visual-content { position:relative; z-index:1; text-align:center; color:#fff; padding:40px; }
        .visual-content .logo-big {
            width:100px; height:100px; background:rgba(255,255,255,0.15);
            border-radius:28px; display:flex; align-items:center; justify-content:center;
            font-size:48px; margin:0 auto 24px; backdrop-filter:blur(10px);
        }
        .visual-content h1 { font-family:'Poppins',sans-serif; font-size:36px; font-weight:800; margin-bottom:12px; }
        .visual-content p { font-size:16px; opacity:0.85; max-width:340px; margin:0 auto; line-height:1.6; }
        .login-form-wrapper {
            width:520px; min-width:520px; display:flex; align-items:center; justify-content:center; padding:48px;
        }
        .login-form { width:100%; max-width:400px; }
        .login-form h2 { font-size:28px; font-weight:700; color:#f1f5f9; margin-bottom:8px; }
        .login-form .subtitle { color:#94a3b8; font-size:14px; margin-bottom:32px; }
        .form-floating { margin-bottom:16px; }
        .form-floating .form-control {
            background:var(--dark-2); border:1px solid var(--border); color:#e2e8f0;
            border-radius:12px; padding:16px; height:56px; font-size:14px;
        }
        .form-floating .form-control:focus {
            background:var(--dark-2); border-color:var(--primary); color:#e2e8f0;
            box-shadow:0 0 0 3px rgba(99,102,241,0.15);
        }
        .form-floating label { color:#94a3b8; font-size:14px; padding:16px; }
        .btn-login {
            width:100%; background:linear-gradient(135deg,var(--primary),var(--secondary));
            border:none; padding:16px; border-radius:12px; color:#fff; font-weight:600;
            font-size:15px; transition:all 0.3s; margin-top:8px;
        }
        .btn-login:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(99,102,241,0.4); color:#fff; }
        .alert-danger {
            background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.25);
            color:#fca5a5; border-radius:12px; font-size:13px; padding:12px 16px;
        }
        .divider { display:flex; align-items:center; gap:16px; margin:24px 0; color:#64748b; font-size:13px; }
        .divider::before, .divider::after { content:''; flex:1; height:1px; background:var(--border); }
        .demo-accounts {
            background:var(--dark-2); border:1px solid var(--border); border-radius:12px; padding:16px;
        }
        .demo-accounts p { font-size:12px; color:#94a3b8; margin:0; cursor:pointer; padding:4px 0; transition:all 0.2s; }
        .demo-accounts p:hover { color:var(--primary); }
        .demo-accounts p span { color:#64748b; }
        .register-link { text-align:center; margin-top:24px; font-size:14px; color:#94a3b8; }
        .register-link a { color:var(--primary); text-decoration:none; font-weight:600; }
        .register-link a:hover { text-decoration:underline; }
        .back-link { display:inline-flex; align-items:center; gap:6px; color:#94a3b8; font-size:13px; text-decoration:none; margin-bottom:24px; transition:all 0.2s; }
        .back-link:hover { color:var(--primary); }
        @media(max-width:991px) {
            .login-visual { display:none; }
            .login-form-wrapper { width:100%; min-width:auto; }
        }
        @media(max-width:575px) { .login-form-wrapper { padding:24px; } }
    </style>
</head>
<body>
    <div class="login-visual">
        <div class="visual-content">
            <div class="logo-big"><i class="bi bi-shop"></i></div>
            <h1>Ketoeroenan Doeloe</h1>
            <p>Sistem Informasi Toko Alat Tulis Kantor — Kelola inventaris, penjualan & procurement dalam satu platform.</p>
        </div>
    </div>
    <div class="login-form-wrapper">
        <div class="login-form">
            <a href="../../index.php" class="back-link"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
            <h2>Selamat Datang 👋</h2>
            <p class="subtitle">Masuk ke dashboard untuk mengelola toko Anda</p>

            <?php if ($error): ?>
                <div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" id="loginForm">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                </div>
                <button type="submit" class="btn btn-login"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk</button>
            </form>

            <div class="divider">Demo Account</div>
            <div class="demo-accounts">
                <p onclick="fillLogin('admin@atk.com','password')">👑 <strong>Admin</strong> <span>— admin@atk.com</span></p>
                <p onclick="fillLogin('kasir@atk.com','password')">🖥️ <strong>Kasir</strong> <span>— kasir@atk.com</span></p>
                <p onclick="fillLogin('gudang@atk.com','password')">📦 <strong>Gudang</strong> <span>— gudang@atk.com</span></p>
            </div>
            <div class="register-link">
                Belum punya akun? <a href="register.php">Daftar disini</a>
            </div>
        </div>
    </div>
    <script>
        function fillLogin(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }
    </script>
</body>
</html>
