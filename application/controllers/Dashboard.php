<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

  }

	public function index()
	{
    //
    // $this->sendOnWhatsapp();
    // die();
    $user = $this->bm->getRow('users','id',$this->user_id_);

    $data = [

      'title' => 'Dashboard',
      'active_menu' => 'dashboard',
      'user' => $user,
      'styles' => [
        'dashboard.css'
      ],
      'scripts' => [
        'charts/vectore-chart.js',
        'charts/dashboard.js'
      ]

    ];

    if($user->type == 'driver')
    {

        $this->load->model('Stock_model');
        $this->load->model('Order_model');
        $data['stock'] = $this->Stock_model->getAssignStockQtyToDriver($this->user_id_);
        $data['call_orders'] = $this->Order_model->getAllCallOrders($this->user_id_);

        $data['call_orders_details'] = [];

        foreach ($data['call_orders'] as $key => $v)
        {
            $data['call_orders_details'][$key] = $this->Order_model->getAllCallOrdersQtyByCallOrderId($v->id);
        }
    }
    else if($user->type == 'production')
    {

      $this->load->model('Product_model');
      $this->load->model('Driver_model');
      $data['products'] = $this->Product_model->getProductsCount();
      $data['drivers'] = $this->Driver_model->getDriversCount();

    }
    elseif ($user->type == 'admin')
    {

        $this->load->model('Customer_model');
        $this->load->model('Driver_model');
        $this->load->model('Sale_model');
        $this->load->model('Payment_model');

        $data['customers'] = $this->Customer_model->getCustomersCount();
        $data['drivers'] = $this->Driver_model->getDriversCount();
        $data['sale'] = $this->Sale_model->getTotalSaleAmount();
        $data['payment'] = $this->Payment_model->getTotalCreditAmount();
        $data['customer_credits'] = $this->Payment_model->getCustomerCreditsAmount();


      $total_daily_sale_amount = 0;
      $total_daily_credit_amount = 0;

      $sale = $this->Payment_model->getAllDailyPayments();
    
      if(!empty($sale))
      {
          
        //   echo "<pre>";
        //   print_r($sale);
        //   die();
        $t_credit = $sale->total_credit - $sale->total_debit;
        
        if($t_credit < 1)
        {
            $t_credit = 0;
        }
        
        $total_daily_credit_amount = change_number_format($t_credit);
        $total_daily_sale_amount = change_number_format($sale->total_debit);

      }

    //   $credit = $this->Payment_model->getDailyCreditAmount();

    //   if(isset($credit))
    //   {

    //     $total_daily_credit_amount = change_number_format(checkIsset($credit->total_credit) - checkIsset($credit->total_debit));

    //   }

      $data['total_daily_credit_amount'] = $total_daily_credit_amount;
      $data['total_daily_sale_amount'] = $total_daily_sale_amount;

    }


    $this->template('dashboard/index',$data);


	}

  public function update_language($language)
  { 

      if($language != '')
      {

        $this->session->set_userdata('user_language',$language);

      }
      else
      {
        
        $this->session->set_userdata('user_language','Eng');

      }

      echo json_encode(true);

  }

}
