
<div class="modal fade create_customer_modal" id="CreateModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">

    <div class="modal-content">
        <div class="modal-body">

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="float:right!important"></button>

          <div class="container" id="create_modal_">


              <h3>Add Customer</h3>

              <div class="row mt-3">
                  <div class="col-sm-12 col-lg-12">
                    <form class="row g-3" action="javascript:void(0)" method="post" id="CreateCustomer" data-parsley-validate enctype="multipart/form-data">
                      <div class="row mt-4">

                          <div class="col-sm-3">


                              <?php

                                echo getImgField();

                               ?>


                          </div>
                          <div class="col-sm-9 form-col-padding">
                            <div class="row">

                              <?php

                                echo getInputField([
                                    'label' => 'Customer Name',
                                    'name' => 'name',
                                    'value' => form_set_value('name')
                                  ]);
                                echo getInputField([
                                    'label' => 'Shop Name',
                                    'name' => 'shop_name',
                                    'value' => form_set_value('shop_name')
                                  ]);
                                echo getInputField([
                                    'label' => 'Shop Acronym',
                                    'name' => 'shop_acronym',
                                    'value' => form_set_value('shop_acronym')
                                  ]);
                                echo getInputField([
                                    'label' => 'Shop ID',
                                    'name' => 'shop_id',
                                    'value' => form_set_value('shop_id')
                                  ]);
                                echo getInputField([
                                    'label' => 'Primary Contact',
                                    'name' => 'primary_contact',
                                    'value' => form_set_value('primary_contact')
                                  ]);
                                echo getInputField([
                                    'label' => 'Secondary Contact',
                                    'name' => 'secondary_contact',
                                    'value' => form_set_value('secondary_contact'),
                                    'required' => false
                                  ]);
                                echo getInputField([
                                    'label' => 'Email Address For E-Receipt',
                                    'name' => 'email',
                                    'type' => 'email',
                                    'value' => form_set_value('email'),
                                    'required' => false
                                  ]);
                                echo getInputField([
                                    'label' => 'Email Address For SOA',
                                    'name' => 'soa_email',
                                    'type' => 'email',
                                    'value' => form_set_value('soa_email'),
                                    'required' => false
                                  ]);

                                echo getSelectField([
                                  'label' => 'Payment Type',
                                  'name' => 'cat_type',
                                  'id' => 'modal_select_cat_type_',
                                  'static' => true,
                                  'data' => $cat_types,
                                  'classes' => 'modal_select_cat_type_',
                                  'selected' => form_set_value('cat_type')
                                ]);

                                echo getSelectField([
                                  'label' => 'Salesperson',
                                  'name' => 'salesperson_id',
                                  'id' => 'modal_select_salesperson_',
                                  'data' => $salespersons,
                                  'classes' => 'modal_select_salesperson_',
                                  'selected' => form_set_value('salesperson_id')
                                ]);

                                echo getSelectField([
                                  'label' => 'Assign Driver To This Customer',
                                  'name' => 'driver_id',
                                  'id' => 'modal_select_assign_driver_',
                                  'data' => $drivers,
                                  'classes' => 'modal_select_assign_driver_',
                                  'selected' => form_set_value('driver_id')
                                ]);

                                echo getSelectField([
                                  'label' => 'Day',
                                  'name' => 'day',
                                  'id' => 'modal_select_day_',
                                  'static' => true,
                                  'data' => $days,
                                  'classes' => 'modal_select_day_',
                                  'selected' => form_set_value('day')
                                ]);

                                ?>
                            </div>
                            <div class="row">
                              <?php

                                echo getTextareaField([
                                  'label' => 'Shop Address',
                                  'name' => 'address',
                                  'required' => false,
                                  'value' => form_set_value('address')
                                ]);
                                echo getTextareaField([
                                  'label' => 'Remarks',
                                  'name' => 'remarks',
                                  'required' => false,
                                  'value' => form_set_value('remarks')
                                ]);

                                echo getSubmitBtn('Add Customer');

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
</div>
</div>
