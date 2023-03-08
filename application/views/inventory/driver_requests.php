<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Inventory','url' => 'driver_requests'],
          ['label'=>'Request Summary']
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
              getHiddenField('driver_request_filter_url',site_url('AjaxController/viewDriverRequestDetails'));
              ?>
                    <form class="row g-3 driver_request_form" method="post" id="myForm" data-parsley-validate>
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

                                <div class="row mt-3">

                                    <?php

                           echo getSubmitBtn('View Request Summary');

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