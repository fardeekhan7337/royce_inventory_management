<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salesperson extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->checkRole(66);

  }

	public function index()
	{

    $data = [

      'title' => 'Salesperson',
      'page_head' => 'Salesperson',
      'active_menu' => 'salesperson',
      'ajax_url' => site_url('Salesperson/getSalespersons'),
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'DataTable/myDataTable.js',
        'main.js',
        'dataTable_buttons'
      ]

    ];

    $this->template('salesperson/index',$data);


	}

  public function getSalespersons()
	{

    $this->load->model('Salesperson_model');

		$records = $this->Salesperson_model->getSalespersons($_REQUEST,'records');
		$totalFilteredRecords = $this->Salesperson_model->getSalespersons($_REQUEST,'filter');
		$recordsTotal = $this->Salesperson_model->getSalespersons($_REQUEST,'recordsTotal');

		$data = array();
		$SNo = 0;
		$Style = "";

		foreach ($records as $key => $v)
		{

      $ID = $v->id;

			$SNo++;

			$nestedData = array();

			$nestedData[] = $SNo;


      $delete_url = site_url('delete_salesperson/'.$ID);

  			$actions = '';

          $actions .= '<span class="actions-icons">';

          if (isUserAllow(68)) {

    				$actions .= '<a href="'.site_url('edit_salesperson/'.$ID) .'" class="action-icons" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
              <i class="fa fa-pencil"></i>
            </a>';

          }

          if (isUserAllow(69)) {
            
  					$actions .= '<a href="javascript:void(0)" class="action-icons delete_record_" data-msg="Are you sure you want to delete this Salesperson?" data-url="'. $delete_url .'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
              <i class="fa-solid fa-trash"></i>
            </a>';

          }

          $actions .= '</span>';

			     $nestedData[] = $actions;


			$nestedData[] = $v->name;
      $nestedData[] = $v->email;
      $nestedData[] = $v->contact_no;
			$nestedData[] = $v->address;

        
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

    $this->checkRole(67);

    $data = [

      'title' => 'Add Salesperson',
      'page_head' => 'Add Salesperson',
      'active_menu' => 'salesperson',
      'scripts' => [
        'img_trigger.js'
      ]

    ];

    $this->template('salesperson/create',$data);

  }

  public function save_salesperson()
  {

      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required');
      $this->form_validation->set_rules('contact_no', 'Contact #', 'required');

      if ($this->form_validation->run() == FALSE)
      {

        $error = validation_errors();

        $this->session->set_flashdata('_error',$error);

        redirect('add_salesperson');

      }
      else
      {

           $p = $this->inp_post();

           $ID = (isset($p['ID'])?$p['ID']:'');
           unset($p['ID']);

           $arr = [

              'name' => $p['name'],
              'email' => $p['email'],
              'contact_no' => $p['contact_no'],
              'address' => $p['address'],
              'added_by' => $this->user_id_

           ];

           $this->trans_('start');

            if(!empty($ID))
            {

              unset($arr['added_by']);

              $this->bm->update('salesperson',$arr,'id',$ID);

            }
            else
            {
                $arr['added_at'] = $this->curr_datetime;
                $this->bm->insert_row('salesperson',$arr);

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

               $this->session->set_flashdata('_success','Salesperson updated successfully');

             }
             else
             {

               $this->session->set_flashdata('_success','Salesperson created successfully');

             }

           }

           redirect('salesperson');

      }

  }

  public function edit($salesperson_id)
  {

    $this->checkRole(68);

    $data = [

      'title' => 'Edit Salesperson',
      'page_head' => 'Edit Salesperson',
      'active_menu' => 'salesperson',
      'salesperson' => $this->bm->getRow('salesperson','id',$salesperson_id)

    ];

    $this->template('salesperson/edit',$data);

  }

  public function delete($salesperson_id)
  {

    $this->checkRole(69);

      $arr = [

        'is_deleted' => 1

      ];

      $res = $this->bm->update('salesperson',$arr,'id',$salesperson_id);

      if ($res)
      {

        $this->session->set_flashdata('_success','Salesperson deleted successfully');

      }
      else
      {

        $this->session->set_flashdata('_error','Connection error Try Again');

      }

      redirect('salesperson');

  }

}
