<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Inventory','url' => 'goods_return'],
          ['label'=>'Goods Return']
        ])
        ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h3 class="card-title"><?= $page_head ?></h3>
                    </div>
                </div>
                <div class="card-body">

                    <form class="row g-3 driver_request_form" action="<?= site_url('save_goods_return') ?>"
                        method="post" id="myForm" data-parsley-validate>
                        <div class="row mt-4">

                            <div class="col-sm-12">

                                <div class="row">

                                    <div class="col-sm-6 mb-3">

                                        <label for="Customer" class="form-label">Customer</label>

                                        <select class="form-select form-select-sm select2" data-width="100%"
                                            name="customer_id" id="sale_customer_id" required>

                                            <option value="">select</option>
                                            <?php foreach ($customers as $key => $v): ?>

                                            <option value="<?= $v->id ?>">
                                                <?= '*'.$v->address.'-'.$v->shop_name.'-'.$v->shop_acronym ?></option>

                                            <?php endforeach; ?>
                                            <?php foreach ($not_assigned_customers as $key => $v): ?>

                                            <option value="<?= $v->id ?>">
                                                <?= $v->address.'-'.$v->shop_name.'-'.$v->shop_acronym ?></option>

                                            <?php endforeach; ?>
                                        </select>

                                    </div>
                                </div>
                                <div id="return_products_to_driver">
                                    <div class="row mygood_return">
                                        <?php
                                            
                                        echo getSelectField([
                                        'label' => 'Product',
                                        'name' => 'product_id[]',
                                        'data' => $products,
                                        'id' => 'product_id',
                                        'option_color' => true,
                                        ]);

                                        echo getInputField([
                                        'label' => 'Qty',
                                        'type' => 'number',
                                        'column' => 'sm-2',
                                        'name' => 'qty[]',
                                        'attr' => 'min="1"',
                                        ]); 
                                          
                                    ?>




                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-sm-12">
                                        <a href="javascript:void(0)" class="add_return_products_to_driver">
                                            + Add Row
                                        </a>
                                    </div>
                                </div>

                                <div class="row mt-3">

                                    <?php

                           echo getSubmitBtn('Return Goods');

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


<div class="getProductOptionsToReturn" style="display:none!important">

    <option value="">select</option>
    <?php foreach ($products as $key => $v): ?>
    <option value="<?= $v->id ?>"><?= $v->name ?></option>
    <?php endforeach; ?>

</div>