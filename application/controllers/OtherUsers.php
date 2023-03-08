<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OtherUsers extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->load->library('encryption');

    $this->checkRole(16);

  }

	public function index()
	{

    $data = [

      'title' => 'Other Users',
      'page_head' => 'Other Users',
      'active_menu' => 'users',
      'active_submenu' => 'others_users',
      'ajax_url' => site_url('OtherUsers/getOtherUsers'),
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

    $this->template('users/other/index',$data);


	}

  public function getOtherUsers()
	{

    $this->load->model('OtherUser_model');

		$records = $this->OtherUser_model->getOtherUsers($_REQUEST,'records');
		$totalFilteredRecords = $this->OtherUser_model->getOtherUsers($_REQUEST,'filter');
		$recordsTotal = $this->OtherUser_model->getOtherUsers($_REQUEST,'recordsTotal');

		$data = array();
		$SNo = 0;
		$Style = "";

		foreach ($records as $key => $v)
		{

      $ID = $v->id;

			$SNo++;

			$nestedData = array();

			$nestedData[] = $SNo;

      
      $delete_url = site_url('delete_other_user/'.$ID);

      $actions = '';

        $actions .= '<span class="actions-icons">';

        if (isUserAllow(18)) {

          $actions .= '<a href="'.site_url('edit_other_user/'.$ID) .'" class="action-icons" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
            <i class="fa fa-pencil"></i>
          </a>';

        }

        if (isUserAllow(20)) {

          $actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Other User?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
            <i class="fa-solid fa-trash"></i>
          </a>';

        }

        if (isUserAllow(73)) {

          $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getUserDetailsByType/Other_user/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
            <i class="fa fa-eye"></i>
          </a>';

        }

        $actions .= '</span>';

         $nestedData[] = $actions;

      //check image is exist in folder or not
      // if (@getimagesize(base_url('uploads/other_user/'.$v->img)) && !empty($v->img))
      // {
      //     $img_url = base_url('uploads/other_user/'.$v->img);
      // }
      // else
      // {
      //     $img_url = base_url('assets/images/avatars/01.png');
      // }

      // $name = '<div class="table-circular-img"><img src="'. $img_url .'" class="" alt=""></div>'.
      //   '<span class="table-img-txt-design">'.$v->name.'</span>';

      $name = $v->name;

			$nestedData[] = $name;
			$nestedData[] = $v->username;
			$nestedData[] = $v->email;
      $nestedData[] = $v->contact_no;

      $change_status_class = '';

      if(isUserAllow(73))
      {

        $change_status_class = 'changeUser_status_';

      }

        if($v->status != 0)
        {

          $change_status_url = site_url('update_other_user_status/active/'.$ID);

          $status = '<a href="javascript:void(0)" class="'. $change_status_class .' action-icons" data-type-status="active" data-msg="Other User" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Active">
                   <span class="badge rounded-pill bg-secondary">Deactivated</span>
             </a>';

        }
        else
        {

          $change_status_url = site_url('update_other_user_status/deactivated/'.$ID);

          $status = '<a href="javascript:void(0)" class="'. $change_status_class .' action-icons" data-type-status="deactivate" data-msg="Other User" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Deactivate">
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


  public function save_other_user()
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

      $this->form_validation->set_rules('email', 'Email',$is_email_unique,[
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

          redirect('edit_other_user/'.$p['ID']);

        }
        else
        {

          redirect('add_other_user');

        }

      }
      else
      {

           $ID = (isset($p['ID'])?$p['ID']:'');
           unset($p['ID']);

           $otherUser_img = NULL;

           if($ID != '')
           {
              $otherUser_img = $p['old_img'];
              unset($p['old_img']);
           }

           if(!empty($_FILES['img']['name']))
           {

             if($ID != '')
             {
                  if (@getimagesize(base_url('uploads/other_user/'.$otherUser_img)) && !empty($otherUser_img))
                  {
                      $dir_path = getcwd().'/uploads/other_user/'.$otherUser_img;

                      unlink($dir_path);
                  }
             }

             $otherUser_img = $this->bm->uploadFile($_FILES['img'],'uploads/other_user');

           }

           $arr = [

              'img' => $otherUser_img,
              'name' => $p['name'],
              'email' => $p['email'],
              'username' => $p['username'],
              'password' => $this->encryption->encrypt($p['password']),
              'contact_no' => $p['contact_no'],
              'license_no' => $p['license_no'],
              'fin_no' => $p['fin_no'],
              'car_plate' => $p['car_plate'],
              'dob' => $p['dob'],
              'country' => $p['country'],
              'city' => $p['city'],
              'zip_code' => $p['zip_code'],
              'address' => $p['address'],
              'type' => 'other',
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

               $this->session->set_flashdata('_success','Other User updated successfully');

             }
             else
             {

               $this->session->set_flashdata('_success','Other User created successfully');

             }

           }

           redirect('other_users');

      }

  }

  public function create()
  {

    $this->checkRole(17);

    $data = [

      'title' => 'Add Other User',
      'page_head' => 'Add Other User',
      'active_menu' => 'users',
      'active_submenu' => 'others_users',
      'scripts' => [
        'img_trigger.js'
      ]

    ];

    $this->template('users/other/create',$data);

  }

  public function edit($otherUser_id)
  {

    $this->checkRole(18);

    $data = [

      'title' => 'Edit Other User',
      'page_head' => 'Edit Other User',
      'active_menu' => 'users',
      'active_submenu' => 'others_users',
      'otherUser' => $this->bm->getRow('users','id',$otherUser_id),
      'scripts' => [
        'img_trigger.js'
      ]

    ];

    $this->template('users/other/edit',$data);

  }

  public function update_status($status,$otherUser_id)
  {

    $this->checkRole(73);

      $arr = [

        'status' => $status == 'active'?0:1

      ];

      $res = $this->bm->update('users',$arr,'id',$otherUser_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Other User '.$status.' successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('other_users');

  }

  public function delete($otherUser_id)
  {

      $this->checkRole(19);

      $arr = [

        'is_deleted' => 1

      ];

      $res = $this->bm->update('users',$arr,'id',$otherUser_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Other User deleted successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('other_users');

  }


}
