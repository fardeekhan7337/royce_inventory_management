<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Sales','url' => 'sales'],
          ['label'=>'Edit Sale']
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

                echo getHiddenField('remove_sale_products_url',site_url('AjaxController/add_removed_sale_products'));
                echo getHiddenField('sale_action','update');

                echo getHiddenField('total_products',count($sales_details));

                if(isset($sale->sale_type) && $sale->sale_type == 'call_order')
                {

                  echo getHiddenField('save_sale',site_url('Sales/save_call_order_sale'));
                }
                else
                {
                  echo getHiddenField('save_sale',site_url('Sales/save_sale'));

                }
                echo getHiddenField('show_details',site_url('AjaxController/showSalesDetails'));
               ?>
                    <form class="row g-3" action="javascript:void(0)" method="post" id="save_sale"
                        data-parsley-validate>
                        <div class="row mt-4">

                            <div class="col-sm-12">
                                <div class="row">

                                    <?php

                          echo getHiddenField('ID',$sale->id);
                          echo getHiddenField('customer_category',$sale->customer_category);
                          echo getHiddenField('total_amount',$sale->total_amount);
                          echo getHiddenField('main_id',$sale->main_id);

                          echo getHiddenField('customer_id',$sale->customer_id);

                          echo getInputField([
                            'label' => 'Customer',
                            'attr' => 'readonly',
                            'column' => 'sm-4',
                            'value' => $v->customer_address.'-'.$v->customer_shop_name.'-'.$v->customer_shop_acronym

                          ]);

                          ?>

                                    <div class="col-md-8">
                                        <label for="Customer Remarks" class="form-label">Customer Remarks</label>
                                        <p id="customer_remarks"><?= $sale->customer_remarks ?></p>
                                    </div>

                                    <?php

                          echo getSelectField([
                            'label' => 'Customer Paying?',
                            'name' => 'is_customer_pay',
                            'id' => 'is_customer_pay',
                            'column' => 'sm-4',
                            'static' => true,
                            'data' => ['Yes','No'],
                            'selected' => $sale->is_pay == 0?'No':'Yes'
                          ]);

                          $select_pay_type = '';

                          if($sale->pay_type == 'Cash')
                          {
                            $select_pay_type = 'Cash';
                          }
                          elseif ($sale->pay_type == 'Cheque')
                          {
                            $select_pay_type = 'Cheque';
                          }
                          elseif ($sale->pay_type == 'Bank')
                          {
                            $select_pay_type = 'Bank';
                          }

                          echo getSelectField([
                            'label' => 'Payment Type',
                            'name' => 'payment_type',
                            'classes' => 'payment_type',
                            'column' => 'sm-4',
                            'col_classes' => 'payment_type_col',
                            'static' => true,
                            'data' => ['Cash','Cheque','Bank'],
                            'selected' => $select_pay_type,
                            'col_attr' => $sale->is_pay == 0?'':'style="display:block;"',
                            'required' => $sale->is_pay == 0?false:''
                          ]);

                          echo getInputField([
                            'label' => 'Reason',
                            'name' => 'reason',
                            'column' => 'sm-8',
                            'col_classes' => 'reason_col',
                            'required' => false,
                            'value' => $sale->reason,
                            'col_attr' => $sale->is_pay == 0?'style="display:block;"':''
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
                            'value' => $sale->bank,
                            'required' => false
                          ]);
                          echo getInputField([
                            'label' => 'Account Number',
                            'name' => 'acc_no',
                            'id' => 'acc_no',
                            'column' => 'sm-4',
                            'col_classes' => 'acc_no_col',
                            'value' => $sale->acc_no,
                            'required' => false
                          ]);
                          echo getInputField([
                            'label' => 'Cheque No',
                            'name' => 'cheque_no',
                            'id' => 'cheque_no',
                            'column' => 'sm-4',
                            'col_classes' => 'cheque_no_col',
                            'value' => $sale->cheque_no,
                            'required' => false
                          ]);

                         ?>

                                </div>

                                <div id="showCustomerSaleProducts_">
                                    <?php if (isset($sale->sale_type) && $sale->sale_type == 'call_order'): ?>

                                    <?php foreach ($sales_details as $key => $v): ?>

                                    <?php if ($v->qty != 0): ?>

                                    <div class="row">

                                        <?php

                            echo getHiddenField('product_id[]',$v->product_id);
                            echo getHiddenField('price[]',$v->price,'price_');

                            echo getInputField([
                              'label' => 'Product',
                              'value' => $v->product_name,
                              'column' => 'sm-4',
                              'attr' => 'readonly'
                            ]);

                            echo getInputField([
                              'label' => 'Available Qty',
                              'name' => 'available_qty[]',
                              'column' => 'sm-2',
                              'classes' => 'available_qty_',
                              'attr' => 'readonly',
                              'value' => $v->qty
                            ]);

                            echo getInputField([
                              'label' => 'Sale Qty',
                              'name' => 'sale_qty[]',
                              'column' => 'sm-2',
                              'classes' => 'sale_qty_',
                              'value' => $v->sale_qty
                            ]);

                            echo getHiddenField('exchange_qty[]',0,'exchange_qty_');

                            echo getInputField([
                              'label' => 'Foc Qty',
                              'name' => 'foc_qty[]',
                              'column' => 'sm-2',
                              'classes' => 'foc_qty_',
                              'value' => $v->foc_qty
                            ]);

                            echo getInputField([
                              'label' => 'Total',
                              'name' => 'total[]',
                              'column' => 'sm-2',
                              'classes' => 'total_qty_',
                              'attr' => 'readonly,min="'. $v->qty .'",max="'.$v->qty.'"',
                              'value' => $v->sale_qty + $v->foc_qty

                            ]);

                            echo getHiddenField('amount[]',$v->amount,'amount_');

                            ?>

                                    </div>

                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php else: ?>

                                    <div class="row mb-3">
                                        <div class="col-sm-8"></div>
                                        <div class="col-sm-4">
                                            <label for="Add_Remove_Products" class="form-label">Add Remove
                                                Products</label>
                                            <select class="form-select form-select-sm select2 remove_sale_products_"
                                                data-width="100%" name="remove_products_">
                                                <option value="">select</option>
                                                <?php if (!empty($removed_products)): ?>

                                                <?php foreach ($removed_products as $key => $v): ?>

                                                <?php if ($v['available_qty'] != 0): ?>

                                                <option data-PID="<?= $v['product_id'] ?>"
                                                    data-PNAME="<?= $v['product_name'] ?>"
                                                    data-Qty="<?= $v['available_qty'] ?>"
                                                    data-price="<?= $v['product_price'] ?>"><?= $v['product_name'] ?>
                                                </option>

                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>


                                    <?php foreach ($sales_details as $key => $v): ?>

                                    <?php if ($v->available_qty != 0): ?>

                                    <div class="row">

                                        <?php

                              $pclr = 'style="color:'. $v->product_color .'"';

                              echo getHiddenField('product_id[]',$v->product_id);
                              echo getHiddenField('price[]',$v->price,'price_');

                              echo getInputField([
                                'label' => 'Product',
                                'custom_label' => '<a href="javascript:void(0)" class="remove_customer_sale_product" data-PID="'. $v->product_id .'" data-PNAME="'. $v->product_name .'" data-Qty="'. $v->available_qty. '" data-price="'. $v->price .'">
                                    <i class="fa-solid fa-x" style="font-size: 15px;color:#fd6262!important;"></i>
                                  </a>',
                                'value' => $v->product_name,
                                'column' => 'sm-4',
                                'attr' => 'readonly,'.$pclr
                              ]);
                              echo getInputField([
                                'label' => 'Available Qty',
                                'name' => 'available_qty[]',
                                'column' => 'sm-2',
                                'col_classes' => '',
                                'classes' => 'available_qty_',
                                'attr' => 'readonly',
                                'value' => $v->available_qty
                              ]);
                              echo getInputField([
                                'label' => 'Sale Qty',
                                'name' => 'sale_qty[]',
                                'column' => 'sm-2',
                                'col_classes' => '',
                                'classes' => 'sale_qty_',
                                'value' => $v->sale_qty
                              ]);
                              echo getInputField([
                                'label' => 'Exchange Qty',
                                'name' => 'exchange_qty[]',
                                'column' => 'sm-2',
                                'col_classes' => '',
                                'classes' => 'exchange_qty_',
                                'value' => $v->exchange_qty
                              ]);
                              echo getInputField([
                                'label' => 'Foc Qty',
                                'name' => 'foc_qty[]',
                                'column' => 'sm-2',
                                'col_classes' => '',
                                'classes' => 'foc_qty_',
                                'value' => $v->foc_qty
                              ]);
                              echo getInputField([
                                'label' => 'Total',
                                'name' => 'total[]',
                                'column' => 'sm-2',
                                'col_classes' => '',
                                'classes' => 'total_qty_',
                                'attr' => 'readonly,max="'.$v->available_qty.'"',
                                'value' => $v->sale_qty + $v->exchange_qty + $v->foc_qty

                              ]);

                              echo getHiddenField('amount[]',$v->amount,'amount_');

                              ?>

                                        <!-- <div class="col-sm-1" style="padding:0px!important;width:1.333333%!important;">
                                <a href="javascript:void(0)" class="remove_customer_sale_product">
                                  <i class="fa-solid fa-x" style="font-size: 20px;margin-top: 38px;margin-left:8px;;color:#fd6262!important;"></i>
                                </a>
                              </div> -->

                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; ?>

                                    <?php endif; ?>

                                </div>

                                <div class="row mt-1 mb-1">

                                    <?php

                          echo getSubmitBtn('Update Sale');

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
