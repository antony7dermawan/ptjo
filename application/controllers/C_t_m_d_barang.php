<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_d_barang extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();


    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_barang');
    $this->load->model('m_t_m_d_kategori');
    $this->load->model('m_t_m_d_satuan');
    $this->load->model('m_t_m_d_jenis_barang');
  }

  public function index()
  {
    $this->session->set_userdata('t_m_d_company_delete_logic', '0');
    $this->session->set_userdata('t_m_d_kategori_delete_logic', '0');
    $this->session->set_userdata('t_m_d_satuan_delete_logic', '0');
    $this->session->set_userdata('t_m_d_jenis_barang_delete_logic', '0');

    $this->session->set_userdata('t_m_d_barang_delete_logic', '1');
    $data = [
      "c_t_m_d_company" => $this->m_t_m_d_company->select(),
      "c_t_m_d_barang" => $this->m_t_m_d_barang->select(),
      "c_t_m_d_kategori" => $this->m_t_m_d_kategori->select_option(),
      "c_t_m_d_satuan" => $this->m_t_m_d_satuan->select_option(),
      "c_t_m_d_jenis_barang" => $this->m_t_m_d_jenis_barang->select_option(),

      "title" => "Master Barang",
      "description" => "Hati Hati dalam mengisi master data"
    ];
    $this->render_backend('template/backend/pages/t_m_d_barang', $data);
  }

  public function change_kategori_id()
  {
    $master_barang_kategori_id = ($this->input->post("kategori_id"));
    $this->session->set_userdata('master_barang_kategori_id', $master_barang_kategori_id);
    redirect('/c_t_m_d_barang');
  }

  public function change_company_id()
  {
    $master_barang_company_id = ($this->input->post("company_id"));
    $this->session->set_userdata('master_barang_company_id', $master_barang_company_id);
    redirect('/c_t_m_d_barang');
  }

  public function delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_m_d_barang->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_m_d_barang');
  }

  public function undo_delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_m_d_barang->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('/c_t_m_d_barang');
  }

  

  function pinlok_company_id()
  {
    $id = $this->input->post("id");


    $company = $this->input->post("company");
    $read_select = $this->m_t_m_d_company->select_id($company);
    foreach ($read_select as $key => $value) {
      $company_id = $value->ID;
    }

    if($company_id!=0)
    {
      $read_select = $this->m_t_m_d_barang->select_by_id_id($id);
      foreach ($read_select as $key => $value) {
        $kode_barang = $value->KODE_BARANG;

        $barang = $value->BARANG;
        $part_number = $value->PART_NUMBER;
        $kategori_id = $value->KATEGORI_ID;
        $merk_barang = $value->MERK_BARANG;
        $posisi = $value->POSISI;
        $minimum_stok = $value->MINIMUM_STOK;
        $created_by = $value->CREATED_BY;
        $updated_by = $value->UPDATED_BY;
        $mark_for_delete = $value->MARK_FOR_DELETE;
        $barang_id = $value->BARANG_ID;
        $harga_jual = $value->HARGA_JUAL;
        $satuan_id = $value->SATUAN_ID;
        $maximum_stok = $value->MAXIMUM_STOK;
        $jenis_barang_id = $value->JENIS_BARANG_ID;

      }

      $yes_logic=0;
      $read_select = $this->m_t_m_d_barang->select_existing_barang_id_in_company($barang_id,$company_id);
      foreach ($read_select as $key => $value) {
        $yes_logic=1;
        $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong>Barang Sudah Tersedia di Company Tujuan!</p></div>');
      }

      if($yes_logic==0)
      {
        $data = array(
          'KODE_BARANG' => $kode_barang,
          'BARANG' => $barang,
          'PART_NUMBER' => $part_number,
          'KATEGORI_ID' => $kategori_id,
          'MERK_BARANG' => $merk_barang,
          'POSISI' => $posisi,
          'MINIMUM_STOK' => $minimum_stok,
          'CREATED_BY' => $this->session->userdata('username'),
          'UPDATED_BY' => '',
          'MARK_FOR_DELETE' => FALSE,
          'BARANG_ID' => $barang_id,
          'HARGA_JUAL' => $harga_jual,
          'SATUAN_ID' => $satuan_id,
          'COMPANY_ID' => $company_id,
          'MAXIMUM_STOK' => $maximum_stok,
          'JENIS_BARANG_ID' => $jenis_barang_id
        );

        $this->m_t_m_d_barang->tambah($data);

        $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dipindahkan Ke Company Tujuan!</strong></p></div>');
      }


      
    }
    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap!</p></div>');
    }
    redirect('c_t_m_d_barang');
    
    

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    

    
  }


  function tambah()
  {
    $kode_barang = substr($this->input->post("kode_barang"), 0, 100);
    $barang = substr($this->input->post("barang"), 0, 100);
    $part_number = substr($this->input->post("part_number"), 0, 50);
    $kategori_id = intval($this->input->post("kategori_id"));
    $merk_barang = substr($this->input->post("merk_barang"), 0, 50);
    $posisi = substr($this->input->post("posisi"), 0, 200);
    $minimum_stok = floatval($this->input->post("minimum_stok"));
    $harga_jual = floatval($this->input->post("harga_jual"));
    $maximum_stok = floatval($this->input->post("maximum_stok"));

    $jenis_barang_id = intval($this->input->post("jenis_barang_id"));

    $satuan_id = intval($this->input->post("satuan_id"));

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'KODE_BARANG' => $kode_barang,
      'BARANG' => $barang,
      'PART_NUMBER' => $part_number,
      'KATEGORI_ID' => $kategori_id,
      'MERK_BARANG' => $merk_barang,
      'POSISI' => $posisi,
      'MINIMUM_STOK' => $minimum_stok,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => '',
      'MARK_FOR_DELETE' => FALSE,
      'BARANG_ID' => strtotime(date('Y-m-d H:i:s')),
      'HARGA_JUAL' => $harga_jual,
      'SATUAN_ID' => $satuan_id,
      'COMPANY_ID' => $this->session->userdata('company_id'),
      'MAXIMUM_STOK' => $maximum_stok,
      'JENIS_BARANG_ID' => $jenis_barang_id
    );

    $this->m_t_m_d_barang->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_d_barang');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $kode_barang = substr($this->input->post("kode_barang"), 0, 100);
    $barang = substr($this->input->post("barang"), 0, 100);
    $part_number = substr($this->input->post("part_number"), 0, 50);
    $maximum_stok = floatval($this->input->post("maximum_stok"));


    $kategori = ($this->input->post("kategori"));

    $read_select = $this->m_t_m_d_kategori->select_id($kategori);
    foreach ($read_select as $key => $value) {
      $kategori_id = $value->ID;
    }

    $satuan = ($this->input->post("satuan"));
    $read_select = $this->m_t_m_d_satuan->select_id($satuan);
    foreach ($read_select as $key => $value) {
      $satuan_id = $value->ID;
    }


    $jenis_barang = ($this->input->post("jenis_barang"));
    $read_select = $this->m_t_m_d_jenis_barang->select_id($jenis_barang);
    foreach ($read_select as $key => $value) {
      $jenis_barang_id = $value->ID;
    }


    $merk_barang = substr($this->input->post("merk_barang"), 0, 50);
    $posisi = substr($this->input->post("posisi"), 0, 200);
    $minimum_stok = floatval($this->input->post("minimum_stok"));
    $harga_jual = floatval($this->input->post("harga_jual"));
    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'KODE_BARANG' => $kode_barang,
      'BARANG' => $barang,
      'PART_NUMBER' => $part_number,
      'KATEGORI_ID' => $kategori_id,
      'MERK_BARANG' => $merk_barang,
      'POSISI' => $posisi,
      'MINIMUM_STOK' => $minimum_stok,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => '',
      'MARK_FOR_DELETE' => FALSE,
      'HARGA_JUAL' => $harga_jual,
      'SATUAN_ID' => $satuan_id,
      'MAXIMUM_STOK' => $maximum_stok,
      'JENIS_BARANG_ID' => $jenis_barang_id
    );

    $this->m_t_m_d_barang->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_d_barang');
  }
}
