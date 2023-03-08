<h3>Edit Product</h3>
<div class="row mt-3">
    <div class="col-sm-12 col-lg-12">

        <form class="row g-3" action="javascript:void(0)" method="post" id="updateProduct" data-parsley-validate
            enctype="multipart/form-data">
            <div class="row mt-4">

                <div class="col-sm-4">

                    <?php

                    //check image is exist in folder or not
                    if (@getimagesize(base_url('uploads/product/'.$product->img)) && !empty($product->img))
                    {
                        echo getImgField([
                          'img_url' => base_url('uploads/product/'.$product->img)
                        ]);
                    }
                    else
                    {
                        echo getImgField();
                    }

                   ?>


                </div>
                <div class="col-sm-6 form-col-padding">
                    <div class="row">

                        <?php

                  echo getHiddenField('ID',$product->id);
                  echo getHiddenField('old_img',$product->img);
                  echo getHiddenField('old_name',$product->name);

                  $p_name = form_set_value('name');

                  echo getInputField([
                    'label' => 'Product Name',
                    'name' => 'name',
                    'column' => 'sm-12',
                    'value' => $p_name != '' ?$p_name:$product->name
                  ]);
                  echo getInputField([
                    'label' => 'Product Code',
                    'name' => 'product_code',
                    'column' => 'sm-12',
                    'value' => form_set_value('product_code') != '' ?form_set_value('product_code'):$product->code
                  ]);
                  echo getInputField([
                    'label' => 'SKU',
                    'name' => 'sku',
                    'column' => 'sm-12',
                    'value' => form_set_value('sku') != '' ?form_set_value('sku'):$product->sku
                  ]);
                  echo getInputField([
                    'label' => 'Product Color',
                    'type' => 'color',
                    'name' => 'product_color',
                    'column' => 'sm-12',
                    'value' => form_set_value('product_color') != '' ?form_set_value('product_color'):$product->color
                  ]);
                  echo getSelectField([
                    'label' => 'Product Category',
                    'name' => 'cat_id',
                    'column' => 'sm-12',
                    'data' => $categories,
                    'selected' => form_set_value('cat_id') != '' ?form_set_value('cat_id'):$product->cat_id
                  ]);
                  echo getInputField([
                    'label' => 'Price',
                    'name' => 'price',
                    'type' => 'text',
                    'column' => 'sm-12',
                    'attr' => 'readonly',
                    'value' => form_set_value('price') != '' ?form_set_value('price'):$product->price
                  ]);
                  echo getTextareaField([
                    'label' => 'Description',
                    'name' => 'description',
                    'column' => 'sm-12',
                    'required' => false,
                    'value' => form_set_value('description') != '' ?form_set_value('description'):$product->description
                  ]);

                      echo getSubmitBtn('Update Product');

                  ?>


                    </div>
                </div>

            </div>

        </form>
    </div>
</div>