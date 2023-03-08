<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Sales','url' => 'sales'],
          ['label'=>'Add Call Order Sale']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
               <span id="total_unpaid_inv"></span>
            </div>
            <div class="card-body">
              <?php
                echo getHiddenField('sale_action','create');
                echo getHiddenField('total_products',0);
                echo getHiddenField('save_sale',site_url('Sales/save_call_order_sale'));
                echo getHiddenField('show_details',site_url('AjaxController/showSalesDetails'));
              ?>
                <form class="row g-3" action="javascript:void(0)" method="post" id="save_sale" data-parsley-validate>
                <div class="row mt-4">

                    <div class="col-sm-12">
                      <div class="row">

                        <?php

                          echo getHiddenField('customer_category');

                          ?>

                          <div class="col-sm-4 mb-3">

                            <label for="Customer" class="form-label">Customer</label>

                            <select class="form-select form-select-sm select2" data-width="100%" name="customer_id" id="sale_customer_id" required>

                              <option value="">select</option>
                              <?php foreach ($customers as $key => $v): ?>

                                <option value="<?= $v->id ?>"><?= $v->name.'-'.$v->shop_name.'-'.$v->shop_acronym ?></option>

                              <?php endforeach; ?>
                            </select>

                          </div>

                        <div class="col-md-8">
                          <label for="Customer Remarks" class="form-label customer_remarks_col" style="display:none;">Customer Remarks</label>
                          <p id="customer_remarks"></p>
                        </div>

                        <?php

                          echo getSelectField([
                            'label' => 'Customer Paying?',
                            'name' => 'is_customer_pay',
                            'id' => 'is_customer_pay',
                            'column' => 'sm-4',
                            'static' => true,
                            'data' => ['Yes','No']
                          ]);

                          echo getSelectField([
                            'label' => 'Payment Type',
                            'name' => 'payment_type',
                            'classes' => 'payment_type',
                            'column' => 'sm-4',
                            'col_classes' => 'payment_type_col',
                            'static' => true,
                            'data' => ['Cash','Cheque','Bank']
                          ]);

                          echo getInputField([
                            'label' => 'Reason',
                            'name' => 'reason',
                            'column' => 'sm-8',
                            'col_classes' => 'reason_col',
                            'required' => false
                          ]);

                        ?>
                      </div>

                      <div class="row">

                        <?php

                          echo getInputField([
                            'label' => 'Bank Name',
                            'name' => 'bank_name',
                            'id' => 'bank_name',
                            'column' => 'sm-4',
                            'col_classes' => 'bank_name_col',
                            'required' => false
                          ]);
                          echo getInputField([
                            'label' => 'Account Number',
                            'name' => 'acc_no',
                            'id' => 'acc_no',
                            'column' => 'sm-4',
                            'col_classes' => 'acc_no_col',
                            'required' => false
                          ]);
                          echo getInputField([
                            'label' => 'Cheque No',
                            'name' => 'cheque_no',
                            'id' => 'cheque_no',
                            'column' => 'sm-4',
                            'col_classes' => 'cheque_no_col',
                            'required' => false
                          ]);

                         ?>

                      </div>

                      <div id="showCustomerSaleProducts_">

                      </div>

                      <div class="row mt-1 mb-1">


                        <?php

                          echo getSubmitBtn('Add Call Order Sale');

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
