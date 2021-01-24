<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_faktur_penjualan extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_faktur_penjualan');
    $this->load->model('m_t_t_a_penjualan_pks');
    $this->load->model('m_t_m_a_no_polisi');
    $this->load->model('m_t_m_a_pks');
    $this->load->model('m_t_m_a_divisi');
    $this->load->model('m_t_m_a_kendaraan');
    $this->load->model('m_ak_m_coa');
    $this->load->model('m_t_ak_faktur_penjualan_print_setting');
    $this->load->model('m_t_ak_jurnal');
  }

  public function index()
  {
    $data = [
      "c_t_ak_faktur_penjualan" => $this->m_t_ak_faktur_penjualan->select($this->session->userdata('date_faktur_penjualan')),
      "c_t_m_a_no_polisi" => $this->m_t_m_a_no_polisi->select(),
      "c_t_m_a_pks" => $this->m_t_m_a_pks->select(),
      "c_t_m_a_divisi" => $this->m_t_m_a_divisi->select(),
      "c_t_m_a_kendaraan" => $this->m_t_m_a_kendaraan->select(),
      "title" => "Faktur Penjualan",
      "description" => "Membuat Tagihan ke PKS"
    ];
    $this->render_backend('template/backend/pages/t_ak_faktur_penjualan', $data);
  }


  public function delete($id)
  {
    $this->m_t_ak_faktur_penjualan->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data User Berhasil Dihapus!</p></div>');
    redirect('/c_t_ak_faktur_penjualan');
  }

  public function date_faktur_penjualan()
  {
    $date_faktur_penjualan = ($this->input->post("date_faktur_penjualan"));
    $this->session->set_userdata('date_faktur_penjualan', $date_faktur_penjualan);
    redirect('/c_t_ak_faktur_penjualan');
  }
  

  function update_enable_edit($id,$sum_total_penjualan,$ppn_logic,$enable_edit)
  {
    $read_select = $this->m_t_ak_faktur_penjualan->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $no_faktur=$value->NO_FAKTUR;
    }

    
    if($enable_edit==1)
    {
      $created_id = strtotime(date('Y-m-d H:i:s'));
      $coa_id = 0;
      $coa_id_dpp = 'taik';
      $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(1);
      foreach ($read_select as $key => $value) 
      {
        $setting_value=$value->SETTING_VALUE;
      }
      $read_select = $this->m_ak_m_coa->read_coa_id_from_no_akun($setting_value);
      foreach ($read_select as $key => $value) 
      {
        $coa_id_dpp=$value->ID;
        $db_k_id=$value->DB_K_ID;
      }

      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_dpp,
        'DEBIT' => intval($sum_total_penjualan),
        'KREDIT' => 0,
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_faktur,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id
        );
      }
      if($db_k_id==2)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_dpp,
        'DEBIT' => 0,
        'KREDIT' => intval($sum_total_penjualan),
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_faktur,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done jurnal dpp
      $coa_id_ppn = 0;
      $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(2);
      foreach ($read_select as $key => $value) 
      {
        $setting_value=$value->SETTING_VALUE;
      }
      $read_select = $this->m_ak_m_coa->read_coa_id_from_no_akun($setting_value);
      foreach ($read_select as $key => $value) 
      {
        $coa_id_ppn=$value->ID;
        $db_k_id=$value->DB_K_ID;
      }
      $ppn=0;
      if($ppn_logic==1)
      {
        $ppn = (intval($sum_total_penjualan) * 10)/100;
      }
      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_ppn,
        'DEBIT' => intval($ppn),
        'KREDIT' => 0,
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_faktur,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id
        );
      }
      if($db_k_id==2)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_ppn,
        'DEBIT' => 0,
        'KREDIT' => intval($ppn),
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_faktur,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done jurnal dpp

      $coa_id_piutang_dagang = 0;
      $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(3);
      foreach ($read_select as $key => $value) 
      {
        $setting_value=$value->SETTING_VALUE;
      }
      $read_select = $this->m_ak_m_coa->read_coa_id_from_no_akun($setting_value);
      foreach ($read_select as $key => $value) 
      {
        $coa_id_piutang_dagang=$value->ID;
        $db_k_id=$value->DB_K_ID;
      }
      $piutang_dagang = $sum_total_penjualan + $ppn;
      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_piutang_dagang,
        'DEBIT' => intval($piutang_dagang),
        'KREDIT' => 0,
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_faktur,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id
        );
      }
      if($db_k_id==2)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_piutang_dagang,
        'DEBIT' => 0,
        'KREDIT' => intval($piutang_dagang),
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_faktur,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done jurnal dpp
    }

    $data = array(
      'ENABLE_EDIT' => 0
    );

    $this->m_t_ak_faktur_penjualan->update($data, $id);

    $this->session->set_flashdata('notif', "<div class='alert alert-info icons-alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <i class='icofont icofont-close-line-circled'></i></button><p><strong>TEST</strong></p></div>");

    
    #$this->render_backend('template/backend/pages/laporan_pdf/faktur_penjualan_print/3', $data);
    #redirect('/laporan_pdf/faktur_penjualan_print/3');
    redirect('c_t_ak_faktur_penjualan');
  }

  function tambah()
  {
    $pks_id = intval($this->input->post("pks_id"));
    $keterangan = '';
    $no_faktur = ($this->input->post("no_faktur"));
    

    $data = array(
      'DATE' => date('Y-m-d'),
      'TIME' => date('H:i:s'),
      'PKS_ID' => $pks_id,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username'),
      'KETERANGAN' => $keterangan,
      'NO_FAKTUR' => $no_faktur,
      'ENABLE_EDIT' => 1,
      'TOTAL_PEMBAYARAN' => 0
    );

    $this->m_t_ak_faktur_penjualan->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_ak_faktur_penjualan');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");


    $no_polisi = ($this->input->post("no_polisi"));
    $read_select = $this->m_t_m_a_no_polisi->select_id($no_polisi);
    foreach ($read_select as $key => $value) 
    {
      $no_polisi_id=$value->NO_POLISI_ID;
    }





    $pks = ($this->input->post("pks"));
    $read_select = $this->m_t_m_a_pks->select_id($pks);
    foreach ($read_select as $key => $value) 
    {
      $pks_id=$value->PKS_ID;
    }



    $divisi = ($this->input->post("divisi"));
    $read_select = $this->m_t_m_a_divisi->select_id($divisi);
    foreach ($read_select as $key => $value) 
    {
      $divisi_id=$value->DIVISI_ID;
    }



    $kendaraan = ($this->input->post("kendaraan"));
    $read_select = $this->m_t_m_a_kendaraan->select_id($kendaraan);
    foreach ($read_select as $key => $value) 
    {
      $kendaraan_id=$value->KENDARAAN_ID;
    }
    $uang_jalan = intval($this->input->post("uang_jalan"));

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'NO_POLISI_ID' => $no_polisi_id,
      'PKS_ID' => $pks_id,
      'DIVISI_ID' => $divisi_id,
      'KENDARAAN_ID' => $kendaraan_id,
      'UANG_JALAN' => $uang_jalan
    );
    $this->m_t_ak_faktur_penjualan->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_ak_faktur_penjualan');
  }

}
