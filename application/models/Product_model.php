<?php

/**
 *
 */
class Product_model extends CI_Model
{

  public function getProducts($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => NULL,
          2 => 'products.name',
          3 => 'categories.name',
          4 => 'products.code',
          5 => 'products.sku',
          6 => 'products.color',
          7 => 'products.price',
          8 => NULL

      ];

      $this->db->select('products.*,categories.name as cat_name');
      $this->db->from('products');
      $this->db->join('categories','categories.id = products.cat_id');

      $this->db->where('products.is_deleted',0);

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
            $this->db->or_like('categories.name',$requestData['search']['value']);
            $this->db->or_like('products.code',$requestData['search']['value']);
            $this->db->or_like('products.sku',$requestData['search']['value']);
            $this->db->or_like('products.price',$requestData['search']['value']);

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

  public function getAllProducts()
  {

    $this->db->select('products.*,categories.name as cat_name');
    $this->db->from('products');
    $this->db->join('categories','categories.id = products.cat_id');

    $this->db->where('products.is_deleted',0);

    return $this->db->get()->result();

  }

  public function getProductsCount()
  {

    $this->db->select('products.id');
    $this->db->from('products');
    $this->db->join('categories','categories.id = products.cat_id');

    $this->db->where('products.is_deleted',0);

    return $this->db->count_all_results();

  }


}