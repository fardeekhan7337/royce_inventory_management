<?php

/**
 *
 */
class Stock_model extends CI_Model
{

  public function getStocks($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'products.name',
          2 => NULL,
          3 => 'users.name',
          4 => 'stock.added_at',
          5 => NULL

      ];

      $this->db->select('stock.*,products.name as product_name,users.name as added_by_name');
      $this->db->from('stock');
      $this->db->join('products','products.id = stock.product_id');
      $this->db->join('users','users.id = stock.added_by');

      $this->db->where('stock.type','add');
      $this->db->where('stock.is_deleted',0);

      if($type == 'recordsTotal')
      {
          return $this->db->count_all_results();
      }

      else if($type == 'filter' || $type == 'records')
      {

        if (!empty($requestData['search']['value']))
        {

           $this->db->group_start();

            $this->db->or_like('products.name',$requestData['search']['value']);
            $this->db->or_like('users.name',$requestData['search']['value']);
            $this->db->or_like('stock.added_at',getDateTimeFormat($requestData['search']['value']));

           $this->db->group_end();

        }

        if($type == 'records')
        {

          if(isset($requestData['order']))
          {

              $this->db->order_by($columns[$requestData['order'][0]['column']],$requestData['order'][0]['dir']);

          }
          else
          {

            $this->db->order_by('stock.id','desc');

          }

          if(isset($requestData["length"]))
          {

               $this->db->limit(@$_POST['length'], @$_POST['start']);

          }

          return $this->db->get()->result();

        }
        else
        {

            return $this->db->count_all_results();

        }


      }

  }

  public function getStockHistory($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'products.name',
          2 => NULL,
          3 => 'stock.type',
          3 => 'users.name',
          4 => 'stock.added_at',

      ];

      $this->db->select('stock.*,products.name as product_name,users.name as added_by_name');
      $this->db->from('stock');
      $this->db->join('products','products.id = stock.product_id');
      $this->db->join('users','users.id = stock.added_by');

      if($type == 'recordsTotal')
      {
          return $this->db->count_all_results();
      }

      else if($type == 'filter' || $type == 'records')
      {

        if (!empty($requestData['search']['value']))
        {

           $this->db->group_start();

            $this->db->or_like('products.name',$requestData['search']['value']);
            $this->db->or_like('users.name',$requestData['search']['value']);
            $this->db->or_like('stock.type',$requestData['search']['value']);
            $this->db->or_like('stock.added_at',getDateTimeFormat($requestData['search']['value']));

           $this->db->group_end();

        }

        if($type == 'records')
        {

          if(isset($requestData['order']))
          {

              $this->db->order_by($columns[$requestData['order'][0]['column']],$requestData['order'][0]['dir']);

          }
          else
          {

            $this->db->order_by('stock.id','desc');

          }

          if(isset($requestData["length"]))
          {

               $this->db->limit(@$_POST['length'], @$_POST['start']);

          }

          return $this->db->get()->result();

        }
        else
        {

            return $this->db->count_all_results();

        }


      }

  }

  public function getProductStock($product_id)
  {

    $this->db->select("logs.product_id,products.name as product_name,sum(if(logs.type='add_stock',qty,0)) as total_add_stock_qty,sum(if(logs.type='remove_stock',qty,0)) as total_remove_stock_qty,sum(if(logs.type='assign_stock_confirmed',qty,0)) as total_assign_stock_confirmed,sum(if(logs.type='pending_call_order_confirmed',qty,0)) as total_pending_call_order_confirmed,sum(if(logs.type='return' && logs.qty_type='missing_qty',qty,0)) as total_return_missing,sum(if(logs.type='return' && logs.qty_type='return_qty',qty,0)) as total_return", FALSE);
    $this->db->from('logs');
    $this->db->join('products','products.id = logs.product_id');

    $this->db->where('logs.product_id',$product_id);

    $result = $this->db->get()->row();

    $total_add = $result->total_add_stock_qty + $result->total_return;
    $total_remove = $result->total_remove_stock_qty + $result->total_assign_stock_confirmed + $result->total_pending_call_order_confirmed + $result->total_return_missing;

    $total_qty = $total_add - $total_remove;

    $arr = [

      'product_id' => $result->product_id,
      'available_qty' => $total_qty,

    ];

    return $arr;

  }


  public function getDriverRequestStock($driver_id)
  {

    $this->db->select_max('id');
    $this->db->where('driver_id', $driver_id);
    $res = $this->db->get('driver_request')->row();

    $this->db->select('driver_request_details.*');
    $this->db->from('driver_request');
    $this->db->join('driver_request_details','driver_request_details.driver_request_id = driver_request.id');

    $this->db->where('driver_request_details.driver_request_id',$res->id);
    $this->db->where('driver_request.driver_id',$driver_id);

    return $this->db->get()->result();

  }

  public function getDriverRequestedProductsSummary($driver_id)
  {

    $this->db->select_max('id');
    $this->db->where('driver_id', $driver_id);
    $res = $this->db->get('driver_request')->row();

    $this->db->select('driver_request_details.*,products.name as product_name,products.price as product_price');
    $this->db->from('driver_request');
    $this->db->join('driver_request_details','driver_request_details.driver_request_id = driver_request.id');
    $this->db->join('products','products.id = driver_request_details.product_id');

    $this->db->where('driver_request_details.driver_request_id',$res->id);
    $this->db->where('driver_request.driver_id',$driver_id);

    return $this->db->get()->result();

  }

  public function getDriverRequestedProducts($driver_id)
  {

    $this->db->select_max('id');
    $this->db->where('driver_id', $driver_id);
    $this->db->where('is_assign', 0);
    $res = $this->db->get('driver_request')->row();

    $this->db->select('driver_request_details.*,products.name as product_name,products.price as product_price');
    $this->db->from('driver_request');
    $this->db->join('driver_request_details','driver_request_details.driver_request_id = driver_request.id');
    $this->db->join('products','products.id = driver_request_details.product_id');

    $this->db->where('driver_request_details.driver_request_id',$res->id);
    $this->db->where('driver_request.driver_id',$driver_id);

    return $this->db->get()->result();

  }

  public function getAssignStockDetails($id)
  {

    $this->db->select('assign_stock.*,users.img as driver_img,users.name as driver_name,users.email as driver_email,users.contact_no as driver_number,assign_stock_details.qty,assign_stock_details.available_qty,assign_stock_details.exchange_qty,assign_stock_details.foc_qty,products.name as product_name,added_by.name as added_by_name');
    $this->db->from('assign_stock');
    $this->db->join('users','users.id = assign_stock.driver_id');
    $this->db->join('assign_stock_details','assign_stock_details.assign_stock_id = assign_stock.id');
    $this->db->join('products','products.id = assign_stock_details.product_id');
    $this->db->join('users added_by', 'added_by.id = assign_stock.added_by', 'left');

    $this->db->where('assign_stock.id',$id);

    return $this->db->get()->result();

  }

  public function getAssignStockQtyToDriver($driver_id)
  {

      $this->db->select('sum(assign_stock_details.qty) as total_assign_qty,sum(assign_stock_details.available_qty) as total_available_qty,sum(assign_stock_details.exchange_qty) as total_exchange_qty');
      $this->db->from('assign_stock');
      $this->db->join('users','users.id = assign_stock.driver_id');
      $this->db->join('assign_stock_details','assign_stock_details.assign_stock_id = assign_stock.id');
      $this->db->join('products','products.id = assign_stock_details.product_id');

      $this->db->where('assign_stock.driver_id',$driver_id);
      $this->db->where('assign_stock.status','confirmed');
      $this->db->where('assign_stock.is_return',0);

      return $this->db->get()->row();

  }

}
