<?php
/**
 * Register Page — Ketoeroenan Doeloe v2
 */
session_start();
require_once __DIR__ . '/../../config/database.php';

if (isset($_SESSION['user_id'])) { header('Location: ../dashboard/index.php'); exit; }

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = sanitize($conn, $_POST['nama'] ?? '');
    $email = sanitize($conn, $_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($nama) || empty($email) || empty($password)) {
        $error = 'Semua field wajib diisi.';
    } elseif ($password !== $confirm) {
        $error = 'Konfirmasi password tidak cocok.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Email sudah terdaftar.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'kasir')");
            $stmt->bind_param("sss", $nama, $email, $hash);
            if ($stmt->execute()) {
                $success = 'Pendaftaran berhasil! Silakan login.';
            } else {
                $error = 'Terjadi kesalahan. Coba lagi.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Ketoeroenan Doeloe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#6366f1; --secondary:#8b5cf6; --accent:#06b6d4; --dark:#0f172a; --dark-2:#1e293b; --border:rgba(99,102,241,0.15); }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--dark); min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .bg-shapes { position:fixed; inset:0; z-index:0; overflow:hidden; }
        .bg-shapes .s { position:absolute; border-radius:50%; filter:blur(100px); opacity:0.2; }
        .s1 { width:500px; height:500px; background:var(--primary); top:-150px; right:-100px; }
        .s2 { width:350px; height:350px; background:var(--secondary); bottom:-100px; left:-50px; }
        .register-card {
            position:relative; z-index:1; background:rgba(30,41,59,0.8); backdrop-filter:blur(20px);
            border:1px solid var(--border); border-radius:24px; padding:48px; width:90%; max-width:460px;
        }
        .register-card h2 { font-size:28px; font-weight:700; color:#f1f5f9; margin-bottom:8px; }
        .register-card .subtitle { color:#94a3b8; font-size:14px; margin-bottom:28px; }
        .form-floating { margin-bottom:16px; }
        .form-floating .form-control {
            background:var(--dark-2); border:1px solid var(--border); color:#e2e8f0;
            border-radius:12px; height:56px; font-size:14px;
        }
        .form-floating .form-control:focus { background:var(--dark-2); border-color:var(--primary); color:#e2e8f0; box-shadow:0 0 0 3px rgba(99,102,241,0.15); }
        .form-floating label { color:#94a3b8; font-size:14px; }
        .btn-register {
            width:100%; background:linear-gradient(135deg,var(--primary),var(--secondary));
            border:none; padding:16px; border-radius:12px; color:#fff; font-weight:600; font-size:15px; transition:all 0.3s;
        }
        .btn-register:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(99,102,241,0.4); color:#fff; }
        .alert-danger { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.25); color:#fca5a5; border-radius:12px; font-size:13px; }
        .alert-success { background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.25); color:#6ee7b7; border-radius:12px; font-size:13px; }
        .login-link { text-align:center; margin-top:20px; font-size:14px; color:#94a3b8; }
        .login-link a { color:var(--primary); text-decoration:none; font-weight:600; }
        .back-link { display:inline-flex; align-items:center; gap:6px; color:#94a3b8; font-size:13px; text-decoration:none; margin-bottom:20px; }
        .back-link:hover { color:var(--primary); }
    </style>
</head>
<body>
    <div class="bg-shapes"><div class="s s1"></div><div class="s s2"></div></div>
    <div class="register-card">
        <a href="../../index.php" class="back-link"><i class="bi bi-arrow-left"></i> Beranda</a>
        <h2>Buat Akun Baru ✨</h2>
        <p class="subtitle">Daftar untuk menggunakan sistem Ketoeroenan Doeloe</p>
        <?php if($error): ?><div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i><?= $error ?></div><?php endif; ?>
        <?php if($success): ?><div class="alert alert-success"><i class="bi bi-check-circle me-2"></i><?= $success ?> <a href="login.php" style="color:#6ee7b7;font-weight:600;">Login →</a></div><?php endif; ?>
        <form method="POST">
            <div class="form-floating">
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
                <label for="nama"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required minlength="6">
                <label for="password"><i class="bi bi-lock me-2"></i>Password (min 6 karakter)</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi" required>
                <label for="confirm_password"><i class="bi bi-lock-fill me-2"></i>Konfirmasi Password</label>
            </div>
            <button type="submit" class="btn btn-register mt-2"><i class="bi bi-person-plus me-2"></i>Daftar</button>
        </form>
        <div class="login-link">Sudah punya akun? <a href="login.php">Login disini</a></div>
    </div>
</body>
</html>
