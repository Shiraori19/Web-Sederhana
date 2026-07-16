        </div><!-- /content-wrapper -->
    </main>

    <?php
    // Flash messages
    $flash = getFlash();
    if ($flash):
    ?>
    <div class="flash-toast" id="flashToast">
        <div class="flash-toast-content flash-<?= $flash['type'] ?>">
            <i class="bi bi-<?= $flash['type']=='success'?'check-circle':'exclamation-circle' ?>"></i>
            <span><?= $flash['message'] ?></span>
            <button onclick="this.parentElement.parentElement.remove()"><i class="bi bi-x"></i></button>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggle = document.getElementById('sidebarToggle');

        toggle?.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Mobile: close sidebar on link click
        if (window.innerWidth < 992) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', () => {
                    sidebar.classList.add('collapsed');
                });
            });
        }

        // Auto dismiss flash
        const flash = document.getElementById('flashToast');
        if (flash) setTimeout(() => flash.remove(), 4000);
    </script>
    <?php if (isset($extraJs)): foreach($extraJs as $js): ?>
    <script src="<?= $js ?>"></script>
    <?php endforeach; endif; ?>
</body>
</html>
