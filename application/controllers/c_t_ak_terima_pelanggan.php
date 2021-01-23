<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_t_ak_terima_pelanggan extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_terima_pelanggan');
    $this->load->model('m_t_ak_faktur_penjualan');
    $this->load->model('m_t_t_a_penjualan_pks');
    $this->load->model('m_t_m_a_no_polisi');
    $this->load->model('m_t_m_a_pks');
    $this->load->model('m_t_m_a_divisi');
    $this->load->model('m_t_m_a_kendaraan');
    $this->load->model('m_ak_m_coa');
    $this->load->model('m_t_ak_terima_pelanggan_print_setting');
    $this->load->model('m_t_ak_jurnal');
  }

  public function index()
  {
    $data = [
      "c_t_ak_terima_pelanggan" => $this->m_t_ak_terima_pelanggan->select($this->session->userdata('date_terima_pelanggan')),
      "c_t_m_a_no_polisi" => $this->m_t_m_a_no_polisi->select(),
      "c_t_m_a_pks" => $this->m_t_m_a_pks->select(),
      "c_t_m_a_divisi" => $this->m_t_m_a_divisi->select(),
      "c_t_m_a_kendaraan" => $this->m_t_m_a_kendaraan->select(),
      "title" => "Transaksi Terima Pelanggan",
      "description" => "form terima pelanggan"
    ];
    $this->render_backend('template/backend/pages/t_ak_terima_pelanggan', $data);
  }


  public function delete($id)
  {
    $this->m_t_ak_terima_pelanggan->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data User Berhasil Dihapus!</p></div>');
    redirect('/c_t_ak_terima_pelanggan');
  }

  public function date_terima_pelanggan()
  {
    $date_terima_pelanggan = ($this->input->post("date_terima_pelanggan"));
    $this->session->set_userdata('date_terima_pelanggan', $date_terima_pelanggan);
    redirect('/c_t_ak_terima_pelanggan');
  }
  

  function update_enable_edit($id,$sum_total_penjualan,$sum_jumlah,$sum_diskon,$enable_edit)
  {
    $read_select = $this->m_t_ak_terima_pelanggan->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $no_form=$value->NO_FORM;
    }

    if($enable_edit==1)
    {
      $created_id = strtotime(date('Y-m-d H:i:s'));
      $coa_id = 0;


      $coa_id_total_pembayaran = 0;
      $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(5);
      foreach ($read_select as $key => $value) 
      {
        $setting_value=$value->SETTING_VALUE;
      }
      $read_select = $this->m_ak_m_coa->read_coa_id_from_no_akun($setting_value);
      foreach ($read_select as $key => $value) 
      {
        $coa_id_total_pembayaran=$value->ID;
        $db_k_id=$value->DB_K_ID;
      }

      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_total_pembayaran,
        'DEBIT' => intval($sum_total_penjualan),
        'KREDIT' => 0,
        'CATATAN' => 'TERIMA PELANGGAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
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
        'COA_ID' => $coa_id_total_pembayaran,
        'DEBIT' => 0,
        'KREDIT' => intval($sum_total_penjualan),
        'CATATAN' => 'TERIMA PELANGGAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
        'CREATED_ID' => $created_id
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done 



      $coa_diskon = 0;
      $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(6);
      foreach ($read_select as $key => $value) 
      {
        $setting_value=$value->SETTING_VALUE;
      }
      $read_select = $this->m_ak_m_coa->read_coa_id_from_no_akun($setting_value);
      foreach ($read_select as $key => $value) 
      {
        $coa_diskon=$value->ID;
        $db_k_id=$value->DB_K_ID;
      }
      
      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_diskon,
        'DEBIT' => intval($sum_diskon),
        'KREDIT' => 0,
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
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
        'COA_ID' => $coa_diskon,
        'DEBIT' => 0,
        'KREDIT' => intval($sum_diskon),
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
        'CREATED_ID' => $created_id
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done




      $coa_id_beban_adm_bank = 0;
      $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(7);
      foreach ($read_select as $key => $value) 
      {
        $setting_value=$value->SETTING_VALUE;
      }
      $read_select = $this->m_ak_m_coa->read_coa_id_from_no_akun($setting_value);
      foreach ($read_select as $key => $value) 
      {
        $coa_id_beban_adm_bank=$value->ID;
        $db_k_id=$value->DB_K_ID;
      }
      $total_adm_bank = 30000;
      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_beban_adm_bank,
        'DEBIT' => intval($total_adm_bank),
        'KREDIT' => 0,
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
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
        'COA_ID' => $coa_id_beban_adm_bank,
        'DEBIT' => 0,
        'KREDIT' => intval($total_adm_bank),
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
        'CREATED_ID' => $created_id
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done 




      $coa_id_beban_selisih_pembulatan = 0;
      $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(8);
      foreach ($read_select as $key => $value) 
      {
        $setting_value=$value->SETTING_VALUE;
      }
      $read_select = $this->m_ak_m_coa->read_coa_id_from_no_akun($setting_value);
      foreach ($read_select as $key => $value) 
      {
        $coa_id_beban_selisih_pembulatan=$value->ID;
        $db_k_id=$value->DB_K_ID;
      }


      $total_transaksi = floatval($sum_total_penjualan)+floatval($sum_diskon)+floatval($total_adm_bank);

      $up_total_transaksi = ceil($total_transaksi);




      $total_beban_selisih_pembulatan = intval($up_total_transaksi)-intval($total_transaksi);
      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_beban_selisih_pembulatan,
        'DEBIT' => intval($total_beban_selisih_pembulatan),
        'KREDIT' => 0,
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
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
        'COA_ID' => $coa_id_beban_selisih_pembulatan,
        'DEBIT' => 0,
        'KREDIT' => intval($total_beban_selisih_pembulatan),
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
        'CREATED_ID' => $created_id
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done 





      $coa_piutang_dagang = 0;
      $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(9);
      foreach ($read_select as $key => $value) 
      {
        $setting_value=$value->SETTING_VALUE;
      }
      $read_select = $this->m_ak_m_coa->read_coa_id_from_no_akun($setting_value);
      foreach ($read_select as $key => $value) 
      {
        $coa_piutang_dagang=$value->ID;
        $db_k_id=$value->DB_K_ID;
      }





      $total_piutang_dagang = intval($up_total_transaksi);

      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_piutang_dagang,
        'DEBIT' => intval($total_piutang_dagang),
        'KREDIT' => 0,
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
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
        'COA_ID' => $coa_piutang_dagang,
        'DEBIT' => 0,
        'KREDIT' => intval($total_piutang_dagang),
        'CATATAN' => 'FAKTUR PENJUALAN : '.$no_form,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_form,
        'CREATED_ID' => $created_id
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done 




    }

    $data = array(
      'ENABLE_EDIT' => 0
    );

    $this->m_t_ak_terima_pelanggan->update($data, $id);

    $this->session->set_flashdata('notif', "<div class='alert alert-info icons-alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <i class='icofont icofont-close-line-circled'></i></button><p><strong>TEST</strong></p></div>");

    
    #$this->render_backend('template/backend/pages/laporan_pdf/faktur_penjualan_print/3', $data);
    #redirect('/laporan_pdf/faktur_penjualan_print/3');
    redirect('c_t_ak_terima_pelanggan');
  }






  function tambah()
  {
    $pks_id = intval($this->input->post("pks_id"));
    $keterangan = ($this->input->post("ket"));;
    $no_form = ($this->input->post("no_form"));
    $date = ($this->input->post("date"));

    $data = array(
      'DATE' => $date,
      'TIME' => date('H:i:s'),
      'KET' => $keterangan,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username'),
      'ENABLE_EDIT' => 1,
      'NO_FORM' => $no_form,
      'PKS_ID' => $pks_id
    );

    $this->m_t_ak_terima_pelanggan->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_ak_terima_pelanggan');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $no_form = $this->input->post("no_form");

    

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'NO_FORM' => $no_form
    );
    $this->m_t_ak_terima_pelanggan->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_ak_terima_pelanggan');
  }

}
