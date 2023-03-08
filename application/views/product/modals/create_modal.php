<div class="modal fade create_product_modal" id="CreateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="float:right!important"></button>

                <div class="container" id="create_modal_">


                    <h3>Add Product</h3>

                    <div class="row mt-3">
                        <div class="col-sm-12 col-lg-12">
                            <form class="row g-3" action="javascript:void(0)" method="post" id="CreateProduct"
                                data-parsley-validate enctype="multipart/form-data">
                                <div class="row mt-4">

                                    <div class="col-sm-4">


                                        <?php

                                      echo getImgField();

                                     ?>


                                    </div>
                                    <div class="col-sm-6 form-col-padding">

                                        <div class="row">

                                            <?php

                                    // echo ;

                                    $p_name = form_set_value('name');


                                    echo getInputField([
                                      'label' => 'Product Name',
                                      'name' => 'name',
                                      'type' => 'text',
                                      'column' => 'sm-12',
                                      'value' => $p_name
                                    ]);

                                    echo getInputField([
                                      'label' => 'Product Code',
                                      'name' => 'product_code',
                                      'column' => 'sm-12',
                                      'value' => form_set_value('product_code')
                                    ]);
                                    echo getInputField([
                                      'label' => 'SKU',
                                      'name' => 'sku',
                                      'column' => 'sm-12',
                                      'value' => form_set_value('sku')
                                    ]);
                                    echo getInputField([
                                      'label' => 'Product Color',
                                      'type' => 'color',
                                      'name' => 'product_color',
                                      'column' => 'sm-12',
                                      'value' => form_set_value('product_color')
                                    ]);
                                    echo getSelectField([
                                      'label' => 'Product Category',
                                      'name' => 'cat_id',
                                      'column' => 'sm-12',
                                      'data' => $categories,
                                      'classes' => 'modal_select_category_',
                                      'selected' => form_set_value('cat_id')
                                    ]);
                                    echo getInputField([
                                      'label' => 'Price',
                                      'name' => 'price',
                                      'type' => 'text',
                                      'column' => 'sm-12',
                                      'attr' => 'readonly',
                                      'value' => form_set_value('price')
                                    ]);
                                    echo getTextareaField([
                                      'label' => 'Description',
                                      'name' => 'description',
                                      'column' => 'sm-12',
                                      'required' => false,
                                      'value' => form_set_value('description')
                                    ]);

                                        echo getSubmitBtn('Add Product');

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