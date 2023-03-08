<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Call Orders','url' => 'call_order'],
          ['label'=>'Add Call Order']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
              <form class="row g-3" action="<?= site_url('save_call_order') ?>" method="post" id="myForm" data-parsley-validate>
                <div class="row mt-4">

                    <div class="col-sm-12">
                      <div class="row">

                        <div class="col-sm-12 mb-2">
                            <h5>Customer Details</h5>
                        </div>

                        <div class="col-sm-6 mb-3">

                          <label for="Customer" class="form-label">Customer</label>

                          <select class="form-select form-select-sm select2" data-width="100%" name="customer_id" id="customer_id" required>

                            <option value="">select</option>
                            <?php foreach ($customers as $key => $v): ?>

                              <option value="<?= $v->id ?>"><?= $v->name.'-'.$v->shop_name.'-'.$v->shop_acronym ?></option>

                            <?php endforeach; ?>
                          </select>

                        </div>
                        <?php

                        echo getInputField([
                          'label' => 'Customer Name',
                          'id' => 'customer_name_',
                          'attr' => 'readonly'
                        ]);

                        echo getInputField([
                          'label' => 'Shop Acronym',
                          'id' => 'customer_shop_acronym_',
                          'attr' => 'readonly'
                        ]);

                        echo getInputField([
                          'label' => 'Contact #',
                          'id' => 'customer_cno_',
                          'attr' => 'readonly'
                        ]);

                        echo getInputField([
                          'label' => 'Email',
                          'id' => 'customer_email_',
                          'type' => 'email',
                          'attr' => 'readonly'
                        ]);

                        echo getInputField([
                          'label' => 'Address',
                          'id' => 'customer_addr_',
                          'attr' => 'readonly'
                        ]);

                        ?>

                        <div class="col-sm-12 mb-2">
                            <h5>Assign to Driver</h5>
                        </div>
                        <?php

                        echo getSelectField([
                          'label' => 'Driver',
                          'name' => 'driver_id',
                          'data' => $drivers,
                          'column' => 'sm-6'
                        ]);
                        echo getSelectField([
                          'label' => 'Day',
                          'name' => 'day',
                          'column' => 'sm-6',
                          'static' => true,
                          'data' => $days
                        ]);

                          ?>

                      </div>
                      <div id="call_order_products_">

                        <div class="row">

                          <div class="col-sm-12 mb-2">
                              <h5>Stock Details</h5>
                          </div>
                          <?php

                          echo getSelectField([
                            'label' => 'Product',
                            'name' => 'product_id[]',
                            'classes' => 'product_id_',
                            'data' => $products
                          ]);

                          echo getInputField([
                            'label' => 'Qty',
                            'type' => 'number',
                            'name' => 'qty[]',
                            'column' => 'sm-5',
                            'classes' => 'qty_',
                            'attr' => 'min="1"'
                          ]);

                          ?>

                        </div>

                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <a href="javascript:void(0)" class="add_call_order_products_">
                            + Add Row
                          </a>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">

                      <?php
                        
                        echo getTextareaField([
                            'label' => 'Comment',
                            'name' => 'order_comment',
                            'column' => 'sm-12',
                            'required' => false
                            ]);
                      echo getSubmitBtn('Add Call Order');

                      ?>

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
