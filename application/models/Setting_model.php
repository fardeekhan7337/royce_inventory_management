<?php

/**
 *
 */
class Setting_model extends CI_Model
{

  public function getTemplates($requestData,$type)
  {
      // storing request (ie, get/post) global array to a variable
      $columns = [
          // datatable column index => database column name
          0 => NULL,
          1 => 'title',
          2 => 'subject',
          3 => 'template',
          4 => NULL

      ];

      $this->db->select('*');
      $this->db->from('email_templates');

      if($type == 'recordsTotal')
      {
          return $this->db->count_all_results();
      }

      else if($type == 'filter' || $type == 'records')
      {

        if (!empty($requestData['search']['value']))
        {

           $this->db->group_start();

            $this->db->or_like('title',$requestData['search']['value']);
            $this->db->or_like('subject',$requestData['search']['value']);
            $this->db->or_like('template',$requestData['search']['value']);

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

  public function getAllTemplates()
  {

      $this->db->select('id as id,title as name');
      $this->db->from('email_templates');

      return $this->db->get()->result();

  }

  public function getGeneralSetting($type)
  {

      $this->db->select('*');
      $this->db->from('general_setting');

      $this->db->where('name',$type);

      return $this->db->get()->row();

  }


}
