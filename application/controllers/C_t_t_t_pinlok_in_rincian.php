<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_t_t_t_pinlok_in_rincian extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_t_t_pemakaian');

    $this->load->model('m_t_t_t_pemakaian_rincian'); 

    $this->load->model('m_t_t_t_pembelian');
    

    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_barang');
    
    $this->load->model('m_t_t_t_pembelian_rincian'); 
  }

  public function index($pinlok_in_id)
  {
    $this->session->set_userdata('t_t_t_pemakaian_delete_logic', '1');
    
    $this->session->set_userdata('t_m_d_barang_delete_logic', '0');

    $this->session->set_userdata('master_barang_kategori_id', '0');
    $this->session->set_userdata('master_barang_company_id', $this->session->userdata('company_id'));


    $data = [
      //"select_barang_with_supplier" => $this->m_t_t_t_pembelian_rincian->select_barang_with_supplier(),
      "c_t_t_t_pinlok_in_rincian" => $this->m_t_t_t_pembelian_rincian->select_pinlok_out($pinlok_in_id),

      "c_t_t_t_pinlok_in_by_id" => $this->m_t_t_t_pembelian->select_by_id($pinlok_in_id),






      "c_t_m_d_barang" => $this->m_t_m_d_barang->select(),
      
      "pinlok_in_id" => $pinlok_in_id,
      "title" => "Rincian Transaksi Pindah Lokasi Masuk",
      "description" => "form Pindah Lokasi Masuk"
    ];
    $this->render_backend('template/backend/pages/t_t_t_pinlok_in_rincian', $data);
  }



  public function delete($id,$pinlok_in_id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_t_t_pembelian_rincian->update($data, $id);

    $read_select = $this->m_t_t_t_pembelian_rincian->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $r_qty_jual = $value->QTY;
      $r_barang_id_jual = $value->BARANG_ID;
      $r_pembelian_rincian_id = $value->PEMBELIAN_RINCIAN_ID;
    }


    $read_select = $this->m_t_t_t_pembelian_rincian->select_by_id($r_pembelian_rincian_id);
    foreach ($read_select as $key => $value) 
    {
      $pr_sisa_qty = $value->SISA_QTY;

      $data = array(
        'SISA_QTY' => $pr_sisa_qty + $r_qty_jual
      );
      $this->m_t_t_t_pembelian_rincian->update($data,$value->ID);
    }



    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');

    redirect('c_t_t_t_pinlok_in_rincian/index/' . $pinlok_in_id);
  }






 

  function tambah($pinlok_in_id)
  {
    $barang_id = intval($this->input->post("barang_id"));
    $qty = floatval($this->input->post("qty"));
    $diskon_p_1 = 0;
    $diskon_p_2 = 0;
    $diskon_harga = 0;
    $harga_jual = 0;

    /* harga db
    $read_select = $this->m_t_m_d_barang->select_by_id($barang_id);
    foreach ($read_select as $key => $value) 
    {
      $harga_jual = $value->HARGA_JUAL;
    }
    */

    $sub_total_1 = ($qty * $harga_jual) - (($qty * $harga_jual * $diskon_p_1)/100);
    $sub_total_2 = ($sub_total_1) - (($sub_total_1 * $diskon_p_2)/100);
    $sub_total = $sub_total_2 - $diskon_harga;




    $read_select = $this->m_t_t_t_pembelian->select_by_id($pinlok_in_id);
    foreach ($read_select as $key => $value) 
    {
      $company_id = $value->COMPANY_ID;
    }

    $sisa_qty_tt = 0;
    $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty_for_1_barang_id($barang_id);
    foreach ($read_select as $key => $value) 
    {
      $sisa_qty_tt = $value->SUM_SISA_QTY;
    }


    


    

    if($barang_id!=0 and $qty<=$sisa_qty_tt)
    {
      

      //..............................................kurangin stok pembelian rincian
      $vivo_qty = $qty;
      $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty($barang_id);
      foreach ($read_select as $key => $value) 
      {
        $sub_total = floatval($value->HARGA) * $vivo_qty;
        $harga_jual = floatval($value->HARGA);

        if($vivo_qty<=$value->SISA_QTY)
        {
          if($vivo_qty>0)
          {
            $data = array(
              'PEMBELIAN_ID' => $pinlok_in_id,
              'BARANG_ID' => $barang_id,
              'QTY' => $vivo_qty,
              'SISA_QTY_RB' => $vivo_qty,
              'SISA_QTY' => $vivo_qty,
              'HARGA' => $harga_jual,
              'SUB_TOTAL' => $sub_total,
              'SISA_QTY_TT' => $sisa_qty_tt,
              'SPECIAL_CASE_ID' => 50, //nol kode barang indent
              'SUPPLIER_ID' => $value->SUPPLIER_ID,
              'CREATED_BY' => $this->session->userdata('username'),
              'UPDATED_BY' => '',
              'MARK_FOR_DELETE' => FALSE,
              'COMPANY_ID' => $this->session->userdata('company_id'), //gudang tujuan
              'PEMBELIAN_RINCIAN_ID' => $value->ID
            );

            $this->m_t_t_t_pembelian_rincian->tambah($data);


          }
          

          $live_sisa_qty = $value->SISA_QTY - $vivo_qty;
          $data = array(
            'SISA_QTY' => $live_sisa_qty
          );
          $this->m_t_t_t_pembelian_rincian->update($data,$value->ID);
          $vivo_qty = 0;
        }

        if($vivo_qty>$value->SISA_QTY)
        {

          $sub_total = floatval($value->HARGA) * $value->SISA_QTY;
          $harga_jual = floatval($value->HARGA);


          if($value->SISA_QTY>0)
          {
        
            $data = array(
              'PEMBELIAN_ID' => $pinlok_in_id,
              'BARANG_ID' => $barang_id,
              'QTY' => $value->SISA_QTY,
              'SISA_QTY_RB' => $value->SISA_QTY,
              'SISA_QTY' => $value->SISA_QTY,
              'HARGA' => $harga_jual,
              'SUB_TOTAL' => $sub_total,
              'SISA_QTY_TT' => $sisa_qty_tt,
              'SPECIAL_CASE_ID' => 50, //nol kode barang indent
              'SUPPLIER_ID' => $value->SUPPLIER_ID,
              'CREATED_BY' => $this->session->userdata('username'),
              'UPDATED_BY' => '',
              'MARK_FOR_DELETE' => FALSE,
              'COMPANY_ID' => $this->session->userdata('company_id'), //gudang tujuan
              'PEMBELIAN_RINCIAN_ID' => $value->ID
            );

            $this->m_t_t_t_pembelian_rincian->tambah($data);

          }
          

          $live_sisa_qty = 0;
          $data = array(
            'SISA_QTY' => $live_sisa_qty
          );
          $this->m_t_t_t_pembelian_rincian->update($data,$value->ID);
          $vivo_qty = $vivo_qty - $value->SISA_QTY;
        }
      }

      //..............................................kurangin stok pembelian rincian end



      //.............................................select barang
      $read_select = $this->m_t_m_d_barang->select_by_id($barang_id);
      foreach ($read_select as $key => $value) 
      {
        $minimum_stok = $value->MINIMUM_STOK;
        $maximum_stok = $value->MAXIMUM_STOK;
      }
      //.............................................select barang

      if(($sisa_qty_tt-$qty)<=$minimum_stok) // stok sisa kena minimum stok
      {
        $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Jumlah Beririsan Dengan Minimum Stok Digudang ini!</strong></p></div>');
      }// stok sisa kena minimum stok end

      if(($sisa_qty_tt-$qty)>$minimum_stok) // stok sisa kena minimum stok
      {
        $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
      }
      
      

      
    }

    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap/Qty > Limit!</p></div>');
    }
    

    
    redirect('c_t_t_t_pinlok_in_rincian/index/'.$pinlok_in_id);
  }




}