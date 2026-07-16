/* ============================================
   Ketoeroenan Doeloe v2 — Dashboard / Admin Styles
   ============================================ */

:root {
    --primary: #6366f1; --primary-dark: #4f46e5; --primary-light: #818cf8;
    --secondary: #8b5cf6; --accent: #06b6d4; --accent-2: #14b8a6;
    --success: #10b981; --warning: #f59e0b; --danger: #ef4444; --info: #3b82f6;
    --dark: #0f172a; --dark-2: #1e293b; --dark-3: #334155;
    --surface: rgba(30, 41, 59, 0.8); --text: #e2e8f0; --text-muted: #94a3b8;
    --text-bright: #f1f5f9; --border: rgba(99, 102, 241, 0.15);
    --sidebar-width: 260px; --topbar-height: 64px;
    --radius: 16px; --radius-sm: 10px; --radius-xs: 6px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --font: 'Inter', -apple-system, sans-serif;
}

* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: var(--font); background: var(--dark); color: var(--text); overflow-x: hidden; }

/* ===== TOP NAVBAR ===== */
.top-navbar {
    position: fixed; top: 0; left: var(--sidebar-width); right: 0; height: var(--topbar-height);
    background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--border); display: flex; align-items: center;
    justify-content: space-between; padding: 0 24px; z-index: 900; transition: var(--transition);
}

.top-navbar-left { display: flex; align-items: center; gap: 16px; }
.top-navbar-right { display: flex; align-items: center; gap: 16px; }

.sidebar-toggle {
    background: none; border: 1px solid var(--border); color: var(--text-muted);
    width: 40px; height: 40px; border-radius: var(--radius-sm); display: flex;
    align-items: center; justify-content: center; cursor: pointer; transition: var(--transition); font-size: 20px;
}
.sidebar-toggle:hover { background: rgba(99,102,241,0.1); color: var(--primary-light); }

.breadcrumb-nav { display: flex; align-items: center; gap: 8px; font-size: 14px; }
.breadcrumb-nav .breadcrumb-item { color: var(--text-muted); }
.breadcrumb-nav .breadcrumb-item.active { color: var(--text-bright); font-weight: 600; }
.breadcrumb-nav i { font-size: 10px; color: var(--text-muted); }

.nav-alert {
    position: relative; width: 40px; height: 40px; display: flex; align-items: center;
    justify-content: center; border-radius: var(--radius-sm); color: var(--text-muted);
    transition: var(--transition); text-decoration: none;
}
.nav-alert:hover { background: rgba(239,68,68,0.1); color: var(--danger); }
.alert-badge {
    position: absolute; top: 4px; right: 4px; background: var(--danger); color: #fff;
    font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}

.user-dropdown .btn {
    display: flex; align-items: center; gap: 10px; background: none; border: 1px solid var(--border);
    border-radius: 12px; padding: 6px 12px 6px 6px; color: var(--text); transition: var(--transition);
}
.user-dropdown .btn:hover { border-color: var(--primary); background: rgba(99,102,241,0.05); }
.user-dropdown .btn::after { display: none; }

.user-avatar {
    width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 10px; display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700; color: #fff;
}
.user-info { text-align: left; }
.user-name { display: block; font-size: 13px; font-weight: 600; color: var(--text-bright); line-height: 1.2; }
.user-role { display: block; font-size: 11px; color: var(--text-muted); }

.dropdown-menu {
    background: var(--dark-2); border: 1px solid var(--border); border-radius: var(--radius-sm);
    box-shadow: 0 10px 40px rgba(0,0,0,0.4); padding: 8px;
}
.dropdown-header { color: var(--text-muted); font-size: 12px; }
.dropdown-divider { border-color: var(--border); }
.dropdown-item {
    color: var(--text); border-radius: var(--radius-xs); font-size: 13px; padding: 8px 12px;
}
.dropdown-item:hover { background: rgba(99,102,241,0.1); color: var(--primary-light); }

/* ===== SIDEBAR ===== */
.sidebar {
    position: fixed; top: 0; left: 0; width: var(--sidebar-width); height: 100vh;
    background: var(--dark-2); border-right: 1px solid var(--border); z-index: 950;
    display: flex; flex-direction: column; transition: var(--transition); overflow: hidden;
}
.sidebar.collapsed { transform: translateX(-100%); }
.sidebar.collapsed ~ .top-navbar { left: 0; }
.sidebar.collapsed ~ .main-content { margin-left: 0; }

