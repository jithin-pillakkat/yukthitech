<?php $this->extend('layout/app') ?>

<?php $this->section('content') ?>
<div class="card mt-4">
    <div class="card-header">
        <div class="card-title fw-3">
            <h5 class="d-inline">Product</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive w-100">
            <table id="sample" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAME</th>
                        <th>CODE</th>
                        <th>PRICE</th>
                        <th>STOCK</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

<script>
    var dataTable = $('#sample').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        info: false,
        ajax: "<?= route_to('product.list') ?>",
        order: [],
        columnDefs: [
            { targets: 0, orderable: false },
        ],
        layout: {
            topStart: {
                buttons: [
                    { extend: 'pageLength', className: 'btn-dark btn-sm' },
                    { extend: 'excel', className: 'btn-dark btn-sm' },
                    { extend: 'csv', className: 'btn-dark btn-sm' },
                    { extend: 'pdf', className: 'btn-dark btn-sm' },
                ]
            }
        }
    });    
</script>
<?php $this->endSection() ?>