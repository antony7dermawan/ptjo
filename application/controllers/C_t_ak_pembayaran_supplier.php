<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_pembayaran_supplier extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();


    $this->load->model('m_t_ak_pembayaran_supplier');
    $this->load->model('m_t_t_t_penjualan');


    $this->load->model('m_ak_m_coa');
    $this->load->model('m_t_ak_pembayaran_supplier_metode_bayar');
    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_supplier');
    $this->load->model('m_ak_m_coa');
    $this->load->model('m_t_ak_pembayaran_supplier_print_setting');
    $this->load->model('m_t_ak_jurnal');

    $this->load->model('m_t_ak_pembayaran_supplier_diskon');

  }

  public function index()
  {
    $this->session->set_userdata('t_m_d_pelanggan_delete_logic', '0');
    $this->session->set_userdata('t_m_d_supplier_delete_logic', '0');

    if($this->session->userdata('date_pembayaran_supplier')=='')
    {
      $date_pembayaran_supplier = date('Y-m-d');
      $this->session->set_userdata('date_pembayaran_supplier', $date_pembayaran_supplier);
    }

    $data = [
      "no_akun_option" => $this->m_ak_m_coa->select_no_akun(),
      "c_t_ak_pembayaran_supplier" => $this->m_t_ak_pembayaran_supplier->select($this->session->userdata('date_pembayaran_supplier')),

      "c_t_m_d_supplier" => $this->m_t_m_d_supplier->select(),

      "title" => "Transaksi Pembayaran Supplier",
      "description" => ""
    ];
    $this->render_backend('template/backend/pages/t_ak_pembayaran_supplier', $data);
  }

  public function undo($id)
  {

    $data = array(
      'ENABLE_EDIT' => 1
    );
    $this->m_t_ak_pembayaran_supplier->update($data, $id);
    $read_select = $this->m_t_ak_pembayaran_supplier->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $no_faktur=$value->NO_FAKTUR;
    }
    $this->m_t_ak_jurnal->delete_no_voucer($no_faktur);

    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil Dibatalkan!</p></div>');
    redirect('/c_t_ak_pembayaran_supplier');
  }


  public function delete($id)
  {
    $this->m_t_ak_pembayaran_supplier->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil Dihapus!</p></div>');
    redirect('/c_t_ak_pembayaran_supplier');
  }

  public function date_pembayaran_supplier()
  {
    $date_pembayaran_supplier = ($this->input->post("date_pembayaran_supplier"));
    $this->session->set_userdata('date_pembayaran_supplier', $date_pembayaran_supplier);
    redirect('/c_t_ak_pembayaran_supplier');
  }
  

  function update_enable_edit($id)
  {
    $read_select = $this->m_t_ak_pembayaran_supplier->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $no_faktur=$value->NO_FAKTUR;
      $date_move = $value->DATE;
      $time_move = $value->TIME;


      $coa_id_supplier = $value->COA_ID;

      $supplier = $value->SUPPLIER;

      $sum_total_penjualan = $value->SUM_TOTAL_PENJUALAN;
      $sum_adm_bank = round($value->SUM_ADM_BANK);
      $sum_payment_t = $value->SUM_PAYMENT_T;
      $sum_jumlah = round($value->SUM_JUMLAH);
      $sum_diskon = round($value->SUM_DISKON);



      $sum_pembayaran_supplier = $sum_jumlah + $sum_adm_bank + $sum_diskon;


      $sum_ppn = ($sum_jumlah + $sum_adm_bank + $sum_diskon) - $sum_total_penjualan;
      $no_faktur = $value->NO_FAKTUR;

      $enable_edit= $value->ENABLE_EDIT;
    }


    
    if($enable_edit==1)
    {
      $created_id = strtotime(date('Y-m-d H:i:s'));

      
      $coa_id_ps = $coa_id_supplier;
      $db_k_id=1;

      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => $date_move,
        'TIME' => $time_move,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_ps,
        'DEBIT' => round($sum_total_penjualan),
        'KREDIT' => 0,
        'CATATAN' => 'Pembayaran Supplier : ' . $supplier,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id,
        'CHECKED_ID' => 1,
        'SPECIAL_ID' => 0,
        'COMPANY_ID' => $this->session->userdata('company_id')
        );
      }
      if($db_k_id==2)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => $date_move,
        'TIME' => $time_move,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_ps,
        'DEBIT' => 0,
        'KREDIT' => round($sum_total_penjualan),
        'CATATAN' => 'Pembayaran Supplier : ' . $supplier,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id,
        'CHECKED_ID' => 1,
        'SPECIAL_ID' => 0,
        'COMPANY_ID' => $this->session->userdata('company_id')
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done jurnal dpp








      $coa_id_ppn = 2821;
      $db_k_id=1;

      if($db_k_id==1)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => $date_move,
        'TIME' => $time_move,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_ppn,
        'DEBIT' => round($sum_ppn),
        'KREDIT' => 0,
        'CATATAN' => 'Pembayaran Supplier : ' . $supplier,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id,
        'CHECKED_ID' => 1,
        'SPECIAL_ID' => 0,
        'COMPANY_ID' => $this->session->userdata('company_id')
        );
      }
      if($db_k_id==2)#kode 1 debit / 2 kredit
      {
        $data = array(
        'DATE' => $date_move,
        'TIME' => $time_move,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $coa_id_ppn,
        'DEBIT' => 0,
        'KREDIT' => round($sum_ppn),
        'CATATAN' => 'Pembayaran Supplier : ' . $supplier,
        'DEPARTEMEN' => '0',
        'NO_VOUCER' => $no_faktur,
        'CREATED_ID' => $created_id,
        'CHECKED_ID' => 1,
        'SPECIAL_ID' => 0,
        'COMPANY_ID' => $this->session->userdata('company_id')
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done jurnal dpp




      $coa_id_beban_adm_bank = 0;
      $read_select = $this->m_t_ak_pembayaran_supplier_print_setting->select_id(2);
      foreach ($read_select as $key => $value) {
        $setting_value = $value->SETTING_VALUE;
      }
      $read_select = $this->m_ak_m_coa->read_coa_id_from_no_akun($setting_value);
      foreach ($read_select as $key => $value) {
        $coa_id_beban_adm_bank = $value->ID;
        $db_k_id = 2;
      }
      $total_adm_bank = floatval($sum_adm_bank);
      if ($db_k_id == 1) #kode 1 debit / 2 kredit
      {
        $data = array(
          'DATE' => $date_move,
          'TIME' => $time_move,
          'CREATED_BY' => $this->session->userdata('username'),
          'UPDATED_BY' => $this->session->userdata('username'),
          'COA_ID' => $coa_id_beban_adm_bank,
          'DEBIT' => round($total_adm_bank),
          'KREDIT' => 0,
          'CATATAN' => 'Pembayaran Supplier : ' . $supplier,
          'DEPARTEMEN' => '0',
          'NO_VOUCER' => $no_faktur,
          'CREATED_ID' => $created_id,
          'CHECKED_ID' => 1,
          'SPECIAL_ID' => 0,
          'COMPANY_ID' => $this->session->userdata('company_id')
        );
      }
      if ($db_k_id == 2) #kode 1 debit / 2 kredit
      {
        $data = array(
          'DATE' => $date_move,
          'TIME' => $time_move,
          'CREATED_BY' => $this->session->userdata('username'),
          'UPDATED_BY' => $this->session->userdata('username'),
          'COA_ID' => $coa_id_beban_adm_bank,
          'DEBIT' => 0,
          'KREDIT' => round($total_adm_bank),
          'CATATAN' => 'Pembayaran Supplier : ' . $supplier,
          'DEPARTEMEN' => '0',
          'NO_VOUCER' => $no_faktur,
          'CREATED_ID' => $created_id,
          'CHECKED_ID' => 1,
          'SPECIAL_ID' => 0,
          'COMPANY_ID' => $this->session->userdata('company_id')
        );
      }
      $this->m_t_ak_jurnal->tambah($data);
      #.....................................................................................done 




      $sum_all_payment = 0;
      $read_select = $this->m_t_ak_pembayaran_supplier_metode_bayar->select($id);
      foreach ($read_select as $key => $value) 
      {
        $coa_id = $value->COA_ID;
        $jumlah_per_bank = $value->JUMLAH;

        $read_select_in = $this->m_ak_m_coa->select_coa_id($coa_id);
        foreach ($read_select_in as $key_in => $value_in) 
        {
          $db_k_id = 2;
          if ($db_k_id == 1) #kode 1 debit / 2 kredit
          {
            $data = array(
              'DATE' => $date_move,
              'TIME' => $time_move,
              'CREATED_BY' => $this->session->userdata('username'),
              'UPDATED_BY' => $this->session->userdata('username'),
              'COA_ID' => $coa_id,
              'DEBIT' => round($jumlah_per_bank),
              'KREDIT' => 0,
              'CATATAN' => 'Pembayaran Supplier : ' . $supplier,
              'DEPARTEMEN' => '0',
              'NO_VOUCER' => $no_faktur,
              'CREATED_ID' => $created_id,
              'CHECKED_ID' => 1,
              'SPECIAL_ID' => 0,
              'COMPANY_ID' => $this->session->userdata('company_id')
            );
          }
          if ($db_k_id == 2) #kode 1 debit / 2 kredit
          {
            $data = array(
              'DATE' => $date_move,
              'TIME' => $time_move,
              'CREATED_BY' => $this->session->userdata('username'),
              'UPDATED_BY' => $this->session->userdata('username'),
              'COA_ID' => $coa_id,
              'DEBIT' => 0,
              'KREDIT' => round($jumlah_per_bank),
              'CATATAN' => 'Pembayaran Supplier : ' . $supplier,
              'DEPARTEMEN' => '0',
              'NO_VOUCER' => $no_faktur,
              'CREATED_ID' => $created_id,
              'CHECKED_ID' => 1,
              'SPECIAL_ID' => 0,
              'COMPANY_ID' => $this->session->userdata('company_id')
            );
          }
          $this->m_t_ak_jurnal->tambah($data);
          $sum_all_payment = floatval($sum_all_payment) + floatval($jumlah_per_bank);
        }
      }

      #.....................................................................................done






      $sum_all_diskon = 0;
      $read_select = $this->m_t_ak_pembayaran_supplier_diskon->select($id);
      foreach ($read_select as $key => $value) 
      {
        $coa_id = $value->COA_ID;
        $jumlah_per_diskon = $value->JUMLAH;

        $db_k_id =1;

        $read_select_in = $this->m_ak_m_coa->select_coa_id($coa_id);
        foreach ($read_select_in as $key_in => $value_in) 
        {
          
         
            $data = array(
              'DATE' => $date_move,
              'TIME' => $time_move,
              'CREATED_BY' => $this->session->userdata('username'),
              'UPDATED_BY' => '',
              'COA_ID' => $coa_id,
              'DEBIT' => 0,
              'KREDIT' => round($jumlah_per_diskon),
              'CATATAN' => 'Pembayaran Supplier : ' . $supplier,
              'DEPARTEMEN' => '0',
              'NO_VOUCER' => $no_faktur,
              'CREATED_ID' => $created_id,
              'CHECKED_ID' => 1,
              'SPECIAL_ID' => 0,
              'COMPANY_ID' => $this->session->userdata('company_id')
            );
            $sum_all_diskon = floatval($sum_all_diskon) + floatval($jumlah_per_diskon);
          
          $this->m_t_ak_jurnal->tambah($data);
          
        }
      }

      #.....................................................................................done









    }

    $data = array(
      'ENABLE_EDIT' => 0
    );

    $this->m_t_ak_pembayaran_supplier->update($data, $id);

    $this->session->set_flashdata('notif', "<div class='alert alert-info icons-alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <i class='icofont icofont-close-line-circled'></i></button><p><strong>Data Berhasil Masuk Jurnal</strong></p></div>");

    
    #$this->render_backend('template/backend/pages/laporan_pdf/pembayaran_supplier_print/3', $data);
    #redirect('/laporan_pdf/pembayaran_supplier_print/3');
    redirect('c_t_ak_pembayaran_supplier');
  }

  function tambah()
  {
    $supplier_id = intval($this->input->post("supplier_id"));
    $keterangan = '';
    $coa_id = intval($this->input->post("coa_id"));

    $inv_manual =  substr($this->input->post("inv"), 0, 50) ;
    
    $date = ($this->input->post("date"));


    if($date=='')
    {
      $date = date('Y-m-d');
    }
    
    $date_pembayaran_supplier = $date;
    $this->session->set_userdata('date_pembayaran_supplier', $date_pembayaran_supplier);


    if($supplier_id!=0 and $coa_id!=0)
    {

      $logic_no_faktur = 0;
      

      $inv_int = 0;
      $read_select = $this->m_t_ak_pembayaran_supplier->select_inv_int();
      foreach ($read_select as $key => $value) 
      {
        $inv_int = intval($value->INV_INT)+1;
      }

      $read_select = $this->m_t_m_d_company->select_by_company_id();
      foreach ($read_select as $key => $value) 
      {
        $inv_pembayaran_supplier = $value->INV_PEMBAYARAN_SUPPLIER;
        $inv_terima_pelanggan = $value->INV_TERIMA_PELANGGAN;
      }

      $live_inv = $inv_pembayaran_supplier.date('y-m').'.'.sprintf('%05d', $inv_int);






      if($logic_no_faktur == 0)
      {
        $data = array(
          'DATE' => $date,
          'TIME' => date('H:i:s'),
          'SUPPLIER_ID' => $supplier_id,
          'CREATED_BY' => $this->session->userdata('username'),
          'UPDATED_BY' => $this->session->userdata('username'),
          'KETERANGAN' => $keterangan,
          'NO_FAKTUR' => $inv_manual,
          'ENABLE_EDIT' => 1,

          'INV_INT' =>$inv_int,
          'COMPANY_ID' => $this->session->userdata('company_id'),
          'COA_ID' => $coa_id
          
        );

        $this->m_t_ak_pembayaran_supplier->tambah($data);

        $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
      }
      
    }
    if($supplier_id==0)
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Pelanggan Tidak Boleh Kosong!</p></div>');
    }
    
    redirect('c_t_ak_pembayaran_supplier');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $ppn = $this->input->post("ppn");
    $pph = $this->input->post("pph");


    if($ppn==null)
    {
      $ppn = false;
    }
    if($pph==null)
    {
      $pph = false;
    }

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'PPN' => $ppn,
      'PPH' => $pph
    );
    $this->m_t_ak_pembayaran_supplier->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_ak_pembayaran_supplier');
  }

}
