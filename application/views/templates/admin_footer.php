        </div><!-- /.admin-content -->
    </div><!-- /.admin-wrapper -->

    <!-- Admin Footer -->
    <div class="admin-footer" id="adminFooter">
        <div class="admin-footer-inner">
            <span class="small text-secondary">&copy; <?php echo date('Y'); ?> <strong><?php echo htmlspecialchars(setting('general_site_name', 'REBAS COURSE')); ?></strong></span>
            <span class="small text-secondary">v3.0</span>
        </div>
    </div>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($load_aos) && $load_aos): ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <?php endif; ?>
    <?php if (isset($load_chartjs) && $load_chartjs): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <?php endif; ?>
    <!-- REBAS JS -->
    <script src="<?php echo base_url('assets/js/rebas.js'); ?>"></script>
</body>
</html>
