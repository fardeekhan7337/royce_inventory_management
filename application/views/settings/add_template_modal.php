
<div class="modal fade" id="AddTemplateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?= site_url('save_email_template') ?>" method="post" class="row g-3" id="myForm" data-parsley-validate>
          <div class="modal-body">

              <div class="container">

                <h3 id="template_action_head">Add Template</h3>

                <div class="row mt-3">

                  <div class="col-sm-12 mb-3">

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Template Commands
                                    </button>
                                </h4>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                      <div class="row">

                                        <div class="col-sm-12 p-2">

                                          <a href="javascript:void(0)">
                                            <span class="badge rounded-pill bg-primary template_commands_" data="[NAME]">Name</span>
                                          </a>
                                          <a href="javascript:void(0)">
                                            <span class="badge rounded-pill bg-primary template_commands_" data="[SHOP_NAME]">Shop Name</span>
                                          </a>
                                          <a href="javascript:void(0)">
                                            <span class="badge rounded-pill bg-primary template_commands_" data="[PRIMARY_CONTACT]">Primary Contact</span>
                                          </a>
                                          <a href="javascript:void(0)">
                                            <span class="badge rounded-pill bg-primary template_commands_" data="[SECONDARY_CONTACT]">Secondary Contact</span>
                                          </a>
                                          <a href="javascript:void(0)">
                                            <span class="badge rounded-pill bg-primary template_commands_" data="[E_RECEIPT_EMAIL]">E-Receipt Email</span>
                                          </a>
                                          <a href="javascript:void(0)">
                                            <span class="badge rounded-pill bg-primary template_commands_" data="[SOA_EMAIL]">SOA Email</span>
                                          </a>
                                          <a href="javascript:void(0)">
                                            <span class="badge rounded-pill bg-primary template_commands_" data="[SHOP_ADDRESS]">Shop Address</span>
                                          </a>
                                          <a href="javascript:void(0)">
                                            <span class="badge rounded-pill bg-primary template_commands_" data="[CURR_DATE]">Curr: Date</span>
                                          </a>

                                        </div>

                                      </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                  </div>
                  <?php

                    echo getHiddenField('ID',0);

                    echo getInputField([
                      'label' => 'Title',
                      'name' => 'title',
                      'column' => 'sm-12'
                    ]);
                    echo getInputField([
                      'label' => 'Subject',
                      'name' => 'subject',
                      'column' => 'sm-12'
                    ]);
                    echo getTextareaField([
                      'label' => 'Template',
                      'name' => 'template',
                      'column' => 'sm-12'
                    ]);

                  ?>

                </div>
              </div>

          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-sm btn-primary" style="text-transform:capitalize!important">Submit</button>
              <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
  </div>
</div>