.sidebar-brand {
    height: var(--topbar-height); display: flex; align-items: center; gap: 10px;
    padding: 0 20px; font-size: 18px; font-weight: 700; color: #fff;
    border-bottom: 1px solid var(--border); flex-shrink: 0;
}
.sidebar-brand .brand-icon {
    width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 10px; display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: #fff;
}

.sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
.sidebar-nav::-webkit-scrollbar { width: 4px; }
.sidebar-nav::-webkit-scrollbar-thumb { background: var(--dark-3); border-radius: 4px; }

.nav-section-title {
    font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase;
    letter-spacing: 1px; padding: 16px 12px 8px; margin-top: 4px;
}

.nav-item {
    display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: var(--radius-sm);
    color: var(--text-muted); text-decoration: none; font-size: 13px; font-weight: 500;
    transition: var(--transition); margin-bottom: 2px; position: relative;
}
.nav-item:hover { background: rgba(99,102,241,0.08); color: var(--text); }
.nav-item.active { background: rgba(99,102,241,0.15); color: var(--primary-light); font-weight: 600; }
.nav-item.active::before {
    content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
    width: 3px; height: 20px; background: var(--primary); border-radius: 0 4px 4px 0;
}
.nav-item i { font-size: 18px; width: 24px; text-align: center; }
.nav-badge {
    margin-left: auto; background: var(--danger); color: #fff; font-size: 10px; font-weight: 700;
    padding: 2px 8px; border-radius: 10px;
}

.sidebar-footer {
    padding: 16px 20px; border-top: 1px solid var(--border); flex-shrink: 0;
}
.sidebar-footer-info small { color: var(--text-muted); font-size: 11px; }

/* ===== MAIN CONTENT ===== */
.main-content {
    margin-left: var(--sidebar-width); margin-top: var(--topbar-height);
    min-height: calc(100vh - var(--topbar-height)); transition: var(--transition);
}
.main-content.expanded { margin-left: 0; }
.content-wrapper { padding: 24px; }

/* ===== PAGE HEADER ===== */
.page-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
}
.page-header h1 { font-size: 24px; font-weight: 700; color: var(--text-bright); margin: 0; }
.page-header p { font-size: 14px; color: var(--text-muted); margin: 4px 0 0; }

/* ===== CARDS ===== */
.card-glass {
    background: var(--surface); backdrop-filter: blur(20px);
    border: 1px solid var(--border); border-radius: var(--radius);
    transition: var(--transition);
}
.card-glass:hover { border-color: rgba(99,102,241,0.25); }
.card-glass .card-body { padding: 24px; }
.card-glass .card-header {
    background: transparent; border-bottom: 1px solid var(--border);
    padding: 16px 24px; font-weight: 600; color: var(--text-bright);
}

