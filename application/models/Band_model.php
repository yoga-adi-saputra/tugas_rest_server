<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Band_model extends CI_Model {


  public function __construct()
  {
    parent::__construct();
  }


  public function get($id = null, $limit = 5, $offset = 0)
  {
      if ($id === null) {
      return $this->db->get('daftar_band', $limit,$offset)->result();
    } else {
      return $this->db->get_where('daftar_band', ['id' => $id])->result_array();
    }
  }
  
  public function count()
  {
    return $this->db->get('daftar_band')->num_rows();
  }

  public function add($data)
  {
    try{
      $this->db->insert('daftar_band', $data);
      $error=$this->db->error();
      if(!empty($error['code']))
      {
        throw new exception('Terjadi Kesalahan:' .$error['message']);
        return false; 
      }
      return ['status'=>true, 'data'=>$this->db->affected_rows()];
    }catch (Exception $ex) {
      return['status'=>false, 'msg' => $ex->getMessage()];
    }
  }

  public function update($id, $data)
  {
    try{
      $this->db->update('daftar_band', $data, ['id' =>$id]);
      $error=$this->db->error();
      if(!empty($error['code']))
      {
        throw new exception('Terjadi Kesalahan:' .$error['message']);
        return false; 
      }
      return ['status'=>true, 'data'=>$this->db->affected_rows()];
    }catch (Exception $ex) {
      return['status'=>false, 'msg' => $ex->getMessage()];
    }
  }

  public function delete($id)
  {
    try{
      $this->db->delete('daftar_band', ['id' =>$id]);
      $error=$this->db->error();
      if(!empty($error['code']))
      {
        throw new exception('Terjadi Kesalahan:' .$error['message']);
        return false; 
      }
      return ['status'=>true, 'data'=>$this->db->affected_rows()];
    }catch (Exception $ex) {
      return['status'=>false, 'msg' => $ex->getMessage()];
    }
  }

}

