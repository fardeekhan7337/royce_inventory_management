<div class="row mt-4">

    <div class="col-sm-12 mb-3">

          <div class="accordion" id="accordionExample">

              <?php foreach ($product_categories as $key => $v): ?>

              <div class="accordion-item">
                  <h4 class="accordion-header" id="headingOne<?= $v->id ?>">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?= $v->id ?>" aria-expanded="true" aria-controls="collapseOne<?= $v->id ?>">
                          <?= $v->name ?>
                      </button>
                  </h4>
                  <div id="collapseOne<?= $v->id ?>" class="accordion-collapse collapse" aria-labelledby="headingOne<?= $v->id ?>" data-bs-parent="#accordionExample">
                      <div class="accordion-body">

                        <div class="row">

                          <?=

                            getInputField([
                              'label' => 'Adjust All Products Price',
                              'type' => 'number',
                              'attr' => 'step="any"',
                              'id' => $v->id,
                              'classes' => 'adjust_product_price',
                              'required' => false
                            ]);

                          ?>

                        </div>

                        <?php foreach ($customer_product_prices[$key] as $k => $val): ?>

                        <div class="row">

                          <div class="col-sm-8">

                              <label for="productName">Product Name</label>
                              <p class="view-details-txt"><?= $val->product_name ?> </p>

                          </div>

                              <?= getHiddenField('product_id[]',$val->product_id); ?>
                              <?=

                                getInputField([
                                  'label' => 'Price',
                                  'name' => 'price[]',
                                  'type' => 'number',
                                  'attr' => 'step="any"',
                                  'column' => 'sm-4',
                                  'classes' => 'product_price_'.$v->id,
                                  'value' => $val->price
                                ]);

                              ?>

                        </div>

                        <?php endforeach; ?>

                      </div>
                  </div>
              </div>

              <?php endforeach; ?>

          </div>


    </div>
</div>
