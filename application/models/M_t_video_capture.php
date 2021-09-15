<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_video_capture extends CI_Model {
    
  

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_VIDEO_CAPTURE', $data);
}

public function select_id($id)
{
  $this->db->select('ID');
  $this->db->from('T_VIDEO_CAPTURE');
  $this->db->where('SATUAN', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}


  public function select_option()
  {
    $this->db->select('*');
    $this->db->from('T_VIDEO_CAPTURE');
    $this->db->where("MARK_FOR_DELETE=false");
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  } 


  

  public function select_last_data()
  {
    $this->db->limit(1);
    $this->db->select('*');
    $this->db->from('T_VIDEO_CAPTURE');

    
    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_VIDEO_CAPTURE');

   
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_VIDEO_CAPTURE');
  }

  function tambah($data)
  {
    $this->db->insert('T_VIDEO_CAPTURE', $data);
    return TRUE;
  }

}


