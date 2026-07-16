<?php
/**
 * Authentication Guard
 */
session_start();

require_once __DIR__ . '/../config/database.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/modules/auth/login.php');
        exit;
    }
}

function requireRole($roles) {
    requireLogin();
    if (!is_array($roles)) $roles = [$roles];
    if (!in_array($_SESSION['user_role'], $roles)) {
        header('Location: ' . BASE_URL . '/modules/dashboard/index.php?error=unauthorized');
        exit;
    }
}

function currentUser() {
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'nama' => $_SESSION['user_nama'] ?? '',
        'email' => $_SESSION['user_email'] ?? '',
        'role' => $_SESSION['user_role'] ?? '',
    ];
}
?>
