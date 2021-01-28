<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_terima_pelanggan_diskon extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_terima_pelanggan_diskon');
    $this->load->model('m_t_ak_terima_pelanggan');
    $this->load->model('m_t_ak_faktur_penjualan');
    $this->load->model('m_ak_m_coa');

    $this->load->model('m_t_ak_terima_pelanggan_no_faktur');
  }

  public function index($id, $pks_id)
  {
    $data = [
      "c_t_ak_terima_pelanggan_diskon" => $this->m_t_ak_terima_pelanggan_diskon->select($id),
      "c_t_ak_terima_pelanggan" => $this->m_t_ak_terima_pelanggan-> select_by_id($id),
      "terima_pelanggan_id" => $id,
      "no_akun_option" => $this->m_ak_m_coa->select_no_akun(),
      "select_no_faktur" => $this->m_t_ak_faktur_penjualan->select_no_faktur(),
      "pks_id" => $pks_id,
      "title" => "Rincian Diskon",
      "description" => "Isi Rincian Diskon"
    ];
    $this->render_backend('template/backend/pages/t_ak_terima_pelanggan_diskon', $data);
  }




  public function delete($id, $terima_pelanggan_id, $pks_id)
  {
    

    $jumlah_dihapus = 0;
    $db_logic = 0;
    $read_select = $this->m_t_ak_terima_pelanggan_diskon->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $jumlah_dihapus = intval($value->JUMLAH);
    }


    $read_select = $this->m_t_ak_terima_pelanggan_no_faktur->select($terima_pelanggan_id);
    foreach ($read_select as $key => $value) 
    {
      $db_logic = 1;
      $faktur_penjualan_id[$key] =  $value->FAKTUR_PENJUALAN_ID;
      $total_penjualan[$key] =  $value->TOTAL_PENJUALAN;
      $payment_t_saldo_awal[$key] = intval($value->PAYMENT_T);
    }
    $total_db_data = $key;


    if($db_logic==1)
    {
      for($i=0;$i<=$total_db_data;$i++)
      {
        if(($payment_t_saldo_awal[$i]-$jumlah_dihapus)>=0)
        {
          $data = array(
          'PAYMENT_T' => ($payment_t_saldo_awal[$i]-$jumlah_dihapus)
          );
          $this->m_t_ak_faktur_penjualan->update($data, $faktur_penjualan_id[$i]);
          $jumlah_dihapus = 0;
        }
        if(($payment_t_saldo_awal[$i]-$jumlah_dihapus)<0)
        {
          $data = array(
          'PAYMENT_T' => 0
          );
          $this->m_t_ak_faktur_penjualan->update($data, $faktur_penjualan_id[$i]);
          $jumlah_dihapus = $jumlah_dihapus-$payment_t_saldo_awal[$i];
        }
        
      }
    }
    $this->m_t_ak_terima_pelanggan_diskon->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');

    redirect('c_t_ak_terima_pelanggan_diskon/index/' . $terima_pelanggan_id . '/' . $pks_id);
  }



  function tambah($terima_pelanggan_id, $pks_id)
  {
    $jumlah = intval($this->input->post("jumlah"));
    $coa_id = intval($this->input->post("coa_id"));


    $db_logic = 0;
    $read_select = $this->m_t_ak_terima_pelanggan_no_faktur->select($terima_pelanggan_id);
    foreach ($read_select as $key => $value) 
    {
      $db_logic = 1;
      $sum_total_penjualan = $sum_total_penjualan+ intval($value->TOTAL_PENJUALAN);
      $sum_payment_t_saldo_awal = $sum_payment_t_saldo_awal+intval($value->PAYMENT_T);
    }

    if(($sum_payment_t_saldo_awal+$jumlah)<=$sum_total_penjualan)
    {
      $data = array(
        'TERIMA_PELANGGAN_ID' => $terima_pelanggan_id,
        'COA_ID' => $coa_id,
        'JUMLAH' => $jumlah,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username')
      );

      $this->m_t_ak_terima_pelanggan_diskon->tambah($data);

      $saldo_diskon = $jumlah;
      $db_logic = 0;
      $read_select = $this->m_t_ak_terima_pelanggan_no_faktur->select($terima_pelanggan_id);
      foreach ($read_select as $key => $value) 
      {
        $db_logic = 1;
        $faktur_penjualan_id[$key] =  $value->FAKTUR_PENJUALAN_ID;
        $total_penjualan[$key] =  $value->TOTAL_PENJUALAN;
        $payment_t_saldo_awal[$key] = intval($value->PAYMENT_T);
      }
      $total_db_data = $key;


      if($db_logic==1)
      {
        for($i=0;$i<=$total_db_data;$i++)
        {
          if($total_penjualan[$i]>=($payment_t_saldo_awal[$i]+$saldo_diskon))
          {
            $data = array(
            'PAYMENT_T' => ($payment_t_saldo_awal[$i]+$saldo_diskon)
            );
            $this->m_t_ak_faktur_penjualan->update($data, $faktur_penjualan_id[$i]);
            $saldo_diskon = 0;
          }
          if($total_penjualan[$i]<($payment_t_saldo_awal[$i]+$saldo_diskon) and $i<$total_db_data)
          {
            $data = array(
            'PAYMENT_T' => $total_penjualan[$i]
            );
            $this->m_t_ak_faktur_penjualan->update($data, $faktur_penjualan_id[$i]);
            $saldo_diskon = ($payment_t_saldo_awal[$i]+$saldo_diskon)-$total_penjualan[$i];
          }
          if($total_penjualan[$i]<($payment_t_saldo_awal[$i]+$saldo_diskon) and $i==$total_db_data)
          {
            $data = array(
            'PAYMENT_T' => ($payment_t_saldo_awal[$i]+$saldo_diskon)
            );
            $this->m_t_ak_faktur_penjualan->update($data, $faktur_penjualan_id[$i]);
            $saldo_diskon = ($payment_t_saldo_awal[$i]+$saldo_diskon)-$total_penjualan[$i];
          }

          
        }
      }




      

      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
      
    }
    if(($sum_payment_t_saldo_awal+$jumlah)>$sum_total_penjualan)
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Input Lebih Besar Dari Total Tagihan!</p></div>');
    }
    redirect('c_t_ak_terima_pelanggan_diskon/index/' . $terima_pelanggan_id . '/' . $pks_id);
    
  }
}
