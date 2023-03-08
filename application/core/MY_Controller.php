<?php

class MY_Controller extends CI_Controller
{

  public $user_id_ = 0;
  public $use_type_ = 0;
  public $curr_datetime = '';

  public function __construct()
  {

      parent::__construct();

      $this->check_user_login();

      $this->curr_datetime = date('Y-m-d H:i:s');

      $this->user_id_ = $this->session->userdata('UID');

      $this->use_type_ = $this->session->userdata('UTYPE');

      if ($this->session->userdata('user_language') == 'CHN') {

          $language = 'Chinese';

      }
      else{

        $language = 'Eng';

      }

        $this->load->language($language,$language);

  }

  public function template($path,$data = '')
  {

      if(!isset($data['active_submenu']))
      {
          $data['active_submenu'] = '';
      }

      $this->load->view('template/header',$data);
      $this->load->view('template/sidebar');
      $this->load->view($path);
      $this->load->view('template/footer');

  }

  public function load_view($path,$data = '',$render = false)
  {

      if(!isset($data['active_submenu']) && $render != true)
      {
          $data['active_submenu'] = '';

          $this->load->view($path,$data);

      }
      else
      {

        return $this->load->view($path,$data,true);

      }


  }

  public function inp_post($index = '')
  {

      if($index != '')
      {

        return $this->input->post($index);

      }
      else
      {

        return $this->input->post();

      }

  }

  public function inp_get($index = '')
  {

      if($index != '')
      {

        return $this->input->get($index);

      }
      else
      {

        return $this->input->get();

      }

  }

  public function trans_($type = 'start')
  {

      switch ($type) {
        case 'start':

            return $this->db->trans_start();

          break;

        case 'complete':

            return $this->db->trans_complete();

          break;

        case 'status':

            return $this->db->trans_status();

          break;

        default:
          // code...
          break;
      }

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

  public function generateSalePdf($sale_id)
  {

      $this->load->model('Sale_model');

      $sales_details = $this->Sale_model->getSaleDetails($sale_id);

      $sale = @$sales_details[0];

      $page_title = 'Invoice Details';

      $path = '';

      $data = [

        'page_title' => $page_title,
        'sale' => $sale,
        'sales_details' => $sales_details,
        'file' => 'invoice',
        'root' => $_SERVER['DOCUMENT_ROOT'].'/'

      ];

      @$this->load->library('pdf');

      @$this->pdf->load_view('sales/sales_pdf',$data);

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

  public function sendInvoicePdfOnMail($sale_id)
  {

      //get sale row
      $sale_row = $this->bm->getRow('sales','id',$sale_id);
      $customer = $this->bm->getRow('customers','id',$sale_row->customer_id);

      if($customer->e_receipt_email == '')
      {
          return true;
      }

      $email_subject = 'RZ';
      $email_body = '';

      $invoice_temp = $this->bm->getRowWithConditions('general_setting',['name' => 'INVOICE_TEMP']);

      if(!empty($invoice_temp))
      {

        $email_template = $this->bm->getRow('email_templates','id',$invoice_temp->value);

        if(!empty($email_template))
        {

          $email_subject = $email_template->subject;
          $email_body = $this->replaceWithCustomerData($email_template->template,$customer);

        }

      }

        @$this->generateSalePdf($sale_row->id);

          $arr = [

            'to' => $customer->e_receipt_email,
            'subject' => $email_subject,
            'body' => $email_body,
            'attachment' => $_SERVER["DOCUMENT_ROOT"].'/assets/invoice.pdf'

          ];

          //send mail to customer about his sale
          $res = $this->send_mail_($arr);

          if($res)
          {
            return true;
          }
          else
          {
            return false;
          }

  }

  public function sendInvoicePdfOnWhatsapp($sale_id)
  {

    return true;
    die();
    $sale_row = $this->bm->getRow('sales','id',$sale_id);
    $customer = $this->bm->getRow('customers','id',$sale_row->customer_id);

    if ($customer->primary_contact == '') {

        return true;
    }

    $email_subject = 'RZ';
    $email_body = '';

    //whatsapp template
    $invoice_temp = $this->bm->getRowWithConditions('general_setting',['name' => 'WHATSAPP_TEMP']);

    if(!empty($invoice_temp))
    {

      $email_template = $this->bm->getRow('email_templates','id',$invoice_temp->value);

      if(!empty($email_template))
      {

        $email_subject = $email_template->subject;
        $email_body = $this->replaceWithCustomerData($email_template->template,$customer);

      }

    }

      @$this->generateSalePdf($sale_row->id);

      $arr = [

        // 'recipient_number' => $customer->primary_contact,
        'recipient_number' => '+923361240874',
        'sender_number' => '+923413368152',
        'message' => 'Your appointment is coming up on 30/06/2014 at 4:15 PM',
        'attachment' => $_SERVER["DOCUMENT_ROOT"].'/assets/invoice.pdf'

      ];

      //send whatsapp to customer about his sale
      $res = $this->sendOnWhatsapp($arr);

      if($res)
      {
        return true;
      }
      else
      {
        return false;
      }

  }

  public function sendOnWhatsapp()
	{

      return true;

      die();
      $arr = [

        // 'recipient_number' => $customer->primary_contact,
        'recipient_number' => '+923313676465',
        'sender_number' => '+12403564679',
        'message' => 'Your appointment is coming up on 30/06/2014 at 4:15 PM',
        'attachment' => site_url('assets/mypdf.pdf')

      ];

      $this->load->library('twilio');

      $recipient_number = $arr['recipient_number'];
      $sender_number = $arr['sender_number'];
      $message = $arr['message'];
      $mediaurl = $arr['attachment'];

      $send = $this->twilio->sendmessage($recipient_number, $sender_number, $message,$mediaurl);

      return true;

	}

  public function redirect_to()
  {

      return '404_override';

  }

  public function checkRole($role_id)
  {

    if(isUserAllow($role_id) == false)
    {
      redirect($this->redirect_to());
    }

  }

  public function check_user_login()
  {

    $uid = $this->session->userdata('UID');

    if(empty($uid))
    {
      redirect('login');
    }

  }

}