/* KPI Cards */
.kpi-card {
    background: var(--surface); backdrop-filter: blur(20px); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 24px; transition: var(--transition);
    position: relative; overflow: hidden;
}
.kpi-card:hover { transform: translateY(-4px); border-color: rgba(99,102,241,0.3); box-shadow: 0 12px 40px rgba(0,0,0,0.2); }
.kpi-card::after {
    content: ''; position: absolute; top: 0; right: 0; width: 120px; height: 120px;
    background: radial-gradient(circle, var(--kpi-clr, var(--primary)) 0%, transparent 70%);
    opacity: 0.06; border-radius: 50%; transform: translate(30%, -30%);
}
.kpi-card .kpi-icon {
    width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center;
    justify-content: center; font-size: 22px; margin-bottom: 16px;
}
.kpi-card .kpi-value { font-size: 28px; font-weight: 800; color: var(--text-bright); line-height: 1; }
.kpi-card .kpi-label { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

/* ===== TABLES ===== */
.table-glass {
    width: 100%; color: var(--text); font-size: 13px;
}
.table-glass thead th {
    background: rgba(99,102,241,0.06); color: var(--text-muted); font-weight: 600;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;
    padding: 12px 16px; border-bottom: 1px solid var(--border); white-space: nowrap;
}
.table-glass tbody td {
    padding: 12px 16px; border-bottom: 1px solid rgba(99,102,241,0.06);
    vertical-align: middle;
}
.table-glass tbody tr:hover { background: rgba(99,102,241,0.04); }
.table-glass tbody tr:last-child td { border-bottom: none; }

/* ===== BADGES ===== */
.badge-status {
    padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;
}
.badge-success { background: rgba(16,185,129,0.15); color: #6ee7b7; }
.badge-warning { background: rgba(245,158,11,0.15); color: #fcd34d; }
.badge-danger { background: rgba(239,68,68,0.15); color: #fca5a5; }
.badge-info { background: rgba(59,130,246,0.15); color: #93c5fd; }
.badge-primary { background: rgba(99,102,241,0.15); color: #a5b4fc; }
.badge-secondary { background: rgba(100,116,139,0.15); color: #cbd5e1; }

/* ===== BUTTONS ===== */
.btn-primary-glass {
    background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none;
    color: #fff; font-weight: 600; font-size: 13px; padding: 10px 20px;
    border-radius: var(--radius-sm); transition: var(--transition);
}
.btn-primary-glass:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,0.35); color: #fff; }

.btn-outline-glass {
    background: transparent; border: 1px solid var(--border); color: var(--text-muted);
    font-weight: 500; font-size: 13px; padding: 10px 20px; border-radius: var(--radius-sm);
    transition: var(--transition);
}
.btn-outline-glass:hover { border-color: var(--primary); color: var(--primary-light); background: rgba(99,102,241,0.05); }

.btn-sm-icon {
    width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
    border-radius: 8px; border: 1px solid var(--border); background: transparent;
    color: var(--text-muted); font-size: 14px; transition: var(--transition); cursor: pointer;
}
.btn-sm-icon:hover { border-color: var(--primary); color: var(--primary-light); }
.btn-sm-icon.danger:hover { border-color: var(--danger); color: var(--danger); background: rgba(239,68,68,0.05); }

/* ===== FORMS ===== */
.form-control-glass, .form-select-glass {
    background: var(--dark-2); border: 1px solid var(--border); color: var(--text);
    border-radius: var(--radius-sm); padding: 10px 14px; font-size: 13px; transition: var(--transition);
}
.form-control-glass:focus, .form-select-glass:focus {
    background: var(--dark-2); border-color: var(--primary); color: var(--text);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
}
.form-control-glass::placeholder { color: var(--text-muted); }
.form-label-glass { color: var(--text-muted); font-size: 12px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }

/* ===== MODALS ===== */
.modal-content-glass {
    background: var(--dark-2); border: 1px solid var(--border); border-radius: var(--radius);
    color: var(--text);
}
.modal-content-glass .modal-header { border-bottom: 1px solid var(--border); padding: 20px 24px; }
.modal-content-glass .modal-title { font-weight: 700; color: var(--text-bright); }
.modal-content-glass .modal-body { padding: 24px; }
.modal-content-glass .modal-footer { border-top: 1px solid var(--border); padding: 16px 24px; }
.modal-content-glass .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }

/* ===== EMPTY STATE ===== */
.empty-state-dash { text-align: center; padding: 48px 24px; color: var(--text-muted); }
.empty-state-dash i { font-size: 48px; opacity: 0.3; margin-bottom: 12px; }

/* ===== FLASH TOAST ===== */
.flash-toast {
    position: fixed; top: 80px; right: 24px; z-index: 9999;
    animation: slideInRight 0.4s ease;
}
.flash-toast-content {
    display: flex; align-items: center; gap: 12px; padding: 14px 20px;
    border-radius: var(--radius-sm); font-size: 13px; font-weight: 500;
    backdrop-filter: blur(20px); min-width: 280px;
}
.flash-toast-content button { background: none; border: none; color: inherit; cursor: pointer; margin-left: auto; }
.flash-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.25); color: #6ee7b7; }
.flash-error { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.25); color: #fca5a5; }
.flash-warning { background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.25); color: #fcd34d; }

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

/* ===== PAGINATION ===== */
.pagination-glass .page-link {
    background: var(--dark-2); border: 1px solid var(--border); color: var(--text-muted);
    font-size: 13px; padding: 8px 14px;
}
.pagination-glass .page-link:hover { background: rgba(99,102,241,0.1); color: var(--primary-light); border-color: var(--primary); }
.pagination-glass .page-item.active .page-link { background: var(--primary); border-color: var(--primary); color: #fff; }

/* ===== RESPONSIVE ===== */
@media (max-width: 991.98px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.collapsed { transform: translateX(-100%); }
    .sidebar:not(.collapsed) { transform: translateX(0); box-shadow: 0 0 60px rgba(0,0,0,0.5); }
    .top-navbar { left: 0; }
    .main-content { margin-left: 0; }
    .main-content.expanded { margin-left: 0; }
    .content-wrapper { padding: 16px; }
}

@media (max-width: 575.98px) {
    .page-header { flex-direction: column; align-items: flex-start; }
    .content-wrapper { padding: 12px; }
    .kpi-card { padding: 16px; }
    .kpi-card .kpi-value { font-size: 22px; }
}
