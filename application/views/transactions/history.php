<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1200px;">
    <!-- Header -->
    <div class="mb-3">
        <h4 class="fw-extrabold mb-1" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.3rem;">
            <?php echo t('Riwayat Transaksi', 'Transaction History'); ?>
        </h4>
        <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;">
            <?php echo t('Semua transaksi dan pembelian kamu.', 'All your transactions and purchases.'); ?>
        </p>
    </div>

    <!-- ============ MOBILE APP-STYLE (list card) ============ -->
    <div class="dashboard-mobile-only">
        <div id="mobTxList" class="d-flex flex-column gap-3">
            <div class="text-center py-5" style="color: #a8a29e;">
                <div class="spinner-border spinner-border-sm text-success mb-3"></div>
                <div style="font-size: 0.8rem;"><?php echo t('Memuat...', 'Loading...'); ?></div>
            </div>
        </div>
    </div>

    <!-- ============ DESKTOP (DataTables) ============ -->
    <div class="dashboard-desktop-only">
        <!-- Table Card -->
        <div class="border rounded-3 p-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
            <div class="table-responsive">
                <table id="transactionTable" class="table mb-0" style="width: 100%; font-size: 0.82rem;">
                    <thead>
                        <tr>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.7rem; border-color: #e7e5e4; padding: 0.75rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Tanggal', 'Date'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.7rem; border-color: #e7e5e4; padding: 0.75rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Tipe', 'Type'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.7rem; border-color: #e7e5e4; padding: 0.75rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Item', 'Item'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.7rem; border-color: #e7e5e4; padding: 0.75rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Nominal', 'Amount'); ?></th>
                            <th style="display:none;"></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.7rem; border-color: #e7e5e4; padding: 0.75rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Status', 'Status'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.7rem; border-color: #e7e5e4; padding: 0.75rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; text-align: center;"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<style>
@keyframes dtSpin { to { transform: rotate(360deg); } }

/* ---- Wrapper ---- */
.dataTables_wrapper { font-size: 0.82rem; color: #1c1917; }

/* ---- Length + Search ---- */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0;
}
.dataTables_wrapper .dataTables_length label,
.dataTables_wrapper .dataTables_filter label {
    font-size: 0.78rem;
    font-weight: 600;
    color: #78716c;
    margin-bottom: 0;
    white-space: nowrap;
}
.dataTables_wrapper .dataTables_length select {
    border: 1px solid #e7e5e4;
    border-radius: 8px;
    padding: 0.3rem 0.5rem;
    font-size: 0.78rem;
    color: #1c1917;
    background: #fff;
    cursor: pointer;
    transition: all 0.15s;
}
.dataTables_wrapper .dataTables_length select:hover { border-color: #d6d3d1; }
.dataTables_wrapper .dataTables_length select:focus {
    border-color: #059669;
    outline: none;
    box-shadow: 0 0 0 3px rgba(249,115,22,0.1);
}
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #e7e5e4;
    border-radius: 100px;
    padding: 0.4rem 0.9rem 0.4rem 2.2rem;
    font-size: 0.78rem;
    color: #1c1917;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%23a8a29e' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242.156a5 5 0 1 1 0-10 5 5 0 0 1 0 10z'/%3E%3C/svg%3E") no-repeat 10px center;
    transition: all 0.15s;
}
.dataTables_wrapper .dataTables_filter input:hover { border-color: #d6d3d1; }
.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #059669;
    outline: none;
    box-shadow: 0 0 0 3px rgba(249,115,22,0.1);
}

