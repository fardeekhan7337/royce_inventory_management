<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->checkRole(51);

  }

	public function index()
	{

    $data = [

      'title' => 'Call Orders',
      'page_head' => 'Call Orders',
      'active_menu' => 'call_order',
      'ajax_url' => site_url('Order/getCallOrders'),
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'DataTable/callOrderDataTable.js',
        'inventory/change_status.js',
        'main.js',
        'dataTable_buttons'
      ]

    ];

    $this->template('order/index',$data);

	}

  public function getCallOrders()
  {

    $this->load->model('Order_model');

    $records = $this->Order_model->getCallOrders($_REQUEST,'records');
    $totalFilteredRecords = $this->Order_model->getCallOrders($_REQUEST,'filter');
    $recordsTotal = $this->Order_model->getCallOrders($_REQUEST,'recordsTotal');

    $data = array();
    $SNo = 0;
    $Style = "";

    foreach ($records as $key => $v)
    {

      $ID = $v->id;

      $SNo++;

      $nestedData = array();

      $nestedData[] = $SNo;

      $delete_url = site_url('delete_call_order/'.$ID);

        $actions = '';

          $actions .= '<span class="actions-icons">';

          if (isUserAllow(77)) {

            $actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Call Order?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </a>';

          }

          if (isUserAllow(53)) {


            $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getCallOrderDetails/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
              <i class="fa fa-eye"></i>
            </a>';

          }

          $actions .= '</span>';

           $nestedData[] = $actions;


      $nestedData[] = $v->customer_name;
      $nestedData[] = $v->shop_name;
      $nestedData[] = $v->shop_acronym;
      $nestedData[] = $v->delivery_day;
      $nestedData[] = $v->total_products;
      $nestedData[] = $v->total_qty;
      $nestedData[] = change_number_format($v->total_price);
      $nestedData[] = $v->order_comment;


        $change_status_class = '';

        if (isUserAllow(54)) {

          $change_status_class = 'changeInv_status_';

        }

        $change_status_url = site_url('update_call_order_status/'.$ID);

        $status = '<a href="javascript:void(0)" class="'. $change_status_class .' action-icons" data-btn-txt="Move To Pending Request" data-msg="Are you sure you want to move this Call Order to Pending Request?" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Move To Pending Request">
                 <span class="badge rounded-pill bg-secondary">Pending</span>
           </a>';

        $nestedData[] = $status;

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

  public function create()
  {

    $this->checkRole(52);

    $this->load->model('Product_model');

    $days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
    ];

    $data = [

      'title' => 'Add Call Order',
      'page_head' => 'Add Call Order',
      'active_menu' => 'call_order',
      'customers' => $this->bm->getRows('customers','is_deleted',0),
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'products' => $this->Product_model->getAllProducts(),
      'days' => $days,
      'scripts' => [
        'inventory/assign_to_driver.js',
        'order/main.js'
      ]

    ];

    $this->template('order/create',$data);

  }

  public function save()
  {

      $p = $this->inp_post();

      $where_arr = [

         'customer_id' => $p['customer_id'],
         'driver_id' => $p['driver_id'],
         'delivery_day' => $p['day'],
         'is_deleted' => 0

      ];

      $call_order = $this->bm->getRowWithConditions('call_orders',$where_arr);

      if (!empty($call_order))
      {

          $this->session->set_flashdata('_error','The Call Order customer already assign to this driver on that day');
          redirect('call_order');

      }

      $this->form_validation->set_rules('customer_id', 'Driver', 'required');
      $this->form_validation->set_rules('driver_id', 'Driver', 'required');
      $this->form_validation->set_rules('day', 'Day', 'required');
      $this->form_validation->set_rules('product_id[]', 'Product', 'required');
      $this->form_validation->set_rules('qty[]', 'Quantity', 'required');

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $this->session->set_flashdata('_error',$error);

        redirect('add_call_order');

      }
      else
      {

           $arr = [

              'customer_id' => $p['customer_id'],
              'driver_id' => $p['driver_id'],
              'delivery_day' => $p['day'],
              'order_comment' => $p['order_comment'],
              'added_by' => $this->user_id_

           ];

           $this->trans_('start');
            
                $arr['added_at'] = $this->curr_datetime;
              $last_id = $this->bm->insert_row('call_orders',$arr);

              $call_order_products = [];

              foreach ($p['product_id'] as $key => $v) {

                  $call_order_products[] = [

                    'call_order_id' => $last_id,
                    'product_id' => $v,
                    'qty' => $p['qty'][$key]

                  ];

                  $logs[] = [

                      'product_id' => $v,
                      'customer_id' => $p['customer_id'],
                      'driver_id' => $p['driver_id'],
                      'qty' => $p['qty'][$key],
                      'type' => 'call_order',
                      'added_by' => $this->user_id_,
                      'added_at' => $this->curr_datetime

                  ];

              }

              $this->bm->insert_rows('call_orders_details',$call_order_products);
              $this->bm->insert_rows('logs',$logs);

           $this->trans_('complete');

           if ($this->trans_('status') === FALSE)
           {

               $this->session->set_flashdata('_error','Connection error Try Again');

           }
           else
           {

               $this->session->set_flashdata('_success','Call Order created successfully');

           }

           redirect('call_order');
      }

  }

  public function update_status($call_order_id)
  {

    $this->checkRole(54);

      $arr = [

        'status' => 'confirmed'

      ];

      $res = $this->bm->update('call_orders',$arr,'id',$call_order_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Call Order has moved to Pending Requests successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('call_order');

  }

  public function delete($call_order_id)
  {

      $this->checkRole(77);

      $arr = [

        'is_deleted' => 1

      ];

      $res = $this->bm->update('call_orders',$arr,'id',$call_order_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Call Order deleted successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('call_order');

  }

}
