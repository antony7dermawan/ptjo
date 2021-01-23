<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_d_company extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_d_company');
  }

  public function index()
  {
    $data = [
      "c_t_m_d_company" => $this->m_t_m_d_company->select(),
      "title" => "Master Company",
      "description" => "Company ID untuk Login"
    ];
    $this->render_backend('template/backend/pages/t_m_d_company', $data);
  }



  public function delete($id)
  {
    $this->m_t_m_d_company->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data User Berhasil Dihapus!</p></div>');
    redirect('/c_t_m_d_company');
  }


  function tambah()
  {
    $company_id = intval($this->input->post("company_id"));
    $company = $this->input->post("company");

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'COMPANY_ID' => $company_id,
      'COMPANY' => $company,
    );

    $this->m_t_m_d_company->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_d_company');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $company_id = intval($this->input->post("company_id"));
    $company = $this->input->post("company");

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'COMPANY_ID' => $company_id,
      'COMPANY' => $company,
    );
    
    $this->m_t_m_d_company->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_d_company');
  }

}
