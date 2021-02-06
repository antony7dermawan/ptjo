<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_po extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_po');
  }

  public function index()
  {
    $data = [
      "c_t_po" => $this->m_t_po->select($this->session->userdata('date_po')),
      
      "title" => "PO",
      "description" => "Menu Pembuatan PO"
    ];
    $this->render_backend('template/backend/pages/t_po', $data);
  }

  public function date_po()
  {
    $date_po = ($this->input->post("date_po"));
    $this->session->set_userdata('date_po', $date_po);
    redirect('/c_t_po');
  }


  public function delete($id)
  {
    $this->m_t_po->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_po');
  }



  function tambah()
  {
    $date = ($this->input->post("date"));
    $no_po = substr($this->input->post("no_po"), 0, 100);
    $supplier = substr($this->input->post("supplier"), 0, 100);
    $ket = substr($this->input->post("ket"), 0, 500);

    
    

    $data = array(
      'DATE' => $date,
      'TIME' => date('H:i:s'),
      'NO_PO' => $no_po,
      'SUPPLIER' => $supplier,
      'KET' => $ket,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username')
    );

    $this->m_t_po->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_po');
  }




  public function edit_action()
  {
    $id = $this->input->post("id");


    $no_po = substr($this->input->post("no_po"), 0, 100);
    $supplier = substr($this->input->post("supplier"), 0, 100);
    $ket = substr($this->input->post("ket"), 0, 500);

    
    

    $data = array(
      'NO_PO' => $no_po,
      'SUPPLIER' => $supplier,
      'KET' => $ket,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username')
    );
    $this->m_t_po->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_po');
  }
}
