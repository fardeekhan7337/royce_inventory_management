<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Production extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->load->library('encryption');

    $this->checkRole(11);

  }

	public function index()
	{

    $data = [

      'title' => 'Production Users',
      'page_head' => 'Production Users',
      'active_menu' => 'users',
      'active_submenu' => 'productions',
      'ajax_url' => site_url('Production/getProductionUsers'),
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

    $this->template('users/production/index',$data);


	}

  public function getProductionUsers()
	{

    $this->load->model('Production_model');

		$records = $this->Production_model->getProductionUsers($_REQUEST,'records');
		$totalFilteredRecords = $this->Production_model->getProductionUsers($_REQUEST,'filter');
		$recordsTotal = $this->Production_model->getProductionUsers($_REQUEST,'recordsTotal');

		$data = array();
		$SNo = 0;
		$Style = "";

		foreach ($records as $key => $v)
		{

      $ID = $v->id;

			$SNo++;

			$nestedData = array();

			$nestedData[] = $SNo;

      $delete_url = site_url('delete_production/'.$ID);

      $actions = '';

        $actions .= '<span class="actions-icons">';

          $actions .= '<a href="'.site_url('edit_production/'.$ID) .'" class="action-icons" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
            <i class="fa fa-pencil"></i>
          </a>';

          $actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Production User?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
            <i class="fa-solid fa-trash"></i>
          </a>';

          $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getUserDetailsByType/Production/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
            <i class="fa fa-eye"></i>
          </a>';

        $actions .= '</span>';

        $nestedData[] = $actions;

      //check image is exist in folder or not
      // if (@getimagesize(base_url('uploads/production/'.$v->img)) && !empty($v->img))
      // {
      //     $img_url = base_url('uploads/production/'.$v->img);
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
      $nestedData[] = $v->fin_no;

      $change_status_class = '';

      if(isUserAllow(72))
      {

        $change_status_class = 'changeUser_status_';

      }

        if($v->status != 0)
        {

          $change_status_url = site_url('update_production_status/active/'.$ID);

          $status = '<a href="javascript:void(0)" class="'. $change_status_class.' action-icons" data-type-status="active" data-msg="Production User" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Active">
                   <span class="badge rounded-pill bg-secondary">Deactivated</span>
             </a>';

        }
        else
        {

          $change_status_url = site_url('update_production_status/deactivated/'.$ID);

          $status = '<a href="javascript:void(0)" class="'. $change_status_class.' action-icons" data-type-status="deactivate" data-msg="Production User" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Deactivate">
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

    $this->checkRole(12);

    $data = [

      'title' => 'Add Production User',
      'page_head' => 'Add Production User',
      'active_menu' => 'users',
      'active_submenu' => 'productions',
      'scripts' => [
        'img_trigger.js'
      ]

    ];

    $this->template('users/production/create',$data);

  }

  public function save_production()
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
      $this->form_validation->set_rules('fin_no', 'FIN #', 'required');

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $this->session->set_flashdata('_error',$error);

        if(isset($p['ID']))
        {

            redirect('edit_production/'.$p['ID']);

        }
        else
        {

          redirect('add_production');

        }

      }
      else
      {

           $ID = (isset($p['ID'])?$p['ID']:'');
           unset($p['ID']);

           $production_img = NULL;

           if($ID != '')
           {
              $production_img = $p['old_img'];
              unset($p['old_img']);
           }

           if(!empty($_FILES['img']['name']))
           {

             if($ID != '')
             {
                  if (@getimagesize(base_url('uploads/production/'.$production_img)) && !empty($production_img))
                  {
                      $dir_path = getcwd().'/uploads/production/'.$production_img;

                      unlink($dir_path);
                  }
             }

             $production_img = $this->bm->uploadFile($_FILES['img'],'uploads/production');

           }

           $arr = [

              'img' => $production_img,
              'name' => $p['name'],
              'email' => $p['email'],
              'username' => $p['username'],
              'password' => $this->encryption->encrypt($p['password']),
              'contact_no' => $p['contact_no'],
              'fin_no' => $p['fin_no'],
              'dob' => $p['dob'],
              'country' => $p['country'],
              'city' => $p['city'],
              'zip_code' => $p['zip_code'],
              'address' => $p['address'],
              'type' => 'production',
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

               $this->session->set_flashdata('_success','Production User updated successfully');

             }
             else
             {

               $this->session->set_flashdata('_success','Production User created successfully');

             }


           }

           redirect('productions');

      }

  }

  public function edit($production_id)
  {

    $this->checkRole(13);

    $data = [

      'title' => 'Edit Production User',
      'page_head' => 'Edit Production User',
      'active_menu' => 'users',
      'active_submenu' => 'productions',
      'production' => $this->bm->getRow('users','id',$production_id),
      'scripts' => [
        'img_trigger.js'
      ]

    ];

    $this->template('users/production/edit',$data);

  }

  public function update_status($status,$production_id)
  {

      $this->checkRole(72);

      $arr = [

        'status' => $status == 'active'?0:1

      ];

      $res = $this->bm->update('users',$arr,'id',$production_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Production User '.$status.' successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('productions');

  }

  public function delete($production_id)
  {

      $this->checkRole(14);

      $arr = [

        'is_deleted' => 1

      ];

      $res = $this->bm->update('users',$arr,'id',$production_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Production User deleted successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('productions');

  }


}
