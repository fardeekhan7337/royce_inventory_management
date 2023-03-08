
<div class="modal fade assign_modal_select_" id="AssignStockToDriverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
        <form class="row g-3" method="post" action="<?= site_url('save_assign_to_driver') ?>" id="myForm" data-parsley-validate>
          <div class="modal-body">

              <div class="container">

                <h3>Assign Stock To Driver</h3>

                <div class="row mt-3">

                  <?php

                    echo getHiddenField('redirect',$redirect_to);

                    echo getSelectField([
                      'label' => 'Driver',
                      'name' => 'driver_id',
                      'column' => 'sm-8',
                      'classes' => 'modal_select_assign_',
                      'id' => 'modal_driver_id',
                      'data' => $drivers
                    ]);

                  ?>

                </div>
                <div id="assign_products_to_driver_modal">

                  <div class="row">
                    <?php

                      echo getSelectField([
                        'label' => 'Product',
                        'name' => 'product_id[]',
                        'column' => 'sm-8',
                        'classes' => 'modal_select_assign_,product_id_',
                        'data' => $products
                      ]);

                      echo getInputField([
                        'label' => 'Qty',
                        'type' => 'number',
                        'name' => 'qty[]',
                        'column' => 'sm-3',
                        'attr' => 'min="1"',
                        'classes' => 'qty_'
                      ]);

                    ?>

                  </div>

                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <a href="javascript:void(0)" class="add_assign_products_to_driver_from_modal">
                      + Add Row
                    </a>
                  </div>
                </div>
              </div>

          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-sm btn-success" style="text-transform:capitalize!important">Assign Stock</button>
              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
  </div>
</div>

<div class="getProductOptionsToAssign" style="display:none!important">

    <option value="">select</option>
    <?php foreach ($products as $key => $v): ?>
      <option value="<?= $v->id ?>"><?= $v->name ?></option>
    <?php endforeach; ?>

</div>
