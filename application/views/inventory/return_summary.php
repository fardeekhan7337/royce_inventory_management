<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Inventory','url' => 'driver_requests'],
          ['label'=>'Return Summary']
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
              getHiddenField('driver_return_filter_url',site_url('AjaxController/viewReturnSummaryDetails'));
              ?>
                    <form class="row g-3 return_summary_form" method="post" id="myForm" data-parsley-validate>
                        <div class="row mt-4">

                            <div class="col-sm-12">

                                <div class="row">
                                    <?php

                            echo getSelectField([
                              'label' => 'Driver',
                              'name' => 'driver_id',
                              'data' => $drivers,
                              'required' => false
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

                           echo getSubmitBtn('View Return Summary');

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
