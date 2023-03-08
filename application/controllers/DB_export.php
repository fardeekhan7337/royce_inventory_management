<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DB_export extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

  }

	public function index()
	{

    $data = [

      'title' => 'DB Export',
      'page_head' => 'DB Export',
      'active_menu' => 'db_export',

    ];

    $this->template('db_export/index',$data);


	}

}