/* ---- Table ---- */
table.dataTable { width: 100% !important; border-collapse: separate; border-spacing: 0; }
table.dataTable thead th {
    background: #fafaf9;
    font-weight: 600;
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #78716c;
    padding: 0.7rem 1rem;
    border-bottom: 1px solid #e7e5e4;
    border-top: none;
    white-space: nowrap;
}
table.dataTable thead th.sorting:after,
table.dataTable thead th.sorting_asc:after,
table.dataTable thead th.sorting_desc:after {
    font-size: 0.55rem;
    opacity: 0.4;
}
table.dataTable thead th.sorting_asc:after { opacity: 0.7; color: #059669; }
table.dataTable thead th.sorting_desc:after { opacity: 0.7; color: #059669; }
table.dataTable tbody td {
    padding: 0.65rem 1rem;
    border-bottom: 1px solid #f0eeeb;
    color: #1c1917;
    vertical-align: middle;
    font-size: 0.8rem;
    transition: background 0.1s;
}
table.dataTable tbody tr { transition: background 0.1s; }
table.dataTable tbody tr:hover { background: #fafaf9; }
table.dataTable tbody tr:last-child td { border-bottom: none; }
table.dataTable.no-footer { border-bottom: none; }

/* ---- Empty state ---- */
.dataTables_wrapper table.dataTable .dataTables_empty {
    color: #a8a29e;
    font-size: 0.85rem;
    padding: 3rem 1rem;
    text-align: center;
}

/* ---- Info ---- */
.dataTables_wrapper .dataTables_info {
    color: #78716c;
    font-size: 0.75rem;
    padding: 0.6rem 0;
}

/* ---- Pagination ---- */
.dataTables_wrapper .dataTables_paginate { padding: 0.5rem 0; }
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
    border: 1px solid #e7e5e4 !important;
    color: #57534e !important;
    background: #fff !important;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.35rem 0.75rem;
    margin: 0 0.1rem;
    transition: all 0.15s;
    cursor: pointer;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #f5f5f4 !important;
    color: #1c1917 !important;
    border-color: #d6d3d1 !important;
    box-shadow: none !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: #059669 !important;
    border-color: #059669 !important;
    color: #fff !important;
    box-shadow: 0 2px 8px rgba(249,115,22,0.25) !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
    opacity: 0.3;
    cursor: default;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.next,
.dataTables_wrapper .dataTables_paginate .paginate_button.previous {
    border: none !important;
    background: transparent !important;
    color: #78716c !important;
    font-weight: 500;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.next:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover {
    background: #f5f5f4 !important;
    color: #1c1917 !important;
}

/* ---- Processing spinner ---- */
.dataTables_processing {
    background: rgba(255,255,255,0.92) !important;
    border: 1px solid #e7e5e4 !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06) !important;
    font-size: 0.8rem !important;
    color: #78716c !important;
    padding: 0.5rem 1.2rem !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var isMobile = window.innerWidth <= 768;
    
    var table = $('#transactionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo base_url('transactions/history_data'); ?>',
            type: 'GET'
        },
        columns: [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 },
            { data: 4, visible: false },
            { data: 5 },
            { data: 6, className: 'text-center' }
        ],
        order: [[4, 'desc']],
        language: {
            processing: "<div style='display:flex;align-items:center;gap:0.5rem;'><div style='width:16px;height:16px;border:2px solid #e7e5e4;border-top-color:#059669;border-radius:50%;animation:dtSpin 0.6s linear infinite;'></div> <?php echo t('Memuat data...', 'Loading...'); ?></div>",
            zeroRecords: "<div style='padding:2rem 0;'><div style='font-size:2rem;color:#d6d3d1;margin-bottom:0.5rem;'><i class='fas fa-receipt'></i></div><div><?php echo t('Belum ada transaksi.', 'No transactions found.'); ?></div></div>",
        },
        drawCallback: function(settings) {
            if (isMobile) {
                var api = this.api();
                var data = api.rows({page:'current'}).data();
                var html = '';
                if (data.length === 0) {
                    html = '<div class="mob-empty"><i class="fas fa-receipt"></i><p><?php echo t('Belum ada transaksi.', 'No transactions found.'); ?></p></div>';
                } else {
                    data.each(function(row) {
                        html += `
                        <div class="bg-white rounded-4 border p-3" style="border-color:#f0eeeb!important;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="min-w-0">
                                    <div class="fw-bold text-dark text-truncate" style="font-size:0.85rem;">${row[2]}</div>
                                    <div class="text-muted" style="font-size:0.7rem;">${row[0]}</div>
                                    <div class="text-muted" style="font-size:0.65rem; font-family:monospace;">BT-${row[7]}</div>
                                </div>
                                <div>${row[5]}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top" style="border-color:#fafafa!important;">
                                <div class="fw-extrabold text-dark" style="font-size:0.9rem;">${row[3]}</div>
                                <div>${row[6]}</div>
                            </div>
                        </div>`;
                    });
                }
                $('#mobTxList').html(html);
            }
        }
    });
});
</script>
