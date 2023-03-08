<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxController extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

  }

  public function getUserDetailsByType($type,$user_id)
	{

      $this->load->library('encryption');

      $data = [

        'type' => $type,
        'user' => $this->bm->getRow('users','id',$user_id)

      ];

      $output['html'] = $this->load_view('users/modals/view_details',$data,true);

      echo json_encode($output);

	}

  public function getCategoryPrice($cat_id)
  {

      $output = $this->bm->getRow('categories','id',$cat_id);

      echo json_encode($output);

  }

  public function getProductDetails($product_id)
  {

      $product_row = $this->bm->getRow('products','id',$product_id);

      $data = [

        'type' => 'Product',
        'product' => $product_row,
        'category' => $this->bm->getRow('categories','id',$product_row->cat_id)

      ];

      $output['html'] = $this->load_view('product/view_details',$data,true);

      echo json_encode($output);

  }

  public function getCustomerDetails($customer_id)
  {

    $customer_row = $this->bm->getRow('customers','id',$customer_id);

    $data = [

      'type' => 'Customer',
      'customer' => $customer_row,
      'salesperson' => $this->bm->getRow('salesperson','id',$customer_row->salesperson_id),
      'driver' => $this->bm->getRow('users','id',$customer_row->driver_id)

    ];

    $output['html'] = $this->load_view('customer/view_details',$data,true);

    echo json_encode($output);

  }

  public function getCustomerProductPrices($customer_id)
  {

      $this->load->model('Category_model');
      $this->load->model('Customer_model');

      $product_categories = $this->Category_model->getAllProductCategoriesByCustomerId($customer_id);

      $customer_products_price = [];

      foreach ($product_categories as $key => $v)
      {

        $customer_products_price[] = $this->Customer_model->getCustomerProductPricesByCatId($v->id,$customer_id);

      }

      $data = [

        'product_categories' => $product_categories,
        'customer_product_prices' => $customer_products_price

      ];

      $output['html'] = $this->load_view('customer/customer_products_data',$data,true);
      $output['customer_id'] = $customer_id;

      echo json_encode($output);

  }

  public function getEvidenceDetails($evidence_id)
  {

    $this->load->model('Evidence_model');

    $data = [

      'type' => 'Evidence',
      'evidence' => $this->Evidence_model->getEvidenceDetails($evidence_id)

    ];

    $output['html'] = $this->load_view('evidence/view_details',$data,true);

    echo json_encode($output);

  }

  public function printEvidenceDetails($evidence_id)
  {

      $this->load->model('Evidence_model');

      $data = [

        'page_title' => 'Print Evidence Details',
        'type' => 'Evidence',
        'evidence' => $this->Evidence_model->getEvidenceDetails($evidence_id)

      ];

      $this->load_view('evidence/print',$data);

  }

  public function getTemplateData($template_id)
  {

      $output['data'] = $this->bm->getRow('email_templates','id',$template_id);

      echo json_encode($output);

  }

  public function getProductAvailableQty($product_id)
  {

    $this->load->model('Stock_model');

    $output['data'] = $this->Stock_model->getProductStock($product_id);

    echo json_encode($output);

  }

  public function getCustomersData($customer_id)
  {

    $output['data'] = $this->bm->getRow('customers','id',$customer_id);

    echo json_encode($output);

  }

  public function getCallOrderDetails($call_order_id)
  {

    $this->load->model('Order_model');

    $data['call_order'] = $this->Order_model->getCallOrderDetails($call_order_id);

    $output['html'] = $this->load_view('order/view_details',$data,true);

    echo json_encode($output);

  }

  public function getReturnStockProductsByDriverId($driver_id)
  {
      $this->load->model('Sale_model');

      $assign_products = $this->Sale_model->getAssignStockToDriver($driver_id);

      $data = [
        'assign_products' => $assign_products
      ];

      $output['html'] = $this->load_view('inventory/modals/return_stock_products',$data,true);

      echo json_encode($output);

  }

  public function getInventoryDetailsByType($tab,$product_id)
  {
      $this->load->model('Inventory_model');

      $stock_details = $this->Inventory_model->getProdudtStockDetails($tab,$product_id);

      $product = $this->bm->getRow('products','id',$product_id);

      $data = [

        'type' => $tab,
        'product' => $product,
        'stock_details' => $stock_details

      ];

      $output['html'] = $this->load_view('inventory/modals/inv_details',$data,true);

      echo json_encode($output);

  }


  public function getViewDetailsByDriverAssignQty($assign_stock_id)
  {
      $this->load->model('Stock_model');



      $data = [
        'assign_stock_details' => $this->Stock_model->getAssignStockDetails($assign_stock_id)
      ];

      $output['html'] = $this->load_view('inventory/modals/live_stock_details',$data,true);

      echo json_encode($output);

  }

  public function viewLogDetails()
  {

      $get = $this->inp_get();

      $get['types'] = explode(',',$get['type']);
      $product_ids = explode(',',$get['product_id']);
      $get['product_ids'] = $product_ids;
      $driver_ids = explode(',',$get['driver_id']);
      $get['driver_ids'] = $driver_ids;

      $this->load->model('Inventory_model');

      if(!empty($get['product_id']))
      {

        $products = $this->bm->getRowsWhereIn('products','id',$product_ids);
      }
      else
      {
        $products = [];
      }

      if(!empty($get['customer_id']))
      {
        $customer = $this->bm->getRow('customers','id',$get['customer_id']);
      }
      else
      {
        $customer = [];
      }

      if(!empty($get['driver_id']))
      {
        $drivers = $this->bm->getRowsWhereIn('users','id',$driver_ids);
      }
      else
      {
        $drivers = [];
      }

      $data = [

        'page_title' => 'Log Details',
        'products' => $products,
        'customer' => $customer,
        'drivers' => $drivers,
        'type' => $get['type'],
        'types' => $get['types'],
        'from' => $get['from'],
        'to' => $get['to'],
        'logs' => $this->Inventory_model->getLogDetails($get)

      ];

      if($get['export_type'] == 'Print')
      {

        $this->load_view('inventory/print_log_details',$data);

      }
      else
      {

        $this->load_view('inventory/excel_log_details',$data);

      }

  }

  public function viewDriverRequestDetails()
  {

      $get = $this->inp_get();

      $this->load->model('Stock_model');

      if(!empty($get['driver_id']))
      {
        $drivers = $this->bm->getRowsWithConditions('users',['id' => $get['driver_id']]);
      }
      else
      {
        $drivers = $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']);
      }

      $driver_stock_requests = [];
      foreach ($drivers as $key => $v) {
        $driver_stock_requests[$key] = $this->Stock_model->getDriverRequestedProductsSummary($v->id);
      }

      $data = [

        'page_title' => 'Stock Request Summary',
        'drivers' => $drivers,
        'driver_stock_requests' => $driver_stock_requests,
      ];

      // echo"<pre>";
      // print_r($data);

      // die();

      $this->load_view('inventory/print_driver_stock_request_details',$data);

  }


  public function getCustomerSaleInfo($customer_id)
  {

      $this->load->model('Sale_model');

      $unpaid_inv = $this->Sale_model->getCountCustomerUnpaidInvoices($customer_id);
      $customer = $this->bm->getRow('customers','id',$customer_id);

      $driver_id = $this->user_id_;
      $products = $this->Sale_model->getAssignStockToDriverForSale($customer_id,$driver_id);

      if($unpaid_inv->total > 0)
      {
          $output['total_unpaid_inv'] = '<span class="badge rounded-pill bg-danger">Total Unpaid Invoices: '. $unpaid_inv->total .'</span>';
      }
      else
      {
          $output['total_unpaid_inv'] = '<span class="badge rounded-pill bg-success">Total Unpaid Invoices: 0</span>';
      }

      $output['remarks'] = $customer->remarks;
      $output['payment_type'] = $customer->cat_type;
      $output['total_products'] = count($products);

      $data = [
          'products' => $products
      ];

      $output['html'] = $this->load_view('sales/customer_sale_products',$data,true);

      echo json_encode($output);

  }

  public function getCustomerConfirmedCallOrderInfo($customer_id)
  {

      $this->load->model('Sale_model');
      $this->load->model('Order_model');

      $unpaid_inv = $this->Sale_model->getCountCustomerUnpaidInvoices($customer_id);
      $customer = $this->bm->getRow('customers','id',$customer_id);

      $driver_id = $this->user_id_;
      $products = $this->Order_model->getCustomerCallOrdersProducts($customer_id,$driver_id);

      if($unpaid_inv->total > 0)
      {
          $output['total_unpaid_inv'] = '<span class="badge rounded-pill bg-danger">Total Unpaid Invoices: '. $unpaid_inv->total .'</span>';
      }
      else
      {
          $output['total_unpaid_inv'] = '<span class="badge rounded-pill bg-success">Total Unpaid Invoices: 0</span>';
      }

      $output['remarks'] = $customer->remarks;
      $output['payment_type'] = $customer->cat_type;
      $output['total_products'] = count($products);

      $data = [
          'products' => $products
      ];

      $output['html'] = $this->load_view('sales/customer_sale_call_order_products',$data,true);

      echo json_encode($output);

  }

  public function showSalesDetails($sale_id,$type = '')
  {

    $this->load->model('Sale_model');

    $sales_details = $this->Sale_model->getSaleDetails($sale_id);

    $sale = @$sales_details[0];

    $page_title = 'Sale Information';
    if ($type == 'invoice' || $type == 'invoice_print')
    {

      $page_title = 'Invoice Details';

    }

    $data = [
      'page_title' => $page_title,
      'type' => $type,
      'sale' => $sale,
      'sales_details' => $sales_details

    ];

    $output['html'] = $this->load_view('sales/view_sale',$data);

  }

  public function getCustomerPayments()
  {

    $p = $this->inp_get();

    $this->load->model('Payment_model');

    $payments = $this->Payment_model->getPayments($p['customer_id'],$p['from'],$p['to']);

    $customer = $this->bm->getRow('customers','id',$p['customer_id']);

    $data = [

      'page_title' => 'Customer Payments',
      'payments' => $payments,
      'customer' => $customer,
      'customer_id' => $p['customer_id'],
      'from' => $p['from'],
      'to' => $p['to']

    ];

    // $this->load_view('payments/view_payments1',$data);
    $this->load_view('payments/view_payments',$data);

  }

  public function getPendingPageStockDetails($type,$id)
  {

    if($type == 'call_order')
    {

      $this->load->model('Order_model');

      $details = $this->Order_model->getCallOrderDetails($id);

    }
    else
    {

      $this->load->model('Stock_model');

      $details = $this->Stock_model->getAssignStockDetails($id);

    }

    $data = [

      'type' => $type,
      'data' => $details

    ];

    $output['html'] = $this->load_view('inventory/modals/pending_page_details',$data,true);

    echo json_encode($output);

  }

  public function getDriverRequestedProducts($driver_id)
  {

    $this->load->model('Stock_model');
    $this->load->model('Product_model');

    $driver_request_products = $this->Stock_model->getDriverRequestedProducts($driver_id);

    $products = $this->Product_model->getAllProducts();

    $output = [

        'driver_request' => $driver_request_products,
        'products' => $products

    ];

    // $html = '';
    //
    // foreach ($driver_request_products as $key => $v)
    // {
    //
    //   $p_stock = getProductAvailableStock($v->product_id);
    //
    //   $available_stock = 'max='.$p_stock['available_qty'];
    //
    //   $html .= '<div class="row">'.
    //                   '<div class="col-sm-5 mb-3">'.
    //                     '<label for="product_" class="form-label">Product <a href="javascript:void(0)" class="remove_assign_products_to_driver">
    //                       <i class="fa-solid fa-x" style="font-size: 15px;color:#fd6262!important;"></i>
    //                     </a></label>'.
    //                     '<select class="form-select form-select-sm product_id_ select2_assign_products" data-width="100%" name="product_id[]" required>'.
    //                       '<option value="">select</option>';
    //
    //                       foreach ($products as $product)
    //                       {
    //
    //                         $html .='<option value="'. $product->id .'" "'. $v->product_id == $product->id?'selected':''.'">'. $product->name .'</option>';
    //
    //                       }
    //
    //           $html .='</select>'.
    //                   '</div>'.
    //                   '<div class="col-sm-2 mb-3">'.
    //                     '<label for="qty" class="form-label">Qty</label>'.
    //                     '<input type="number" class="form-control form-control-sm qty_" min="1" '. $available_stock .' name="qty" value="'. $v->qty .'">'.
    //                   '</div>'.
    //                   '<div class="col-sm-1" style="padding:0px!important;">'.
    //                     '<a href="javascript:void(0)" class="remove_assign_products_to_driver">'.
    //                       '<i class="fa-solid fa-x" style="font-size: 20px;margin-top: 38px;margin-left:8px;;color:#fd6262!important;"></i>'.
    //                     '</a>'.
    //                   '</div>'.
    //                 '</div>';
    //
    // }

    echo json_encode($output);


  }

  public function getAllSalesandCreditAmounts($type)
  {

      if ($type == 'weekly')
      {
        $output['heads'] = ["Mon","Tues","Wed","Thurs","Fri","Sat","Sun"];
      }
      else if($type == 'monthly')
      {
          $month_last_date = date("t", strtotime(date('Y-m-d')));
          $heads = [];
          for ($i=1; $i <= $month_last_date; $i++) {
            $heads[] = $i;
          }
          $output['heads'] = $heads;
      }
      else if($type == 'yearly')
      {
        $output['heads'] = ["Jan", "Feb", "Mar", "Apr","May","Jun", "Jul", "Aug","Sept","Oct","Nov","Dec"];
      }

      $this->load->model('Sale_model');

      $output['data'] = $this->Sale_model->getAllSalesandCreditAmounts($type);

      $output['data'] = $this->toFillNullDateData($type,$output);
      //
      // echo "<pre>";
      //  print_r($output);
      //  echo "</pre>";
      //  die();
      echo json_encode($output);

  }

  public function check_heads_value_exist($date,$array,$type = '')
  {

      $arr = [

        'total_sale_amount' => 0,
        'total_credit_amount' => 0

      ];

      foreach ($array as $key => $v)
      {

          if($type == 'yearly')
          {

            $added_at = date('m',strtotime($v['added_at']));

          }
          else
          {

            $added_at = date('Y-m-d',strtotime($v['added_at_formatted']));

          }

          if($added_at == $date)
          {

            $arr = [

              'total_sale_amount' => number_format(floatval($v['total_sale_amount']),2,'.',''),
              'total_credit_amount' => number_format(floatval($v['total_credit_amount']),2,'.','')

            ];

            break;

          }

      }

      return $arr;

  }

  public function getBetweenDates($startDate, $endDate)
  {

    $rangArray = [];

    $startDate = strtotime($startDate);

    $endDate = strtotime($endDate);

    for ($currentDate = $startDate; $currentDate <= $endDate;$currentDate += (86400))
    {

        $date = date('Y-m-d', $currentDate);

        $rangArray[] = $date;

    }

    return $rangArray;

  }

  public function toFillNullDateData($type,$output)
  {

      if ($type == 'weekly')
      {

        $week_first_day = date('Y-m-d',strtotime('monday this week'));
        $week_last_day = date('Y-m-d',strtotime('sunday this week'));

        $dates = $this->getBetweenDates($week_first_day,$week_last_day);

        $values = [];
        foreach ($dates as $key => $v)
        {

            $res = $this->check_heads_value_exist($v,$output['data']);

            $values['total_sale_amount'][] = $res['total_sale_amount'];
            $values['total_credit_amount'][] = 1;

        }

      }
      elseif ($type == 'monthly')
      {

        foreach ($output['heads'] as $key => $v)
        {

            if($v < 10)
            {
              $v = '0'.$v;
            }

            $cur_month = date('Y-m-'.$v);

            $res = $this->check_heads_value_exist($cur_month,$output['data']);

            $values['total_sale_amount'][] = $res['total_sale_amount'];
            $values['total_credit_amount'][] = $res['total_credit_amount'];

        }


      }
      elseif ($type == 'yearly')
      {

        $month_nums = ['01','02','03','04','05','06','07','08','09','10','11','12'];

        foreach ($month_nums as $key => $v)
        {

            $res = $this->check_heads_value_exist($v,$output['data'],'yearly');

            $values['total_sale_amount'][] = $res['total_sale_amount'];
            $values['total_credit_amount'][] = $res['total_credit_amount'];

        }


      }

      return $values;

  }


  public function sendPdfToCustomer()
  {

    $p = $this->inp_post();

    $sale_id = $p['sale_id'];
    $type = $p['type'];

    $output['status'] = false;
    $output['msg'] = 'Connection error try again';

    if($type != '' && $sale_id != '')
    {

        if($type != 'whatsapp')
        {
          //send mail to customer about his sale
          $res = $this->sendInvoicePdfOnMail($sale_id);

          if($res)
          {
              $output['status'] = true;
              $output['msg'] = 'Pdf has sent on email successfully';
          }

        }
        else
        {
          //send whatsapp to customer about his sale
          $res = $this->sendInvoicePdfOnWhatsapp($sale_id);

          if($res)
          {
              $output['status'] = true;
              $output['msg'] = 'Pdf has sent on whatsapp successfully';
          }

        }

    }

    echo json_encode($output);

  }

  public function generatePaymentsPdf($customer_id,$from_date,$to_date)
  {

    $this->load->model('Payment_model');

    $payments = $this->Payment_model->getPayments($customer_id,$from_date,$to_date);

    $customer = $this->bm->getRow('customers','id',$customer_id);

    $data = [

      'page_title' => 'Customer Payments',
      'payments' => $payments,
      'customer' => $customer,
      'customer_id' => $customer_id,
      'from' => $from_date,
      'to' => $to_date,
      'file' => 'soa',
      'root' => $_SERVER['DOCUMENT_ROOT'].'/',

    ];

    @$this->load->library('pdf');

    @$this->pdf->load_view('payments/payments_pdf',$data);


  }

  public function sendPaymentsInPdfToCustomer()
  {

    $p = $this->inp_post();

    $customer_id = $p['customer_id'];
    $from_date = $p['from_date'];
    $to_date = $p['to_date'];
    $type = $p['type'];

    $output['status'] = false;
    $output['msg'] = 'Connection error try again';

    if($type != '' && $customer_id != '' && $from_date != '' && $to_date != '')
    {

        $customer = $this->bm->getRow('customers','id',$customer_id);

        $email_subject = 'RZ';
        $email_body = '';

        $recurr_temp = $this->bm->getRowWithConditions('general_setting',['name' => 'RECURR_TEMP']);

        if(!empty($recurr_temp))
        {

          $template = $this->bm->getRow('email_templates','id',$recurr_temp->value);

          if(!empty($template))
          {

            $email_subject = $template->subject;
            $email_body = $this->replaceWithCustomerData($template->template,$customer);

          }

        }

        // generate payments pdf
        @$this->generatePaymentsPdf($customer_id,$from_date,$to_date);

        if($type != 'whatsapp')
        {

          if($customer->soa_email != '')
          {

            $arr = [

              'to' => $customer->soa_email,
              'subject' => $email_subject,
              'body' => $email_body,
              'attachment' => $_SERVER["DOCUMENT_ROOT"].'/assets/soa.pdf'

            ];

            //send mail to customer about his payments
            $res = $this->send_mail_($arr);

            if($res)
            {
                $output['status'] = true;
                $output['msg'] = 'Pdf has sent on email successfully';
            }

          }
          else
          {

              $output['status'] = true;
              $output['msg'] = 'Pdf has sent on email successfully';

          }

        }
        else
        {

          // send whatsapp to customer about his payments
          $res = $this->sendOnWhatsapp();

          if($res)
          {
              $output['status'] = true;
              $output['msg'] = 'Pdf has sent on whatsapp successfully';
          }

        }
    }

    echo json_encode($output);

  }

  public function getRightsDetails($type)
  {

      $this->load->model('Rights_model');

      $modules = $this->bm->getRows('modules');
      $roles = [];
      foreach ($modules as $key => $v) {

        $roles[$key] = $this->Rights_model->getModuleRolesByUserType($v->id,$type);

      }

      $data = [

        'type' => 'Rights',
        'modules' => $modules,
        'roles' => $roles

      ];

      $output['html'] = $this->load_view('users/modals/view_details',$data,true);

      echo json_encode($output);

  }

  public function getDailySalesandCreditAmounts()
  {

      $this->load->model('Sale_model');
      $this->load->model('Payment_model');

      $output['total_sale_amount'] = 0;
      $output['total_credit_amount'] = 0;

      $sale = $this->Sale_model->getDailySaleAmount();

      if(isset($sale->total_amount))
      {

        $output['total_sale_amount'] = change_number_format($sale->total_amount);

      }

      $credit = $this->Payment_model->getDailyCreditAmount();

      if(isset($credit))
      {

        $output['total_credit_amount'] = change_number_format(checkIsset($credit->total_credit) - checkIsset($credit->total_debit));

      }

      $calculation[] = $output['total_credit_amount'];
      $calculation[] = $output['total_sale_amount'];

      echo json_encode($calculation);

  }

  public function add_removed_sale_products()
  {

      $data['pro'] = $this->inp_get();

      $output['html'] = $this->load_view('sales/removed_sale_products',$data,true);

      echo json_encode($output);

  }

  public function viewReturnSummaryDetails()
  {

      $get = $this->inp_get();

      $this->load->model('Inventory_model');

      if(!empty($get['driver_id']))
      {
        $drivers = $this->bm->getRowsWithConditions('users',['id' => $get['driver_id']]);
      }
      else
      {
        $drivers = $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']);
      }

      $driver_return_summary = [];
      foreach ($drivers as $key => $v) {
        $driver_return_summary[$key] = $this->Inventory_model->getReturnSummaryDetails($v->id,$get['from'],$get['to']);
      }

      $data = [

        'page_title' => 'Return Summary',
        'drivers' => $drivers,
        'driver_return_summary' => $driver_return_summary,
        'from' => $get['from'],
        'to' => $get['to'],
      ];

      // echo"<pre>";
      // print_r($data);

      // die();

      $this->load_view('inventory/print_return_summary',$data);

  }

  public function viewMissingSummaryDetails()
  {

      $get = $this->inp_get();

      $this->load->model('Inventory_model');

      if(!empty($get['driver_id']))
      {
        $drivers = $this->bm->getRowsWithConditions('users',['id' => $get['driver_id']]);
      }
      else
      {
        $drivers = $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']);
      }

      $driver_missing_summary = [];
      foreach ($drivers as $key => $v) {
        $driver_missing_summary[$key] = $this->Inventory_model->getMissingSummaryDetails($v->id,$get['from'],$get['to']);
      }

      $data = [

        'page_title' => 'Missing Summary',
        'drivers' => $drivers,
        'driver_missing_summary' => $driver_missing_summary,
        'from' => $get['from'],
        'to' => $get['to'],
      ];


      // echo"<pre>";
      // print_r($data);

      // die();

      $this->load_view('inventory/print_missing_summary',$data);

  }

  public function showSalesStatusHistory($sale_id)
  {

    $history = $this->bm->getRows('sales_history','sale_id',$sale_id);

    $output = '';
    if(empty($history))
    {

      $output .= '<tr>';
      $output .= '<td colspan="3">No history found... </td>';
      $output .= '</tr>';
    }
    else
    {

      foreach ($history as $key => $v)
      {

        $output .= '<tr>';
        $output .= '<td>'. $key+1 .'</td>';
        $output .= '<td>'. ucfirst($v->status) .'</td>';
        $output .= '<td>'. getDateTimeFormat($v->added_at) .'</td>';
        $output .= '</tr>';

      }

    }

    $data['html'] = $output;

    echo json_encode($data);

  }

  public function printInventoryDetails()
  {

    $this->load->model('Inventory_model');

    $data = [

      'page_title' => 'Print Available Inventory Details',
      'available_inventory' => $this->Inventory_model->availableInventoryDetails()

    ];

    $this->load_view('inventory/print_available',$data);


  }

  public function printMultipleInvoices()
  {

      $get = $this->inp_get('sale_id');

      if($get != 'all')
      {

        $sale_ids = explode(',',$get);

      }
      else
      {

        $sale_ids = $get;

      }

      $this->load->model('Sale_model');

      $sales = $this->Sale_model->getSaleDetailsRow($sale_ids);

      $sales_details = [];
      foreach ($sales as $key => $v) {

          $sales_details[] = $this->Sale_model->getSaleDetailsRows($v->id);

      }

      // echo "<pre>";
      //
      // print_r($sale_ids);
      // print_r($sales);
      // print_r($sales_details);
      //
      // die();

      $page_title = 'Invoice Details';

      $data = [
        'page_title' => $page_title,
        'sales' => $sales,
        'sales_details' => $sales_details

      ];

      $this->load_view('invoices/print_invoices',$data);


  }

  public function printFilterInvoices()
  {

      $get = $this->inp_get();

      $this->load->model('Sale_model');

      $sales = $this->Sale_model->getFilterSaleDetailsRow($get);

      $sales_details = [];
      foreach ($sales as $key => $v) {

          $sales_details[] = $this->Sale_model->getSaleDetailsRows($v->id);

      }

      $page_title = 'Invoice Details';

      $data = [
        'page_title' => $page_title,
        'sales' => $sales,
        'sales_details' => $sales_details

      ];

      $this->load_view('invoices/print_invoices',$data);


  }


}
