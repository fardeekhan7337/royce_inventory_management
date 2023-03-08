<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller
{

	public function __construct()
  {

		parent:: __construct();

	}

	public function sendRecurringMail()
  {

		$general_setting = $this->bm->getRow('general_setting','name','SENDING_TYPE');

		$this->load->model('Customer_model');

		$customers = $this->Customer_model->getRecurringCustomers();

		$is_email_send = false;

		if(!empty($general_setting))
		{

				switch ($general_setting->send_type) {

					case 'Daily':

						$is_email_send = true;

						break;
					case 'Weekly':

						if(!empty($general_setting->send_on))
						{

								$cur_day = date('d-m-Y');

								if($general_setting->send_on == $cur_day)
								{

										$is_email_send = true;

								}

						}

						break;
					case 'Monthly':

						if(!empty($general_setting->send_on))
						{

								$date =  $general_setting->send_on;

								if($date < 10)
								{

										$date = '0'.$date;

								}

								$cur_date = date('d');

								if($cur_date == $date)
								{

									$is_email_send = true;

								}
						}

						break;

				}

				if($is_email_send)
				{

					foreach ($customers as $key => $v)
					{

							$this->bm->insert_row('mails',['mail_to' => $v->id]);

							$this->sendPaymentsInPdfToCustomer($v->id,$v->soa_email);


					}

				}

		}

	}

  public function send_mail_($arr)
  {

      $this->load->library('email');

      $to = $arr['to'];
      $subject = $arr['subject'];
      $body = $arr['body'];

      $company_name = companySetting('name');

      $config['crlf']     = "\r\n";
      $config['newline']  = "\r\n";
      $config['mailtype'] = 'html';
      $config['charset']  = 'utf-8';

      $this->email->initialize($config);
      $this->email->from('RZ',$company_name);
      $this->email->to($to);

      $this->email->subject($subject);

      $this->email->message($body);

      if(isset($arr['attachment']))
      {

        $this->email->attach($arr['attachment']);

      }

      if($this->email->send() == true)
      {
        return true;
      }
      else
      {
        return false;
      }

  }

	public function generatePaymentsPdf($customer_id)
	{

		$this->load->model('Payment_model');

		$payments = $this->Payment_model->getPayments($customer_id);

		$customer = $this->bm->getRow('customers','id',$customer_id);

		$data = [

			'page_title' => 'Customer Payments',
			'payments' => $payments,
			'customer' => $customer,
			'customer_id' => $customer_id,
			'from' => '',
			'to' => '',
			'file' => 'soa',
			'root' => $_SERVER['DOCUMENT_ROOT'].'/',

		];

		@$this->load->library('pdf');

		@$this->pdf->load_view('payments/payments_pdf',$data);

	}

  public function replaceWithCustomerData($msg,$customer)
  {

    $name = isset($customer->name)?$customer->name:'';
    $shop_name = isset($customer->shop_name)?$customer->shop_name:'';
    $primary_contact = isset($customer->primary_contact)?$customer->primary_contact:'';
    $secondary_contact = isset($customer->secondary_contact)?$customer->secondary_contact:'';
    $e_receipt_email = isset($customer->e_receipt_email)?$customer->e_receipt_email:'';
    $soa_email = isset($customer->soa_email)?$customer->soa_email:'';
    $address = isset($customer->address)?$customer->address:'';
    $cur_date = date('d-m-Y');

    $search = ['[NAME]','[SHOP_NAME]','[PRIMARY_CONTACT]','[SECONDARY_CONTACT]','[E_RECEIPT_EMAIL]','[SOA_EMAIL]','[SHOP_ADDRESS]','[CURR_DATE]'];
    $replace = [$name, $shop_name, $primary_contact,$secondary_contact,$e_receipt_email,$soa_email,$address,$cur_date];

    $message = str_replace($search, $replace, $msg);

    return $message;

  }

	public function sendPaymentsInPdfToCustomer($customer_id,$customer_email)
  {

    if($customer_id != '' && $customer_email != '')
    {

				$customer_row = $this->bm->getRow('customers','id',$customer_id);

        $email_subject = 'RZ';
        $email_body = '';

        $recurr_temp = $this->bm->getRowWithConditions('general_setting',['name' => 'RECURR_TEMP']);

        if(!empty($recurr_temp))
        {

          $template = $this->bm->getRow('email_templates','id',$recurr_temp->value);

          if(!empty($template))
          {

            $email_subject = $template->subject;
            $email_body = $this->replaceWithCustomerData($template->template,$customer_row);

          }

        }

        // generate payments pdf
        @$this->generatePaymentsPdf($customer_id);

          $arr = [

            'to' => $customer_email,
            'subject' => $email_subject,
            'body' => $email_body,
            'attachment' => $_SERVER["DOCUMENT_ROOT"].'/assets/soa.pdf'

          ];

          //send mail to customer about his payments
          $this->send_mail_($arr);

    }

    return true;

  }

}
