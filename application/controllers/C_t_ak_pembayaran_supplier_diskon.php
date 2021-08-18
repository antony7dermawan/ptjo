<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_pembayaran_supplier_diskon extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_pembayaran_supplier_diskon');
    $this->load->model('m_t_ak_pembayaran_supplier');
    $this->load->model('m_t_ak_faktur_penjualan');
    $this->load->model('m_ak_m_coa');
    $this->load->model('m_t_t_t_pembelian');


    $this->load->model('m_t_ak_pembayaran_supplier_rincian');
  }

  public function index($id, $supplier_id)
  {
    $data = [
      "c_t_ak_pembayaran_supplier_diskon" => $this->m_t_ak_pembayaran_supplier_diskon->select($id),
      "c_t_ak_pembayaran_supplier" => $this->m_t_ak_pembayaran_supplier-> select_by_id($id),
      "pembayaran_supplier_id" => $id,
      "no_akun_option" => $this->m_ak_m_coa->select_no_akun(),
      "select_no_faktur" => $this->m_t_ak_faktur_penjualan->select_no_faktur(),
      "supplier_id" => $supplier_id,
      "title" => "Rincian Metode Bayar",
      "description" => "Isi Rincian Metode Bayar"
    ];
    $this->render_backend('template/backend/pages/t_ak_pembayaran_supplier_diskon', $data);
  }




  public function delete($id, $pembayaran_supplier_id, $supplier_id)
  {
    $jumlah_dihapus = 0;
    $db_logic = 0;
    $read_select = $this->m_t_ak_pembayaran_supplier_diskon->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $jumlah_dihapus = floatval($value->JUMLAH);
    }


    $read_select = $this->m_t_ak_pembayaran_supplier_rincian->select($pembayaran_supplier_id);
    foreach ($read_select as $key => $value) 
    {
      $db_logic = 1;
      $pembelian_id[$key] =  $value->PEMBELIAN_ID;
      $total_penjualan[$key] =  $value->SUM_SUB_TOTAL;
      $payment_t_saldo_awal[$key] = floatval($value->PAYMENT_T);
      $pembayaran_supplier_rincian_id[$key] =  $value->ID;
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
          $this->m_t_t_t_pembelian->update($data, $pembelian_id[$i]);

          

          $jumlah_dihapus = 0;
        }
        if(($payment_t_saldo_awal[$i]-$jumlah_dihapus)<0)
        {
          $data = array(
          'PAYMENT_T' => 0
          );
          $this->m_t_t_t_pembelian->update($data, $pembelian_id[$i]);


          $data = array(
            'ENABLE_EDIT' => 1
          );
          $this->m_t_ak_pembayaran_supplier_rincian->update($data, $pembayaran_supplier_rincian_id[$i]);


          $jumlah_dihapus = $jumlah_dihapus-$payment_t_saldo_awal[$i];
        }
        
      }
    }
    $this->m_t_ak_pembayaran_supplier_diskon->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');

    redirect('c_t_ak_pembayaran_supplier_diskon/index/' . $pembayaran_supplier_id . '/' . $supplier_id);
  }




  function tambah($pembayaran_supplier_id, $supplier_id)
  {
    $jumlah = floatval($this->input->post("jumlah"));
    $coa_id = floatval($this->input->post("coa_id"));


    $db_logic = 0;
    $read_select = $this->m_t_ak_pembayaran_supplier_rincian->select($pembayaran_supplier_id);
    foreach ($read_select as $key => $value) 
    {
      $db_logic = 1;
      $sum_total_penjualan = $sum_total_penjualan+ floatval($value->SUM_SUB_TOTAL)+ floatval($value->SUM_PPN);
      $sum_payment_t_saldo_awal = $sum_payment_t_saldo_awal+floatval($value->PAYMENT_T);
    }

    
      





    if(($sum_payment_t_saldo_awal+$jumlah)<=$sum_total_penjualan)
    {
      $data = array(
        'PEMBAYARAN_SUPPLIER_ID' => $pembayaran_supplier_id,
        'COA_ID' => $coa_id,
        'JUMLAH' => $jumlah,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => ''
      );

      $this->m_t_ak_pembayaran_supplier_diskon->tambah($data);

      $saldo_diskon = $jumlah;
      $db_logic = 0;
      $read_select = $this->m_t_ak_pembayaran_supplier_rincian->select($pembayaran_supplier_id);
      foreach ($read_select as $key => $value) 
      {
        $db_logic = 1;
        
        $total_penjualan[$key] =  $value->SUM_SUB_TOTAL;
        $payment_t_saldo_awal[$key] = floatval($value->PAYMENT_T);
        $pembelian_id[$key] =  $value->PEMBELIAN_ID;
        $pembayaran_supplier_rincian_id[$key] =  $value->ID;
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
            $this->m_t_t_t_pembelian->update($data, $pembelian_id[$i]);

            $data = array(
            'ENABLE_EDIT' => 0
            );
            $this->m_t_ak_pembayaran_supplier_rincian->update($data, $pembayaran_supplier_rincian_id[$i]);

            $saldo_diskon = 0;
          }
          if($total_penjualan[$i]<($payment_t_saldo_awal[$i]+$saldo_diskon) and $i<$total_db_data)
          {
            $data = array(
            'PAYMENT_T' => $total_penjualan[$i]
            );
            $this->m_t_t_t_pembelian->update($data, $pembelian_id[$i]);

            $data = array(
            'ENABLE_EDIT' => 0
            );
            $this->m_t_ak_pembayaran_supplier_rincian->update($data, $pembayaran_supplier_rincian_id[$i]);


            $saldo_diskon = ($payment_t_saldo_awal[$i]+$saldo_diskon)-$total_penjualan[$i];
          }
          if($total_penjualan[$i]<($payment_t_saldo_awal[$i]+$saldo_diskon) and $i==$total_db_data)
          {
            $data = array(
            'PAYMENT_T' => ($payment_t_saldo_awal[$i]+$saldo_diskon)
            );
            $this->m_t_t_t_pembelian->update($data, $pembelian_id[$i]);

            $data = array(
            'ENABLE_EDIT' => 0
            );
            $this->m_t_ak_pembayaran_supplier_rincian->update($data, $pembayaran_supplier_rincian_id[$i]);

            $saldo_diskon = ($payment_t_saldo_awal[$i]+$saldo_diskon)-$total_penjualan[$i];
          }

          
        }
      }
      
      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
      
    }
    if(($sum_payment_t_saldo_awal+$jumlah)>$sum_total_penjualan)
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Kelebihan Bayar!</p></div>');
    }
    
    redirect('c_t_ak_pembayaran_supplier_diskon/index/' . $pembayaran_supplier_id . '/' . $supplier_id);
  }
}
