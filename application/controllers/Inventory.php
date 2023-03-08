<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

  }

	public function index()
	{

    $this->checkRole(35);

    $this->load->model('Product_model');

    $data = [

      'title' => 'Inventory',
      'page_head' => 'Inventory',
      'active_menu' => 'inventory',
      'active_submenu' => 'view_inventory',
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' =>0,'type' => 'driver']),
      'products' => $this->Product_model->getAllProducts(),
      'redirect_to' => site_url('view_inventory'),
      'ajax_url' => site_url('Inventory/getInventory'),
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'DataTable/inventoryDataTable.js',
        'inventory/main.js',
        'inventory/assign_to_driver.js',
        'inventory/return_stock.js',
        'inventory/add_stock.js',
        'dataTable_buttons'
      ]

    ];

    $this->template('inventory/index',$data);

	}

  public function getInventory($tab = 'available')
  {

    $this->load->model('Inventory_model');

    $records = $this->Inventory_model->getInventory($_REQUEST,'records',$tab);
    $totalFilteredRecords = $this->Inventory_model->getInventory($_REQUEST,'filter',$tab);
    $recordsTotal = $this->Inventory_model->getInventory($_REQUEST,'recordsTotal',$tab);

    $data = array();
    $SNo = 0;
    $Style = "";

    foreach ($records as $key => $v)
    {

      $total_qty = 0;

      $ID = $v->product_id;

      $SNo++;

      $nestedData = array();

      $nestedData[] = $SNo;


      $actions = '';

      $actions .= '<span class="actions-icons">';

      if (isUserAllow(36)) {

        $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getInventoryDetailsByType/'.$tab.'/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
          <i class="fa fa-eye"></i>
        </a>';

      }

      $actions .= '</span>';

       $nestedData[] = $actions;

      if($tab == 'available')
      {

        $total_add = $v->total_add_stock_qty + $v->total_return;
        $total_remove = $v->total_remove_stock_qty + $v->total_assign_stock_confirmed + $v->total_pending_call_order_confirmed + $v->total_return_missing;

        $total_qty = $total_add - $total_remove;

      }
      else if($tab == 'missing')
      {

        $total_qty = $v->total_return_missing;

      }
      else if($tab == 'return')
      {

        $total_qty = $v->total_return;

      }
      else if($tab == 'exchange')
      {

        $total_qty = $v->total_exchange;

      }

      $nestedData[] = $v->product_name;
      $nestedData[] = $total_qty;

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

  public function add_stock()
  {

    $this->checkRole(37);

    $this->load->model('Product_model');

    $data = [

      'title' => 'Add Stock',
      'page_head' => 'Add Stock',
      'active_menu' => 'inventory',
      'active_submenu' => 'add_stock',
      'products' => $this->Product_model->getAllProducts()

    ];

    $this->template('inventory/stock/add',$data);

  }

  public function save_stock()
  {
      $p = $this->inp_post();

      $rediect_to = $p['redirect_to'];

      $this->form_validation->set_rules('product_id', 'Product', 'required');
      $this->form_validation->set_rules('qty', 'Qty', 'required');

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $this->session->set_flashdata('_error',$error);

        redirect($rediect_to);

      }
      else
      {

           $arr = [

              'product_id' => $p['product_id'],
              'qty' => $p['qty'],
              'type' => 'add',
              'added_by' => $this->user_id_,
              'added_at' => $this->curr_datetime

           ];

           $this->trans_('start');

                $this->bm->insert_row('stock',$arr);

                $arr['type'] = 'add_stock';

                $this->bm->insert_row('logs',$arr);

           $this->trans_('complete');

           if ($this->trans_('status') === FALSE)
           {

               $this->session->set_flashdata('_error','Connection error Try Again');

           }
           else
           {

               $this->session->set_flashdata('_success','Stock added successfully');

           }

           redirect($rediect_to);

      }

  }

  public function view_stock()
  {

    $this->checkRole(38);

    $data = [

      'title' => 'View Stock',
      'page_head' => 'View Stock',
      'active_menu' => 'inventory',
      'active_submenu' => 'view_stock',
      'ajax_url' => site_url('Inventory/getStocks'),
      'products' => $this->bm->getRows('products','is_deleted',0),
      'redirect_to' => site_url('view_stock'),
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'DataTable/stockDataTable.js',
        'inventory/add_stock.js',
        'main.js',
        'dataTable_buttons'
      ]

    ];

    $this->template('inventory/stock/index',$data);

  }

	public function getStocks()
	{

    $this->load->model('Stock_model');

		$records = $this->Stock_model->getStocks($_REQUEST,'records');
		$totalFilteredRecords = $this->Stock_model->getStocks($_REQUEST,'filter');
		$recordsTotal = $this->Stock_model->getStocks($_REQUEST,'recordsTotal');

		$data = array();
		$SNo = 0;
		$Style = "";

		foreach ($records as $key => $v)
		{

      $ID = $v->id;

			$SNo++;

			$nestedData = array();

			$nestedData[] = $SNo;

      $delete_url = site_url('delete_stock/'.$ID);

  			$actions = '';

          $actions .= '<span class="actions-icons">';

            if (isUserAllow(75)) {

  					$actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Stock?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </a>';

          }

          $actions .= '</span>';

			     $nestedData[] = $actions;


			$nestedData[] = $v->product_name;
      $nestedData[] = $v->qty;
      $nestedData[] = $v->added_by_name;
			$nestedData[] = getDateTimeFormat($v->added_at);

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

  public function delete_stock($stock_id)
  {

      $this->checkRole(75);

      $arr = [

        'is_deleted' => 1

      ];

      $this->trans_('start');

           $this->bm->update('stock',$arr,'id',$stock_id);

           $stock = $this->bm->getRow('stock','id',$stock_id);

           $stock_arr = [

              'product_id' => $stock->product_id,
              'qty' => $stock->qty,
              'type' => 'remove',
              'added_by' => $this->user_id_,
              'added_at' => $this->curr_datetime

           ];

           $this->bm->insert_row('stock',$stock_arr);

           $stock_arr['type'] = 'remove_stock';

           $this->bm->insert_row('logs',$stock_arr);

      $this->trans_('complete');

      if ($this->trans_('status') === FALSE)
      {

          $this->session->set_flashdata('_error','Connection error Try Again');

      }
      else
      {
          $this->session->set_flashdata('_success','Stock deleted successfully');

      }

      redirect('view_stock');

  }

  public function stock_history()
  {

    $this->checkRole(39);

    $data = [

      'title' => 'Stock History',
      'page_head' => 'Stock History',
      'active_menu' => 'inventory',
      'active_submenu' => 'stock_history',
      'ajax_url' => site_url('Inventory/getStockHistory'),
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'DataTable/stockHistoryDataTable.js',
        'inventory/add_stock.js',
        'main.js',
        'dataTable_buttons'
      ]

    ];

    $this->template('inventory/stock/stock_history',$data);

  }

  public function getStockHistory()
	{

    $this->load->model('Stock_model');

		$records = $this->Stock_model->getStockHistory($_REQUEST,'records');
		$totalFilteredRecords = $this->Stock_model->getStockHistory($_REQUEST,'filter');
		$recordsTotal = $this->Stock_model->getStockHistory($_REQUEST,'recordsTotal');

		$data = array();
		$SNo = 0;
		$Style = "";

		foreach ($records as $key => $v)
		{

      $ID = $v->id;

			$SNo++;

			$nestedData = array();

			$nestedData[] = $SNo;

			$nestedData[] = $v->product_name;
      $nestedData[] = $v->qty;

      if($v->type == 'add')
      {

        $type = '<span class="badge rounded-pill bg-success">'.ucfirst($v->type).'</span>';

      }
      else
      {

        $type = '<span class="badge rounded-pill bg-danger">'.ucfirst($v->type).'</span>';

      }

      $nestedData[] = $type;

      $nestedData[] = $v->added_by_name;
			$nestedData[] = getDateTimeFormat($v->added_at);

        $delete_url = site_url('delete_stock/'.$ID);

  			$actions = '';

          $actions .= '<span class="actions-icons">';

  					$actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Stock?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </a>';

          $actions .= '</span>';

			     $nestedData[] = $actions;

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

  public function assign_to_driver()
  {

    $this->checkRole(40);

    $this->load->model('Product_model');
    $this->load->model('Stock_model');

    $data = [

      'title' => 'Assign Stock To Driver',
      'page_head' => 'Assign Stock To Driver',
      'active_menu' => 'inventory',
      'active_submenu' => 'assign_to_driver',
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'products' => $this->Product_model->getAllProducts(),
      'driver_request_products' => $this->Stock_model->getDriverRequestStock($this->user_id_),
      'scripts' => [
        'inventory/assign_to_driver.js'
      ]
    ];

    $this->template('inventory/stock/assign_to_driver',$data);

  }

  public function save_assign_to_driver($value='')
  {

      $p = $this->inp_post();

      $assign_stock = $this->bm->getRowWithConditions('assign_stock',['is_return' => 0,'driver_id' => $p['driver_id'],'is_deleted' => 0]);

      if (!empty($assign_stock))
      {

          $this->session->set_flashdata('_error','Stock has been already assign to this driver');
          redirect($p['redirect']);

      }

      $this->form_validation->set_rules('driver_id', 'Driver', 'required');
      $this->form_validation->set_rules('product_id[]', 'Product', 'required');
      $this->form_validation->set_rules('qty[]', 'Quantity', 'required');

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $this->session->set_flashdata('_error',$error);

        redirect($p['redirect']);

      }
      else
      {

           $arr = [

              'driver_id' => $p['driver_id'],
              'added_by' => $this->user_id_

           ];

           $this->trans_('start');

              //update driver request row
              $dreq = [

                 'is_assign' => 1

              ];

              $this->bm->update('driver_request',$dreq,'driver_id',$p['driver_id']);

                $arr['added_at'] = $this->curr_datetime;
              $last_id = $this->bm->insert_row('assign_stock',$arr);

              $assign_products = [];

              $logs = [];

              foreach ($p['product_id'] as $key => $v) {

                  $assign_products[] = [

                    'assign_stock_id' => $last_id,
                    'product_id' => $v,
                    'qty' => $p['qty'][$key],
                    'available_qty' => $p['qty'][$key]

                  ];

                  $logs[] = [

                      'product_id' => $v,
                      'driver_id' => $p['driver_id'],
                      'qty' => $p['qty'][$key],
                      'type' => 'assign',
                      'added_by' => $this->user_id_,
                      'added_at' => $this->curr_datetime

                  ];

              }

              $this->bm->insert_rows('assign_stock_details',$assign_products);
              $this->bm->insert_rows('logs',$logs);

           $this->trans_('complete');

           if ($this->trans_('status') === FALSE)
           {

               $this->session->set_flashdata('_error','Connection error Try Again');

           }
           else
           {

               $this->session->set_flashdata('_success','Assigned to driver');

           }

           redirect($p['redirect']);
      }

  }

  public function return_stock()
  {

    $this->checkRole(41);

    $data = [

      'title' => 'Return Stock',
      'page_head' => 'Return Stock',
      'active_menu' => 'inventory',
      'active_submenu' => 'return_stock',
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'scripts' => [
        'inventory/return_stock.js'
      ]
    ];

    $this->template('inventory/stock/return_stock',$data);

  }

  public function save_return_stock()
  {

      $p = $this->inp_post();

      if(!isset($p['product_id']))
      {

          $this->session->set_flashdata('_error','Product is required');

          redirect($p['redirect']);

      }

      $assign_stock = $this->bm->getRowWithConditions('assign_stock',['is_return' => 0,'driver_id' => $p['driver_id']]);

      $this->trans_('start');

          $arr = [
              'is_return' => 1
          ];

          $this->bm->update('assign_stock',$arr,'id',$assign_stock->id);

          $logs = [];

          foreach ($p['product_id'] as $key => $v)
          {

              $logs[] = [

                  'product_id' => $v,
                  'driver_id' => $p['driver_id'],
                  'qty' => $p['missing_qty'][$key],
                  'type' => 'return',
                  'qty_type' => 'missing_qty',
                  'added_by' => $this->user_id_,
                  'added_at' => $this->curr_datetime

              ];
              $logs[] = [

                'product_id' => $v,
                'driver_id' => $p['driver_id'],
                'qty' => $p['return_qty'][$key],
                'type' => 'return',
                'qty_type' => 'return_qty',
                'added_by' => $this->user_id_,
                'added_at' => $this->curr_datetime

              ];

          }

           $this->bm->insert_rows('logs',$logs);

      $this->trans_('complete');

      if ($this->trans_('status') === FALSE)
      {

          $this->session->set_flashdata('_error','Connection error Try Again');

      }
      else
      {

          $this->session->set_flashdata('_success','Stock has returned successfully');

      }

      redirect($p['redirect']);

  }

  public function live_stock()
  {

    $this->checkRole(42);

    $data = [

      'title' => 'Live Stock',
      'page_head' => 'Live Stock',
      'active_menu' => 'inventory',
      'active_submenu' => 'live_stock',
      'ajax_url' => site_url('Inventory/getLiveStocks'),
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'DataTable/liveStockDataTable.js',
        'main.js'
      ]

    ];

    $this->template('inventory/stock/live_stock',$data);

  }

  public function getLiveStocks()
  {

    $this->load->model('Inventory_model');

    $records = $this->Inventory_model->getLiveStocks($_REQUEST,'records');
    $totalFilteredRecords = $this->Inventory_model->getLiveStocks($_REQUEST,'filter');
    $recordsTotal = $this->Inventory_model->getLiveStocks($_REQUEST,'recordsTotal');

    $data = array();
    $SNo = 0;
    $Style = "";

    foreach ($records as $key => $v)
    {

      $ID = $v->id;

      $SNo++;

      $nestedData = array();

      $nestedData[] = $SNo;

              $actions = '';

                $actions .= '<span class="actions-icons">';

                  $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getViewDetailsByDriverAssignQty/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
                    <i class="fa fa-eye"></i>
                  </a>';

                $actions .= '</span>';

                 $nestedData[] = $actions;

      $nestedData[] = $v->driver_name;
      $nestedData[] = $v->total_products;
      $nestedData[] = $v->total_qty;
      $nestedData[] = $v->total_qty - $v->total_available_qty;
      $nestedData[] = $v->total_available_qty;

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

  public function request_stock()
  {

    $this->checkRole(43);

    $this->load->model('Product_model');
    $this->load->model('Stock_model');

    $data = [

      'title' => 'Request Stock',
      'page_head' => 'Request Stock',
      'active_menu' => 'inventory',
      'active_submenu' => 'request_stock',
      'driver_id' => $this->user_id_,
      'products' => $this->Product_model->getAllProducts(),
      'driver_request_products' => $this->Stock_model->getDriverRequestStock($this->user_id_),
      'scripts' => [
        'inventory/assign_to_driver.js'
      ]

    ];

    $this->template('inventory/stock/request_stock',$data);

  }

  public function save_driver_stock_request()
  {

      $this->form_validation->set_rules('driver_id', 'Driver', 'required');
      $this->form_validation->set_rules('product_id[]', 'Product', 'required');
      $this->form_validation->set_rules('qty[]', 'Quantity', 'required');

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $this->session->set_flashdata('_error',$error);

        redirect('request_stock');

      }
      else
      {

           $p = $this->inp_post();


           $arr = [

              'driver_id' => $p['driver_id'],
              'added_by' => $this->user_id_,
              'is_assign' => 0,
              'added_at' => $this->curr_datetime,

           ];

           $this->trans_('start');

            // delete previous request

            $this->bm->deleteWithCondidtions('driver_request',['driver_id' => $p['driver_id'],'is_assign' => 0]);

            // if(!empty($is_driver))
            // {
            //
            //   $last_id = $is_driver->id;
            //   $this->bm->update('driver_request',$arr,'id',$last_id);
            //
            //   $this->bm->delete('driver_request_details','driver_request_id',$last_id);
            //
            // }
            // else
            // {

                $last_id = $this->bm->insert_row('driver_request',$arr);

            // }

              $request_products = [];

              foreach ($p['product_id'] as $key => $v)
              {

                  $request_products[] = [

                    'driver_request_id' => $last_id,
                    'product_id' => $v,
                    'qty' => $p['qty'][$key]

                  ];

                  $log_req[] = [

                      'product_id' => $v,
                      'driver_id' => $p['driver_id'],
                      'qty' => $p['qty'][$key],
                      'type' => 'request',
                      'added_by' => $this->user_id_,
                      'added_at' => $this->curr_datetime

                  ];

              }

              $this->bm->insert_rows('driver_request_details',$request_products);
              $this->bm->insert_rows('logs',$log_req);

           $this->trans_('complete');

           if ($this->trans_('status') === FALSE)
           {

               $this->session->set_flashdata('_error','Connection error Try Again');

           }
           else
           {

             // if(!empty($is_driver))
             // {
             //
             //   $this->session->set_flashdata('_success','Request has been updated');
             //
             // }
             // else
             // {

               $this->session->set_flashdata('_success','Request has been sent');

             // }

           }

           redirect('request_stock');

      }

  }

  public function pending_request()
  {

    $this->checkRole(44);

    $data = [

      'title' => 'Pending Requests',
      'page_head' => 'Pending Requests',
      'active_menu' => 'inventory',
      'active_submenu' => 'pending_request',
      'ajax_url' => site_url('Inventory/getDeliveryOrders'),
      'ajax_url1' => site_url('Inventory/getCallOrders'),
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'DataTable/pendingRequest.js',
        'main.js',
        'pending_request/pending_request.js',
        'inventory/change_status.js',
        'dataTable_buttons'
      ]

    ];

    $this->template('inventory/stock/pending_page',$data);

  }

  public function getDeliveryOrders()
	{

    $this->load->model('Inventory_model');

		$records = $this->Inventory_model->getDeliveryOrders($_REQUEST,'records');
		$totalFilteredRecords = $this->Inventory_model->getDeliveryOrders($_REQUEST,'filter');
		$recordsTotal = $this->Inventory_model->getDeliveryOrders($_REQUEST,'recordsTotal');

		$data = array();
		$SNo = 0;
		$Style = "";

		foreach ($records as $key => $v)
		{

      $ID = $v->id;

			$SNo++;

			$nestedData = array();

			$nestedData[] = $SNo;

      $delete_url = site_url('delete_delivery_order/'.$ID);

      $actions = '';

        $actions .= '<span class="actions-icons">';

          $actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Delivery Order?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
            <i class="fa-solid fa-trash"></i>
          </a>';

          $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getPendingPageStockDetails/delivery_order/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
            <i class="fa fa-eye"></i>
          </a>';

        $actions .= '</span>';

         $nestedData[] = $actions;

			$nestedData[] = $v->driver_name;
      $nestedData[] = $v->total_products;
      $nestedData[] = $v->total_qty;

        $change_status_url = site_url('update_delivery_order_status/'.$ID);

        $status = '<a href="javascript:void(0)" class="changeInv_status_ action-icons" data-btn-txt="Confirm" data-msg="Are you sure you want to Confirm this delivery order?" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Confirm">
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

  public function update_delivery_order_status($delivery_order_id)
  {

      $arr = [

        'status' => 'confirmed'

      ];


      $this->trans_('start');

         $this->bm->update('assign_stock',$arr,'id',$delivery_order_id);

         $assign_stock_row = $this->bm->getRow('assign_stock','id',$delivery_order_id);
         $products = $this->bm->getRows('assign_stock_details','assign_stock_id',$delivery_order_id);

         $logs = [];
         foreach ($products as $key => $v) {

             $logs[] = [

                 'product_id' => $v->product_id,
                 'driver_id' => $assign_stock_row->driver_id,
                 'qty' => $v->qty,
                 'type' => 'assign_stock_confirmed',
                 'added_by' => $this->user_id_,
                 'added_at' => $this->curr_datetime

             ];

         }

         $this->bm->insert_rows('logs',$logs);

      $this->trans_('complete');

      if ($this->trans_('status') === FALSE)
      {

          $this->session->set_flashdata('_error','Connection error Try Again');

      }
      else
      {

          $this->session->set_flashdata('_success','Delivery Order has confirmed successfully');

      }

      redirect('pending_request');

  }

  public function delete_delivery_order($delivery_order_id)
  {

      $arr = [

        'is_deleted' => 1

      ];

      $this->bm->delete('assign_stock_details','assign_stock_id',$delivery_order_id);
      $res = $this->bm->delete('assign_stock','id',$delivery_order_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Delivery Order deleted successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('pending_request');

  }

  public function getCallOrders()
  {

    $this->load->model('Inventory_model');

    $records = $this->Inventory_model->getCallOrders($_REQUEST,'records');
    $totalFilteredRecords = $this->Inventory_model->getCallOrders($_REQUEST,'filter');
    $recordsTotal = $this->Inventory_model->getCallOrders($_REQUEST,'recordsTotal');

    $data = array();
    $SNo = 0;
    $Style = "";

    foreach ($records as $key => $v)
    {

      $ID = $v->id;

      $SNo++;

      $nestedData = array();

      $nestedData[] = $SNo;


      $delete_url = site_url('delete_pending_call_order/'.$ID);

      $actions = '';

        $actions .= '<span class="actions-icons">';

          $actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Call Order?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
            <i class="fa-solid fa-trash"></i>
          </a>';

          $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getPendingPageStockDetails/call_order/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
            <i class="fa fa-eye"></i>
          </a>';

        $actions .= '</span>';

         $nestedData[] = $actions;


      $nestedData[] = $v->customer_name;
      $nestedData[] = $v->driver_name;
      $nestedData[] = $v->delivery_day;
      $nestedData[] = $v->total_products;
      $nestedData[] = $v->total_qty;
      // $nestedData[] = change_number_format($v->total_price);


        $change_status_url = site_url('update_pending_call_order_status/'.$ID);

        $status = '<a href="javascript:void(0)" class="changeInv_status_ action-icons" data-btn-txt="Confirm" data-msg="Are you sure you want to Confirm this Call Order?" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Confirm">
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

  public function update_pending_call_order_status($call_order_id)
  {

      $arr = [

        'pending_request_status' => 'confirmed'

      ];


      $this->trans_('start');

         $this->bm->update('call_orders',$arr,'id',$call_order_id);

         $call_order_row = $this->bm->getRow('call_orders','id',$call_order_id);
         $products = $this->bm->getRows('call_orders_details','call_order_id',$call_order_id);

         $logs = [];
         foreach ($products as $key => $v) {

             $logs[] = [

                 'product_id' => $v->product_id,
                 'customer_id' => $call_order_row->customer_id,
                 'driver_id' => $call_order_row->driver_id,
                 'qty' => $v->qty,
                 'type' => 'pending_call_order_confirmed',
                 'added_by' => $this->user_id_,
                 'added_at' => $this->curr_datetime

             ];

         }

         $this->bm->insert_rows('logs',$logs);

      $this->trans_('complete');

      if ($this->trans_('status') === FALSE)
      {

          $this->session->set_flashdata('_error','Connection error Try Again');

      }
      else
      {

          $this->session->set_flashdata('_success','Call Order has confirmed successfully');

      }

      redirect('pending_request');

  }

  public function delete_pending_call_order($call_order_id)
  {

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

      redirect('pending_request');

  }

  public function logs()
  {

    $this->checkRole(45);

    $type_arr = (object)[

      (object)[
        'id' => 'add_stock',
        'name' => 'Add Stock'
      ],
      (object)[
        'id' => 'remove_stock',
        'name' => 'Remove Stock'
      ],
      (object)[
        'id' => 'request',
        'name' => 'Driver Request'
      ],
      (object)[
        'id' => 'assign',
        'name' => 'Assign To Driver'
      ],
      (object)[
        'id' => 'return',
        'name' => 'Return Stock'
      ],
      (object)[
        'id' => 'call_order',
        'name' => 'Add Call Order'
      ],
      (object)[
        'id' => 'assign_stock_confirmed',
        'name' => 'Assign Stock Confirmed'
      ],
      (object)[
        'id' => 'call_order_confirmed',
        'name' => 'Call Order Confirmed'
      ],
      (object)[
        'id' => 'pending_call_order_confirmed',
        'name' => 'Pending Request Call Order Confirmed'
      ],
      (object)[
        'id' => 'add_sale',
        'name' => 'Add Sale'
      ],
      (object)[
        'id' => 'edit_sale',
        'name' => 'Edit Sale'
      ],
      (object)[
        'id' => 'mark_sale_done',
        'name' => 'Mark Sale Done'
      ],
      (object)[
        'id' => 'goods_return',
        'name' => 'Goods Return'
      ],
    ];

    $data = [

      'title' => 'Inventory Logs',
      'page_head' => 'Inventory Logs',
      'active_menu' => 'inventory',
      'active_submenu' => 'logs',
      'products' => $this->bm->getRows('products','is_deleted',0),
      'customers' => $this->bm->getRows('customers','is_deleted',0),
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'type_arr' => $type_arr,
      'scripts' => [
        'inventory/logs.js'
      ]

    ];

    $this->template('inventory/logs',$data);

  }

  public function view_driver_requests()
  {

    $this->checkRole(81);

    $data = [

      'title' => 'Request Summary',
      'page_head' => 'Request Summary',
      'active_menu' => 'inventory',
      'active_submenu' => 'driver_requests',
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'scripts' => [
        'inventory/driver_request.js'
      ]

    ];

    $this->template('inventory/driver_requests',$data);

  }

  public function goods_return()
  {

    $this->checkRole(82);

    $this->load->model('Product_model');
    $this->load->model('Customer_model');

    $data = [

      'title' => 'Goods Return',
      'page_head' => 'Goods Return',
      'active_menu' => 'inventory',
      'active_submenu' => 'goods_return',
      'customers' => $this->bm->getRowsWithConditions('customers',['driver_id' => $this->user_id_,'is_deleted' => 0, 'day'=>date('l')]),
      'not_assigned_customers' => $this->Customer_model->notAssignedCustomer($this->user_id_),
      'products' => $this->Product_model->getAllProducts(),
      'scripts' => [
        'inventory/goods_return.js'
      ]

    ];

    $this->template('inventory/goods_return',$data);

  }

  public function save_goods_return()
  {

    $is_driver = $this->bm->getRowWithConditions('users',['is_deleted' => 0,'type' => 'driver','id' => $this->user_id_]);

    if(empty($is_driver))
    {

      $this->session->set_flashdata('_error','The login user is not a driver');
      redirect('goods_return');

    }
    else
    {

      $p = $this->inp_post();

      $product_ids = $p['product_id'];

      $this->load->model('Inventory_model');

      $this->trans_('start');

        foreach($product_ids as $key => $pid)
        {

          $assign_stocks = $this->Inventory_model->getAssignProductOfDriver($this->user_id_,$pid);

          if(empty($assign_stocks['data']))
          {

            $this->session->set_flashdata('_error','You have not assigned any product');
            redirect('goods_return');

          }
          else
          {

            if($assign_stocks['is_product'] == true)
            {

              $arr = [
                'qty' => $assign_stocks['data']->qty + $p['qty'][$key],
                'available_qty' => $assign_stocks['data']->available_qty + $p['qty'][$key]
              ];

              $this->bm->update('assign_stock_details',$arr,'id',$assign_stocks['data']->id);

            }
            else
            {

              $arr = [
                'assign_stock_id' => $assign_stocks['data']->id,
                'product_id' => $pid,
                'qty' => $p['qty'][$key],
                'available_qty' => $p['qty'][$key],
                'exchange_qty' => 0,
                'foc_qty' => 0,
              ];

              $this->bm->insert_row('assign_stock_details',$arr);

            }

            // add exchange qty(usable)
            $logs = [

              'customer_id' => $p['customer_id'],
              'driver_id' => $this->user_id_,
              'product_id' => $pid,
              'qty' => $p['qty'][$key],
              'type' => 'goods_return',
              'added_by' => $this->user_id_,
              'added_at' => $this->curr_datetime

            ];

            $this->bm->insert_row('logs',$logs);

          }

        }

      $this->trans_('complete');

      if ($this->trans_('status') === FALSE)
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }
      else
      {

        $this->session->set_flashdata('_success','Goods Return successfully');

      }

      redirect('goods_return');

    }

  }

  public function return_summary()
  {

    // $this->checkRole(81);

    $data = [

      'title' => 'Return Summary',
      'page_head' => 'Return Summary',
      'active_menu' => 'inventory',
      'active_submenu' => 'return_summary',
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'scripts' => [
        'inventory/return_summary.js'
      ]

    ];

    $this->template('inventory/return_summary',$data);

  }

  public function missing_summary()
  {

    // $this->checkRole(81);

    $data = [

      'title' => 'Missing Summary',
      'page_head' => 'Missing Summary',
      'active_menu' => 'inventory',
      'active_submenu' => 'missing_summary',
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'scripts' => [
        'inventory/missing_summary.js'
      ]

    ];

    $this->template('inventory/missing_summary',$data);

  }

}
