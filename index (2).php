<?php
/**
 * Admin Header — Ketoeroenan Doeloe v2
 */
$user = currentUser();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$currentDir = basename(dirname($_SERVER['PHP_SELF']));

// Count low stock alerts
$lowStockCount = 0;
$lowStockResult = $conn->query("SELECT COUNT(*) as c FROM produk WHERE stok <= stok_minimum AND is_active=1");
if ($lowStockResult) $lowStockCount = $lowStockResult->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dashboard' ?> — Ketoeroenan Doeloe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/dashboard.css" rel="stylesheet">
    <?php if (isset($extraCss)): foreach($extraCss as $css): ?>
    <link href="<?= $css ?>" rel="stylesheet">
    <?php endforeach; endif; ?>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="top-navbar">
        <div class="top-navbar-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="breadcrumb-nav">
                <span class="breadcrumb-item"><?= ucfirst($currentDir) ?></span>
                <i class="bi bi-chevron-right"></i>
                <span class="breadcrumb-item active"><?= $pageTitle ?? ucfirst($currentPage) ?></span>
            </div>
        </div>
        <div class="top-navbar-right">
            <?php if ($lowStockCount > 0): ?>
            <a href="<?= BASE_URL ?>/modules/stok/index.php" class="nav-alert" title="<?= $lowStockCount ?> produk stok rendah">
                <i class="bi bi-bell-fill"></i>
                <span class="alert-badge"><?= $lowStockCount ?></span>
            </a>
            <?php endif; ?>
            <div class="user-dropdown dropdown">
                <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="user-avatar"><?= strtoupper(substr($user['nama'], 0, 1)) ?></div>
                    <div class="user-info d-none d-md-block">
                        <span class="user-name"><?= htmlspecialchars($user['nama']) ?></span>
                        <span class="user-role"><?= ucfirst($user['role']) ?></span>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-header">Login sebagai <?= ucfirst($user['role']) ?></span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/modules/auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
