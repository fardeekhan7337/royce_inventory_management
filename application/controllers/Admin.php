<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->load->library('encryption');

    $this->checkRole(1);

  }

	public function index()
	{
        
    $data = [

      'title' => 'Admins',
      'page_head' => 'Admins',
      'active_menu' => 'users',
      'active_submenu' => 'admins',
      'ajax_url' => site_url('Admin/getAdmins'),
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'DataTable/usersDataTable.js',
        'users/main.js',
        'main.js',
        'dataTable_buttons'
      ]

    ];

    $this->template('users/admin/index',$data);


	}

	public function getAdmins()
	{
    $this->load->model('Admin_model');

		$records = $this->Admin_model->getAdmins($_REQUEST,'records');
		$totalFilteredRecords = $this->Admin_model->getAdmins($_REQUEST,'filter');
		$recordsTotal = $this->Admin_model->getAdmins($_REQUEST,'recordsTotal');

		$data = array();
		$SNo = 0;
		$Style = "";

		foreach ($records as $key => $v)
		{

      $ID = $v->id;

			$SNo++;

			$nestedData = array();

			$nestedData[] = $SNo;

      $delete_url = site_url('delete_admin/'.$ID);

      $actions = '';

        $actions .= '<span class="actions-icons">';

          if (isUserAllow(3)) {
            // code...
          $actions .= '<a href="'.site_url('edit_admin/'.$ID) .'" class="action-icons" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
            <i class="fa fa-pencil"></i>
          </a>';

        }

        if (isUserAllow(9)) {

          $actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Admin?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
            <i class="fa-solid fa-trash"></i>
          </a>';

        }

          if (isUserAllow(4)) {

              $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getUserDetailsByType/Admin/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
                <i class="fa fa-eye"></i>
              </a>';

            }

        $actions .= '</span>';

        $nestedData[] = $actions;

      //check image is exist in folder or not
      // if (@getimagesize(base_url('uploads/admin/'.$v->img)) && !empty($v->img))
      // {
      //     $img_url = base_url('uploads/admin/'.$v->img);
      // }
      // else
      // {
      //     $img_url = base_url('assets/images/avatars/01.png');
      // }

      // $name = '<div class="table-circular-img"><img src="'. $img_url .'" class="" alt=""></div>'.
      //     '<span class="table-img-txt-design">'.$v->name.'</span>';

      $name = $v->name;

			$nestedData[] = $name;
			$nestedData[] = $v->username;
			$nestedData[] = $v->email;
			$nestedData[] = $v->contact_no;

        $change_status_class = '';

        if(isUserAllow(70))
        {

          $change_status_class = 'changeUser_status_';

        }

        if($v->status != 0)
        {

          $change_status_url = site_url('update_admin_status/active/'.$ID);

          $status = '<a href="javascript:void(0)" class="'. $change_status_class .' action-icons" data-type-status="active" data-msg="Admin" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Active">
                   <span class="badge rounded-pill bg-secondary">Deactivated</span>
             </a>';

        }
        else
        {

          $change_status_url = site_url('update_admin_status/deactivated/'.$ID);

          $status = '<a href="javascript:void(0)" class="'. $change_status_class .' action-icons" data-type-status="deactivate" data-msg="Admin" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Deactivate">
                 <span class="badge rounded-pill bg-success">Active</span>
           </a>';

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

    $this->checkRole(2);

    $data = [

      'title' => 'Add Admin',
      'page_head' => 'Add Admin',
      'active_menu' => 'users',
      'active_submenu' => 'admins',
      'scripts' => [
        'img_trigger.js'
      ]

    ];

    $this->template('users/admin/create',$data);

  }

  public function save_admin()
  {
      $p = $this->inp_post();
      $is_email_unique = '';
      $is_username_unique = '';

      $this->form_validation->set_rules('name', 'Name', 'required');

      if(isset($p['old_email']))
      {

        if ($p['email'] != $p['old_email'])
        {

          $is_email_unique = '|is_unique[users.email]';

        }

      }
      else
      {

        $is_email_unique = '|is_unique[users.email]';

      }

      $this->form_validation->set_rules('email', 'Email', 'required'.$is_email_unique,[
        'required'      => 'The %s is required',
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

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $this->session->set_flashdata('_error',$error);

        if(isset($p['ID']))
        {

          redirect('edit_admin/'.$p['ID']);

        }
        else
        {

          redirect('add_admin');

        }

      }
      else
      {

           $ID = (isset($p['ID'])?$p['ID']:'');
           unset($p['ID']);

           $admin_img = NULL;

           if($ID != '')
           {
              $admin_img = $p['old_img'];
              unset($p['old_img']);
           }

           if(!empty($_FILES['img']['name']))
           {

             if($ID != '')
             {
                  if (@getimagesize(base_url('uploads/admin/'.$admin_img)) && !empty($admin_img))
                  {
                      $dir_path = getcwd().'/uploads/admin/'.$admin_img;

                      unlink($dir_path);
                  }
             }

             $admin_img = $this->bm->uploadFile($_FILES['img'],'uploads/admin');

           }

           $arr = [

              'img' => $admin_img,
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
              'type' => 'admin',
              'added_by' => $this->user_id_

           ];

           $this->trans_('start');

            if(!empty($ID))
            {

              unset($arr['type']);
              unset($arr['added_by']);

              $this->bm->update('users',$arr,'id',$ID);

            }
            else
            {
                
                $arr['added_at'] = $this->curr_datetime;
                $this->bm->insert_row('users',$arr);

            }

           $this->trans_('complete');

           if ($this->trans_('status') === FALSE)
           {

               $this->session->set_flashdata('_error','Connection error Try Again');

           }
           else
           {

             if(!empty($ID))
             {

               $this->session->set_flashdata('_success','Admin updated successfully');

             }
             else
             {

               $this->session->set_flashdata('_success','Admin created successfully');

             }


           }

           redirect('admins');

      }

  }

  public function edit($admin_id)
  {

    $this->checkRole(3);

    $data = [

      'title' => 'Edit Admin',
      'page_head' => 'Edit Admin',
      'active_menu' => 'users',
      'active_submenu' => 'admins',
      'admin' => $this->bm->getRow('users','id',$admin_id),
      'scripts' => [
        'img_trigger.js'
      ]

    ];

    $this->template('users/admin/edit',$data);

  }

  public function update_status($status,$admin_id)
  {

      $this->checkRole(70);

      $arr = [

        'status' => $status == 'active'?0:1

      ];

      $res = $this->bm->update('users',$arr,'id',$admin_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Admin '.$status.' successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('admins');

  }

  public function delete($admin_id)
  {

      $this->checkRole(9);

      $arr = [

        'is_deleted' => 1

      ];

      $res = $this->bm->update('users',$arr,'id',$admin_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Admin deleted successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('admins');

  }

}
