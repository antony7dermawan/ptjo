<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_t_t_t_pembelian_rincian2 extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_t_t_pembelian');
    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_barang');
    $this->load->model('m_t_m_d_supplier');
    $this->load->model('m_t_t_t_pembelian_rincian'); 
  }
  
  public function index($pembelian_id)
  {

    $this->session->set_userdata('t_t_t_pembelian_delete_logic', '1');
    
    $this->session->set_userdata('t_m_d_barang_delete_logic', '0');
    $this->session->set_userdata('t_m_d_barang_delete_logic', '0');

    $this->session->set_userdata('master_barang_kategori_id', '0');
    $this->session->set_userdata('master_barang_company_id', $this->session->userdata('company_id'));
    
    $data = [
      //"select_barang_with_supplier" => $this->m_t_t_t_pembelian_rincian->select_barang_with_supplier(),
      "c_t_t_t_pembelian_rincian" => $this->m_t_t_t_pembelian_rincian->select($pembelian_id),
      "c_t_t_t_pembelian_by_id" => $this->m_t_t_t_pembelian->select_by_id($pembelian_id),
      "c_t_m_d_barang" => $this->m_t_t_t_pembelian_rincian->select_barang_id($pembelian_id),
      "c_t_m_d_supplier" => $this->m_t_m_d_supplier->select(),
      "pembelian_id" => $pembelian_id,
      "title" => "Rincian Kedatangan Barang",
      "description" => "form Kedatangan Barang"
    ];
    $this->render_backend('template/backend/pages/t_t_t_pembelian_rincian2', $data);
  }




  public function delete($id,$pembelian_id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_t_t_pembelian_rincian->update($data, $id);



    $read_select = $this->m_t_t_t_pembelian_rincian->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $r_qty_beli = $value->QTY;
      $r_barang_id_beli = $value->BARANG_ID;
    }

    $vivo_qty = $r_qty_beli;

      $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty_in_1_inv_pembelian($r_barang_id_beli,$pembelian_id);
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


    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');

    redirect('c_t_t_t_pembelian_rincian2/index/' . $pembelian_id);
  }

  public function undo_delete($id,$retur_pembelian_id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_t_t_pembelian_rincian->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('c_t_t_t_pembelian_rincian/index/' . $retur_pembelian_id);
  }

 







  function tambah($pembelian_id)
  {
    $date = $this->input->post("date");
    if($date=='')
    {
      $date = date('Y-m-d');
    }
    $this->session->set_userdata('date_pembelian_incoming', $date);
    $time = date('H:i:s');


    $barang_id = intval($this->input->post("barang_id"));
    $qty = floatval($this->input->post("qty"));
    $harga = floatval($this->input->post("harga"));
    $qty_datang = floatval($this->input->post("qty_datang"));
    $ppn_percentage = floatval($this->input->post("ppn_percentage"));

    $sub_total = $qty * $harga;


    $ppn_value = ($sub_total*$ppn_percentage)/100;

    $read_select = $this->m_t_t_t_pembelian->select_by_id($pembelian_id);
    foreach ($read_select as $key => $value) 
    {
      $supplier_id = $value->SUPPLIER_ID;
    }

    $sisa_qty_tt = 0;
    $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty_for_1_barang_id($barang_id);
    foreach ($read_select as $key => $value) 
    {
      $sisa_qty_tt = $value->SUM_SISA_QTY;
    }


    $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty_for_1_barang_id_in_1_inv_pembelian($barang_id,$pembelian_id);
    foreach ($read_select as $key => $value) 
    {
      $sisa_qty_pembelian = $value->SUM_SISA_QTY;
    }



    if($qty<=$sisa_qty_pembelian)
    {
      if($barang_id!=0 )
      {
        




        $vivo_qty = $qty;
        $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty_in_1_inv_pembelian($barang_id,$pembelian_id);
        foreach ($read_select as $key => $value) 
        {
          if($vivo_qty<=$value->SISA_QTY)
          {
            $qty_tambah = $vivo_qty;
            if($qty_tambah>0)
            {
              $harga = $value->HARGA;
              $sub_total = intval($value->HARGA)*$vivo_qty;
              $ppn_percentage = $value->PPN_PERCENTAGE;
              $ppn_value = ($sub_total*$value->PPN_PERCENTAGE)/100;
              $data = array(
                'PEMBELIAN_ID' => $pembelian_id,
                'BARANG_ID' => $barang_id,
                'QTY' => $qty_tambah,
                'SISA_QTY_RB' => $qty_tambah,
                'SISA_QTY' => $qty_tambah,
                'HARGA' => $harga,
                'SUB_TOTAL' => $sub_total,
                'SISA_QTY_TT' => $sisa_qty_tt,
                'SPECIAL_CASE_ID' => 0, //nol kode barang uda jelas masuk stok
                'SUPPLIER_ID' => $supplier_id,
                'CREATED_BY' => $this->session->userdata('username'),
                'UPDATED_BY' => '',
                'MARK_FOR_DELETE' => FALSE,
                'COMPANY_ID' => $this->session->userdata('company_id'),
                'QTY_DATANG' => 0,
                'PPN_PERCENTAGE' => $ppn_percentage,
                'PPN_VALUE' => $ppn_value,
                'DATE' => $date,
                'TIME'=> $time
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
            $qty_tambah = $value->SISA_QTY;
            if($qty_tambah>0)
            {
              $harga = $value->HARGA;
              $sub_total = intval($value->HARGA)*$vivo_qty;
              $ppn_percentage = $value->PPN_PERCENTAGE;
              $ppn_value = ($sub_total*$value->PPN_PERCENTAGE)/100;
              $data = array(
                'PEMBELIAN_ID' => $pembelian_id,
                'BARANG_ID' => $barang_id,
                'QTY' => $qty_tambah,
                'SISA_QTY_RB' => $qty_tambah,
                'SISA_QTY' => $qty_tambah,
                'HARGA' => $harga,
                'SUB_TOTAL' => $sub_total,
                'SISA_QTY_TT' => $sisa_qty_tt,
                'SPECIAL_CASE_ID' => 0, //nol kode barang uda jelas masuk stok
                'SUPPLIER_ID' => $supplier_id,
                'CREATED_BY' => $this->session->userdata('username'),
                'UPDATED_BY' => '',
                'MARK_FOR_DELETE' => FALSE,
                'COMPANY_ID' => $this->session->userdata('company_id'),
                'QTY_DATANG' => 0,
                'PPN_PERCENTAGE' => $ppn_percentage,
                'PPN_VALUE' => $ppn_value,
                'DATE' => $date,
                'TIME'=> $time
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
        $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');


      }
    
    }

    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap/Qty > limit pembelian!</p></div>');
    }
    

    
    redirect('c_t_t_t_pembelian_rincian2/index/'.$pembelian_id);
  }






  public function edit_action($pembelian_id)
  {
    $id = $this->input->post("id");
   
    $qty = floatval($this->input->post("qty"));
    $harga = floatval($this->input->post("harga"));
    $qty_datang = floatval($this->input->post("qty_datang"));
    $ppn_percentage = floatval($this->input->post("ppn_percentage"));

    $sub_total = $qty * $harga;

    
    $ppn_value = ($sub_total*$ppn_percentage)/100;


    $sisa_qty_tt = 0;

    if($qty_datang<=$qty)
    {
      $read_select = $this->m_t_t_t_pembelian_rincian->select_by_id($id);
      foreach ($read_select as $key => $value) 
      {
        $e_qty_datang = $value->QTY_DATANG;
        $e_sisa_qty = $value->SISA_QTY;
      }

      $update_sisa_qty = ($qty_datang-$e_qty_datang)+$e_sisa_qty;

        $data = array(
          
          'SISA_QTY_RB' => $qty,
          'QTY' => $qty,
          'SISA_QTY' => $update_sisa_qty,
          'HARGA' => $harga,
          'SUB_TOTAL' => $sub_total,
          'SISA_QTY_TT' => $sisa_qty_tt,
          'UPDATED_BY' => $this->session->userdata('username'),
          'QTY_DATANG' => $qty_datang,
          'PPN_PERCENTAGE' => $ppn_percentage,
          'PPN_VALUE' => $ppn_value
        );

        $this->m_t_t_t_pembelian_rincian->update($data,$id);

        $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    }


    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> QTY Datang > QTY Pembelian!</p></div>');
    }
    
    



    
    redirect('c_t_t_t_pembelian_rincian/index/'.$pembelian_id);
  }
}
