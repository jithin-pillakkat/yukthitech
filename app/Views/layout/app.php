<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jithin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- data table  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</head>
<style>
    .pagination {
        --bs-pagination-active-bg: black;
        --bs-pagination-active-border-color: black;
    }

    div.dt-processing>div:last-child>div {
        background: black !important;
    }

    .form-control:focus {
        border-color: black;
        outline: 0;
        box-shadow: none;
    }

    .form-select:focus {
        border-color: black;
        outline: 0;
        box-shadow: none;
    }
</style>

<body>

    <nav class="navbar bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand text-danger fw-bold">Yukthitech</a>
            <div class="d-flex">
                <a class="btn btn-sm btn-outline-dark me-2 <?= '/' . uri_string() == route_to('bill.index') ? 'active' : '' ?>"
                    href="<?= route_to('bill.index') ?>">Bill</a>
                <a class="btn btn-sm btn-outline-dark me-2 <?= '/' . uri_string() == route_to('product.index') ? 'active' : '' ?>"
                    href="<?= route_to('product.index') ?>">Product</a>
                <button class="btn btn-sm btn-outline-dark" type="button" id="logout">Logout</button>
            </div>
        </div>
    </nav>

    <div class="container">

        <?php $this->renderSection('content') ?>

    </div>




    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <?php $this->renderSection('scripts') ?>

    <script>
        $('#logout').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to logout !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= route_to('logout') ?>";
                }
            });
        })
    </script>

</body>

</html>