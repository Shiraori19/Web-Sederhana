<?php
/**
 * Auto-Installer
 * Sistem Informasi Toko ATK v2
 */
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'sistem_atk2';

$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$message = '';
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli($host, $user, $pass);
    if ($conn->connect_error) {
        $error = "Gagal koneksi MySQL: " . $conn->connect_error;
    } else {
        $conn->set_charset("utf8mb4");

        // Step 1: Create database & tables
        $sql = file_get_contents(__DIR__ . '/setup.sql');
        if ($conn->multi_query($sql)) {
            // Flush all results
            while ($conn->next_result()) {;}

            // Reconnect to the new database
            $conn->close();
            $conn = new mysqli($host, $user, $pass, $dbname);
            $conn->set_charset("utf8mb4");

            // Step 2: Insert default users
            $adminPass = password_hash('password', PASSWORD_DEFAULT);

            $users = [
                ['Admin ATK', 'admin@atk.com', $adminPass, 'admin'],
                ['Kasir 1', 'kasir@atk.com', $adminPass, 'kasir'],
                ['Gudang 1', 'gudang@atk.com', $adminPass, 'gudang'],
            ];

            foreach ($users as $u) {
                $check = $conn->query("SELECT id FROM users WHERE email = '{$u[1]}'");
                if ($check->num_rows == 0) {
                    $conn->query("INSERT INTO users (nama, email, password, role) VALUES ('{$u[0]}', '{$u[1]}', '{$u[2]}', '{$u[3]}')");
                }
            }

            // Step 3: Insert sample categories
            $categories = [
                ['Alat Tulis', 'Pensil, pulpen, spidol, dll', 'bi-pencil'],
                ['Kertas', 'HVS, folio, karton, dll', 'bi-file-earmark'],
                ['Perlengkapan Kantor', 'Stapler, gunting, lem, dll', 'bi-briefcase'],
                ['Buku & Notebook', 'Buku tulis, agenda, binder', 'bi-book'],
                ['Tinta & Cartridge', 'Tinta printer, cartridge', 'bi-droplet'],
                ['Amplop & Map', 'Amplop, map, folder', 'bi-envelope'],
                ['Alat Hitung', 'Kalkulator, penggaris', 'bi-calculator'],
                ['Aksesoris Meja', 'Tempat pensil, paper clip', 'bi-grid-3x3-gap'],
            ];

            foreach ($categories as $c) {
                $check = $conn->query("SELECT id FROM kategori WHERE nama_kategori = '{$c[0]}'");
                if ($check->num_rows == 0) {
                    $conn->query("INSERT INTO kategori (nama_kategori, deskripsi, icon) VALUES ('{$c[0]}', '{$c[1]}', '{$c[2]}')");
                }
            }

            // Step 4: Insert sample products
            $products = [
                ['ATK-001', 'Pulpen Standard AE7', 1, 'Pulpen tinta hitam', 2000, 3500, 150, 20, 'pcs'],
                ['ATK-002', 'Pensil 2B Faber-Castell', 1, 'Pensil 2B asli', 3000, 5000, 200, 30, 'pcs'],
                ['ATK-003', 'Spidol Snowman Hitam', 1, 'Spidol permanen', 5000, 8000, 80, 15, 'pcs'],
                ['ATK-004', 'Kertas HVS A4 70gr', 2, 'Satu rim 500 lembar', 35000, 48000, 50, 10, 'rim'],
                ['ATK-005', 'Kertas Folio Bergaris', 2, 'Per pak isi 100', 15000, 22000, 40, 10, 'pak'],
                ['ATK-006', 'Stapler Kenko HD-10', 3, 'Stapler kecil', 15000, 25000, 30, 5, 'pcs'],
                ['ATK-007', 'Gunting Joyko SC-828', 3, 'Gunting kantor', 8000, 15000, 25, 5, 'pcs'],
                ['ATK-008', 'Lem Stick UHU 21g', 3, 'Lem batang', 8000, 12000, 60, 10, 'pcs'],
                ['ATK-009', 'Buku Tulis Sidu 58 lmb', 4, 'Buku tulis isi 58', 3500, 5500, 100, 20, 'pcs'],
                ['ATK-010', 'Binder Joyko A5', 4, 'Binder ring 26', 20000, 35000, 20, 5, 'pcs'],
                ['ATK-011', 'Tinta Epson 664 Black', 5, 'Tinta printer 70ml', 55000, 75000, 15, 5, 'botol'],
                ['ATK-012', 'Cartridge HP 680 Black', 5, 'Cartridge original', 95000, 135000, 10, 3, 'pcs'],
                ['ATK-013', 'Amplop Coklat Folio', 6, 'Per pak isi 50', 20000, 32000, 30, 5, 'pak'],
                ['ATK-014', 'Map Plastik L Folio', 6, 'Map transparan', 1500, 3000, 100, 20, 'pcs'],
                ['ATK-015', 'Kalkulator Casio MX-12B', 7, 'Kalkulator 12 digit', 85000, 125000, 12, 3, 'pcs'],
            ];

            foreach ($products as $p) {
                $check = $conn->query("SELECT id FROM produk WHERE kode = '{$p[0]}'");
                if ($check->num_rows == 0) {
                    $conn->query("INSERT INTO produk (kode, nama, kategori_id, deskripsi, harga_beli, harga_jual, stok, stok_minimum, satuan)
                        VALUES ('{$p[0]}', '{$p[1]}', {$p[2]}, '{$p[3]}', {$p[4]}, {$p[5]}, {$p[6]}, {$p[7]}, '{$p[8]}')");
                }
            }

            // Step 5: Insert sample suppliers
            $suppliers = [
                ['PT. Sinar Dunia', '021-55501234', 'info@sinardunia.co.id', 'Jl. Industri Raya No.10, Tangerang', 'Tangerang'],
                ['CV. Jaya Stationery', '031-77702345', 'order@jayastation.com', 'Jl. Rungkut Industri No.5, Surabaya', 'Surabaya'],
                ['UD. Makmur Kertas', '022-44403456', 'makmurkertas@gmail.com', 'Jl. Soekarno-Hatta No.88, Bandung', 'Bandung'],
            ];

            foreach ($suppliers as $s) {
                $check = $conn->query("SELECT id FROM supplier WHERE nama = '{$s[0]}'");
                if ($check->num_rows == 0) {
                    $conn->query("INSERT INTO supplier (nama, kontak, email, alamat, kota) VALUES ('{$s[0]}', '{$s[1]}', '{$s[2]}', '{$s[3]}', '{$s[4]}')");
                }
            }

            // Step 6: Insert sample customers
            $customers = [
                ['Budi Santoso', '081234567890', 'budi@email.com', 'Jl. Merdeka No.1', 150, 'Silver', 750000],
                ['Siti Rahmawati', '082345678901', 'siti@email.com', 'Jl. Sudirman No.25', 50, 'Bronze', 250000],
                ['PT. Maju Jaya', '021-33334444', 'procurement@majujaya.co.id', 'Jl. TB Simatupang No.100', 500, 'Gold', 5000000],
                ['Andi Pratama', '085678901234', 'andi.p@gmail.com', 'Jl. Ahmad Yani No.15', 20, 'Bronze', 100000],
            ];

            foreach ($customers as $c) {
                $check = $conn->query("SELECT id FROM pelanggan WHERE nama = '{$c[0]}'");
                if ($check->num_rows == 0) {
                    $conn->query("INSERT INTO pelanggan (nama, telepon, email, alamat, poin_loyalitas, level, total_belanja)
                        VALUES ('{$c[0]}', '{$c[1]}', '{$c[2]}', '{$c[3]}', {$c[4]}, '{$c[5]}', {$c[6]})");
                }
            }

            // Step 7: Insert sample transactions
            $sampleDates = [];
            for ($i = 6; $i >= 0; $i--) {
                $sampleDates[] = date('Y-m-d', strtotime("-$i days"));
            }

            $channels = ['toko', 'shopee', 'tokopedia', 'website'];
            $methods = ['cash', 'qris', 'ewallet'];

            $check = $conn->query("SELECT id FROM penjualan LIMIT 1");
            if ($check->num_rows == 0) {
                foreach ($sampleDates as $date) {
                    $numTx = rand(2, 5);
                    for ($t = 0; $t < $numTx; $t++) {
                        $inv = 'INV-' . str_replace('-', '', $date) . '-' . strtoupper(substr(uniqid(), -5));
                        $channel = $channels[array_rand($channels)];
                        $method = $methods[array_rand($methods)];
                        $custId = rand(1, 4);
                        $hour = ($date == date('Y-m-d')) ? rand(8, (int)date('H')) : rand(8, 20);
                        $min = rand(0, 59);

                        // Random items
                        $numItems = rand(1, 4);
                        $total = 0;
                        $items = [];
                        $usedProducts = [];
                        for ($i = 0; $i < $numItems; $i++) {
                            $pid = rand(1, 15);
                            if (in_array($pid, $usedProducts)) continue;
                            $usedProducts[] = $pid;
                            $prodRes = $conn->query("SELECT harga_jual FROM produk WHERE id = $pid");
                            if ($prodRes && $row = $prodRes->fetch_assoc()) {
                                $qty = rand(1, 5);
                                $harga = $row['harga_jual'];
                                $subtotal = $harga * $qty;
                                $total += $subtotal;
                                $items[] = [$pid, $qty, $harga, $subtotal];
                            }
                        }

                        if (empty($items)) continue;

                        $diskon = (rand(0, 3) == 0) ? round($total * 0.05) : 0;
                        $grandTotal = $total - $diskon;
                        $bayar = ($method == 'cash') ? ceil($grandTotal / 1000) * 1000 : $grandTotal;
                        $kembalian = $bayar - $grandTotal;

                        $conn->query("INSERT INTO penjualan (no_invoice, pelanggan_id, total, diskon, grand_total, bayar, kembalian, metode_bayar, channel, status, tanggal, user_id)
                            VALUES ('$inv', $custId, $total, $diskon, $grandTotal, $bayar, $kembalian, '$method', '$channel', 'selesai', '$date $hour:$min:00', 1)");

                        $saleId = $conn->insert_id;
                        foreach ($items as $item) {
                            $conn->query("INSERT INTO detail_penjualan (penjualan_id, produk_id, jumlah, harga, subtotal) VALUES ($saleId, {$item[0]}, {$item[1]}, {$item[2]}, {$item[3]})");
                        }

                        // Add loyalty points for digital payments
                        if ($method != 'cash') {
                            $points = floor($grandTotal / 10000);
                            $conn->query("UPDATE pelanggan SET poin_loyalitas = poin_loyalitas + $points, total_belanja = total_belanja + $grandTotal WHERE id = $custId");
                        }
                    }
                }
            }

            $success = true;
            $message = "Instalasi berhasil! Database, tabel, dan data demo telah dibuat.";

            // Count stats
            $tables = $conn->query("SHOW TABLES")->num_rows;
            $prodCount = $conn->query("SELECT COUNT(*) as c FROM produk")->fetch_assoc()['c'];
            $userCount = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
            $txCount = $conn->query("SELECT COUNT(*) as c FROM penjualan")->fetch_assoc()['c'];

        } else {
            $error = "Error SQL: " . $conn->error;
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer — Ketoeroenan Doeloe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --dark: #0f172a;
            --surface: #1e293b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .bg-shapes {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 0;
            overflow: hidden;
        }
        .bg-shapes .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
        }
        .shape-1 { width: 400px; height: 400px; background: var(--primary); top: -100px; right: -100px; animation: float 8s infinite; }
        .shape-2 { width: 300px; height: 300px; background: var(--secondary); bottom: -100px; left: -50px; animation: float 10s infinite reverse; }
        .shape-3 { width: 200px; height: 200px; background: var(--accent); top: 50%; left: 50%; animation: float 6s infinite; }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
        .installer-card {
            position: relative;
            z-index: 1;
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 24px;
            padding: 48px;
            max-width: 560px;
            width: 90%;
            text-align: center;
        }
        .installer-card .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 36px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3);
        }
        h1 { color: #fff; font-weight: 700; font-size: 28px; margin-bottom: 8px; }
        .subtitle { color: #94a3b8; font-size: 15px; margin-bottom: 32px; }
        .btn-install {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            padding: 16px 48px;
            border-radius: 16px;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-install:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.5);
            color: #fff;
        }
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin: 24px 0; }
        .stat-item {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.15);
            border-radius: 16px;
            padding: 20px;
        }
        .stat-item .number { font-size: 32px; font-weight: 800; color: var(--accent); }
        .stat-item .label { font-size: 13px; color: #94a3b8; margin-top: 4px; }
        .success-icon {
            width: 100px; height: 100px;
            background: rgba(16, 185, 129, 0.1);
            border: 2px solid var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 48px;
            color: var(--success);
            animation: scaleIn 0.5s ease;
        }
        @keyframes scaleIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 16px;
            color: #fca5a5;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .btn-login {
            background: linear-gradient(135deg, var(--success), #059669);
            border: none;
            padding: 16px 48px;
            border-radius: 16px;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.5);
            color: #fff;
        }
        .warning-text { color: #fbbf24; font-size: 13px; margin-top: 16px; }
        .warning-text i { margin-right: 4px; }
    </style>
</head>
<body>
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="installer-card">
        <?php if ($success): ?>
            <div class="success-icon"><i class="bi bi-check-lg"></i></div>
            <h1>Instalasi Berhasil!</h1>
            <p class="subtitle">Sistem Ketoeroenan Doeloe siap digunakan</p>
            <div class="stats-grid">
                <div class="stat-item"><div class="number"><?= $tables ?></div><div class="label">Tabel Dibuat</div></div>
                <div class="stat-item"><div class="number"><?= $prodCount ?></div><div class="label">Produk Demo</div></div>
                <div class="stat-item"><div class="number"><?= $userCount ?></div><div class="label">User Default</div></div>
                <div class="stat-item"><div class="number"><?= $txCount ?></div><div class="label">Transaksi Demo</div></div>
            </div>
            <a href="modules/auth/login.php" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login Sekarang
            </a>
            <div class="warning-text">
                <i class="bi bi-exclamation-triangle"></i>
                Hapus file install.php setelah selesai untuk keamanan!
            </div>
            <div style="margin-top:20px; padding:16px; background:rgba(99,102,241,.1); border-radius:12px; text-align:left;">
                <p style="color:#c7d2fe; font-size:13px; font-weight:600; margin-bottom:8px;">Default Login:</p>
                <p style="color:#94a3b8; font-size:12px; margin:0;">👑 Admin: admin@atk.com / password</p>
                <p style="color:#94a3b8; font-size:12px; margin:0;">🖥️ Kasir: kasir@atk.com / password</p>
                <p style="color:#94a3b8; font-size:12px; margin:0;">📦 Gudang: gudang@atk.com / password</p>
            </div>
        <?php elseif ($error): ?>
            <div class="logo"><i class="bi bi-exclamation-triangle"></i></div>
            <h1>Instalasi Gagal</h1>
            <div class="alert-error"><?= $error ?></div>
            <form method="POST">
                <button type="submit" class="btn-install"><i class="bi bi-arrow-clockwise me-2"></i>Coba Lagi</button>
            </form>
        <?php else: ?>
            <div class="logo"><i class="bi bi-shop"></i></div>
            <h1>Ketoeroenan Doeloe v2</h1>
            <p class="subtitle">Sistem Informasi Toko Alat Tulis Kantor<br>Installer Otomatis</p>
            <div style="text-align:left; margin-bottom:24px; padding:20px; background:rgba(99,102,241,.08); border-radius:16px;">
                <p style="color:#e2e8f0; font-size:14px; font-weight:600; margin-bottom:12px;"><i class="bi bi-list-check me-2"></i>Yang akan diinstall:</p>
                <ul style="color:#94a3b8; font-size:13px; list-style:none; padding:0; margin:0;">
                    <li style="padding:4px 0;"><i class="bi bi-check-circle text-success me-2"></i>Database <code style="color:#c7d2fe;">sistem_atk2</code></li>
                    <li style="padding:4px 0;"><i class="bi bi-check-circle text-success me-2"></i>12 Tabel (users, produk, stok, dll)</li>
                    <li style="padding:4px 0;"><i class="bi bi-check-circle text-success me-2"></i>3 User default (Admin, Kasir, Gudang)</li>
                    <li style="padding:4px 0;"><i class="bi bi-check-circle text-success me-2"></i>15 Produk demo + 8 Kategori</li>
                    <li style="padding:4px 0;"><i class="bi bi-check-circle text-success me-2"></i>3 Supplier + 4 Pelanggan</li>
                    <li style="padding:4px 0;"><i class="bi bi-check-circle text-success me-2"></i>Transaksi demo 7 hari terakhir</li>
                </ul>
            </div>
            <form method="POST">
                <button type="submit" class="btn-install">
                    <i class="bi bi-download me-2"></i>Mulai Instalasi
                </button>
            </form>
            <p class="warning-text"><i class="bi bi-info-circle"></i>Pastikan XAMPP MySQL sudah running</p>
        <?php endif; ?>
    </div>
</body>
</html>
