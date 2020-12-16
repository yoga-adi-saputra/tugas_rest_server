<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
class Band extends RestController
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Band_model', 'band');
    $this->methods['index_get']['limit'] = 10; 
  }

  public function index_get()
  {
    $id = $this->get('id', true);
    if ($id === null) {
      $p = $this->get('page', true);
      $p = (empty($p) ? 1 : $p);
      $total_data = $this->band->count();
      $total_page = ceil($total_data / 5);
      $start = ($p - 1) * 5;
      $list = $this->band->get(null, 5, $start);
      if ($list) {
        $data = [
          'status' => true,
          'page' => $p,
          'total_data' => $total_data,
          'total_page' => $total_page,
          'data' => $list
        ];
      } else {
        $data = [
          'status' => false,
          'msg' => 'Data tidak ditemukan'
        ];
      }
      $this->response($data, RestController::HTTP_OK);
    } else {
      $data = $this->band->get($id);
      if ($data) {
        $this->response(['status' => true, 'data' => $data], RestController::HTTP_OK);
      } else {
        $this->response(['status' => false, 'msg' => $id . ' tidak ditemukan'], RestController::HTTP_NOT_FOUND);
      }
    }
  }

  public function index_post()
  {
    $data=[
      'id' => $this->post('id',true),
      'nama' => $this->post('nama',true),
      'genre' => $this->post('genre',true),
      'kota' => $this->post('kota',true),
      'kontak' => $this->post('kontak',true)
    ];
    $simpan=$this->band->add($data);
    if($simpan['status']){
      $this->response(['status'=>true,'msg'=>$simpan['data']. ' Data telah ditambahkan'], RestController::HTTP_CREATED);
    }else{
      $this->response(['status'=>false,'msg'=>$simpan['msg']],RestController::HTTP_INTERNAL_ERROR);
    }
  }

  public function index_put()
  {
    $data=[
        'id' => $this->post('id',true),
        'nama' => $this->post('nama',true),
        'genre' => $this->post('genre',true),
        'kota' => $this->post('kota',true),
        'kontak' => $this->post('kontak',true)
    ];
    $id=$this->put('id',true);
    if($id===null){
      $this->response(['status'=>false,'msg'=>'Masukkan ID yang akan diubah'],RestController::HTTP_INTERNAL_ERROR);
    }
    $simpan=$this->band->update($id, $data);
    if($simpan['status']){
      $status=(int)$simpan['data'];
      if($status>0)
      $this->response(['status'=>true,'msg'=>$simpan['data']. ' Data telah diubah'], RestController::HTTP_OK);
      else
      $this->response(['status'=>false,'msg'=>'Tidak ada data yang diubah'],RestController::HTTP_BAD_REQUEST);
    }else{
      $this->response(['status'=>false,'msg'=>$simpan['msg']],RestController::HTTP_INTERNAL_ERROR);
    }
  }

  public function index_delete()
  {
    $id=$this->delete('id',true);
    if($id===null){
      $this->response(['status'=>false,'msg'=>'Masukkan ID yang akan dihapus'],RestController::HTTP_INTERNAL_ERROR);
    }
    $delete=$this->band->delete($id);
    if($delete['status']){
      $status=(int)$delete['data'];
      if($status>0)
      $this->response(['status'=>true,'msg'=>$id. ' telah dihapus'], RestController::HTTP_OK);
      else
      $this->response(['status'=>false,'msg'=>'Tidak ada data yang dihapus'],RestController::HTTP_BAD_REQUEST);
    }else{
      $this->response(['status'=>false,'msg'=>$delete['msg']],RestController::HTTP_INTERNAL_ERROR);
    }
  }

}

