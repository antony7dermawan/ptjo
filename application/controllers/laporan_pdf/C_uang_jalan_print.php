<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_uang_jalan_print extends MY_Controller
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

  public function index($id)
  {
    $pdf = new \TCPDF();
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage('P',  array(100,100));



    $pdf->SetAutoPageBreak(true, 0);
    
        // Add Header
    
    #.............................paper head
    

    


    $pdf->SetFont('','',12);

    $read_select = $this->m_t_t_a_penjualan_pks->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $r_id=$value->ID;
      $r_date=$value->DATE;
      $r_time=$value->TIME;
      $r_no_tiket=$value->NO_TIKET;
      $r_supir=$value->SUPIR;
      $r_no_polisi=$value->NO_POLISI;
      $r_divisi=$value->DIVISI;

      $r_uang_jalan=$value->UANG_JALAN;
      $r_tambahan=$value->TAMBAHAN;
    }



        $pdf->SetFont('','B',10);
        $pdf->Cell( 80,4,'PT. JO PERDANA AGRI TECHNOLOGY','0',1,'C');

        $pdf->Cell( 80,4,'UANG JALAN SUPIR','0',1,'C');

        $pdf->SetFont('','',8);

        $pdf->Cell( 15,8,'NOMOR','0',0,'L');
        $pdf->Cell( 30,8,':'.$r_no_tiket,'0',1,'L');
        $pdf->Cell( 15,5,'Tanggal','0',0,'L');
        $pdf->Cell( 30,5,':'.date('d-m-Y', strtotime($r_date)),'0',1,'L');
        $pdf->Cell( 15,5,'Nama','0',0,'L');
        $pdf->Cell( 30,5,':'.$r_supir,'0',1,'L');

        $pdf->Cell( 15,5,'No.Plat','0',0,'L');
        $pdf->Cell( 30,5,':'.$r_no_polisi,'0',1,'L');

        $pdf->Cell( 15,5,'Divisi','0',0,'L');
        $pdf->Cell( 30,5,':'.$r_divisi,'0',1,'L');


        $pdf->Cell( 15,5,'Sejumlah','0',0,'L');
        $pdf->Cell( 30,5,'a. Uang Minyak (BBM)','B',0,'L');

        $pdf->Cell( 30,5,'Rp'.number_format(intval($r_tambahan)),'B',1,'R');


        $pdf->Cell( 15,5,'','0',0,'L');
        $pdf->Cell( 30,5,'b. Uang Operasional dijalan','B',0,'L');

        $pdf->Cell( 30,5,'Rp'.number_format(intval($r_uang_jalan)),'B',1,'R');


        $pdf->Cell( 15,5,'','0',0,'L');
        $pdf->Cell( 30,5,'','0',0,'L');

        $pdf->Cell( 30,5,'Rp'.number_format(intval($r_uang_jalan)+intval($r_tambahan)),'B',1,'R');

 

        $pdf->Cell(30, 6, "", '0', 1, 'C');

        $pdf->Cell(40, 6, "Penerima", 0, 0, 'C');
        $pdf->Cell(5, 6, "", 0, 0, 'C');
        $pdf->Cell(30, 6, "Pemberi", 0, 1, 'C');


        $pdf->Cell(40, 12, "", 0, 0, 'C');
        $pdf->Cell(5, 12, "", 0, 0, 'C');
        $pdf->Cell(30, 12, "", 0, 1, 'C');

        $pdf->Cell(40, 6, "Krani Timbangan", 'T', 0, 'C');
        $pdf->Cell(5, 6, "", 0, 0, 'C');
        $pdf->Cell(30, 6, "Kasir", 'T', 1, 'C');





    


    $pdf->Output("UANG_JALAN_".$r_no_tiket.".pdf");
  }



  
function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
      $temp = $this->penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
      $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . $this->penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . $this->penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
  }

  function terbilang($nilai) {
    if($nilai<0) {
      $hasil = "minus ". trim($this->penyebut($nilai));
    } else {
      $hasil = trim($this->penyebut($nilai));
    }         
    return $hasil;
  }
  



}
