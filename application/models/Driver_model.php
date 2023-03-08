<?php

/**
 *
 */
class Driver_model extends CI_Model
{

  public function getDrivers($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'name',
          2 => 'username',
          3 => 'email',
          4 => 'contact_no',
          5 => 'fin_no',
          6 => 'car_plate',
          7 => 'status',
          8 => NULL

      ];

      $this->db->select('*');
      $this->db->from('users');

      $this->db->where('is_deleted',0);
      $this->db->where('type','driver');

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
            $this->db->or_like('username',$requestData['search']['value']);
            $this->db->or_like('email',$requestData['search']['value']);
            $this->db->or_like('contact_no',$requestData['search']['value']);
            $this->db->or_like('fin_no',$requestData['search']['value']);
            $this->db->or_like('car_plate',$requestData['search']['value']);


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

  public function getDriversCount()
  {

      $this->db->select('users.id');
      $this->db->from('users');

      $this->db->where('is_deleted',0);
      $this->db->where('type','driver');

      return $this->db->count_all_results();

  }


}
