<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0"
    style=" padding-top: 80px !important; background: #e9ecef !important">
    <div class="row">
        <div class="col-sm-12">
            <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Products']
        ])
        ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">

                        <h4 class="card-title"><?= $page_head ?></h4>
                    </div>
                    <?php
               echo getHiddenField('ajax_url',$ajax_url);
               echo getHiddenField('saveProduct',base_url('Product/saveProduct'));
               echo getHiddenField('edit_product',site_url('Product/editProduct'));
               echo getHiddenField('getCategoryPrice',base_url('AjaxController/getCategoryPrice'));
               ?>

                    <?php if (isUserAllow(26)): ?>

                    <a href="javascript:void(0)" id="create_product" class="btn btn-sm btn-primary">Add Product</a>
                    <?php endif; ?>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2 mb-3">

                            <label for="pageList" class="form-label">Page No#</label>

                            <select class="form-select form-select-sm select2" data-width="100%" name="pageList"
                                id="pageList">
                            </select>

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="myDataTable" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="dnr">Actions</th>
                                    <th style="width:60%!important">Product</th>
                                    <th style="width:60%!important">Product Category</th>
                                    <th>Product Code</th>
                                    <th>SKU</th>
                                    <th>Color</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include(APPPATH.'views/product/modals/create_modal.php');
include(APPPATH.'views/product/modals/edit_modal.php');
include(APPPATH.'views/modals/delete_ajax_modal.php');
include(APPPATH.'views/modals/view-details-modal.php');
 ?>