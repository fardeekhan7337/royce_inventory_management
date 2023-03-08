<?php

/**
 *
 */
class Category_model extends CI_Model
{

  public function getCategories($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'name',
          2 => 'type',
          3 => 'price',
          4 => NULL

      ];

      $this->db->select('*');
      $this->db->from('categories');

      $this->db->where('is_deleted',0);

      if($type == 'recordsTotal')
      {
          return $this->db->count_all_results();
      }

      else if($type == 'filter' || $type == 'records')
      {

        if (!empty($requestData['search']['value']))
        {

           $this->db->group_start();

            $this->db->or_like('name',$requestData['search']['value']);
            $this->db->or_like('type',$requestData['search']['value']);
            $this->db->or_like('price',$requestData['search']['value']);


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

            $this->db->order_by('id','desc');

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

  public function getAllProductCategoriesByCustomerId($customer_id)
  {

    $this->db->select('categories.*');
    $this->db->from('customer_products_price');
    $this->db->join('products','products.id = customer_products_price.product_id');
    $this->db->join('categories','categories.id = products.cat_id');
    $this->db->join('customers','customers.id = customer_products_price.customer_id');

    $this->db->where('customer_products_price.customer_id',$customer_id);

    $this->db->group_by('categories.id');
    $this->db->where('products.is_deleted',0);
    $this->db->where('categories.is_deleted',0);

    return $this->db->get()->result();

  }


}
