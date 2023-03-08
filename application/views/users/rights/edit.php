<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Users','url' => 'rights'],
          ['label'=>'Rights','url' => 'rights'],
          ['label'=>'Edit Rights']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
              <form  action="<?= site_url('save_rights') ?>" class="row g-3" method="post" id="myForm" data-parsley-validate>

                <?= getHiddenField('type',$type); ?>

                <div class="row mt-4">

                    <div class="col-sm-12 mb-3">

                          <div class="accordion" id="accordionExample">

                              <?php foreach ($modules as $key => $v): ?>

                              <div class="accordion-item">
                                  <h4 class="accordion-header" id="headingOne<?= $v->id ?>">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?= $v->id ?>" aria-expanded="true" aria-controls="collapseOne<?= $v->id ?>">
                                          <?= $v->name ?>
                                      </button>
                                  </h4>
                                  <div id="collapseOne<?= $v->id ?>" class="accordion-collapse collapse" aria-labelledby="headingOne<?= $v->id ?>" data-bs-parent="#accordionExample">
                                      <div class="accordion-body">

                                        <?php foreach ($roles[$key] as $k => $val): ?>

                                        <div class="row">

                                          <div class="col-sm-11">

                                            <p><i class="fa-solid fa-star"></i> <?= $val->name ?></p>

                                          </div>

                                          <div class="col-sm-1 text-center">
                                            <div class="form-check form-switch form-check-inline">
                                              <?= getHiddenField('row_id[]',$val->id); ?>
                                                <input class="form-check-input" type="checkbox" id="switch1" name="role_id[<?= $val->id ?>]" <?= (isset($val->is_allow) &&  $val->is_allow == 1?'checked':'') ?> />
                                                <label class="form-check-label pl-2" for="switch1"></label>
                                            </div>
                                          </div>

                                        </div>

                                        <?php endforeach; ?>

                                      </div>
                                  </div>
                              </div>

                              <?php endforeach; ?>

                          </div>


                    </div>

                    <?=

                    getSubmitBtn('Update Rights');

                    ?>
                </div>

               </form>
            </div>
         </div>
      </div>
   </div>
</div>
