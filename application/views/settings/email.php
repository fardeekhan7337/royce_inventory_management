<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Setting','url' => 'email_setting'],
          ['label'=>'Email Setting']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
                <div class="row mt-4">

                    <div class="col-sm-12">

                      <ul class="nav nav-pills" data-toggle="slider-tab" id="myTab" role="tablist">
                          <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#pills-home1" type="button" role="tab" aria-controls="home" aria-selected="true">General</button>
                          </li>
                          <li class="nav-item" role="presentation">
                              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#pills-profile1" type="button" role="tab" aria-controls="profile" aria-selected="false">Templates</button>
                          </li>
                      </ul>
                      <div class="tab-content" id="pills-tabContent">
                          <div class="tab-pane fade show active" id="pills-home1" role="tabpanel"
                              aria-labelledby="pills-home-tab1">

                             <form action="<?= site_url('save_general_setting') ?>" method="post" class="row g-3 needs-validation" novalidate>

                                <h4 class="mt-4 mb-2">General</h4>

                                <div class="row pb-2 pt-4">

                                  <div class="col-sm-11">
                                    <span class="text-dark">Invoice should be sent Automatically on Email?</span>
                                    <br /><br />
                                    <span class="text-muted">When checked the Invoices will be sent Automatically when a new Sale is Completed (marked as done).</span>
                                  </div>
                                  <div class="col-sm-1">
                                      <div class="form-check form-check-inline">
                                         <input type="checkbox" name="is_invoice_sent_on_mail" class="form-check-input" id="customCheck5" <?= isset($is_invoice_sent_on_mail->value) && $is_invoice_sent_on_mail->value == 'yes'?'checked':'' ?>>
                                      </div>
                                  </div>

                                </div>
                                <hr>

                                <div class="row pb-2 pt-4">

                                  <div class="col-sm-11">
                                    <span class="text-dark">Invoice should be sent Automatically on Whatsapp?</span>
                                    <br /><br />
                                    <span class="text-muted">When checked the Invoices will be sent Automatically on Whatsapp when a new Sale is Completed (marked as done).</span>
                                  </div>
                                  <div class="col-sm-1">
                                      <div class="form-check form-check-inline">
                                         <input type="checkbox" name="is_invoice_sent_on_whatsapp" class="form-check-input" id="customCheck5" <?= isset($is_invoice_sent_on_whatsapp->value) && $is_invoice_sent_on_whatsapp->value == 'yes'?'checked':'' ?>>
                                      </div>
                                  </div>

                                </div>
                                <hr>

                                <div class="row pb-2 pt-4">

                                  <div class="col-sm-8">
                                    <span class="text-dark">Recurring Email Timespan </span>
                                    <br />
                                    <br />
                                    <span class="text-muted">Recurring Email means the selected Customers will receive Email Message according to your setting with their Payment details.</span>
                                  </div>
                                  <div class="col-sm-4">

                                      <div class="row">

                                          <?php

                                            echo getSelectField([
                                              'name' => 'sending_type',
                                              'column' => 'sm-6',
                                              'static' => true,
                                              'classes' => 'sending_type',
                                              'data' => $recurring_timespan,
                                              'required' => false,
                                              'selected' => isset($recurring_send->send_type)?$recurring_send->send_type:''
                                            ]);

                                            $send_day = '';
                                            $send_day_date = '';
                                            if (isset($recurring_send->send_type))
                                            {

                                              if($recurring_send->send_type == 'Monthly')
                                              {

                                                $send_day = 'style="display:none"';

                                              }
                                              else if($recurring_send->send_type == 'Weekly')
                                              {

                                                $send_day_date = 'style="display:none"';

                                              }
                                              else
                                              {

                                                $send_day_date = 'style="display:none"';
                                                $send_day = 'style="display:none"';

                                              }

                                            }
                                            echo getSelectField([
                                              'name' => 'sending_day',
                                              'column' => 'sm-6',
                                              'static' => true,
                                              'col_classes' => 'sending_day',
                                              'data' => $days,
                                              'required' => false,
                                              'col_attr' => $send_day,
                                              'selected' => isset($recurring_send->send_on)?$recurring_send->send_on:''
                                            ]);

                                            echo getSelectField([
                                              'name' => 'sending_day_date',
                                              'col_classes' => 'sending_day_date',
                                              'static' => true,
                                              'column' => 'sm-6',
                                              'required' => false,
                                              'data' => $dates,
                                              'col_attr' => $send_day_date,
                                              'selected' => isset($recurring_send->send_on)?$recurring_send->send_on:''
                                            ]);

                                          ?>

                                      </div>

                                  </div>

                                </div>
                                <hr>
                                <div class="row pb-2 pt-4">

                                  <div class="col-sm-10">
                                    <span class="text-dark">Invoice email template</span>
                                    <br /><br />
                                    <span class="text-muted">The selected template will be used when an Invoice is Automatically sent to the Customer.</span>
                                  </div>
                                  <div class="col-sm-2">
                                    <div class="row">
                                      <?php

                                        echo getSelectField([
                                          'name' => 'invoice_template',
                                          'column' => 'sm-12',
                                          'data' => $templates,
                                          'required' => false,
                                          'selected' => isset($invoice_temp->value)?$invoice_temp->value:''
                                        ]);

                                      ?>
                                    </div>
                                  </div>

                                </div>
                                <hr>
                                <div class="row pb-2 pt-4">

                                  <div class="col-sm-10">
                                    <span class="text-dark">Whatsapp template</span>
                                    <br /><br />
                                    <span class="text-muted">The selected template will be used when an Invoice is Automatically sent to the Customer on Whatsapp.</span>
                                  </div>
                                  <div class="col-sm-2">
                                    <div class="row">
                                      <?php

                                        echo getSelectField([
                                          'name' => 'whatsapp_template',
                                          'column' => 'sm-12',
                                          'data' => $templates,
                                          'required' => false,
                                          'selected' => isset($whatsapp_temp->value)?$whatsapp_temp->value:''
                                        ]);

                                      ?>
                                    </div>
                                  </div>

                                </div>
                                <hr>
                                <div class="row pb-2 pt-4">

                                  <div class="col-sm-10">
                                    <span class="text-dark">Recurring email template</span>
                                  </div>
                                  <div class="col-sm-2">
                                    <div class="row">
                                      <?php

                                        echo getSelectField([
                                          'name' => 'recurring_template',
                                          'column' => 'sm-12',
                                          'data' => $templates,
                                          'required' => false,
                                          'selected' => isset($recurr_temp->value)?$recurr_temp->value:''
                                        ]);

                                      ?>
                                    </div>
                                  </div>

                                </div>

                                <div class="row mb-2">

                                  <div class="col-sm-12">

                                    <h4 class="mt-4 mb-2">Recurring Email Receipients</h4>

                                  </div>

                                </div>

                                <div class="row">

                                  <?php
                                  function checkRecurringCustomer($arr , $id)
                                  {
                                      $is_selected = false;
                                      foreach ($arr as $key => $v)
                                      {

                                          if($v->customer_id == $id)
                                          {

                                            $is_selected = true;

                                            break;

                                          }

                                      }

                                      return $is_selected;

                                  } ?>

                                  <div class="col-sm-5 mb-3">
                                    <label for="customer_" class="form-label">Recurring Customers</label>
                                    <select class="form-select form-select-sm select2" data-width="100%" name="customer_ids[]" multiple="multiple">
                                      <option value="" disabled>Select customers</option>

                                      <?php foreach ($customers as $key => $v): ?>

                                        <?php if (checkRecurringCustomer($recurr_customers,$v->id)): ?>

                                          <option value="<?= $v->id ?>" selected><?= $v->name ?></option>

                                          <?php else: ?>

                                            <option value="<?= $v->id ?>"><?= $v->name ?></option>

                                        <?php endif; ?>

                                      <?php endforeach; ?>
                                    </select>
                                  </div>

                                </div>

                                <div class="row" id="email_general_setting_save_btn" style="margin:0px!important;padding:0px!important;margin-top:20px!important;">

                                  <?php

                                    echo getSubmitBtn('Save');

                                  ?>

                                </div>

                            </form>

                          </div>
                          <div class="tab-pane fade" id="pills-profile1" role="tabpanel"
                              aria-labelledby="pills-profile-tab1">

                              <div class="row">

                                <div class="col-sm-12 mb-3">

                                     <a href="javascript:void(0)" id="add_template_" data-head="Add Template" class="btn btn-sm btn-primary" style="float:right!important">Add Template</a>

                                </div>
                                <div class="col-sm-12">
                                  <?=
                                  getHiddenField('ajax_url',$ajax_url);
                                  ?>
                                  <div class="table-responsive">
                                 <table id="myDataTable" class="table" style="width:100%;">
                                    <thead>
                                       <tr>
                                          <th>#</th>
                                          <th class="dnr">Actions</th>
                                          <th>Title</th>
                                          <th>Subject</th>
                                          <th>Template</th>
                                       </tr>
                                    </thead>
                                    <tbody></tbody>
                                 </table>
                              </div>

                                </div>
                              </div>
                          </div>
                      </div>

                    </div>
                </div>

            </div>
         </div>
      </div>
   </div>
</div>



<?php
include(APPPATH.'views/modals/delete-modal.php');
include(APPPATH.'views/settings/add_template_modal.php');
?>
