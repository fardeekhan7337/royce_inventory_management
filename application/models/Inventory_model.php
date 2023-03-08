<?php

/**
 *
 */
class Inventory_model extends CI_Model
{

  public function getInventory($requestData,$type,$tab)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'products.name',
          2 => Null,
          3 => NULL

      ];

      if($tab == 'available')
      {

        $select = "sum(if(logs.type='add_stock',qty,0)) as total_add_stock_qty,sum(if(logs.type='remove_stock',qty,0)) as total_remove_stock_qty,sum(if(logs.type='assign_stock_confirmed',qty,0)) as total_assign_stock_confirmed,sum(if(logs.type='pending_call_order_confirmed',qty,0)) as total_pending_call_order_confirmed,sum(if(logs.type='return' && logs.qty_type='missing_qty',qty,0)) as total_return_missing,sum(if(logs.type='return' && logs.qty_type='return_qty',qty,0)) as total_return";

      }
      else if($tab == 'missing')
      {

        $select = "sum(if(logs.type='return' && logs.qty_type='missing_qty',qty,0)) as total_return_missing";

      }
      else if($tab == 'return')
      {

        $select = "sum(if(logs.type='return' && logs.qty_type='return_qty',qty,0)) as total_return";

      }
      else if($tab == 'exchange')
      {

        $select = "sum(if(logs.type='mark_sale_done' && logs.qty_type='exchange_qty',qty,0)) as total_exchange";

      }

      $this->db->select("logs.product_id,products.name as product_name,".$select, FALSE);

      $this->db->from('logs');
      $this->db->join('products','logs.product_id = products.id','left');

      $this->db->where('products.is_deleted',0);

      if($tab == 'missing')
      {

        $this->db->where('logs.type','return');
        $this->db->where('logs.qty_type','missing_qty');

      }
      else if($tab == 'return')
      {

        $this->db->where('logs.type','return');
        $this->db->where('logs.qty_type','return_qty');

      }
      else if($tab == 'exchange')
      {

        $this->db->where('logs.type','mark_sale_done');
        $this->db->where('logs.qty_type','exchange_qty');

      }

      $this->db->group_by('logs.product_id');

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

            $this->db->order_by('products.id','desc');

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

  public function getLiveStocks($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'driver.name',
          2 => NULL,
          3 => NULL,
          4 => NULL,
          4 => NULL

      ];

      $this->db->select('assign_stock.id,users.name as driver_name,count(assign_stock_details.product_id) as total_products,sum(assign_stock_details.qty) as total_qty,sum(assign_stock_details.available_qty) as total_available_qty');
      $this->db->from('assign_stock');
      $this->db->join('users','users.id = assign_stock.driver_id');
      $this->db->join('assign_stock_details','assign_stock_details.assign_stock_id = assign_stock.id');
      $this->db->join('products','products.id = assign_stock_details.product_id');

      $this->db->where('assign_stock.is_deleted',0);

      $this->db->where('assign_stock.is_return',0);
      $this->db->where('assign_stock.status','confirmed');

      if ($this->session->userdata('UTYPE') == 'driver') {

        $this->db->where('assign_stock.driver_id',$this->session->userdata('UID'));

      }

      $this->db->group_by('assign_stock_details.assign_stock_id');

      if($type == 'recordsTotal')
      {
          return $this->db->count_all_results();
      }

      else if($type == 'filter' || $type == 'records')
      {

        if (!empty($requestData['search']['value']))
        {

           $this->db->group_start();

            $this->db->or_like('users.name',$requestData['search']['value']);

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

            $this->db->order_by('assign_stock.id','desc');

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

  public function getDeliveryOrders($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'driver.name',
          2 => Null,
          3 => 'assign_stock.status',
          4 => NULL

      ];

      $this->db->select('assign_stock.id,assign_stock.status,users.name as driver_name,count(assign_stock_details.product_id) as total_products,sum(assign_stock_details.qty) as total_qty');
      $this->db->from('assign_stock');
      $this->db->join('users','users.id = assign_stock.driver_id');
      $this->db->join('assign_stock_details','assign_stock_details.assign_stock_id = assign_stock.id');
      $this->db->join('products','products.id = assign_stock_details.product_id');

      $this->db->where('assign_stock.is_deleted',0);
      $this->db->where('assign_stock.status','pending');

      $this->db->group_by('assign_stock_details.assign_stock_id');

      if($type == 'recordsTotal')
      {
          return $this->db->count_all_results();
      }

      else if($type == 'filter' || $type == 'records')
      {

        if (!empty($requestData['search']['value']))
        {

           $this->db->group_start();

            $this->db->or_like('users.name',$requestData['search']['value']);
            $this->db->or_like('assign_stock.status',$requestData['search']['value']);

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

            $this->db->order_by('assign_stock.id','desc');

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

  public function getCallOrders($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'customer.name',
          2 => 'users.name',
          3 => 'call_orders.delivery_day',
          4 => Null,
          5 => Null,
          6 => Null,
          7 => 'call_orders.status',
          8 => NULL

      ];

      $this->db->select('call_orders.*,customers.name as customer_name,users.name as driver_name,count(call_orders_details.product_id) as total_products,sum(call_orders_details.qty) as total_qty,sum(products.price) as total_price');
      $this->db->from('call_orders');
      $this->db->join('customers','customers.id = call_orders.customer_id');
      $this->db->join('users','users.id = call_orders.driver_id');
      $this->db->join('call_orders_details','call_orders_details.call_order_id = call_orders.id');
      $this->db->join('products','products.id = call_orders_details.product_id');

      $this->db->where('call_orders.is_deleted',0);
      $this->db->where('call_orders.status','confirmed');
      $this->db->where('call_orders.pending_request_status','pending');

      $this->db->group_by('call_orders_details.call_order_id');

      if($type == 'recordsTotal')
      {
          return $this->db->count_all_results();
      }

      else if($type == 'filter' || $type == 'records')
      {

        if (!empty($requestData['search']['value']))
        {

           $this->db->group_start();

            $this->db->or_like('customers.name',$requestData['search']['value']);
            $this->db->or_like('users.name',$requestData['search']['value']);
            $this->db->or_like('call_orders.delivery_day',$requestData['search']['value']);
            $this->db->or_like('call_orders.status',$requestData['search']['value']);

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

            $this->db->order_by('call_orders.id','desc');

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

  public function getProdudtStockDetails($tab,$product_id)
  {

    if($tab == 'available')
    {

      $select = "sum(if(logs.type='add_stock',qty,0)) as total_add_stock_qty,sum(if(logs.type='remove_stock',qty,0)) as total_remove_stock_qty,sum(if(logs.type='assign_stock_confirmed',qty,0)) as total_assign_stock_confirmed,sum(if(logs.type='pending_call_order_confirmed',qty,0)) as total_pending_call_order_confirmed,sum(if(logs.type='return' && logs.qty_type='missing_qty',qty,0)) as total_return_missing,sum(if(logs.type='return' && logs.qty_type='return_qty',qty,0)) as total_return,sum(if(logs.type='mark_sale_done' && logs.qty_type='sale_qty',qty,0)) as total_sold_qty,sum(if(logs.type='mark_sale_done' && logs.qty_type='exchange_qty',qty,0)) as total_exchange";

    }
    else if($tab == 'missing')
    {

      $select = "sum(if(logs.type='return' && logs.qty_type='missing_qty',qty,0)) as total_return_missing";

    }
    else if($tab == 'return')
    {

      $select = "sum(if(logs.type='return' && logs.qty_type='return_qty',qty,0)) as total_return";

    }
    else if($tab == 'exchange')
    {

      $select = "sum(if(logs.type='mark_sale_done' && logs.qty_type='exchange_qty',qty,0)) as total_exchange";

    }

    $this->db->select("logs.*,DATE(logs.added_at) AS added_at_formatted,driver.name as driver_name,customer.name as customer_name,added_by.name as added_by_name,products.name as product_name,".$select, FALSE);

    $this->db->from('logs');
    $this->db->join('products','logs.product_id = products.id');
    $this->db->join('users driver','logs.driver_id = driver.id','left');
    $this->db->join('users customer','logs.customer_id = customer.id','left');
    $this->db->join('users added_by','logs.added_by = added_by.id','left');

    $this->db->where('logs.product_id',$product_id);

    if($tab == 'missing')
    {

      $this->db->where('logs.type','return');
      $this->db->where('logs.qty_type','missing_qty');
      $this->db->group_by('logs.driver_id');

    }
    else if($tab == 'return')
    {

      $this->db->where('logs.type','return');
      $this->db->where('logs.qty_type','return_qty');
      $this->db->group_by('logs.driver_id');

    }
    else if($tab == 'exchange')
    {

      $this->db->where('logs.type','mark_sale_done');
      $this->db->where('logs.qty_type','exchange_qty');
      $this->db->group_by('logs.driver_id');

    }

    $this->db->group_by('added_at_formatted');

    return $this->db->get()->result();

  }

  public function getLogDetails($data)
  {

    $this->db->select('logs.*,products.name as product_name,categories.type as product_type,customers.name as customer_name,drivers.name as driver_name,users.name as username');
    $this->db->from('logs');
    $this->db->join('products','products.id = logs.product_id','left');
    $this->db->join('categories','categories.id = products.cat_id','left');
    $this->db->join('customers','customers.id = logs.customer_id','left');
    $this->db->join('users drivers','drivers.id = logs.driver_id','left');
    $this->db->join('users','users.id = logs.added_by','left');

    if(!empty($data['product_id']))
    {

      $this->db->where_in('logs.product_id',$data['product_ids']);

    }

    if(!empty($data['customer_id']))
    {

      $this->db->where('logs.customer_id',$data['customer_id']);

    }

    if(!empty($data['driver_id']))
    {

      $this->db->where('logs.driver_id',$data['driver_id']);

    }

    if(!empty($data['type']))
    {

      $this->db->where_in('logs.type',$data['types']);

    }

    if(!empty($data['from']))
    {

      $this->db->where('DATE_FORMAT(logs.added_at, "%Y-%m-%d") >=',$data['from']);

    }

    if(!empty($data['to']))
    {

      $this->db->where('DATE_FORMAT(logs.added_at, "%Y-%m-%d") <=',$data['to']);

    }

    return $this->db->get()->result();

  }

  public function getAssignProductOfDriver($driver_id , $product_id)
  {

    $this->db->select('assign_stock.*');
    $this->db->from('assign_stock');
    $this->db->join('users','users.id = assign_stock.driver_id');
    $this->db->join('assign_stock_details','assign_stock_details.assign_stock_id = assign_stock.id');

    $this->db->where('assign_stock.driver_id',$driver_id);
    $this->db->where('assign_stock.status','confirmed');
    $this->db->where('assign_stock.is_return',0);

    $is_assign_pro = $this->db->get()->row();

    if(!empty($is_assign_pro))
    {

      $this->db->select('assign_stock_details.*');
      $this->db->from('assign_stock');
      $this->db->join('users','users.id = assign_stock.driver_id');
      $this->db->join('assign_stock_details','assign_stock_details.assign_stock_id = assign_stock.id');

      $this->db->order_by('assign_stock_details.id','asc');

      $this->db->where('assign_stock_details.product_id',$product_id);
      $this->db->where('assign_stock.driver_id',$driver_id);
      $this->db->where('assign_stock.status','confirmed');
      $this->db->where('assign_stock.is_return',0);

      $res = $this->db->get()->row();

      if(!empty($res))
      {

        $data = [
          'is_product' => true,
          'data' => $res,
        ];
      }
      else
      {

        $data = [
          'is_product' => false,
          'data' => $is_assign_pro,
        ];

      }

    }
    else
    {

      $data = [
        'is_product' => false,
        'data' => false,
      ];

    }

    return $data;

  }

  public function getReturnSummaryDetails($driver_id,$from,$to)
  {

    $this->db->select('logs.*,products.name as product_name,products.price as product_price,customers.name as customer_name,drivers.name as driver_name,users.name as username');
    $this->db->from('logs');
    $this->db->join('products','products.id = logs.product_id','left');
    $this->db->join('customers','customers.id = logs.customer_id','left');
    $this->db->join('users drivers','drivers.id = logs.driver_id','left');
    $this->db->join('users','users.id = logs.added_by','left');

    if(!empty($driver_id))
    {

      $this->db->where('logs.driver_id',$driver_id);

    }

    $this->db->where('DATE_FORMAT(logs.added_at, "%Y-%m-%d") >=',$from);

    $this->db->where('DATE_FORMAT(logs.added_at, "%Y-%m-%d") <=',$to);

    $this->db->where('logs.type','return');
    $this->db->where('logs.qty_type','return_qty');


    return $this->db->get()->result();

  }


  public function getMissingSummaryDetails($driver_id,$from,$to)
  {

    $this->db->select('logs.*,products.name as product_name,products.price as product_price,customers.name as customer_name,drivers.name as driver_name,users.name as username');
    $this->db->from('logs');
    $this->db->join('products','products.id = logs.product_id','left');
    $this->db->join('customers','customers.id = logs.customer_id','left');
    $this->db->join('users drivers','drivers.id = logs.driver_id','left');
    $this->db->join('users','users.id = logs.added_by','left');

    if(!empty($driver_id))
    {

      $this->db->where('logs.driver_id',$driver_id);

    }

      $this->db->where('DATE_FORMAT(logs.added_at, "%Y-%m-%d") >=',$from);

      $this->db->where('DATE_FORMAT(logs.added_at, "%Y-%m-%d") <=',$to);


      $this->db->where('logs.type','return');
      $this->db->where('logs.qty_type','missing_qty');


    return $this->db->get()->result();

  }

  public function availableInventoryDetails()
  {

      $this->db->select("logs.product_id,products.name as product_name,sum(if(logs.type='add_stock',qty,0)) as total_add_stock_qty,sum(if(logs.type='remove_stock',qty,0)) as total_remove_stock_qty,sum(if(logs.type='assign_stock_confirmed',qty,0)) as total_assign_stock_confirmed,sum(if(logs.type='pending_call_order_confirmed',qty,0)) as total_pending_call_order_confirmed,sum(if(logs.type='return' && logs.qty_type='missing_qty',qty,0)) as total_return_missing,sum(if(logs.type='return' && logs.qty_type='return_qty',qty,0)) as total_return", FALSE);

      $this->db->from('logs');
      $this->db->join('products','logs.product_id = products.id','left');

      $this->db->where('products.is_deleted',0);

      $this->db->group_by('logs.product_id');


      $this->db->order_by('products.id','desc');

      return $this->db->get()->result();

  }


}
