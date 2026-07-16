/* ============================================
   Ketoeroenan Doeloe v2 — Landing Page Styles
   ============================================ */

:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --primary-light: #818cf8;
    --secondary: #8b5cf6;
    --accent: #06b6d4;
    --accent-2: #14b8a6;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --dark: #0f172a;
    --dark-2: #1e293b;
    --dark-3: #334155;
    --surface: rgba(30, 41, 59, 0.8);
    --text: #e2e8f0;
    --text-muted: #94a3b8;
    --text-bright: #f1f5f9;
    --border: rgba(99, 102, 241, 0.15);
    --glow: rgba(99, 102, 241, 0.4);
    --radius: 16px;
    --radius-lg: 24px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --font-main: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    --font-heading: 'Poppins', 'Inter', sans-serif;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

html {
    scroll-behavior: smooth;
    scroll-padding-top: 80px;
}

body {
    font-family: var(--font-main);
    background: var(--dark);
    color: var(--text);
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
}

/* --- Utilities --- */
.text-gradient {
    background: linear-gradient(135deg, var(--primary-light), var(--secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.text-gradient-2 {
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ===== NAVBAR ===== */
.navbar {
    padding: 16px 0;
    transition: var(--transition);
    z-index: 1000;
}

.navbar.scrolled {
    background: rgba(15, 23, 42, 0.95) !important;
    backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--border);
    padding: 10px 0;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 20px;
    color: #fff !important;
    text-decoration: none;
}

.brand-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #fff;
}

.navbar-toggler {
    border: 1px solid var(--border);
    padding: 6px 10px;
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(226, 232, 240, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

.nav-link {
    color: var(--text-muted) !important;
    font-weight: 500;
    font-size: 14px;
    padding: 8px 16px !important;
    border-radius: 8px;
    transition: var(--transition);
}

.nav-link:hover, .nav-link.active {
    color: #fff !important;
    background: rgba(99, 102, 241, 0.1);
}

.btn-glow {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    transition: var(--transition);
    text-decoration: none;
}

.btn-glow:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px var(--glow);
    color: #fff;
}

/* ===== HERO ===== */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
}

.hero-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.25;
}

.shape-1 {
    width: 600px;
    height: 600px;
    background: var(--primary);
    top: -200px;
    right: -100px;
    animation: heroFloat 15s infinite;
}

.shape-2 {
    width: 400px;
    height: 400px;
    background: var(--secondary);
    bottom: -100px;
    left: -100px;
    animation: heroFloat 20s infinite reverse;
}

.shape-3 {
    width: 300px;
    height: 300px;
    background: var(--accent);
    top: 40%;
    left: 30%;
    animation: heroFloat 12s infinite 3s;
}

@keyframes heroFloat {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(50px, -30px) scale(1.05); }
    50% { transform: translate(-20px, 40px) scale(0.95); }
    75% { transform: translate(30px, 20px) scale(1.02); }
}

.hero-grid {
    position: absolute;
    inset: 0;
    background-image: 
        linear-gradient(rgba(99, 102, 241, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(99, 102, 241, 0.03) 1px, transparent 1px);
    background-size: 60px 60px;
}

.hero-content { position: relative; z-index: 1; }

.hero-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 50px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 500;
    color: var(--primary-light);
    margin-bottom: 24px;
    animation: fadeInUp 0.8s ease;
}

.hero-title {
    font-family: var(--font-heading);
    font-size: clamp(36px, 5.5vw, 68px);
    font-weight: 800;
    line-height: 1.1;
    color: var(--text-bright);
    margin-bottom: 24px;
    animation: fadeInUp 0.8s ease 0.2s both;
}

.hero-desc {
    font-size: 17px;
    line-height: 1.7;
    color: var(--text-muted);
    max-width: 520px;
    margin-bottom: 32px;
    animation: fadeInUp 0.8s ease 0.4s both;
}

.hero-actions {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 40px;
    animation: fadeInUp 0.8s ease 0.6s both;
}

.btn-hero-primary {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    border: none;
    padding: 16px 32px;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 15px;
    transition: var(--transition);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-hero-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px var(--glow);
    color: #fff;
}

.btn-hero-outline {
    background: transparent;
    color: var(--text);
    border: 1px solid var(--border);
    padding: 16px 32px;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 15px;
    transition: var(--transition);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-hero-outline:hover {
    background: rgba(99, 102, 241, 0.1);
    border-color: var(--primary);
    color: #fff;
    transform: translateY(-2px);
}

.hero-trust {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
    animation: fadeInUp 0.8s ease 0.8s both;
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-muted);
}

.trust-item i {
    color: var(--success);
    font-size: 16px;
}

/* Hero Visual */
.hero-visual {
    position: relative;
    height: 500px;
}

