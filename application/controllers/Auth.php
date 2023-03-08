<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->load->library('encryption');

  }

  public function login()
	{

    if($this->check_user_login())
    {

      redirect('dashboard');

    }

    $data = [
        'title' => 'Login'
    ];

    $this->load->view('auth/login',$data);

	}

  public function checkLoginDetails()
  {

    $this->load->model('Auth_model');

     $this->form_validation->set_rules('username', 'Username', 'required');
     $this->form_validation->set_rules('password', 'Password', 'required');

     if ($this->form_validation->run() == FALSE)
     {

       $error = validation_errors();

       $this->session->set_flashdata('_error',$error);

       redirect('login');

     }
     else
     {

       $p = $this->input->post();

       $username = $p['username'];
       $password = $p['password'];

       $data = $this->Auth_model->checkLoginDetails($username,$password);

       if($data['result'] == true)
       {

         $this->session->set_userdata('UID',$data['data']->id);
         $this->session->set_userdata('UTYPE',$data['data']->type);

         // remember me
          if(isset($p['remember_me']))
          {
            setcookie ('loginUsername', $username, time()+ (10 * 365 * 24 * 60 * 60));
            setcookie ('loginPass', $password,  time()+ (10 * 365 * 24 * 60 * 60));
          }
          else
          {
            setcookie ('loginUsername','');
            setcookie ('loginPass','');
          }

         redirect('dashboard');

       }
       else
       {

           $this->session->set_flashdata('_error',$data['msg']);

       }

       redirect('login');

     }

  }

  public function forget_password()
	{

    if($this->check_user_login())
    {

      redirect('dashboard');

    }

    $data = [
        'title' => 'Forget Password'
    ];

    $this->load->view('auth/forget_password',$data);

	}

  public function send_forgetpassword_link()
  {

    $this->load->model('Auth_model');

     $this->form_validation->set_rules('email', 'Email', 'required');

     if ($this->form_validation->run() == FALSE)
     {

       $error = validation_errors();

       $this->session->set_flashdata('_error',$error);

     }
     else
     {

       $email = $this->input->post('email');

       $data = $this->Auth_model->checkForgetPasswordEmail($email);

       if($data)
       {

         $passwordplain = rand(999999999,9999999999);

         $arr = [

            'token' => $passwordplain,
            'token_date' => date('Y-m-d H:i:s')

         ];


         // update user forget password token
         $user = $this->Auth_model->updateForgetPasswordToken($email,$arr);

         $company_name = companySetting('name');

         $email_body = '';
         $email_body = 'Dear '.$user->name.','. "\r\n";
         $email_body .= 'Thanks for contacting regarding to forgot password,<br> To change the <b>Password</b> link is given below :<br><a href="'. base_url('change_password/'.$passwordplain).'">Change Password</a>'."\r\n";
         $email_body .= '<br>Please Update your password.';
         $email_body .= '<br>Thanks & Regards';
         $email_body .= '<br>'.$company_name;

         $mail_credentails = [

            'to' => $email,
            'subject' => 'Forget Password',
            'body' => $email_body

         ];

         $is_send = $this->send_mail_($mail_credentails);

         if($is_send)
         {
           $this->session->set_flashdata('_success','Forget Password link has been sent on your email');
         }
         else
         {
           $this->session->set_flashdata('_error','Connection error...');
         }

       }
       else
       {

         $this->session->set_flashdata('_error','Email is not registered');

       }

     }

     redirect('forget_password');

  }

  public function logout()
  {

    if($this->check_user_login())
    {

      $this->session->sess_destroy();

      redirect('login');

    }
    else
    {

      echo "Connection error";

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
      $this->email->from('Royce',$company_name);
      $this->email->to($to);

      $this->email->subject($subject);

      $this->email->message($body);

      if(isset($arr['attachment']))
      {

        $this->email->attach($_SERVER["DOCUMENT_ROOT"].$arr['attachment']);

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

  public function change_password($token)
  {
    
      if($this->check_user_login())
      {

        redirect('dashboard');

      }

      $user = $this->bm->getRow('users','token',$token);

      if(!empty($user))
      {

        $token_time = date("H:i",strtotime('+30 minutes',strtotime($user->token_date)));
        $current_time = date("H:i");

        if(strtotime($token_time) >= strtotime($current_time))
        {
            $data['user'] = $user;
            $this->load->view('auth/change_password',$data);
        }
        else
        {
          $this->load->view('token_expired');
        }

      }
      else
      {
        $this->load->view('token_expired');
      }

  }

  public function update_password()
  {

    $p = $this->input->post();

    $this->form_validation->set_rules('password','Password','required');
    $this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[password]');

    if ($this->form_validation->run() == FALSE)
    {

      $error = validation_errors();

      $this->session->set_flashdata('_error',$error);

      redirect('change_password/'.$p['token']);

    }
    else
    {

        $arr = [

          'password' => $this->encryption->encrypt($p['password']),
          'token' => NULL

        ];

        $this->bm->update('users',$arr,'id',$p['user_id']);

        $this->session->set_flashdata('_success','Password has been changed Successfully');

        redirect('login');

    }

  }

  public function check_user_login()
  {

    $uid = $this->session->userdata('UID');

    if($uid)
    {
      return true;
    }
    else
    {
      return false;
    }

  }

}
