<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->checkRole(46);

  }

	public function index()
	{

    $data = [

      'title' => 'Sales',
      'page_head' => 'Sales',
      'active_menu' => 'sales',
      'ajax_url' => site_url('Sales/getSales'),
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'sales/sales.js',
        'dataTable_buttons'
      ]

    ];

    $this->template('sales/index',$data);

	}

  public function getSales()
  {

    $this->load->model('Sale_model');

    $records = $this->Sale_model->getSales($_REQUEST,'records');
    $totalFilteredRecords = $this->Sale_model->getSales($_REQUEST,'filter');
    $recordsTotal = $this->Sale_model->getSales($_REQUEST,'recordsTotal');

    $data = array();
    $SNo = 0;
    $Style = "";

    foreach ($records as $key => $v)
    {

      $ID = $v->id;

      $SNo++;

      $nestedData = array();

      $nestedData[] = $SNo;

      $delete_url = site_url('delete_sale/'.$ID);

      $actions = '';

        $actions .= '<span class="actions-icons">';

        if ($v->status == 'pending') {

          if (isUserAllow(49)) {


              $actions .= '<a href="'.site_url('edit_sale/'.$ID) .'" class="action-icons" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                <i class="fa fa-pencil"></i>
              </a>';

            }

          if (isUserAllow(80)) {

            $actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Sale?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </a>';

          }

        }

        if (isUserAllow(50)) {

          $actions .= '<a href="javascript:void(0)" class="action-icons view_sale_details_" data-url="'. site_url('AjaxController/showSalesDetails/'.$ID.'/details') .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
            <i class="fa fa-eye"></i>
          </a>';

        }

        // if (isUserAllow(50)) {

          $actions .= '<a href="javascript:void(0)" class="action-icons view_sale_history_" data-url="'. site_url('AjaxController/showSalesStatusHistory/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View History">
            <i class="fa fa-file-text"></i>
          </a>';

        // }

        $actions .= '</span>';

         $nestedData[] = $actions;

         $sale_type = $v->sale_type == 'delivery_order'?'Sale Order':'Call Order';

         // $nestedData[] = getDateTimeFormat($v->added_at,'date');
         // $nestedData[] = $sale_type;
         // $nestedData[] = $v->invoice_no;
         // $nestedData[] = $v->customer_name;
         // $nestedData[] = $v->shop_name;
         // $nestedData[] = $v->shop_acronym;
         // $nestedData[] = $v->driver_name;
         // $nestedData[] = $v->customer_category;
         // $nestedData[] = $v->salesperson_name;
         // $nestedData[] = $v->total_products;
         // $nestedData[] = $v->total_qty;
         // $nestedData[] = $v->total_amount;

         $nestedData[] = $v->salesperson_name;
         $nestedData[] = $v->shop_acronym;
         $nestedData[] = getDateTimeFormat($v->added_at,'date');
         $nestedData[] = $v->customer_category;
         $nestedData[] = $v->invoice_no;
         $nestedData[] = $v->total_amount;
         $nestedData[] = $sale_type;
         $nestedData[] = $v->driver_name;
         $nestedData[] = $v->total_products;
         $nestedData[] = $v->total_qty;
         $nestedData[] = $v->shop_name;

      $change_status_class = '';

        if (isUserAllow(76)) {

          $change_status_class = 'changeSalesStatus';

        }

        if($v->status == 'unpaid' || $v->status == 'credit' || $v->status == 'paid')
        {

          $change_status_url = site_url('update_sales_status/'.$v->status.'/'.$ID);

          if($v->status == 'paid')
          {
            $bg = 'success';
          }
          elseif ($v->status == 'credit') {
            $bg = 'warning';
          }
          elseif ($v->status == 'unpaid') {
            $bg = 'warning';
          }

          $status = '<a href="javascript:void(0)" class="'. $change_status_class .' action-icons" data-msg="Are you sure you want to Paid this invoice?" data-btn="Change Status" data-url="'. $change_status_url .'" data-ID="'. $ID .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Change Status">
                   <span class="badge rounded-pill bg-'. $bg .'">'. ucfirst($v->status) .'</span>
             </a>';

        }
        else
        {


          if ($v->status == 'pending') {
            $bg = 'secondary';
          }

          $status = '<span class="badge rounded-pill bg-'. $bg .'">'. ucfirst($v->status) .'</span>';

        }

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

    $this->checkRole(48);
    $this->load->model('Customer_model');

    $data = [

      'title' => 'Add Sale',
      'page_head' => 'Add Sale',
      'active_menu' => 'sales',
      'customers' => $this->bm->getRowsWithConditions('customers',['driver_id' => $this->user_id_,'is_deleted' => 0, 'day'=>date('l')]),
      'not_assigned_customers' => $this->Customer_model->notAssignedCustomer($this->user_id_),
      'styles' => [
        'add_sale.css'
      ],
      'scripts' => [
        'sales/add_sale.js'
      ]

    ];

    $this->template('sales/create',$data);

  }

  public function save_sale()
  {

      $this->load->model('Sale_model');

      $p = $this->inp_post();

      $sale_row = $this->Sale_model->getLastInvoiceNo($p['customer_category']);

      $ID = (isset($p['ID'])?$p['ID']:'');
      unset($p['ID']);

      $NewInvoiceNo = '';
      if ($ID == '')
      {

        if(!empty($sale_row))
        {

            if($p['customer_category'] == 'Cash')
            {

                $remove_char = str_replace("CA","",$sale_row->invoice_no);

                $inv_prefix = "CA";

            }
            else
            {

                $remove_char = str_replace("T","",$sale_row->invoice_no);

                $inv_prefix = "T";

            }

           $NewInvoiceNo = str_pad($remove_char + 1, 5, '0', STR_PAD_LEFT);

           $NewInvoiceNo = $inv_prefix.''.$NewInvoiceNo;

         }
         else
         {

             if($p['customer_category'] == 'Cash')
             {
                $NewInvoiceNo = "CA00001";
             }
             else
             {
               $NewInvoiceNo = "T00001";
             }

         }

       }

       $arr = [
         'invoice_no' => $NewInvoiceNo,
         'customer_id' => $p['customer_id'],
         'customer_category' => $p['customer_category'],
         'total_amount' => $p['total_amount'],
         'is_pay' => $p['is_customer_pay'] == 'No'?0:1,
         'pay_type' => $p['payment_type'],
         'reason' => $p['reason'],
         'bank' => $p['bank_name'],
         'acc_no' => $p['acc_no'],
         'cheque_no' => $p['cheque_no'],
         'status' => 'pending',
         'sale_type' => 'delivery_order',
         'main_id' => isset($p['main_id'])?$p['main_id']:0,
         'added_by' => $this->user_id_
       ];

       $this->trans_('start');

             if(!empty($ID))
             {

               unset($arr['invoice_no']);
               unset($arr['added_by']);
               unset($arr['main_id']);

               $this->bm->update('sales',$arr,'id',$ID);

               $last_id = $ID;

               $this->bm->delete('sales_details','sale_id',$ID);

             }
             else
             {

                $arr['added_at'] = $this->curr_datetime;
               $last_id = $this->bm->insert_row('sales',$arr);

             }


            $sale_products = [];

            $logs = [];

            foreach ($p['product_id'] as $key => $v) {

                $sale_products[] = [

                  'sale_id' => $last_id,
                  'product_id' => $v,
                  'price' => $p['price'][$key],
                  'sale_qty' => $p['sale_qty'][$key] == ''?0:$p['sale_qty'][$key],
                  'exchange_qty' => $p['exchange_qty'][$key] == ''?0:$p['exchange_qty'][$key],
                  'foc_qty' => $p['foc_qty'][$key] == ''?0:$p['foc_qty'][$key],
                  'amount' => $p['amount'][$key] == ''?0:$p['amount'][$key]

                ];

                $logs[] = [

                    'product_id' => $v,
                    'customer_id' => $p['customer_id'],
                    'driver_id' => $this->user_id_,
                    'qty' => $p['sale_qty'][$key] == ''?0:$p['sale_qty'][$key],
                    'type' => $ID == ''?'add_sale':'edit_sale',
                    'qty_type' => 'sale_qty',
                    'added_by' => $this->user_id_,
                    'added_at' => $this->curr_datetime

                ];
                $logs[] = [

                  'product_id' => $v,
                  'customer_id' => $p['customer_id'],
                  'driver_id' => $this->user_id_,
                  'qty' => $p['exchange_qty'][$key] == ''?0:$p['exchange_qty'][$key],
                  'type' => $ID == ''?'add_sale':'edit_sale',
                  'qty_type' => 'exchange_qty',
                  'added_by' => $this->user_id_,
                  'added_at' => $this->curr_datetime

                ];
                $logs[] = [

                  'product_id' => $v,
                  'customer_id' => $p['customer_id'],
                  'driver_id' => $this->user_id_,
                  'qty' => $p['foc_qty'][$key] == ''?0:$p['foc_qty'][$key],
                  'type' => $ID == ''?'add_sale':'edit_sale',
                  'qty_type' => 'foc_qty',
                  'added_by' => $this->user_id_,
                  'added_at' => $this->curr_datetime

                ];

            }

            $this->bm->insert_rows('sales_details',$sale_products);
            $this->bm->insert_rows('logs',$logs);

       $this->trans_('complete');

       if ($this->trans_('status') === FALSE)
       {

           $output['status'] = false;
           $output['msg'] = 'Connection error Try Again';
           $output['sale_id'] = 0;

       }
       else
       {

         $output['status'] = true;

         if($ID != '')
         {

           $output['msg'] = 'Sale updated successfully';

         }
         else
         {

           $output['msg'] = 'Sale added successfully';

         }

         $output['sale_id'] = $last_id;

       }

       echo json_encode($output);

  }

  public function edit($sale_id)
  {

    $this->checkRole(49);

    $this->load->model('Sale_model');

    $sales_details = $this->Sale_model->getEditSaleDetails($sale_id,$this->user_id_);

      if (empty($sales_details))
      {

          $this->session->set_flashdata('_error','Stock of products in selected sale has sold');
          redirect('sales');

      }

    $sale = @$sales_details[0];

    if (isset($sale->sale_type) && $sale->sale_type != 'call_order')
    {
        $added_product_ids = array_column($sales_details,'product_id');

        if(!empty($added_product_ids))
        {

          $removed_products = $this->Sale_model->getRemovedProducts($added_product_ids,$sale->main_id,$sale->customer_id);

        }
        else
        {
          $removed_products = [];
        }


    }

    $data = [

      'title' => 'Edit Sale',
      'page_head' => 'Edit Sale',
      'active_menu' => 'sales',
      'sale' => $sale,
      'sales_details' => $sales_details,
      'removed_products' => $removed_products,
      'styles' => [
        'add_sale.css'
      ],
      'scripts' => [
        'sales/add_sale.js'
      ]

    ];

    $this->template('sales/edit',$data);

  }

  public function mark_as_done()
  {

      $this->load->model('Sale_model');

      $sale_id = $this->inp_post('sale_id');

      $this->trans_('start');

          $sale_row = $this->bm->getRow('sales','id',$sale_id);

          // insert row for credit payment
          $payment_row = [

              'sale_id' => $sale_id,
              'customer_id' => $sale_row->customer_id,
              'amount' => $sale_row->total_amount,
              'type' => 'credit',
              'added_by' => $this->user_id_,
              'added_at' => $this->curr_datetime

          ];

          $this->bm->insert_row('payments',$payment_row);

          if($sale_row->customer_category == 'cash')
          {

            if($sale_row->is_pay == 0)
            {

              $arr['status'] = 'unpaid';

            }
            else if($sale_row->is_pay == 1)
            {

              $arr['status'] = 'paid';

              // insert row for debit payment
              $payment_row['type'] = 'debit';
              $payment_row['added_at'] = $this->curr_datetime;

              $this->bm->insert_row('payments',$payment_row);

            }

          }
          elseif ($sale_row->customer_category == 'credit')
          {

            $arr['status'] = 'credit';

          }

          $arr['is_mark_done'] = 1;
          $this->bm->update('sales',$arr,'id',$sale_id);

          $sales_products = $this->bm->getRows('sales_details','sale_id',$sale_id);

          $logs = [];

          foreach ($sales_products as $key => $v)
          {

              if($sale_row->sale_type != 'call_order')
              {

                $total_qty = $v->sale_qty + $v->exchange_qty + $v->foc_qty;
                $assign_stock_row = $this->Sale_model->getDriverProductStockByProductId($v->product_id,$this->user_id_,$sale_row->main_id);

                if(!empty($assign_stock_row))
                {

                  $update_assignstock_qty = [

                    'available_qty' => $assign_stock_row->available_qty - $total_qty,
                    // 'sale_qty' => $assign_stock_row->sale_qty + $v->sale_qty,
                    'exchange_qty' => $assign_stock_row->exchange_qty + $v->exchange_qty,
                    'foc_qty' => $assign_stock_row->foc_qty + $v->foc_qty

                  ];

                  $this->bm->update('assign_stock_details',$update_assignstock_qty,'id',$assign_stock_row->id);

                }

              }

              $logs[] = [

                  'product_id' => $v->product_id,
                  'customer_id' => $sale_row->customer_id,
                  'driver_id' => $this->user_id_,
                  'qty' => $v->sale_qty,
                  'type' => 'mark_sale_done',
                  'qty_type' => 'sale_qty',
                  'added_by' => $this->user_id_,
                  'added_at' => $this->curr_datetime

              ];
              $logs[] = [

                'product_id' => $v->product_id,
                'customer_id' => $sale_row->customer_id,
                'driver_id' => $this->user_id_,
                'qty' => $v->exchange_qty,
                'type' => 'mark_sale_done',
                'qty_type' => 'exchange_qty',
                'added_by' => $this->user_id_,
                'added_at' => $this->curr_datetime

              ];
              $logs[] = [

                'product_id' => $v->product_id,
                'customer_id' => $sale_row->customer_id,
                'driver_id' => $this->user_id_,
                'qty' => $v->foc_qty,
                'type' => 'mark_sale_done',
                'qty_type' => 'foc_qty',
                'added_by' => $this->user_id_,
                'added_at' => $this->curr_datetime

              ];

          }

           $this->bm->insert_rows('logs',$logs);

           // check is_send sale pdf on mail or not
           $is_invoice_email = $this->bm->getRowWithConditions('general_setting',['name' => 'INVOICE_EMAIL']);

           if(!empty($is_invoice_email))
           {

              if($is_invoice_email->value == 'yes')
              {

                //send mail to customer about his sale
                $this->sendInvoicePdfOnMail($sale_row->id);

              }

           }
           // check is_send sale pdf on whatsapp or not
           $is_invoice_whatsapp = $this->bm->getRowWithConditions('general_setting',['name' => 'INVOICE_WHATSAPP']);

           if(!empty($is_invoice_whatsapp))
           {

              if($is_invoice_whatsapp->value == 'yes')
              {

                //send whatsapp to customer about his sale
                $this->sendInvoicePdfOnWhatsapp($sale_row->id);

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

        //check driver available stock remaining or not

        if($sale_row->sale_type != 'call_order')
        {

          $is_stock_remaining = $this->Sale_model->checkDriverStockRemainingOrNot($sale_row->main_id);

          if($is_stock_remaining == 0)
          {

            $this->bm->update('assign_stock',['is_return' => 1],'id',$sale_row->main_id);

          }

        }

        $output['status'] = true;
        $output['msg'] = 'Sale submit successfully';

      }

      echo json_encode($output);

  }

  public function update_sales_status($type,$sale_id)
  {

      $this->trans_('start');

          $sale_row = $this->bm->getRow('sales','id',$sale_id);

          // insert row for credit payment
          $payment_row = [

              'sale_id' => $sale_id,
              'customer_id' => $sale_row->customer_id,
              'amount' => $sale_row->total_amount,
              'type' => 'debit',
              'added_by' => $this->user_id_,
              'added_at' => $this->curr_datetime

          ];

          $this->bm->insert_row('payments',$payment_row);

          $arr['status'] = 'paid';

          $this->bm->update('sales',$arr,'id',$sale_id);

      $this->trans_('complete');

       if ($this->trans_('status') === FALSE)
       {

           $this->session->set_flashdata('_error','Connection error Try Again');

       }
       else
       {

          $this->session->set_flashdata('_success','Sale has paid successfully');

       }

       redirect('sales');

  }

  public function sales_status_update()
  {

      $p = $this->inp_get();

      $sale_id = $p['id'];
      $sale_status = $p['status'];

      $this->trans_('start');

          $sale_row = $this->bm->getRow('sales','id',$sale_id);

          $type = $sale_status == 'paid'?'debit':'credit';
          // insert row for credit payment
          $payment_row = [

              'sale_id' => $sale_id,
              'customer_id' => $sale_row->customer_id,
              'amount' => $sale_row->total_amount,
              'type' => $type,
              'added_by' => $this->user_id_,
              'added_at' => $this->curr_datetime

          ];

          $this->bm->insert_row('payments',$payment_row);

          // insert row for status history
          $history = [

              'sale_id' => $sale_id,
              'status' => $sale_status,
              'added_by' => $this->user_id_,
              'added_at' => $this->curr_datetime

          ];

          $this->bm->insert_row('sales_history',$history);

          $arr['status'] = $sale_status;

          $this->bm->update('sales',$arr,'id',$sale_id);

      $this->trans_('complete');

       if ($this->trans_('status') === FALSE)
       {

           $this->session->set_flashdata('_error','Connection error Try Again');

       }
       else
       {

          $this->session->set_flashdata('_success','Sale has '. $sale_status .' successfully');

       }

       echo json_encode(['redirect' => site_url('sales')]);

  }


  public function sale_call_order()
  {

    $this->checkRole(48);

    $this->load->model('Order_model');

    $driver_id = $this->user_id_;

    $customers = $this->Order_model->getAllCallOrdersCustomers($driver_id);

    $data = [

      'title' => 'Add Call Order Sale',
      'page_head' => 'Add Call Order Sale',
      'active_menu' => 'sales',
      'customers' => $customers,
      'styles' => [
        'add_sale.css'
      ],
      'scripts' => [
        'sales/sale_call_order.js'
      ]

    ];

    $this->template('sales/sale_call_order',$data);

  }

  public function save_call_order_sale()
  {

      $this->load->model('Sale_model');

      $p = $this->inp_post();

      $sale_row = $this->Sale_model->getLastInvoiceNo($p['customer_category']);

      $ID = (isset($p['ID'])?$p['ID']:'');
      unset($p['ID']);

      $NewInvoiceNo = '';
      if ($ID == '')
      {

        if(!empty($sale_row))
        {

            if($p['customer_category'] == 'Cash')
            {

                $remove_char = str_replace("CA","",$sale_row->invoice_no);

                $inv_prefix = "CA";

            }
            else
            {

                $remove_char = str_replace("T","",$sale_row->invoice_no);

                $inv_prefix = "T";

            }

           $NewInvoiceNo = str_pad($remove_char + 1, 5, '0', STR_PAD_LEFT);

           $NewInvoiceNo = $inv_prefix.''.$NewInvoiceNo;

         }
         else
         {

             if($p['customer_category'] == 'Cash')
             {
                $NewInvoiceNo = "CA00001";
             }
             else
             {
               $NewInvoiceNo = "T00001";
             }

         }

       }

       $arr = [
         'invoice_no' => $NewInvoiceNo,
         'customer_id' => $p['customer_id'],
         'customer_category' => $p['customer_category'],
         'total_amount' => $p['total_amount'],
         'is_pay' => $p['is_customer_pay'] == 'No'?0:1,
         'pay_type' => $p['payment_type'],
         'reason' => $p['reason'],
         'bank' => $p['bank_name'],
         'acc_no' => $p['acc_no'],
         'cheque_no' => $p['cheque_no'],
         'status' => 'pending',
         'sale_type' => 'call_order',
         'main_id' => isset($p['main_id'])?$p['main_id']:0,
         'added_by' => $this->user_id_
       ];

       $this->trans_('start');

             if(!empty($ID))
             {

               unset($arr['invoice_no']);
               unset($arr['added_by']);
               unset($arr['main_id']);

               $this->bm->update('sales',$arr,'id',$ID);

               $last_id = $ID;

               $this->bm->delete('sales_details','sale_id',$ID);

             }
             else
             {

               $call_order_id = isset($p['main_id'])?$p['main_id']:0;

               $this->bm->update('call_orders',['is_given' => 1],'id',$call_order_id);

                $arr['added_at'] = $this->curr_datetime;
               $last_id = $this->bm->insert_row('sales',$arr);

             }


            $sale_products = [];

            $logs = [];

            foreach ($p['product_id'] as $key => $v) {

                $sale_products[] = [

                  'sale_id' => $last_id,
                  'product_id' => $v,
                  'price' => $p['price'][$key],
                  'sale_qty' => $p['sale_qty'][$key] == ''?0:$p['sale_qty'][$key],
                  'exchange_qty' => $p['exchange_qty'][$key] == ''?0:$p['exchange_qty'][$key],
                  'foc_qty' => $p['foc_qty'][$key] == ''?0:$p['foc_qty'][$key],
                  'amount' => $p['amount'][$key] == ''?0:$p['amount'][$key]

                ];

                $logs[] = [

                    'product_id' => $v,
                    'customer_id' => $p['customer_id'],
                    'driver_id' => $this->user_id_,
                    'qty' => $p['sale_qty'][$key] == ''?0:$p['sale_qty'][$key],
                    'type' => $ID == ''?'add_sale':'edit_sale',
                    'qty_type' => 'sale_qty',
                    'added_by' => $this->user_id_,
                    'added_at' => $this->curr_datetime

                ];

            }

            $this->bm->insert_rows('sales_details',$sale_products);
            $this->bm->insert_rows('logs',$logs);

       $this->trans_('complete');

       if ($this->trans_('status') === FALSE)
       {

           $output['status'] = false;
           $output['msg'] = 'Connection error Try Again';
           $output['sale_id'] = 0;

       }
       else
       {

         $output['status'] = true;

         if($ID != '')
         {

           $output['msg'] = 'Sale updated successfully';

         }
         else
         {

           $output['msg'] = 'Sale added successfully';

         }

         $output['sale_id'] = $last_id;

       }

       echo json_encode($output);

  }

  public function delete($sale_id)
  {

      $this->checkRole(80);

      $arr = [

        'is_deleted' => 1

      ];

      $res = $this->bm->update('sales',$arr,'id',$sale_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Sale deleted successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('sales');

  }

  public function testpdf()
  {
      $this->generateSalePdf(1);
  }

}