.floating-card {
    position: absolute;
    background: var(--surface);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #fff;
    z-index: 2;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

.floating-card i { font-size: 24px; }
.floating-card small { font-size: 11px; color: var(--text-muted); display: block; }
.floating-card strong { font-size: 16px; font-weight: 700; }

.card-1 {
    top: 40px;
    right: 0;
    animation: floatCard 6s infinite ease-in-out;
}
.card-1 i { color: var(--success); }

.card-2 {
    top: 180px;
    left: 0;
    animation: floatCard 8s infinite ease-in-out 1s;
}
.card-2 i { color: var(--primary-light); }

.card-3 {
    bottom: 120px;
    right: 20px;
    animation: floatCard 7s infinite ease-in-out 2s;
}
.card-3 i { color: var(--warning); }

@keyframes floatCard {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

.dashboard-preview {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 280px;
    background: var(--dark-2);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
}

.preview-header {
    background: var(--dark-3);
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.preview-dots {
    display: flex;
    gap: 6px;
}

.preview-dots span {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}
.preview-dots span:nth-child(1) { background: #ef4444; }
.preview-dots span:nth-child(2) { background: #f59e0b; }
.preview-dots span:nth-child(3) { background: #10b981; }

.preview-title { font-size: 12px; color: var(--text-muted); }

.preview-body { padding: 20px; }

.mini-chart {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 100px;
}

.mini-chart .bar {
    flex: 1;
    background: linear-gradient(to top, var(--primary), var(--primary-light));
    border-radius: 4px 4px 0 0;
    transition: var(--transition);
    opacity: 0.6;
}

.mini-chart .bar.active {
    opacity: 1;
    background: linear-gradient(to top, var(--accent), var(--accent-2));
}

/* Scroll Indicator */
.hero-scroll-indicator {
    position: absolute;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    z-index: 2;
    animation: fadeInUp 1s ease 1.2s both;
}

.mouse {
    width: 24px;
    height: 38px;
    border: 2px solid var(--text-muted);
    border-radius: 12px;
    position: relative;
}

.wheel {
    width: 4px;
    height: 10px;
    background: var(--text-muted);
    border-radius: 2px;
    position: absolute;
    top: 6px;
    left: 50%;
    transform: translateX(-50%);
    animation: scrollWheel 2s infinite;
}

@keyframes scrollWheel {
    0% { opacity: 1; top: 6px; }
    100% { opacity: 0; top: 20px; }
}

.hero-scroll-indicator span {
    font-size: 11px;
    color: var(--text-muted);
    letter-spacing: 1px;
    text-transform: uppercase;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== SECTIONS ===== */
.section-header { margin-bottom: 48px; }

.section-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 50px;
    padding: 6px 16px;
    font-size: 13px;
    font-weight: 500;
    color: var(--primary-light);
    margin-bottom: 16px;
}

.section-title {
    font-family: var(--font-heading);
    font-size: clamp(28px, 4vw, 42px);
    font-weight: 800;
    color: var(--text-bright);
    line-height: 1.2;
}

.section-desc {
    font-size: 16px;
    color: var(--text-muted);
    margin-top: 12px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

/* ===== FEATURES ===== */
.features-section {
    padding: 100px 0;
    background: var(--dark);
    position: relative;
}

.feature-card {
    background: var(--surface);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 32px;
    height: 100%;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--clr, var(--primary)), transparent);
    opacity: 0;
    transition: var(--transition);
}

.feature-card:hover {
    transform: translateY(-8px);
    border-color: rgba(99, 102, 241, 0.3);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.feature-card:hover::before { opacity: 1; }

.feature-icon {
    width: 56px;
    height: 56px;
    background: rgba(99, 102, 241, 0.1);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: var(--clr, var(--primary-light));
    margin-bottom: 20px;
    transition: var(--transition);
}

.feature-card:hover .feature-icon {
    background: var(--clr, var(--primary));
    color: #fff;
    transform: scale(1.1);
}

.feature-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-bright);
    margin-bottom: 12px;
}

.feature-card p {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.7;
    margin-bottom: 16px;
}

.feature-tags {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.feature-tags span {
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 6px;
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary-light);
    font-weight: 500;
}

/* ===== PRODUCTS ===== */
.products-section {
    padding: 100px 0;
    background: var(--dark-2);
}

.product-card {
    background: var(--surface);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 28px;
    text-align: center;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
    border-color: rgba(99, 102, 241, 0.3);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

.product-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: rgba(99, 102, 241, 0.15);
    color: var(--primary-light);
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
}

.product-icon {
    width: 72px;
    height: 72px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 32px;
    color: var(--primary-light);
}

.product-card h4 {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-bright);
    margin-bottom: 4px;
}

.product-code {
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 12px;
}

.product-price {
    font-size: 20px;
    font-weight: 800;
    color: var(--accent);
    margin-bottom: 12px;
}

.product-stock {
    font-size: 12px;
    color: var(--success);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

.product-stock.low { color: var(--danger); }

.empty-state {
    padding: 60px 20px;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 64px;
    margin-bottom: 16px;
    opacity: 0.3;
}

.empty-state h4 {
    color: var(--text);
    margin-bottom: 8px;
}

/* ===== STATS ===== */
.stats-section {
    padding: 100px 0;
    background: var(--dark);
    position: relative;
}

.stats-grid-landing {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}

.stat-card {
    background: var(--surface);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 36px 24px;
    text-align: center;
    transition: var(--transition);
}

.stat-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary);
    box-shadow: 0 15px 40px rgba(99, 102, 241, 0.15);
}

.stat-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 24px;
    color: #fff;
}

.stat-number {
    font-family: var(--font-heading);
    font-size: 42px;
    font-weight: 800;
    color: var(--text-bright);
    line-height: 1;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 14px;
    color: var(--text-muted);
    font-weight: 500;
}

/* ===== WORKFLOW ===== */
.workflow-section {
    padding: 100px 0;
    background: var(--dark-2);
}

.workflow-timeline {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
}

.workflow-timeline::before {
    content: '';
    position: absolute;
    left: 40px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, var(--primary), var(--secondary), var(--accent));
}

