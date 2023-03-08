<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->checkRole(25);

  }

	public function index()
	{

    $data = [

      'title' => 'Products',
      'page_head' => 'Products',
      'active_menu' => 'products',
      'ajax_url' => site_url('Product/getProducts'),
      'categories' => $this->bm->getRows('categories','is_deleted' ,0),
      'styles' => [
        'my-dataTable.css',
        'upload_modal_btn.css'
      ],
      'scripts' => [
        'product/product.js',
        'main.js',
        'dataTable_buttons',
        'img_trigger.js'
      ]

    ];

    $this->template('product/index',$data);

	}

  public function getProducts()
  {

    $this->load->model('Product_model');

    $records = $this->Product_model->getProducts($_REQUEST,'records');
    $totalFilteredRecords = $this->Product_model->getProducts($_REQUEST,'filter');
    $recordsTotal = $this->Product_model->getProducts($_REQUEST,'recordsTotal');

    $data = array();
    $SNo = 0;
    $Style = "";

    foreach ($records as $key => $v)
    {

      $ID = $v->id;

      $SNo++;

      $nestedData = array();

      $nestedData[] = $SNo;

      $delete_url = site_url('delete_product/'.$ID);

      $actions = '';

        $actions .= '<span class="actions-icons">';

        if (isUserAllow(27)) {

          $actions .= '<a href="javascript:void(0)" onClick="editProduct('. $ID .')" class="action-icons" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
            <i class="fa fa-pencil"></i>
          </a>';

        }

        if (isUserAllow(28)) {


          $actions .= '<a href="javascript:void(0)" class="action-icons delete_product_" data-msg="Are you sure you want to delete this Product?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
            <i class="fa-solid fa-trash"></i>
          </a>';

        }

        if (isUserAllow(29)) {


          $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getProductDetails/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
            <i class="fa fa-eye"></i>
          </a>';

        }

        $actions .= '</span>';

         $nestedData[] = $actions;


      //check image is exist in folder or not
      // if (@getimagesize(base_url('uploads/product/'.$v->img)) && !empty($v->img))
      // {
      //     $img_url = base_url('uploads/product/'.$v->img);
      // }
      // else
      // {
      //     $img_url = base_url('assets/images/avatars/01.png');
      // }

      // $name = '<div class="table-circular-img"><img src="'. $img_url .'" class="" alt=""></div>'.
      //   '<span class="table-img-txt-design">'.$v->name.'</span>';

      $name = $v->name;

      $nestedData[] = $name;
      $nestedData[] = $v->cat_name;
      $nestedData[] = $v->code;
      $nestedData[] = $v->sku;
      $nestedData[] = '<div style="width:28px;height:28px;margin-top:-10px;border-radius:50%;background-color:'. $v->color .'"></div>';
      $nestedData[] = $v->price;


           $data[] = $nestedData;

    }

    $json_data = array(
      "draw" => intval($_REQUEST['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
      "recordsTotal" => intval($recordsTotal), // total number of records
      "recordsFiltered" => intval($totalFilteredRecords), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );


    echo json_encode($json_data);

  }

  public function saveProduct()
  {

      $output = [];

      $p = $this->inp_post();

      // echo "<pre>";
      // print_r($p);
      //
      //   die();

        $p = $this->inp_post();
        $is_unique = '';
        if(isset($p['old_name']))
        {

          if ($p['name'] != $p['old_name'])
          {

            $is_unique = '|is_unique[products.name]';

          }

        }
        else
        {

          $is_unique = '|is_unique[products.name]';

        }

        $this->form_validation->set_rules('name', 'Product Name', 'required'.$is_unique,[
          'required'      => 'The %s is required',
          'is_unique'     => 'The %s already exist'
        ]);

        $this->form_validation->set_rules('product_code', 'Product Code', 'required');
        $this->form_validation->set_rules('sku', 'Sku', 'required');
        $this->form_validation->set_rules('cat_id', 'Product Category', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');

        if ($this->form_validation->run() == FALSE)
        {

          $error = validation_errors();
          //
          // $set_values = [
          //
          //   'name' => $p['name'],
          //   'product_code' => $p['product_code'],
          //   'sku' => $p['sku'],
          //   'cat_id' => $p['cat_id'],
          //   'price' => $p['price'],
          //   'description' => $p['description']
          //
          // ];
          //
          // $this->session->set_flashdata('_setValues',$set_values);

          // $this->session->set_flashdata('_error',$error);

          $output['status'] = false;
          $output['msg'] = $error;

        }
        else
        {

             $ID = (isset($p['ID'])?$p['ID']:'');
             unset($p['ID']);

             $product_img = NULL;

             if($ID != '')
             {
                $product_img = $p['old_img'];
                unset($p['old_img']);
             }

             if(!empty($_FILES['img']['name']))
             {

               if($ID != '')
               {
                    if (@getimagesize(base_url('uploads/product/'.$product_img)) && !empty($product_img))
                    {
                        $dir_path = getcwd().'/uploads/product/'.$product_img;

                        unlink($dir_path);
                    }
               }

               $product_img = $this->bm->uploadFile($_FILES['img'],'uploads/product');

             }

             $arr = [

                'img' => $product_img,
                'name' => $p['name'],
                'code' => $p['product_code'],
                'sku' => $p['sku'],
                'color' => $p['product_color'] != ''?$p['product_color']:'#8a92a6',
                'cat_id' => $p['cat_id'],
                'price' => $p['price'],
                'description' => $p['description'],
                'added_by' => $this->user_id_

             ];

             $this->trans_('start');

              if(!empty($ID))
              {

                unset($arr['added_by']);

                $this->bm->update('products',$arr,'id',$ID);

              }
              else
              {

                  $arr['added_at'] = $this->curr_datetime;
                  $last_id = $this->bm->insert_row('products',$arr);

                  $customers = $this->bm->getRows('customers','is_deleted',0);
                  $product = $this->bm->getRow('products','id',$last_id);

                  $customer_products = [];

                  foreach ($customers as $key => $v)
                  {

                    $customer_products[] = [

                        'product_id' => $product->id,
                        'customer_id' => $v->id,
                        'price' => $product->price

                    ];

                  }

                  if(!empty($customer_products))
                  {

                    $this->bm->insert_rows('customer_products_price',$customer_products);

                  }


              }

             $this->trans_('complete');

             if ($this->trans_('status') === FALSE)
             {

                 $output['status'] = false;
                 $output['msg'] = 'Connection error Try Again';

             }
             else
             {

               if(!empty($ID))
               {

                 $output['status'] = true;
                 $output['msg'] = 'Product updated successfully';

               }
               else
               {

                 $output['status'] = true;
                 $output['msg'] = 'Product created successfully';

               }


             }
        }

        echo json_encode($output);

  }

  public function editProduct()
  {

    $product_id = $this->inp_get('id');

    $data = [

      'categories' => $this->bm->getRows('categories','is_deleted' ,0),
      'product' => $this->bm->getRow('products','id',$product_id)

    ];

    $output['html'] = $this->load_view('product/edit',$data,true);

    echo json_encode($output);

  }

  public function delete($product_id)
  {

      $output = [];

      $arr = [

        'is_deleted' => 1

      ];

      $res = $this->bm->update('products',$arr,'id',$product_id);

      if ($res)
      {

        $output = [
          'status' => true,
          'msg' => 'Product deleted successfully'
        ];

      }
      else
      {

        $output = [
          'status' => false,
          'msg' =>  'Connection error Try Again'
        ];

      }

      echo json_encode($output);

  }

}