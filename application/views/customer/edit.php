

  <h3>Edit Customer</h3>
  <div class="row mt-3">
      <div class="col-sm-12 col-lg-12">

        <form class="row g-3" action="javascript:void(0)" method="post" id="updateCustomer" data-parsley-validate enctype="multipart/form-data">
          <div class="row mt-4">

              <div class="col-sm-3">


                  <?php

                    //check image is exist in folder or not
                    if (@getimagesize(base_url('uploads/customer/'.$customer->img)) && !empty($customer->img))
                    {
                        echo getImgField([
                          'img_url' => base_url('uploads/customer/'.$customer->img)
                        ]);
                    }
                    else
                    {
                        echo getImgField();
                    }

                   ?>


              </div>
              <div class="col-sm-9 form-col-padding">
                <div class="row">

                  <?php

                    echo getHiddenField('ID',$customer->id);
                    echo getHiddenField('old_img',$customer->img);
                    echo getHiddenField('old_email',$customer->e_receipt_email);
                    echo getHiddenField('old_soa_email',$customer->soa_email);

                    echo getInputField([
                        'label' => 'Customer Name',
                        'name' => 'name',
                        'value' => form_set_value('name') != '' ?form_set_value('name'):$customer->name
                      ]);
                    echo getInputField([
                        'label' => 'Shop Name',
                        'name' => 'shop_name',
                        'value' => form_set_value('shop_name') != '' ?form_set_value('shop_name'):$customer->shop_name
                      ]);
                    echo getInputField([
                        'label' => 'Shop Acronym',
                        'name' => 'shop_acronym',
                        'value' => form_set_value('shop_acronym') != '' ?form_set_value('shop_acronym'):$customer->shop_acronym
                      ]);
                    echo getInputField([
                        'label' => 'Shop ID',
                        'name' => 'shop_id',
                        'value' => form_set_value('shop_id') != '' ?form_set_value('shop_id'):$customer->shop_id
                      ]);
                    echo getInputField([
                        'label' => 'Primary Contact',
                        'name' => 'primary_contact',
                        'value' => form_set_value('primary_contact') != '' ?form_set_value('primary_contact'):$customer->primary_contact
                      ]);
                    echo getInputField([
                        'label' => 'Secondary Contact',
                        'name' => 'secondary_contact',
                        'value' => form_set_value('secondary_contact') != '' ?form_set_value('secondary_contact'):$customer->secondary_contact,
                        'required' => false
                      ]);
                    echo getInputField([
                        'label' => 'Email Address For E-Receipt',
                        'name' => 'email',
                        'type' => 'email',
                        'value' => form_set_value('email') != '' ?form_set_value('email'):$customer->e_receipt_email,
                        'required' => false
                      ]);
                    echo getInputField([
                        'label' => 'Email Address For SOA',
                        'name' => 'soa_email',
                        'type' => 'email',
                        'value' => form_set_value('soa_email') != '' ?form_set_value('soa_email'):$customer->soa_email,
                        'required' => false
                      ]);

                    echo getSelectField([
                      'label' => 'Payment Type',
                      'name' => 'cat_type',
                      'id' => 'modal_edit_cat_type_',
                      'static' => true,
                      'data' => $cat_types,
                      'classes' => 'modal_edit_cat_type_',
                      'selected' => form_set_value('cat_type') != '' ?form_set_value('cat_type'):$customer->cat_type
                    ]);

                    echo getSelectField([
                      'label' => 'Salesperson',
                      'name' => 'salesperson_id',
                      'id' => 'modal_edit_salesperson_',
                      'data' => $salespersons,
                      'classes' => 'modal_edit_salesperson_',
                      'selected' => form_set_value('salesperson_id') != '' ?form_set_value('salesperson_id'):$customer->salesperson_id
                    ]);

                    echo getSelectField([
                      'label' => 'Assign Driver To This Customer',
                      'name' => 'driver_id',
                      'id' => 'modal_edit_assign_driver_',
                      'data' => $drivers,
                      'classes' => 'modal_edit_assign_driver_',
                      'selected' => form_set_value('driver_id') != '' ?form_set_value('driver_id'):$customer->driver_id
                    ]);

                    echo getSelectField([
                      'label' => 'Day',
                      'name' => 'day',
                      'id' => 'modal_edit_day_',
                      'static' => true,
                      'data' => $days,
                      'classes' => 'modal_edit_day_',
                      'selected' => form_set_value('day') != '' ?form_set_value('day'):$customer->day
                    ]);

                    ?>
                </div>
                <div class="row">
                  <?php

                    echo getTextareaField([
                      'label' => 'Shop Address',
                      'name' => 'address',
                      'value' => form_set_value('address') != '' ?form_set_value('address'):$customer->address,
                      'required' => false
                    ]);
                    echo getTextareaField([
                      'label' => 'Remarks',
                      'name' => 'remarks',
                      'value' => form_set_value('remarks') != '' ?form_set_value('remarks'):$customer->remarks,
                      'required' => false
                    ]);

                    echo getSubmitBtn('Update Customer');

                  ?>


                </div>
              </div>

          </div>

         </form>
      </div>
  </div>
