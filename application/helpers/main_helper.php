<?php

if ( ! function_exists('companySetting'))
{

  function companySetting($column = '')
	{

    $ci = & get_instance();

    $result = $ci->db->get('company_setting')->row();

    if(!empty($result))
    {

      if (@getimagesize(base_url('uploads/company_logo/'.$result->logo)) && !empty($result->logo))
      {
           $logo_url = base_url('uploads/company_logo/'.$result->logo);
      }
      else
      {
          $logo_url = base_url('assets/images/company_logo.jpg');
      }

      $company_data =[

        'logo' => $logo_url,
        'pdf_logo' => 'uploads/company_logo/'.$result->logo,
        'name' => $result->name,
        'address' => $result->address,
        'terms_and_condition' => $result->terms_and_condition

      ];

    }
    else
    {

      $company_data =[

        'logo' => base_url('assets/images/company_logo.jpg'),
        'pdf_logo' => 'assets/images/company_logo.jpg',
        'name' => '',
        'address' => '',
        'terms_and_condition' => ''

      ];

    }

    if(!empty($column))
    {

      return $company_data[$column];

    }
    else
    {

      return $company_data;

    }


  }

}

if ( ! function_exists('loginUserDetails'))
{

  function loginUserDetails($user_id)
	{

    $ci=& get_instance();

    $result = $ci->db->get_where('users',['id' => $user_id])->row();

    return $result;

  }

}

if ( ! function_exists('getDateTimeFormat'))
{

  function getDateTimeFormat($value ,$type = 'time')
  {

    if($type == 'time')
    {

      return date('d-m-Y H:i A',strtotime($value));

    }
    else if($type == 'only_time')
    {

      return date('H:i A',strtotime($value));

    }
    else
    {

      return date('d-m-Y',strtotime($value));

    }

  }

}

if ( ! function_exists('change_number_format'))
{

  function change_number_format($value)
  {


    return number_format(floatval($value),2,'.','');

  }

}

if ( ! function_exists('getProductAvailableStock'))
{

  function getProductAvailableStock($product_id)
  {

      $ci=& get_instance();

      $ci->db->select("logs.product_id,products.name as product_name,sum(if(logs.type='add_stock',qty,0)) as total_add_stock_qty,sum(if(logs.type='remove_stock',qty,0)) as total_remove_stock_qty,sum(if(logs.type='assign_stock_confirmed',qty,0)) as total_assign_stock_confirmed,sum(if(logs.type='pending_call_order_confirmed',qty,0)) as total_pending_call_order_confirmed,sum(if(logs.type='return' && logs.qty_type='missing_qty',qty,0)) as total_return_missing,sum(if(logs.type='return' && logs.qty_type='return_qty',qty,0)) as total_return", FALSE);
      $ci->db->from('logs');
      $ci->db->join('products','products.id = logs.product_id');

      $ci->db->where('logs.product_id',$product_id);

      $result = $ci->db->get()->row();

      $total_add = $result->total_add_stock_qty + $result->total_return;
      $total_remove = $result->total_remove_stock_qty + $result->total_assign_stock_confirmed + $result->total_pending_call_order_confirmed + $result->total_return_missing;

      $total_qty = $total_add - $total_remove;

      $arr = [

        'product_id' => $result->product_id,
        'available_qty' => $total_qty,

      ];

      return $arr;

  }

}


if ( ! function_exists('checkIsset'))
{

  function checkIsset($val , $type = 'number')
	{

    if(isset($val))
    {
      $res = $val;
    }
    else
    {
      if($type == 'number')
      {
        $res = 0;
      }
      else
      {
        $res = '';
      }
    }

    return $res;

  }

}


if ( ! function_exists('showPendingRequestCount'))
{

  function showPendingRequestCount()
	{

    $ci=& get_instance();

    $ci->load->model('Count_model');

    $pending_call_orders = $ci->Count_model->getPendingCallOrdersCount();

    $delivery_orders = $ci->Count_model->getDeliveryOrdersCount();

    return $pending_call_orders + $delivery_orders;

  }

}

if ( ! function_exists('showDriverRequestCount'))
{

  function showDriverRequestCount()
	{

    $ci=& get_instance();

    $ci->load->model('Count_model');

    $driver_request = $ci->Count_model->getDriverRequestsCount();

    return $driver_request;

  }

}

if ( ! function_exists('checkUserRight'))
{

  function isUserAllow($role_id)
	{


    $ci=& get_instance();

    $ci->load->model('Rights_model');

    $user_type = $ci->session->userdata('UTYPE');

    $res = $ci->Rights_model->checkUserRight($user_type,$role_id);

    if(!empty($res) && $res->is_allow == 1)
    {
      return true;
    }
    else
    {
      return false;
    }

  }

}

if ( ! function_exists('UTYPE'))
{

  function UTYPE()
  {

    $ci=& get_instance();

    return $ci->session->userdata('UTYPE');

  }

}


if ( ! function_exists('form_set_value'))
{

  function form_set_value($val)
  {


    $ci=& get_instance();

    if (isset($ci->session->flashdata('_setValues')[$val]))
    {

      return $ci->session->flashdata('_setValues')[$val];

    }
    else
    {
      return false;
    }

  }

}



  function __($str) {
    $ci =& get_instance();
    return $ci->lang->line($str);
  }
