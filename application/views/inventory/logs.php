<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Inventory','url' => 'logs'],
          ['label'=>'Logs']
        ])
        ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h3 class="card-title"><?= $page_head ?></h3>
                    </div>
                </div>
                <div class="card-body">
                    <?=
              getHiddenField('logs_filter_url',site_url('AjaxController/viewLogDetails'));
              ?>
                    <form class="row g-3 logs_form" method="post" id="myForm" data-parsley-validate>
                        <div class="row mt-4">

                            <div class="col-sm-12">

                                <div class="row">

                                    <div class="col-sm-6 mb-3">

                                        <label for="Customer" class="form-label">Customer</label>

                                        <select class="form-select form-select-sm select2" data-width="100%"
                                            name="customer_id" id="customer_id">

                                            <option value="">select</option>
                                            <?php foreach ($customers as $key => $v): ?>

                                            <option value="<?= $v->id ?>">
                                                <?= '*'.$v->address.'-'.$v->shop_name.'-'.$v->shop_acronym ?></option>

                                            <?php endforeach; ?>

                                        </select>

                                    </div>

                                </div>
                                <div class="row">
                                    <?php

                            echo getSelectField([
                              'label' => 'Driver',
                              'name' => 'driver_id',
                              'id' => 'driver_id',
                              'data' => $drivers,
                              'required' => false,
                              'attr' => 'multiple="multiple"',
                              'is_first_option' => false,
                            ]);
                          ?>
                                </div>
                                <div class="row">

                                    <?php


                                    echo getSelectField([
                                    'label' => 'Product',
                                    'name' => 'product_id[]',
                                    'id' => 'product_id',
                                    'data' => $products,
                                    'required' => false,
                                    'attr' => 'multiple="multiple"',
                                    'is_first_option' => false,
                                    ]);
                                    ?>
                                </div>
                                <div class="row">
                                    <?php

                          echo getSelectField([
                            'label' => 'Type',
                            'name' => 'type',
                            'id' => 'type_',
                            'data' => $type_arr,
                            'required' => false,
                            'attr' => 'multiple="multiple"',
                            'is_first_option' => false,
                          ]);

                          ?>
                                </div>
                                <div class="row">
                                    <?php

                          echo getSelectField([
                            'label' => 'Export',
                            'name' => 'export_type',
                            'id' => 'export_type',
                            'static' => true,
                            'data' => ['Print','Excel'],
                            'selected' => 'Print'
                          ]);

                          ?>
                                </div>
                                <div class="row">
                                    <?php
                          echo getInputField([
                            'label' => 'From',
                            'type' => 'date',
                            'name' => 'from',
                            'column' => 'sm-3'
                          ]);
                          echo getInputField([
                            'label' => 'To',
                            'type' => 'date',
                            'name' => 'to',
                            'column' => 'sm-3'
                          ]);
                          ?>
                                </div>
                                <div class="row mt-3">

                                    <?php

                           echo getSubmitBtn('View Logs');

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
