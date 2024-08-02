<!-- Modal -->
<div class="modal fade" id="billModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h1 class="modal-title fs-5">Generate Bill</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height:250px">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3">Search Product</h4>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="search" placeholder="Enter product name/code">
                        </div>
                        <table class="table table-bordered d-none" id="search_result">
                            <thead>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Stock</th>
                                <th scope="col" style="width:20%">Qty</th>
                                <th scope="col">Action</th>
                            </thead>
                            <tbody class="search-result">

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4 class="mb-3">Products</h4>
                        <form id="bill_item_details">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"
                        class="ci-csrf">
                        <table class="table table-bordered" id="items">
                            <thead>
                                <th>Product</th>
                                <th>Price</th>
                                <th style="width:20%">Qty</th>
                                <th style="width:20%">Total</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="bill_items">

                            </tbody>
                            <tr id="sum" class="d-none">
                                <td colspan="3" class="text-center"><strong>Total</strong></td>
                                <td class="text-center"><strong class="total_sum"></strong></td>
                                <td></td>
                            </tr>
                        </table>
                        </form>

                        <div class="card mt-4 customer-details d-none">
                            <div class="card-header">
                                Customer Details
                            </div>
                            <div class="card-body">
                                <form action="<?= route_to('products.generate.bill')?>" method="POST" id="create_form"
                                    autocomplete="off">                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                    <input type="text" class="form-control" name="name" id="name">
                                                    <div class="invalid-feedback name_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="phone" class="form-label">Phone</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                                    <input type="phone" class="form-control" name="phone" id="phone">
                                                    <div class="invalid-feedback phone_error"></div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-outline-dark mt-2" id="create">Generate Bill</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>