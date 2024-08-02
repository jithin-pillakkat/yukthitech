<?php $this->extend('layout/app') ?>

<?php $this->section('content') ?>
<div class="card mt-4">
    <div class="card-header">
        <div class="card-title fw-3">
            <h5 class="d-inline">Bill</h5>
            <button class="btn btn-sm btn-dark float-end d-inline" data-bs-toggle="modal"
                data-bs-target="#billModal">Generate Bill</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="sample" class="table table-bordered">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>INVOICE NUMBER</th>
                        <th>CUSTOMER NAME</th>
                        <th>CUSTOMER PHONE</th>
                        <th>TOTAL AMOUNT</th>
                        <th>DATE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<?php include ('bill-modal.php') ?>

<?php include ('detail-canvas.php') ?>

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
        ajax: "<?= route_to('bill.list') ?>",
        order: [],
        columnDefs: [
            { targets: 0, orderable: false },
            { targets: 2, orderable: false },
            { targets: 3, orderable: false },
            { targets: 4, orderable: false },
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

    $('#search').on('keyup', function (e) {
        e.preventDefault();
        if (this.value.length >= 3) {
            $.ajax({
                url: "<?= route_to('product.search') ?>",
                method: "GET",
                data: { search: this.value },
                dataType: 'json',
                beforeSend: function () {
                    $('#search_result').removeClass('d-none');
                    $('.search-result').html(`<tr>
                        <td colspan="5" class="text-center text-danger">
                            <div class="spinner-border text-danger" role="status"></div>
                            </td>
                        </tr>`);
                },
                success: function (response) {
                    $('.search-result').html('');
                    if (!$.isEmptyObject(response.data)) {
                        $.each(response.data, function (index, value) {
                            $('.search-result').append(`
                            <tr id="row_`+ value.id + `">
                                <td><input type="text" id="name_`+ value.id + `" value="` + value.name + `" class="form-control form-control-sm border-0" readonly></td>
                                <td><input type="text" id="price_`+ value.id + `" value="` + value.price + `" class="form-control form-control-sm border-0" readonly></td>
                                <td><input type="text" id="stock_`+ value.id + `" value="` + value.qty + `" class="form-control form-control-sm border-0" readonly></td>
                                <td><input type="text" id="qty_`+ value.id + `" value="" class="form-control form-control-sm"></td>
                                <td><button type="button" onclick="addProduct(`+ value.id + `)" class="btn btn-light btn-sm">Add</button></td>
                            </tr>`);
                        });
                    } else {

                        $('.search-result').html(`<tr>
                        <td colspan="5" class="text-center text-danger">Product not found!</td>
                        </tr>`);
                    }
                }
            })
        } else {
            $('#search_result').addClass('d-none');
        }
    });

    $('#create_form').on('submit', function (e) {
        e.preventDefault();

        let form = this;
        let formData = {
            'name': $(form).find('#name').val(),
            'phone': $(form).find('#phone').val()
        };

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: $('#bill_item_details').serialize() + '&' + $.param(formData),
            dataType: 'json',
            beforeSend: function () {
                $(form).find('input.is-invalid').removeClass('is-invalid');
                $('#create').html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
  <span role="status">Generating...</span>
`).attr('disabled', true);
            },
            success: function (response) {
                $('#create').text('Create Bill').attr('disabled', false);
                $('.ci-csrf').val(response.token);
                if (!$.isEmptyObject(response.errors)) {
                    $.each(response.errors, function (prefix, value) {
                        $('input[name="' + prefix + '"]').addClass('is-invalid');
                        $('.' + prefix + '_error').text(value);
                    });
                }

                if (response.status == true) {
                    $('#billModal').modal('hide');
                    dataTable.ajax.reload();
                    $(form)[0].reset();
                    toastr.success(response.message);
                }

                if (response.status == false) {
                    toastr.error(response.message);
                }
            }
        });

    });


    $(document).on('click', '.view-bill', function (e) {
        e.preventDefault();
        id = $(this).data('id');

        $.ajax({
            url: "<?= route_to('bill.view') ?>",
            method: "GET",
            data: { id: id },
            dataType: "json",
            cache: false,
            beforeSend: function () {
                $('#product_items').html('');
            },
            success: function (response) {
                if (response.status == true) {
                    var total = 0;
                    if (!$.isEmptyObject(response.data)) {
                        $.each(response.data, function (index, row) {
                            total += parseFloat(row.amount);
                            $('#product_items').append(`
                    <tr>
                        <td>`+ ++index + `</td>
                        <td>`+ row.name + `</td>
                        <td>`+ row.price + `</td>
                        <td>`+ row.qty + `</td>
                        <td>`+ row.amount + `</td>
                    </tr>
                    `);
                        });
                        $('#product_items').append(`<tr>
                        <td colspan="4" class="text-center"><strong>Total</strong></td>
                        <td><strong>`+ total + `.00</strong></td>                        
                    </tr>`);
                    }
                    $('#detail_canvas').offcanvas('show');
                }
            }
        })
    });

    function addProduct(product_id) {
        
        let product = $('#name_' + product_id).val();
        let price = $('#price_' + product_id).val();
        let stock = $('#stock_' + product_id).val();
        let qty = $('#qty_' + product_id).val();

        
        if (!$.isNumeric(qty)) {
            toastr.error('Please enter valid Qty');
            return false;
        }

        if (parseFloat(qty) > parseFloat(stock)) {
            toastr.error('Stock not available');
            return false;
        }

        if ($('#item_' + product_id).length) {
            toastr.error('Item already addd !');
            return false;
        }


        let billItems = `<tr id="item_` + product_id + `">      
                            <input type="hidden" name="product_id[]" value="`+ product_id + `">                      
                            <td>`+ product + `</td>
                            <td>`+ price + `</td>
                            <td><input type="text" name="qty[]" value="`+ qty + `" class="form-control form-control-sm border-0" readonly></td>
                            <td><input type="text" value="`+ (price * qty) + `" class="total form-control form-control-sm border-0" readonly></td>
                            <td><button type="button" onclick="removeProduct(`+ product_id + `)" class="btn btn-light btn-sm">Remove</button></td>
                        </tr>`;



        $('#bill_items').append(billItems);
        $('#row_' + product_id).hide();
        itemSum();
    }

    function removeProduct(product_id) {
        $('#item_' + product_id).remove();
        $('#qty_' + product_id).val('');
        $('#row_' + product_id).show();
        itemSum();
    }

    function itemSum() {
        $('#sum').addClass('d-none');
        $('.customer-details').addClass('d-none');
        
        let sum = 0;
        $(".total").each(function () {
            sum += parseFloat($(this).val());
        });
        if (sum > 0) {
            $('.total_sum').text(sum);
            $('#sum').removeClass('d-none');
            $('.customer-details').removeClass('d-none');
        }
    }
</script>
<?php $this->endSection() ?>