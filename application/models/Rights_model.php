<?php

/**
 *
 */
class Rights_model extends CI_Model
{

  public function getModuleRolesByUserType($module_id,$type)
  {

    $this->db->select('roles.id,roles.name,user_roles.is_allow');
    $this->db->from('modules');
    $this->db->join('roles','modules.id = roles.module_id');
    $this->db->join('user_roles','roles.id = user_roles.role_id','left');

      $this->db->where('modules.id',$module_id);
      $this->db->where('user_roles.type',$type);

      $this->db->order_by('roles.order_id','asc');

    $res =  $this->db->get()->result();

    if(!empty($res))
    {
        return $res;
    }
    else
    {
        
      $this->db->select('roles.id,roles.name');
      $this->db->from('modules');
      $this->db->join('roles','modules.id = roles.module_id');

        $this->db->where('modules.id',$module_id);

        $this->db->order_by('roles.order_id','asc');
        
      return $this->db->get()->result();

    }

  }

  public function checkUserRight($type , $role_id)
  {

    $this->db->select('user_roles.is_allow');
    $this->db->from('modules');
    $this->db->join('roles','modules.id = roles.module_id');
    $this->db->join('user_roles','roles.id = user_roles.role_id','left');

      $this->db->where('user_roles.role_id',$role_id);
      $this->db->where('user_roles.type',$type);

    return $this->db->get()->row();

  }

}
