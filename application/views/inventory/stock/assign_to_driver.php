<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Inventory','url' => 'assign_to_driver'],
          ['label'=>'Assign Stock To Driver']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
              <form class="row g-3" method="post" action="<?= site_url('save_assign_to_driver') ?>" id="myForm" data-parsley-validate>
                <div class="row mt-4">

                    <div class="col-sm-12">
                      <div class="row mb-3">

                        <?php

                          echo getHiddenField('redirect','assign_to_driver');

                          echo getSelectField([
                            'label' => 'Driver',
                            'name' => 'driver_id',
                            'column' => 'sm-5',
                            'id' => 'driver_id',
                            'data' => $drivers
                          ]);
                          ?>
                      </div>
                      <div id="assign_products_to_driver">

                        <div class="row">
                          <?php

                            echo getSelectField([
                              'label' => 'Product',
                              'name' => 'product_id',
                              'column' => 'sm-5',
                              'classes' => 'product_id_',
                              'data' => $products
                            ]);

                            echo getInputField([
                              'label' => 'Qty',
                              'type' => 'number',
                              'name' => 'qty',
                              'classes' => 'qty_',
                              'attr' => 'min="1"',
                              'column' => 'sm-2'
                            ]);

                          ?>

                        </div>

                      </div>
                      <div class="row mb-5">
                        <div class="col-sm-12">
                          <a href="javascript:void(0)" class="add_assign_products_to_driver">
                            + Add Row
                          </a>
                        </div>
                      </div>
                      <div class="row">
                        <?php

                          echo getSubmitBtn('Assign To Driver');

                        ?>


                      </div>
                    </div>

                </div>

               </form>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="getProductOptionsToAssign" style="display:none!important">

    <option value="">select</option>
    <?php foreach ($products as $key => $v): ?>
      <option value="<?= $v->id ?>"><?= $v->name ?></option>
    <?php endforeach; ?>

</div>
