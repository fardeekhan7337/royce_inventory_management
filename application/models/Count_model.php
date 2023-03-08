<?php

/**
 *
 */
class Count_model extends CI_Model
{

  public function getPendingCallOrdersCount()
  {

    $this->db->select('call_orders.id');
    $this->db->from('call_orders');
    $this->db->join('customers','customers.id = call_orders.customer_id');
    $this->db->join('users','users.id = call_orders.driver_id');
    $this->db->join('call_orders_details','call_orders_details.call_order_id = call_orders.id');
    $this->db->join('products','products.id = call_orders_details.product_id');

      $this->db->where('call_orders.is_deleted',0);
      $this->db->where('call_orders.status','confirmed');
      $this->db->where('call_orders.pending_request_status','pending');

      $this->db->group_by('call_orders_details.call_order_id');

    return $this->db->count_all_results();

  }

  public function getDeliveryOrdersCount()
  {

    $this->db->select('assign_stock.id');
    $this->db->from('assign_stock');
    $this->db->join('users','users.id = assign_stock.driver_id');
    $this->db->join('assign_stock_details','assign_stock_details.assign_stock_id = assign_stock.id');
    $this->db->join('products','products.id = assign_stock_details.product_id');

      $this->db->where('assign_stock.is_deleted',0);
      $this->db->where('assign_stock.status','pending');

      $this->db->group_by('assign_stock_details.assign_stock_id');

    return $this->db->count_all_results();

  }

  public function getDriverRequestsCount()
  {

      $this->db->select('driver_request.id');
      $this->db->from('driver_request');
      $this->db->join('users','users.id = driver_request.driver_id');

      $this->db->where('driver_request.is_assign',0);
      $this->db->where('users.is_deleted',0);

      return $this->db->count_all_results();

  }

}
