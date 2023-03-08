<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->load->library('encryption');

  }

  public function edit_profile()
  {

    $data = [

      'title' => 'Edit Profile',
      'page_head' => 'Edit Profile',
      'active_menu' => '',
      'user' => $this->bm->getRow('users','id',$this->user_id_),
      'scripts' => [
        'img_trigger.js'
      ]

    ];

    $this->template('users/profile/edit_profile',$data);

  }

  public function update_profile()
  {

      $p = $this->inp_post();
      $is_email_unique = '';
      $is_username_unique = '';

      $this->form_validation->set_rules('name', 'Name', 'required');

      if(isset($p['old_email']))
      {

        if ($p['email'] != $p['old_email'])
        {

          $is_email_unique = 'is_unique[users.email]';

        }

      }
      else
      {

        $is_email_unique = 'is_unique[users.email]';

      }

      $this->form_validation->set_rules('email', 'Email', $is_email_unique,[
        'is_unique'     => 'The %s already exist'
      ]);

      if(isset($p['old_username']))
      {

        if ($p['username'] != $p['old_username'])
        {

          $is_username_unique = '|is_unique[users.username]';

        }

      }
      else
      {

        $is_username_unique = '|is_unique[users.username]';

      }

      $this->form_validation->set_rules('username', 'Username', 'required'.$is_username_unique,[
        'required'      => 'The %s field is required',
        'is_unique'     => 'The %s already exist'
      ]);

      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('contact_no', 'Contact #', 'required');

      if($p['type'] != 'admin')
      {

        $this->form_validation->set_rules('fin_no', 'FIN #', 'required');

      }

      if($p['type'] == 'driver' || $p['type'] == 'other')
      {

        $this->form_validation->set_rules('car_plate', 'Car Plate', 'required');

      }

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $this->session->set_flashdata('_error',$error);

        redirect('edit_profile');

      }
      else
      {

           $ID = $p['ID'];
           unset($p['ID']);

           $user_img = NULL;

           if($ID != '')
           {
              $user_img = $p['old_img'];
              unset($p['old_img']);
           }

           if(!empty($_FILES['img']['name']))
           {

             if($ID != '')
             {
                  if (@getimagesize(base_url('uploads/'.$p['type'].'/'.$user_img)) && !empty($user_img))
                  {
                      $dir_path = getcwd().'/uploads/'.$p['type'].'/'.$user_img;

                      unlink($dir_path);
                  }
             }

             $user_img = $this->bm->uploadFile($_FILES['img'],'uploads/'.$p['type']);

           }

           $arr = [

              'img' => $user_img,
              'name' => $p['name'],
              'email' => $p['email'],
              'username' => $p['username'],
              'password' => $this->encryption->encrypt($p['password']),
              'contact_no' => $p['contact_no'],
              'dob' => $p['dob'],
              'country' => $p['country'],
              'city' => $p['city'],
              'zip_code' => $p['zip_code'],
              'address' => $p['address'],
              'added_by' => $this->user_id_

           ];

           if($p['type'] == 'driver' || $p['type'] == 'other')
           {

             $arr['license_no'] = $p['license_no'];
             $arr['car_plate'] = $p['car_plate'];

           }

           if($p['type'] != 'admin')
           {

             $arr['fin_no'] = $p['fin_no'];

           }

           $this->trans_('start');

              $this->bm->update('users',$arr,'id',$ID);

           $this->trans_('complete');

           if ($this->trans_('status') === FALSE)
           {

               $this->session->set_flashdata('_error','Connection error Try Again');

           }
           else
           {

               $this->session->set_flashdata('_success','Profile updated successfully');

           }

           redirect('edit_profile');

      }

  }

  public function view_profile()
  {

    $data = [

      'title' => 'View Profile',
      'page_head' => 'View Profile',
      'active_menu' => '',
      'user' => $this->bm->getRow('users','id',$this->user_id_)

    ];

    $this->template('users/profile/view_profile',$data);

  }

}
