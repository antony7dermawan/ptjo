<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_video_capture extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_video_capture');
  }

  public function index()
  {
    $this->session->set_userdata('t_video_capture_delete_logic', '1');
    $data = [
      "c_t_video_capture" => $this->m_t_video_capture->select(),
      "title" => "Transaksi Pengambilan Video",
      "description" => "Menampilkan 30 Hari Terakhir"
    ];
    $this->render_backend('template/backend/pages/t_video_capture', $data);
  }



  public function delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_video_capture->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_video_capture');
  }

  public function undo_delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_video_capture->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('/c_t_video_capture');
  }


  function tambah()
  {
    
    $d_pipe = substr($this->input->post("d_pipe"), 0, 32);
    $location = substr($this->input->post("location"), 0, 32);
    $upstream = substr($this->input->post("upstream"), 0, 32);
    $downstream = substr($this->input->post("downstream"), 0, 32);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'D_PIPE' => $d_pipe,
      'LOCATION' => $location,
      'UPSTREAM' => $upstream,
      'DOWNSTREAM' => $downstream,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => '',
      'MARK_FOR_DELETE' => FALSE
    );

    $this->m_t_video_capture->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_video_streaming');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $d_pipe = substr($this->input->post("d_pipe"), 0, 32);
    $location = substr($this->input->post("location"), 0, 32);
    $upstream = substr($this->input->post("upstream"), 0, 32);
    $downstream = substr($this->input->post("downstream"), 0, 32);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'D_PIPE' => $d_pipe,
      'LOCATION' => $location,
      'UPSTREAM' => $upstream,
      'DOWNSTREAM' => $downstream,
      'UPDATED_BY' => $this->session->userdata('username')

    );

 

    $this->m_t_video_capture->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_video_capture');
  }
}
