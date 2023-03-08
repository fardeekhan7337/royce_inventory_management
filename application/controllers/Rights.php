<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rights extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    if(UTYPE() != 'admin')
    {

        redirect($this->redirect_to());

    }

  }

	public function index()
	{

    $data = [

      'title' => 'Rights',
      'page_head' => 'Rights',
      'active_menu' => 'users',
      'active_submenu' => 'rights',
      'styles' => [
        'my-dataTable.css'
      ],
      'scripts' => [
        'DataTable/rightsDataTable.js',
        'dataTable_buttons',
        'main.js'
      ]

    ];

    $this->template('users/rights/index',$data);


	}

  public function edit($type)
  {

    $this->load->model('Rights_model');

    $modules = $this->bm->getRows('modules');
    $roles = [];
    foreach ($modules as $key => $v) {

      $roles[$key] = $this->Rights_model->getModuleRolesByUserType($v->id,$type);

    }
    
    $data = [

      'title' => 'Edit Rights',
      'page_head' => 'Edit Rights',
      'active_menu' => 'users',
      'active_submenu' => 'rights',
      'type' => $type,
      'modules' => $modules,
      'roles' => $roles

    ];

    $this->template('users/rights/edit',$data);

  }

  public function save()
  {

      $p = $this->inp_post();

      $this->trans_('start');

        $this->bm->delete('user_roles','type',$p['type']);

        $rights = [];
        foreach ($p['row_id'] as $key => $v)
        {

            $rights[] = [

                'type' => $p['type'],
                'role_id' => $v,
                'is_allow' => isset($p['role_id'][$v])?1:0

            ];

        }

        $this->bm->insert_rows('user_roles',$rights);

      $this->trans_('complete');

      if ($this->trans_('status') === FALSE)
      {

          $this->session->set_flashdata('_error','Connection error Try Again');

      }
      else
      {

          $this->session->set_flashdata('_success','Rights updated successfully');

      }

      redirect('rights');

  }

}
