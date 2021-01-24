<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_terima_pelanggan_print_setting extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_terima_pelanggan_print_setting');
  }

  public function index()
  {
    $data = [
      "c_t_ak_terima_pelanggan_print_setting" => $this->m_t_ak_terima_pelanggan_print_setting->select(),
      "title" => "Setting Print Terima Pelanggan",
      "description" => "Setting ID tidak boleh diubah-ubah ya"
    ];
    $this->render_backend('template/backend/pages/t_ak_terima_pelanggan_print_setting', $data);
  }



  public function delete($id)
  {
    $this->m_t_ak_terima_pelanggan_print_setting->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_ak_terima_pelanggan_print_setting');
  }


  function tambah()
  {
    $setting_id = intval($this->input->post("setting_id"));
    $setting_name = $this->input->post("setting_name");
    $setting_value = $this->input->post("setting_value");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'SETTING_ID' => $setting_id,
      'SETTING_NAME' => $setting_name,
      'SETTING_VALUE' => $setting_value
    );

    $this->m_t_ak_terima_pelanggan_print_setting->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_ak_terima_pelanggan_print_setting');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $setting_id = intval($this->input->post("setting_id"));
    $setting_name = $this->input->post("setting_name");
    $setting_value = $this->input->post("setting_value");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'SETTING_ID' => $setting_id,
      'SETTING_NAME' => $setting_name,
      'SETTING_VALUE' => $setting_value
    );

    $this->m_t_ak_terima_pelanggan_print_setting->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_ak_terima_pelanggan_print_setting');
  }
}
