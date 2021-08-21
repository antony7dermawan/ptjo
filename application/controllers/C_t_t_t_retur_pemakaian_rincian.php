<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_t_t_t_retur_pemakaian_rincian extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_t_t_retur_pemakaian');
    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_barang');
    

    
    $this->load->model('m_t_t_t_pembelian_rincian'); 
    $this->load->model('m_t_t_t_pemakaian_rincian'); 
    $this->load->model('m_t_t_t_retur_pemakaian_rincian'); 
  }

  public function index($retur_pemakaian_id)
  {
    $this->session->set_userdata('t_t_t_retur_pemakaian_delete_logic', '1');

    $this->session->set_userdata('t_m_d_barang_delete_logic', '0');

    $this->session->set_userdata('master_barang_kategori_id', '0');
    $this->session->set_userdata('master_barang_company_id', $this->session->userdata('company_id'));


    $data = [
      //"select_barang_with_supplier" => $this->m_t_t_t_pemakaian_rincian->select_barang_with_supplier(),
      "c_t_t_t_retur_pemakaian_rincian" => $this->m_t_t_t_retur_pemakaian_rincian->select($retur_pemakaian_id),

      "c_t_t_t_retur_pemakaian_by_id" => $this->m_t_t_t_retur_pemakaian->select_by_id($retur_pemakaian_id),






      "c_t_m_d_barang" => $this->m_t_t_t_retur_pemakaian_rincian->select_barang_id($retur_pemakaian_id),
      
      "retur_pemakaian_id" => $retur_pemakaian_id,
      "title" => "Rincian Transaksi Retur Pemakaian",
      "description" => "form Retur Pemakaian"
    ];
    $this->render_backend('template/backend/pages/t_t_t_retur_pemakaian_rincian', $data);
  }



  public function delete($id,$retur_pemakaian_id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_t_t_retur_pemakaian_rincian->update($data, $id);

    $read_select = $this->m_t_t_t_retur_pemakaian_rincian->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $r_qty_rj = $value->QTY;
      $r_barang_id_rb = $value->BARANG_ID;
      $r_pemakaian_rincian_id = $value->PEMAKAIAN_RINCIAN_ID;
    }

    $read_select = $this->m_t_t_t_retur_pemakaian_rincian->select_barang_id_only_one($retur_pemakaian_id,$r_barang_id_rb);
    foreach ($read_select as $key => $value) 
    {
      $r_qty = $value->QTY;
      $r_harga = $value->HARGA;
      $r_sisa_qty = $value->SISA_QTY; //sisa qty di pemakaian rincian
      $r_pemakaian_rincian_id = $value->PEMAKAIAN_RINCIAN_ID;
    }

    $new_sisa_qty = $r_sisa_qty + $r_qty_rj;
    $data = array(
        
        'SISA_QTY' => $new_sisa_qty
      );
    $this->m_t_t_t_pemakaian_rincian->update($data,$r_pemakaian_rincian_id);


      $vivo_qty = $r_qty_rj;
      $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty($r_barang_id_rb);
      foreach ($read_select as $key => $value) 
      {
        if(($vivo_qty+$value->SISA_QTY) <= $value->QTY)
        {
          $live_sisa_qty = $value->SISA_QTY - $vivo_qty; 
          $data = array(
            'SISA_QTY' => $live_sisa_qty
          );
          $this->m_t_t_t_pembelian_rincian->update($data,$value->ID);
          $vivo_qty = 0; 
        }

        if(($vivo_qty+$value->SISA_QTY) > $value->QTY)
        {
          $live_sisa_qty = $value->QTY;
          $data = array(
            'SISA_QTY' => $live_sisa_qty
          );
          $this->m_t_t_t_pembelian_rincian->update($data,$value->ID);
          $vivo_qty = $vivo_qty - $value->SISA_QTY;
        }
      }


    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');

    redirect('c_t_t_t_retur_pemakaian_rincian/index/' . $retur_pemakaian_id);
  }


 







  function tambah($retur_pemakaian_id)
  {
    $read_pemakaian_id = intval($this->input->post("pemakaian_rincian_id"));
    $qty = floatval($this->input->post("qty"));

    
    $read_select = $this->m_t_t_t_pemakaian_rincian->select_by_id($read_pemakaian_id);
    foreach ($read_select as $key => $value) 
    {
      $barang_id = $value->BARANG_ID;
      $read_pemakaian_sisa_qty = $value->SISA_QTY;
    }


   
 

    $sisa_qty_tt = 0;

    $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty_for_1_barang_id($barang_id);
    foreach ($read_select as $key => $value) 
    {
      $sisa_qty_tt = $value->SUM_SISA_QTY;
    }



    $read_select = $this->m_t_t_t_retur_pemakaian_rincian->select_barang_id_only_one($retur_pemakaian_id,$barang_id);
    foreach ($read_select as $key => $value) 
    {
      $r_qty = $value->QTY;
      $r_harga = $value->HARGA;
      $r_sisa_qty = $value->SISA_QTY;
      $r_pemakaian_rincian_id = $value->PEMAKAIAN_RINCIAN_ID;
    }

    $sub_total = $qty * $r_harga;

    $new_sisa_qty = $r_sisa_qty - $qty;

    if($barang_id!=0 and $qty<=$read_pemakaian_sisa_qty)
    {
      $data = array(
        'RETUR_PEMAKAIAN_ID' => $retur_pemakaian_id,
        'BARANG_ID' => $barang_id,
        'QTY' => $qty,
        
        'HARGA' => $r_harga,
        'SUB_TOTAL' => $sub_total,
        'SISA_QTY_TT' => $sisa_qty_tt,
        
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => '',
        'MARK_FOR_DELETE' => FALSE,
        'COMPANY_ID' => $this->session->userdata('company_id'),
        'PEMAKAIAN_RINCIAN_ID' => $r_pemakaian_rincian_id
      );

      $this->m_t_t_t_retur_pemakaian_rincian->tambah($data);


      $data = array(
        
        'SISA_QTY' => $new_sisa_qty
      );
      $this->m_t_t_t_pemakaian_rincian->update($data,$r_pemakaian_rincian_id);


      


      $vivo_qty = $qty;
      $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty($barang_id);
      foreach ($read_select as $key => $value) 
      {
        if(($vivo_qty+$value->SISA_QTY) <= $value->QTY)
        {
          $live_sisa_qty = $value->SISA_QTY + $vivo_qty;
          $data = array(
            'SISA_QTY' => $live_sisa_qty
          );
          $this->m_t_t_t_pembelian_rincian->update($data,$value->ID);
          $vivo_qty = 0; 
        }

        if(($vivo_qty+$value->SISA_QTY) > $value->QTY)
        {
          $live_sisa_qty = $value->QTY;
          $data = array(
            'SISA_QTY' => $live_sisa_qty
          );
          $this->m_t_t_t_pembelian_rincian->update($data,$value->ID);
          $vivo_qty = $vivo_qty - $value->SISA_QTY;
        }


      }

      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    }

    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap/Qty > Limit!</p></div>');
    }
    

    
    redirect('c_t_t_t_retur_pemakaian_rincian/index/'.$retur_pemakaian_id);
  }




}