<?php

/**
 *
 */
class Evidence_model extends CI_Model
{

  public function getEvidences($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'customers.shop_name',
          2 => NULL,
          3 => 'evidence.comment',
          4 => NULL

      ];

      $this->db->select('evidence.*,customers.shop_name as shop_name,users.name added_by_name');
      $this->db->from('evidence');
      $this->db->join('customers','customers.id = evidence.shop_id');
      $this->db->join('users','users.id = evidence.added_by','left');

      $this->db->where('evidence.is_deleted',0);

      if($this->session->userdata('UTYPE') == 'driver')
      {

        $this->db->where('evidence.added_by',$this->session->userdata('UID'));

      }

      if($type == 'recordsTotal')
      {
          return $this->db->count_all_results();
      }

      else if($type == 'filter' || $type == 'records')
      {

        if (!empty($requestData['search']['value']))
        {

           $this->db->group_start();

            $this->db->or_like('customers.shop_name',$requestData['search']['value']);
            $this->db->or_like('evidence.comment',$requestData['search']['value']);
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

            $this->db->order_by('evidence.id','desc');

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

  public function getEvidenceDetails($evidence_id)
  {

    $this->db->select('evidence.*,customers.shop_name as shop_name,users.name added_by_name');
    $this->db->from('evidence');
    $this->db->join('customers','customers.id = evidence.shop_id');
    $this->db->join('users','users.id = evidence.added_by','left');

    $this->db->where('evidence.id',$evidence_id);

    return $this->db->get()->row();

  }


}
