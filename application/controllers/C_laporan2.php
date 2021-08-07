<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan2 extends MY_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('m_t_m_d_barang');
	    $this->load->model('m_t_m_d_anggota');
	    $this->load->model('m_t_m_d_no_polisi');

    	$this->load->model('m_t_m_d_kategori');

    	$this->load->model('m_t_m_d_sales');
    	$this->load->model('m_t_m_d_pelanggan');
    	$this->load->model('m_t_m_d_supplier');
	}

	public function index(){


		$this->session->set_userdata('t_m_d_anggota_delete_logic', '0');

		$this->session->set_userdata('t_m_d_no_polisi_delete_logic', '0');

		$this->session->set_userdata('t_m_d_supplier_delete_logic', '0');

		$this->session->set_userdata('t_m_d_pelanggan_delete_logic', '0');


		$this->session->set_userdata('t_m_d_barang_delete_logic', '0');

		$this->session->set_userdata('t_m_d_kategori_delete_logic', '0');

		$this->session->set_userdata('master_barang_kategori_id', '0');

		$this->session->set_userdata('master_barang_company_id', $this->session->userdata('company_id'));

		

		$data = [
			"c_t_m_d_anggota" => $this->m_t_m_d_anggota->select(),
			"c_t_m_d_no_polisi" => $this->m_t_m_d_no_polisi->select(),
			"c_t_m_d_barang" => $this->m_t_m_d_barang->select(),
			"c_t_m_d_kategori" => $this->m_t_m_d_kategori->select(),
			"c_t_m_d_pelanggan" => $this->m_t_m_d_pelanggan->select(),
			"c_t_m_d_supplier" => $this->m_t_m_d_supplier->select(),
			"c_t_m_d_sales" => $this->m_t_m_d_sales->select(),
			"title" => "Laporan",
			"description" => "Pilih Detail"
		  ];
		// function render_backend tersebut dari file core/MY_Controller.php
		$this->render_backend('template/backend/pages/laporan2', $data);
	}



}


