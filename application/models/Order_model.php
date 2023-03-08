<?php

/**
 *
 */
class Order_model extends CI_Model
{

  public function getCallOrders($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => NULL,
          2 => 'customers.name',
          3 => 'customers.shop_name',
          4 => 'customers.shop_acronym',
          5 => 'call_orders.delivery_day',
          6 => Null,
          7 => Null,
          8 => Null,
          9 => 'call_orders.order_comment',
          10 => 'call_orders.status'

      ];

      $this->db->select('call_orders.*,customers.name as customer_name,customers.shop_name as shop_name,customers.shop_acronym as shop_acronym,count(call_orders_details.product_id) as total_products,sum(call_orders_details.qty) as total_qty,sum(call_orders_details.qty * customer_products_price.price) as total_price');
      $this->db->from('call_orders');
      $this->db->join('customers','customers.id = call_orders.customer_id');
      $this->db->join('call_orders_details','call_orders_details.call_order_id = call_orders.id');
      $this->db->join('products','products.id = call_orders_details.product_id');
      $this->db->join('customer_products_price','(customer_products_price.product_id = call_orders_details.product_id) AND (customer_products_price.customer_id = customers.id)');

      $this->db->where('call_orders.is_deleted',0);
      $this->db->where('call_orders.status','pending');

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
            $this->db->or_like('customers.shop_name',$requestData['search']['value']);
            $this->db->or_like('customers.shop_acronym',$requestData['search']['value']);
            $this->db->or_like('call_orders.delivery_day',$requestData['search']['value']);
            $this->db->or_like('call_orders.status',$requestData['search']['value']);
            $this->db->or_like('call_orders.order_comment',$requestData['search']['value']);

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

  public function getCallOrderDetails($call_order_id)
  {

      $this->db->select('call_orders.*,call_orders_details.qty,customers.name as customer_name,customers.shop_acronym as shop_acronym,customers.e_receipt_email as customer_email,customers.primary_contact as customer_number,customers.address as customer_address,products.name as product_name,users.name as driver_name,users.name as driver_name,added_by.name as added_by_name');
      $this->db->from('call_orders');
      $this->db->join('customers','customers.id = call_orders.customer_id');
      $this->db->join('users','users.id = call_orders.driver_id');
      $this->db->join('call_orders_details','call_orders_details.call_order_id = call_orders.id');
      $this->db->join('products','products.id = call_orders_details.product_id');
      $this->db->join('users added_by', 'added_by.id = call_orders.added_by', 'left');

      $this->db->where('call_orders.id',$call_order_id);

      return $this->db->get()->result();

  }

  public function getAllCallOrders($driver_id)
  {

    $current_day = date('l');

    $this->db->select('call_orders.*,count(call_orders_details.product_id) total_products,sum(call_orders_details.qty) total_qty,customers.name as customer_name,customers.shop_name,customers.shop_acronym');
    $this->db->from('call_orders');
    $this->db->join('customers','customers.id = call_orders.customer_id');
    $this->db->join('users','users.id = call_orders.driver_id');
    $this->db->join('call_orders_details','call_orders_details.call_order_id = call_orders.id');
    $this->db->join('products','products.id = call_orders_details.product_id');
    $this->db->join('users added_by', 'added_by.id = call_orders.added_by', 'left');

    $this->db->where('call_orders.driver_id',$driver_id);
    $this->db->where('call_orders.delivery_day',$current_day);
    $this->db->where('call_orders.is_given',0);

    $this->db->group_by('call_orders_details.call_order_id');

    return $this->db->get()->result();

  }

  public function getAllCallOrdersQtyByCallOrderId($call_order_id)
  {

    $this->db->select('call_orders_details.qty,products.name as product_name');
    $this->db->from('call_orders');
    $this->db->join('customers','customers.id = call_orders.customer_id');
    $this->db->join('users','users.id = call_orders.driver_id');
    $this->db->join('call_orders_details','call_orders_details.call_order_id = call_orders.id');
    $this->db->join('products','products.id = call_orders_details.product_id');
    $this->db->join('users added_by', 'added_by.id = call_orders.added_by', 'left');

    $this->db->where('call_orders.id',$call_order_id);

    return $this->db->get()->result();

  }

  public function getAllCallOrdersCustomers($driver_id)
  {

    $current_day = date('l');

    $this->db->select('customers.id,customers.name,customers.shop_name,customers.shop_acronym');
    $this->db->from('call_orders');
    $this->db->join('customers','customers.id = call_orders.customer_id');
    $this->db->join('users','users.id = call_orders.driver_id');
    $this->db->join('call_orders_details','call_orders_details.call_order_id = call_orders.id');
    $this->db->join('products','products.id = call_orders_details.product_id');
    $this->db->join('users added_by', 'added_by.id = call_orders.added_by', 'left');

      $this->db->where('call_orders.driver_id',$driver_id);
      $this->db->where('call_orders.delivery_day',$current_day);

      $this->db->where('call_orders.status','confirmed');
      $this->db->where('call_orders.pending_request_status','confirmed');
      $this->db->where('call_orders.is_given',0);


      $this->db->group_by('call_orders_details.call_order_id');

    return $this->db->get()->result();

  }

  public function getCustomerCallOrdersProducts($customer_id,$driver_id)
  {

      $current_day = date('l');

      $this->db->select('call_orders_details.*,products.name as product_name,customer_products_price.price as product_price');
      $this->db->from('call_orders');
      $this->db->join('customers','customers.id = call_orders.customer_id');
      $this->db->join('users','users.id = call_orders.driver_id');
      $this->db->join('call_orders_details','call_orders_details.call_order_id = call_orders.id');
      $this->db->join('products','products.id = call_orders_details.product_id');
      $this->db->join('customer_products_price','(customer_products_price.product_id = call_orders_details.product_id) AND (customer_products_price.customer_id = customers.id)');
      $this->db->join('users added_by', 'added_by.id = call_orders.added_by', 'left');

      $this->db->where('call_orders.customer_id',$customer_id);

      $this->db->where('call_orders.driver_id',$driver_id);
      $this->db->where('call_orders.delivery_day',$current_day);

      $this->db->where('call_orders.status','confirmed');
      $this->db->where('call_orders.pending_request_status','confirmed');
      $this->db->where('call_orders.is_given',0);

      $this->db->order_by('call_orders_details.call_order_id');
      $this->db->group_by('customer_products_price.product_id');

      return $this->db->get()->result();

  }


}
