<?php

class Basic_model extends CI_Model
{

  // inset single row
  public function insert_row($table,$data)
  {

      $this->db->insert($table , $data);

      return $this->db->insert_id();

  }

  //insert multiple rows
  public function insert_rows($table,$data)
  {

      $this->db->insert_batch($table,$data);

      return true;
  }

  // update row
  public function update($table,$data,$column,$id)
  {

      $this->db->where($column,$id);
      $this->db->update($table,$data);

      return true;

  }

  // delete with single condition
  public function delete($table,$column,$id)
  {

      $this->db->where($column,$id);
      $this->db->delete($table);

      return true;

  }

  // delete with multiple condition
  public function deleteWithCondidtions($table,$condition_arr)
  {

      $this->db->where($condition_arr);
      $this->db->delete($table);

      return true;

  }

  // get single row with single condition
  public function getRow($table,$column = '',$id = '')
  {

      if ($column != '') {

        $this->db->where($column,$id);

      }

      return $this->db->get($table)->row();

  }

  // get single row with single condition
  public function getRowWithConditions($table,$condition_arr)
  {

      $this->db->where($condition_arr);

      return $this->db->get($table)->row();

  }

  // get rows with single condition
  public function getRows($table,$column = '',$id = '',$order_column = '',$order = '')
  {

      if ($column != '') {

        $this->db->where($column,$id);

      }

      if (!empty($order_column))
      {

        $this->db->order_by($order_column,$order);

      }

      return $this->db->get($table)->result();

  }

   // get rows with whereIN condition
   public function getRowsWhereIn($table,$column,$ids,$order_column = '',$order = '')
   {

       if ($ids != '') {

         $this->db->where_in($column,$ids);

       }

       if (!empty($order_column))
       {

         $this->db->order_by($order_column,$order);

       }

       return $this->db->get($table)->result();

   }

  // get rows with multiple condition
  public function getRowsWithConditions($table,$condition_arr,$order_column = '',$order = '')
  {

      $this->db->where($condition_arr);

      if (!empty($order_column))
      {

        $this->db->order_by($order_column,$order);

      }

      return $this->db->get($table)->result();

  }


  function uploadFile($file, $uploads_dir)
  {
      set_time_limit(0);

      if ($file['size'] > 0) {

          $pic_name = "";

          $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

          $pic_name = rand();

          $tmp_name = $file["tmp_name"];

          // $pic_name.= $file["name"];

          move_uploaded_file($tmp_name, "$uploads_dir/$pic_name");


          return $pic_name;

      } else {

          return "";

      }

  }



}