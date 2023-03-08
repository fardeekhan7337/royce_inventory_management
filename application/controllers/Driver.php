<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->load->library('encryption');

    $this->checkRole(5);

  }

	public function index()
	{

    $data = [

      'title' => 'Driver',
      'page_head' => 'Drivers',
      'active_menu' => 'users',
      'active_submenu' => 'drivers',
      'ajax_url' => site_url('Driver/getDrivers'),
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

    $this->template('users/driver/index',$data);


	}

  public function getDrivers()
	{

    $this->load->model('Driver_model');

		$records = $this->Driver_model->getDrivers($_REQUEST,'records');
		$totalFilteredRecords = $this->Driver_model->getDrivers($_REQUEST,'filter');
		$recordsTotal = $this->Driver_model->getDrivers($_REQUEST,'recordsTotal');

		$data = array();
		$SNo = 0;
		$Style = "";

		foreach ($records as $key => $v)
		{

      $ID = $v->id;

			$SNo++;

			$nestedData = array();

			$nestedData[] = $SNo;

      $delete_url = site_url('delete_driver/'.$ID);

      $actions = '';

        $actions .= '<span class="actions-icons">';

          if (isUserAllow(7)) {

            $actions .= '<a href="'.site_url('edit_driver/'.$ID) .'" class="action-icons" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
              <i class="fa fa-pencil"></i>
            </a>';

          }

          if (isUserAllow(8)) {

            $actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Driver?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </a>';

          }

          if (isUserAllow(71)) {

            $actions .= '<a href="javascript:void(0)" class="action-icons view_details_" data-url="'. site_url('AjaxController/getUserDetailsByType/Driver/'.$ID) .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
              <i class="fa fa-eye"></i>
            </a>';

          }

        $actions .= '</span>';

         $nestedData[] = $actions;


      // //check image is exist in folder or not
      // if (@getimagesize(base_url('uploads/driver/'.$v->img)) && !empty($v->img))
      // {
      //     $img_url = base_url('uploads/driver/'.$v->img);
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
			$nestedData[] = $v->car_plate;


        $change_status_class = '';

        if(isUserAllow(71))
        {

          $change_status_class = 'changeUser_status_';

        }

        if($v->status != 0)
        {

          $change_status_url = site_url('update_driver_status/active/'.$ID);

          $status = '<a href="javascript:void(0)" class="'. $change_status_class .' action-icons" data-type-status="active" data-msg="Driver" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Active">
                   <span class="badge rounded-pill bg-secondary">Deactivated</span>
             </a>';

        }
        else
        {

          $change_status_url = site_url('update_driver_status/deactivated/'.$ID);

          $status = '<a href="javascript:void(0)" class="'. $change_status_class .' action-icons" data-type-status="deactivate" data-msg="Driver" data-url="'. $change_status_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Deactivate">
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

      $this->checkRole(6);

    $data = [

      'title' => 'Add Driver',
      'page_head' => 'Add Driver',
      'active_menu' => 'users',
      'active_submenu' => 'drivers',
      'scripts' => [
        'img_trigger.js'
      ]

    ];

    $this->template('users/driver/create',$data);

  }

  public function save_driver()
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
      $this->form_validation->set_rules('car_plate', 'Car Plate', 'required');

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $this->session->set_flashdata('_error',$error);

        if(isset($p['ID']))
        {

            redirect('edit_driver/'.$p['ID']);
        }
        else
        {

          redirect('add_driver');

        }

      }
      else
      {

           $ID = (isset($p['ID'])?$p['ID']:'');
           unset($p['ID']);

           $driver_img = NULL;

           if($ID != '')
           {
              $driver_img = $p['old_img'];
              unset($p['old_img']);
           }

           if(!empty($_FILES['img']['name']))
           {

             if($ID != '')
             {
                  if (@getimagesize(base_url('uploads/driver/'.$driver_img)) && !empty($driver_img))
                  {
                      $dir_path = getcwd().'/uploads/driver/'.$driver_img;

                      unlink($dir_path);
                  }
             }

             $driver_img = $this->bm->uploadFile($_FILES['img'],'uploads/driver');

           }

           $arr = [

              'img' => $driver_img,
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
              'type' => 'driver',
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

               $this->session->set_flashdata('_success','Driver updated successfully');

             }
             else
             {

               $this->session->set_flashdata('_success','Driver created successfully');

             }


           }

           redirect('drivers');

      }

  }

  public function edit($driver_id)
  {

      $this->checkRole(7);

      $data = [

        'title' => 'Edit Driver',
        'page_head' => 'Edit Driver',
        'active_menu' => 'users',
        'active_submenu' => 'drivers',
        'driver' => $this->bm->getRow('users','id',$driver_id),
        'scripts' => [
          'img_trigger.js'
        ]

      ];

      $this->template('users/driver/edit',$data);

  }

  public function update_status($status,$driver_id)
  {

      $this->checkRole(71);

      $arr = [

        'status' => $status == 'active'?0:1

      ];

      $res = $this->bm->update('users',$arr,'id',$driver_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Driver '.$status.' successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('drivers');

  }

  public function delete($driver_id)
  {

      $this->checkRole(8);

      $arr = [

        'is_deleted' => 1

      ];

      $res = $this->bm->update('users',$arr,'id',$driver_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Driver deleted successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('drivers');

  }


}
