<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Controller
{

  function __construct()
  {

    parent :: __construct();

    $this->checkRole(55);

  }

	public function index()
	{

    $data = [

      'title' => 'Invoices',
      'page_head' => 'Invoices',
      'active_menu' => 'invoices',
      'customers' => $this->bm->getRows('customers'),
      'drivers' => $this->bm->getRowsWithConditions('users',['is_deleted' => 0,'type' => 'driver']),
      'styles' => [
        'invoice.css'
      ],
      'scripts' => [
        'invoice/invoice.js'
      ]

    ];

    $this->template('invoices/index',$data);

	}

  public function getAllInvoices($rowno=0)
  {

    $p = $this->inp_post();

    $this->load->library('pagination');
    $this->load->model('Invoice_model');

    $selected_page_no = $rowno;

    // Row per page
    $rowperpage = 3;
    // Row position
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    }
    // All records count
    $allcount = $this->Invoice_model->getCountInvoices($p);
    // Get records
    $data1['invoices'] = $this->Invoice_model->getAllInvoices($rowno,$rowperpage,$p);
    $data1['total_pages'] = ceil($allcount / $rowperpage);
    $data1['selected_page'] = $selected_page_no;

    // Pagination Configuration
    $config['base_url'] = site_url().'/Invoice/getAllInvoices';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $allcount;
    $config['per_page'] = $rowperpage;
    $config['num_links'] = 1;
    $config['first_link'] = false;
    $config['last_link'] = false;

    $config['full_tag_open'] = '<nav aria-label="Standard pagination example"><ul class="pagination">';
    $config['full_tag_close'] = '</ul></nav>';

    $config['next_link'] = '»';
    $config['next_tag_open'] = ' <li class="page-item">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = '«';
    $config['prev_tag_open'] = ' <li class="page-item">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = ['class' => 'page-link'];

    // Initialize
    $this->pagination->initialize($config);
    // Initialize $data Array
    $data['pagination'] = $this->pagination->create_links();

    $invoices_html = $this->load_view('invoices/invoices',$data1,true);

    $data['result'] = $invoices_html;
    $data['row'] = $rowno;

    echo json_encode($data);

  }

}
