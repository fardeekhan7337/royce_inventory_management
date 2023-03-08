
<div class="modal fade add_stock_modal_select_" id="AddStockModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= site_url('save_stock') ?>" method="post" class="row g-3" id="myForm" data-parsley-validate>
          <div class="modal-body">

              <div class="container">

                <h3>Add Stock</h3>

                <div class="row mt-3">

                  <?php
                    echo getHiddenField('redirect_to',$redirect_to);

                    echo getSelectField([
                      'label' => 'Product',
                      'name' => 'product_id',
                      'column' => 'sm-9',
                      'classes' => 'add_stock_select_',
                      'data' => $products
                    ]);

                    echo getInputField([
                      'label' => 'Qty',
                      'type' => 'number',
                      'name' => 'qty',
                      'column' => 'sm-3',
                      'attr' => 'min="1"'
                    ]);

                  ?>

                </div>


              </div>

          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-sm btn-primary" style="text-transform:capitalize!important">Add Stock</button>
              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
  </div>
</div>
