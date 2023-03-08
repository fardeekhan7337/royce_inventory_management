<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Inventory','url' => 'add_stock'],
          ['label'=>'Add Stock']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
              <form class="row g-3" action="<?= site_url('save_stock') ?>" method="post" id="myForm" data-parsley-validate>
                <div class="row mt-4">

                    <div class="col-sm-12">
                      <div class="row">

                        <?php

                          echo getHiddenField('redirect_to','add_stock');

                          echo getSelectField([
                            'label' => 'Product',
                            'name' => 'product_id',
                            'data' => $products
                          ]);

                          echo getInputField([
                            'label' => 'Qty',
                            'type' => 'number',
                            'name' => 'qty',
                            'column' => 'sm-3',
                            'attr' => 'min="1"'
                          ]);

                          echo getSubmitBtn('Add Stock');

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
