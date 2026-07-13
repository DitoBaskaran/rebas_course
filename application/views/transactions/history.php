<div>
    <div class="mb-4">
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.03em;"><?php echo t('Riwayat Transaksi', 'Transaction History'); ?></h2>
        <p class="text-secondary mb-0"><?php echo t('Semua transaksi dan pembelian kamu.', 'All your transactions and purchases.'); ?></p>
    </div>

    <div class="card-modern p-4 p-xl-5">
        <table id="transactionTable" class="table-modern w-100" style="width:100%">
            <thead>
                <tr>
                    <th><?php echo t('Tanggal', 'Date'); ?></th>
                    <th><?php echo t('Tipe', 'Type'); ?></th>
                    <th><?php echo t('Item', 'Item'); ?></th>
                    <th><?php echo t('Nominal', 'Amount'); ?></th>
                    <th style="display:none;"></th>
                    <th><?php echo t('Status', 'Status'); ?></th>
                    <th class="text-center"><?php echo t('Aksi', 'Action'); ?></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<!-- DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var table = $('#transactionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo base_url('transactions/history_data'); ?>',
            type: 'GET'
        },
        columns: [
            { data: 0, searchable: true },
            { data: 1, orderable: false, searchable: true },
            { data: 2, searchable: true },
            { data: 3, orderable: true, searchable: false },
            { data: 4, orderable: true, searchable: false, visible: false },
            { data: 5, orderable: false, searchable: false },
            { data: 6, orderable: false, searchable: false, className: 'text-center' }
        ],
        order: [[4, 'desc']],
        language: {
            processing: "<?php echo t('Memuat...', 'Loading...'); ?>",
            lengthMenu: "<?php echo t('Tampilkan _MENU_ data', 'Show _MENU_ entries'); ?>",
            zeroRecords: "<?php echo t('Tidak ada data ditemukan.', 'No records found.'); ?>",
            info: "<?php echo t('Menampilkan _START_ sampai _END_ dari _TOTAL_ data', 'Showing _START_ to _END_ of _TOTAL_ entries'); ?>",
            infoEmpty: "<?php echo t('Tidak ada data.', 'No data.'); ?>",
            search: "<?php echo t('Cari:', 'Search:'); ?>",
            paginate: {
                first: "<?php echo t('Pertama', 'First'); ?>",
                last: "<?php echo t('Terakhir', 'Last'); ?>",
                next: "<?php echo t('Selanjutnya', 'Next'); ?>",
                previous: "<?php echo t('Sebelumnya', 'Prev'); ?>"
            }
        },
        responsive: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
    });
});
</script>
