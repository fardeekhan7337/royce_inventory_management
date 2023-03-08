<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->checkRole(30);

  }

	public function index()
	{

    $days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
    ];

    $cat_types = [
      'Cash',
      'Credit'
    ];

    $data = [

      'title' => 'Add Customer',
      'page_head' => 'Add Customer',
      'active_menu' => 'customers',

      'scripts' => [

      ]

    ];


    $data = [

      'title' => 'Customers',
      'page_head' => 'Customers',
      'active_menu' => 'customers',
      'ajax_url' => site_url('Customer/getCustomers'),
      'salespersons' => $this->bm->getRows('salesperson','is_deleted',0),
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'days' => $days,
      'cat_types' => $cat_types,
      'styles' => [
        'my-dataTable.css',
        'upload_modal_btn.css'
      ],
      'scripts' => [
        'users/customers.js',
        'main.js',
        'dataTable_buttons',
        'img_trigger.js'
      ]

    ];

    $this->template('customer/index',$data);


	}

  public function getCustomers()
  {

    $this->load->model('Customer_model');

    $records = $this->Customer_model->getCustomers($_REQUEST,'records');
    $totalFilteredRecords = $this->Customer_model->getCustomers($_REQUEST,'filter');
    $recordsTotal = $this->Customer_model->getCustomers($_REQUEST,'recordsTotal');

    $data = array();
    $SNo = 0;
    $Style = "";

    foreach ($records as $key => $v)
    {

      $ID = $v->id;

      $SNo++;

      $nestedData = array();

      $nestedData[] = $SNo;

      $delete_url = site_url('delete_customer/'.$ID);

      $actions = '';

        $actions .= '<span class="actions-icons">';


        if (isUserAllow(32)) {

          $actions .= '<a href="javascript:void(0)" onClick="editCustomer('. $ID .')" class="action-icons" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>';

        }

        if (isUserAllow(33)) {

          $actions .= '<a href="javascript:void(0)" class="action-icons delete_customer_" data-msg="Are you sure you want to delete this Customer?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="fa-solid fa-trash"></i></a>';

        }


        if (isUserAllow(34)) {

          $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getCustomerDetails/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details"><i class="fa fa-eye"></i></a>';

        }

          if (isUserAllow(74)) {

          $actions .= '<a href="javascript:void(0)" class="action-icons adjust_prices_" data-url="'. site_url('AjaxController/getCustomerProductPrices/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Adjust Price by product"><i class="fa-solid fa-circle-dollar-to-slot"></i></a>';

          }

        $actions .= '</span>';

         $nestedData[] = $actions;


      //check image is exist in folder or not
      // if (@getimagesize(base_url('uploads/customer/'.$v->img)) && !empty($v->img))
      // {
      //     $img_url = base_url('uploads/customer/'.$v->img);
      // }
      // else
      // {
      //     $img_url = base_url('assets/images/avatars/01.png');
      // }

      // $name = '<div class="table-circular-img"><img src="'. $img_url .'" class="" alt=""></div>'.
      //   '<span class="table-img-txt-design">'.$v->name.'</span>';

      $name = $v->name;

      $nestedData[] = $name;
      $nestedData[] = $v->day;
      $nestedData[] = $v->driver_name;
      $nestedData[] = $v->shop_name;
      $nestedData[] = $v->shop_acronym;
      $nestedData[] = $v->shop_id;
      $nestedData[] = $v->primary_contact;
      $nestedData[] = $v->secondary_contact;
      $nestedData[] = $v->e_receipt_email;

      if($v->cat_type == 'Cash')
      {

        $cat_type = '<span class="badge rounded-pill bg-success">Cash</span>';

      }
      else
      {

        $cat_type = '<span class="badge rounded-pill bg-warning">Credit</span>';

      }

      $nestedData[] = $cat_type;
      $nestedData[] = $v->address;
      $nestedData[] = $v->salesperson_name;
      $nestedData[] = getDateTimeFormat($v->added_at,'date');

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

  public function saveCustomer()
  {

      $output = [];
      $p = $this->inp_post();
      $is_email_unique = '';
      $is_soa_email_unique = '';

      $this->form_validation->set_rules('name', 'Customer Name', 'required');
      $this->form_validation->set_rules('shop_name', 'Shop Name', 'required');
      $this->form_validation->set_rules('shop_acronym', 'Shop Acronym', 'required');
      $this->form_validation->set_rules('shop_id', 'Shop ID', 'required');
      $this->form_validation->set_rules('primary_contact', 'Primary Contact', 'required');

      // if(isset($p['old_email']))
      // {
      //
      //   if ($p['email'] != $p['old_email'])
      //   {
      //
      //     $is_email_unique = 'is_unique[customers.e_receipt_email]';
      //
      //   }
      //
      // }
      // else
      // {
      //
      //   $is_email_unique = 'is_unique[customers.e_receipt_email]';
      //
      // }

      // $this->form_validation->set_rules('email', 'Email Address For E-Receipt',$is_email_unique,[
      //   'is_unique'     => 'The %s already exist'
      // ]);

      // if(isset($p['old_soa_email']))
      // {
      //
      //   if ($p['soa_email'] != $p['old_soa_email'])
      //   {
      //
      //     $is_soa_email_unique = 'is_unique[customers.soa_email]';
      //
      //   }
      //
      // }
      // else
      // {
      //
      //   $is_soa_email_unique = 'is_unique[customers.soa_email]';
      //
      // }
      //
      // $this->form_validation->set_rules('soa_email', 'Email Address For SOA',$is_soa_email_unique,[
      //   'is_unique'     => 'The %s already exist'
      // ]);

      $this->form_validation->set_rules('cat_type', 'Category', 'required');
      $this->form_validation->set_rules('salesperson_id', 'Salesperson', 'required');
      $this->form_validation->set_rules('driver_id', 'Driver', 'required');
      $this->form_validation->set_rules('day', 'Day', 'required');

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $output = [

            'status' => false,
            'msg' => $error
        ];

      }
      else
      {

           $ID = (isset($p['ID'])?$p['ID']:'');
           unset($p['ID']);

           $customer_img = NULL;

           if($ID != '')
           {
              $customer_img = $p['old_img'];
              unset($p['old_img']);
           }

           if(!empty($_FILES['img']['name']))
           {

             if($ID != '')
             {
                  if (@getimagesize(base_url('uploads/customer/'.$customer_img)) && !empty($customer_img))
                  {
                      $dir_path = getcwd().'/uploads/customer/'.$customer_img;

                      unlink($dir_path);
                  }
             }

             $customer_img = $this->bm->uploadFile($_FILES['img'],'uploads/customer');

           }

           $arr = [

              'img' => $customer_img,
              'name' => $p['name'],
              'shop_name' => $p['shop_name'],
              'shop_acronym' => $p['shop_acronym'],
              'shop_id' => $p['shop_id'],
              'primary_contact' => $p['primary_contact'],
              'secondary_contact' => $p['secondary_contact'],
              'e_receipt_email' => $p['email'],
              'soa_email' => $p['soa_email'],
              'cat_type' => $p['cat_type'],
              'salesperson_id' => $p['salesperson_id'],
              'driver_id' => $p['driver_id'],
              'day' => $p['day'],
              'address' => $p['address'],
              'remarks' => $p['remarks'],
              'added_by' => $this->user_id_

           ];

           $this->trans_('start');

            if(!empty($ID))
            {

              unset($arr['added_by']);

              $this->bm->update('customers',$arr,'id',$ID);

            }
            else
            {

                $arr['added_at'] = $this->curr_datetime;
                $last_id = $this->bm->insert_row('customers',$arr);

                $products = $this->bm->getRows('products','is_deleted',0);

                $customer_products = [];

                foreach ($products as $key => $v)
                {

                  $customer_products[] = [

                      'product_id' => $v->id,
                      'customer_id' => $last_id,
                      'price' => $v->price

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

               $output = [

                   'status' => false,
                   'msg' => 'Connection error Try Again'
               ];

           }
           else
           {

             if(!empty($ID))
             {

               $output = [

                   'status' => true,
                   'msg' => 'Customer updated successfully'
               ];

             }
             else
             {

               $output = [

                   'status' => true,
                   'msg' => 'Customer created successfully'
               ];

             }


           }


      }

      echo json_encode($output);

  }

  function check_customer_email($second_field,$first_field)
  {

    if ($second_field == $first_field)
    {
        $this->form_validation->set_message('check_customer_email', 'The Email Address For E-Receipt and Email Address For SOA should not be same');
        return false;
    }

    return true;

  }

  public function editCustomer()
  {

    $customer_id = $this->inp_get('id');

    $days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
    ];

    $cat_types = [
      'Cash',
      'Credit'
    ];

    $data = [

      'customer' => $this->bm->getRow('customers','id',$customer_id),
      'salespersons' => $this->bm->getRows('salesperson','is_deleted',0),
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'days' => $days,
      'cat_types' => $cat_types,
    ];

    $output['html'] = $this->load_view('customer/edit',$data,true);

    echo json_encode($output);

  }

  public function delete($customer_id)
  {

      $output = [];
      $arr = [

        'is_deleted' => 1

      ];

      $res = $this->bm->update('customers',$arr,'id',$customer_id);

      if ($res)
      {

          $output = [

            'status' => true,
            'msg' => 'Customer deleted successfully'

          ];

      }
      else
      {

          $output = [

            'status' => false,
            'msg' => 'Connection error Try Again'

          ];

      }

      echo json_encode($output);

  }

  public function update_products_price()
  {

      // $this->checkRole(74);

      $p = $this->inp_post();

       $this->trans_('start');

        $this->bm->delete('customer_products_price','customer_id',$p['customer_id_']);

        $customer_products = [];

        foreach ($p['product_id'] as $key => $v)
        {

          $customer_products[] = [

              'product_id' => $v,
              'customer_id' => $p['customer_id_'],
              'price' => $p['price'][$key]

          ];

        }

        if(!empty($customer_products))
        {

          $this->bm->insert_rows('customer_products_price',$customer_products);

        }


       $this->trans_('complete');

       if ($this->trans_('status') === FALSE)
       {

          $output['msg'] = 'Connection error Try Again';
          $output['status'] = false;

        }
        else
        {

          $output['msg'] = 'Customer Products Price updated successfully';
          $output['status'] = true;

       }

       echo json_encode($output);

  }


}