.workflow-item {
    display: flex;
    gap: 24px;
    margin-bottom: 32px;
    position: relative;
}

.workflow-number {
    width: 80px;
    height: 80px;
    min-width: 80px;
    background: var(--dark);
    border: 2px solid var(--primary);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-heading);
    font-size: 24px;
    font-weight: 800;
    color: var(--primary-light);
    z-index: 1;
}

.workflow-content {
    background: var(--surface);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
    flex: 1;
    transition: var(--transition);
}

.workflow-content:hover {
    border-color: var(--primary);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.workflow-content h3 {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-bright);
    margin-bottom: 8px;
}

.workflow-content p {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.7;
    margin: 0;
}

/* ===== CTA ===== */
.cta-section { padding: 100px 0; }

.cta-card {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.15));
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: var(--radius-lg);
    padding: 64px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.cta-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.05) 0%, transparent 70%);
    animation: rotateSlow 20s linear infinite;
}

@keyframes rotateSlow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.cta-card h2 {
    font-family: var(--font-heading);
    font-size: clamp(24px, 3vw, 36px);
    font-weight: 800;
    color: var(--text-bright);
    margin-bottom: 16px;
    position: relative;
}

.cta-card p {
    font-size: 16px;
    color: var(--text-muted);
    margin-bottom: 32px;
    position: relative;
}

.cta-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
    position: relative;
}

/* ===== FOOTER ===== */
.footer-section {
    padding: 80px 0 40px;
    background: var(--dark-2);
    border-top: 1px solid var(--border);
}

.footer-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 20px;
    color: #fff;
    margin-bottom: 16px;
}

.footer-desc {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.7;
}

.footer-section h5 {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-bright);
    margin-bottom: 16px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    padding: 4px 0;
    font-size: 14px;
    color: var(--text-muted);
}

.footer-links a {
    color: var(--text-muted);
    text-decoration: none;
    transition: var(--transition);
}

.footer-links a:hover {
    color: var(--primary-light);
    padding-left: 4px;
}

.footer-divider {
    border-color: var(--border);
    margin: 40px 0 24px;
}

.footer-bottom {
    text-align: center;
}

.footer-bottom p {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 991.98px) {
    .hero-section { padding-top: 100px; }
    .stats-grid-landing { grid-template-columns: repeat(2, 1fr); }
    .workflow-timeline::before { left: 28px; }
    .workflow-number { width: 56px; height: 56px; min-width: 56px; font-size: 18px; border-radius: 14px; }
    .cta-card { padding: 40px 24px; }
    .navbar-collapse {
        background: rgba(15, 23, 42, 0.98);
        backdrop-filter: blur(20px);
        border-radius: var(--radius);
        padding: 16px;
        margin-top: 12px;
        border: 1px solid var(--border);
    }
}

@media (max-width: 575.98px) {
    .stats-grid-landing { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .stat-card { padding: 24px 16px; }
    .stat-number { font-size: 32px; }
    .hero-title { font-size: 32px; }
    .hero-actions { flex-direction: column; }
    .btn-hero-primary, .btn-hero-outline { width: 100%; justify-content: center; }
    .hero-trust { flex-direction: column; gap: 8px; }
    .workflow-item { flex-direction: column; gap: 16px; }
    .workflow-timeline::before { display: none; }
    .feature-card { padding: 24px; }
    .section-title { font-size: 24px; }
}
