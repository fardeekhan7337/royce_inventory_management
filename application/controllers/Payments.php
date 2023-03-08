<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->checkRole(59);

  }

	public function index()
	{

    $data = [

      'title' => 'Payments',
      'page_head' => 'Payments',
      'active_menu' => 'payments',
      'customers' => $this->bm->getRows('customers','is_deleted',0),
      'scripts' => [
        'payment/payment.js'
      ]

    ];

    $this->template('payments/index',$data);

	}

  public function save_payment()
  {

      $p = $this->inp_post();

      $this->trans_('start');

        $payment_row = [

          'customer_id' => $p['customer_id'],
          'amount' => $p['amount'],
          'type' => 'debit',
          'added_by' => $this->user_id_,
          'added_at' => $this->curr_datetime

        ];
        
        $this->bm->insert_row('payments',$payment_row);

      $this->trans_('complete');

      if ($this->trans_('status') === FALSE)
      {

          $this->session->set_flashdata('_error','Connection error Try Again');

      }
      else
      {

          $this->session->set_flashdata('_success','Payment added successfully');

      }

      redirect('payments');

  }

}
