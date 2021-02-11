<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_t_a_penjualan_pks extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_t_a_penjualan_pks');
    $this->load->model('m_t_m_a_no_polisi');
    $this->load->model('m_t_m_a_pks');
    $this->load->model('m_t_m_a_divisi');
    $this->load->model('m_t_m_a_kendaraan');
    $this->load->model('m_t_m_a_supir');
    $this->load->model('m_t_m_a_uang_jalan');
  }

  public function index()
  {
    $data = [
      "c_t_t_a_penjualan_pks" => $this->m_t_t_a_penjualan_pks->select($this->session->userdata('date_penjualan_pks')),
      "c_t_m_a_no_polisi" => $this->m_t_m_a_no_polisi->select(),
      "c_t_m_a_pks" => $this->m_t_m_a_pks->select(),
      "c_t_m_a_divisi" => $this->m_t_m_a_divisi->select(),
      "c_t_m_a_kendaraan" => $this->m_t_m_a_kendaraan->select(),
      "c_t_m_a_supir" => $this->m_t_m_a_supir->select(),
      "title" => "Rincian Tagihan",
      "description" => "Untuk PKS"
    ];
    $this->render_backend('template/backend/pages/t_t_a_penjualan_pks', $data);
  }

  public function date_penjualan_pks()
  {
    $date_penjualan_pks = ($this->input->post("date_penjualan_pks"));
    $this->session->set_userdata('date_penjualan_pks', $date_penjualan_pks);
    redirect('/c_t_t_a_penjualan_pks');
  }


  public function delete($id)
  {
    $this->m_t_t_a_penjualan_pks->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_t_a_penjualan_pks');
  }



  function tambah()
  {
    $divisi_id = intval($this->input->post("divisi_id"));
    $pks_id = intval($this->input->post("pks_id"));
    $no_polisi_id = intval($this->input->post("no_polisi_id"));
    $supir_id = intval($this->input->post("supir_id"));
    $kendaraan_id = intval($this->input->post("kendaraan_id"));
    $no_tiket = substr($this->input->post("no_tiket"), 0, 50);

    
    $bruto = floatval($this->input->post("bruto"));
    $sortase_percentage = floatval($this->input->post("sortase_percentage"));

    $date = ($this->input->post("date"));



    $sortase_kg = round(floatval($bruto * $sortase_percentage) / 100); #rumus dari excel
    $neto = round($bruto - $sortase_kg); #rumus dari excel


    $uang_jalan = 0;
    $read_select = $this->m_t_m_a_uang_jalan->select_uang_jalan($no_polisi_id, $pks_id, $divisi_id, $kendaraan_id);
    foreach ($read_select as $key => $value) {
      $uang_jalan = intval($value->UANG_JALAN);
    }

    $tambahan = floatval($this->input->post("tambahan"));
    $total_uang_jalan = $uang_jalan + $tambahan;
    $harga = floatval($this->input->post("harga"));
    $total_penjualan = $neto * $harga; #rumus dari excel
    $ppn = floatval($total_penjualan * 0.1);


    $inv_int = 0;

    $read_select = $this->m_t_t_a_penjualan_pks->select_inv_int();
    foreach ($read_select as $key => $value) {
      $inv_int = ($value->INV_INT) + 1;
    }
    $inv = 'INV-' . $inv_int;

    $data = array(
      'DATE' => $date,
      'TIME' => date('H:i:s'),
      'DIVISI_ID' => $divisi_id,
      'PKS_ID' => $pks_id,
      'NO_POLISI_ID' => $no_polisi_id,
      'SUPIR_ID' => $supir_id,
      'KENDARAAN_ID' => $kendaraan_id,
      'NO_TIKET' => $no_tiket,
      'BRUTO' => $bruto,
      'SORTASE_PERCENTAGE' => $sortase_percentage,
      'SORTASE_KG' => $sortase_kg,
      'NETO' => $neto,
      'UANG_JALAN' => $uang_jalan,
      'TAMBAHAN' => $tambahan,
      'TOTAL_UANG_JALAN' => $total_uang_jalan,
      'HARGA' => $harga,
      'TOTAL_PENJUALAN' => $total_penjualan,
      'PPN' => $ppn,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username'),
      'AREA_ID' => $this->session->userdata('area_id'),
      'COMPANY_ID' => $this->session->userdata('company_id'),
      'INV' => $inv,
      'INV_INT' => $inv_int,
      'ENABLE_EDIT' => 1,
      'CHECKED_ID' => 1,
      'SPECIAL_ID' => 0
    );

    $this->m_t_t_a_penjualan_pks->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_t_a_penjualan_pks');
  }






  public function checked_ok($id)
  {
    $data = array(
      'CHECKED_ID' => 1
    );
    $this->m_t_t_a_penjualan_pks->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_t_a_penjualan_pks');
  }

  public function edit_action()
  {
    $id = $this->input->post("id");


    $bruto = floatval($this->input->post("bruto"));
    $sortase_percentage = floatval($this->input->post("sortase_percentage"));
    $no_tiket = ($this->input->post("no_tiket"));
    $tambahan = intval($this->input->post("tambahan"));
    $harga = intval($this->input->post("harga"));


    $sortase_kg = round(floatval($bruto * $sortase_percentage) / 100); #rumus dari excel
    $neto = round($bruto - $sortase_kg); #rumus dari excel
    $total_penjualan = $neto * $harga; #rumus dari excel
    $ppn = floatval($total_penjualan * 0.1);


    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'BRUTO' => $bruto,
      'SORTASE_PERCENTAGE' => $sortase_percentage,
      'NETO' => $neto,
      'NO_TIKET' => $no_tiket,
      'TAMBAHAN' => $tambahan,
      'HARGA' => $harga,
      'TOTAL_PENJUALAN' => $total_penjualan,
      'PPN' => $ppn,
      'UPDATED_BY' => $this->session->userdata('username')
    );
    $this->m_t_t_a_penjualan_pks->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_t_a_penjualan_pks');
  }
}
