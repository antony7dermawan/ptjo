<?php
defined('BASEPATH') or exit('No direct script access allowed');

class c_faktur_penjualan_print extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_faktur_penjualan_rincian');
    $this->load->model('m_t_ak_faktur_penjualan');
    $this->load->model('m_t_ak_faktur_penjualan_print_setting');
  }

  public function index($id,$pks_id)
  {
    $pdf = new \TCPDF();
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage('P', 'mm', 'A4');
    $pdf->SetAutoPageBreak(true, 0);

 
        // Add Header
    
    #.............................paper head
    

    


    $pdf->SetFont('','',10);

    $read_select = $this->m_t_ak_faktur_penjualan->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $no_pelanggan=$value->NO_PELANGGAN;
      $no_faktur=$value->NO_FAKTUR;
      $tgl_faktur=$value->DATE;
      $nama=$value->NAMA;
      $alamat=$value->ALAMAT;
      $npwp=$value->NPWP;
      $telepon=$value->TELEPON;
    }

    

    $total_kuantitas = 0;
    $total_sub = 0;
    $dpp = 0;
    $ppn = 0;
    $pph_22 = 0;
    $total_tagihan = 0;
    $total_row_1_bon = 10;
    $read_select = $this->m_t_ak_faktur_penjualan_rincian->select($id);
    foreach ($read_select as $key => $value) 
    {
      $rmd=(float)($key/$total_row_1_bon);
      $rmd=($rmd-(int)$rmd)*$total_row_1_bon;

      if($key==0 or ($key>=$total_row_1_bon and $rmd==0))
      {
        if($key>=$total_row_1_bon and $rmd==0)
        {
          $pdf->SetPrintHeader(false);
          $pdf->SetPrintFooter(false);
          $pdf->AddPage();
        }
        $pdf->Image('assets/images/logo-jo.jpg',10,10,0);

        $pdf->SetFont('','B',10);
        $pdf->Cell(30, 5, "", 0, 0, 'L');
        $pdf->Cell(100, 5, "PT. JO PERDANA AGRI TECHNOLOGY", 0, 1, 'L');

        $pdf->SetFont('','',12);

        $pdf->Cell(30, 3, "", 0, 0, 'L');
        $pdf->Cell(100, 3, "JL. RAYA BENGKAYANG DUSUN BARABAS BARU 1 RT.1 RW.1", 0, 1, 'L');

        $pdf->Cell(30, 5, "", 0, 0, 'L');
        $pdf->Cell(100, 5, "MEKAR BARU - MONTERADO", 0, 1, 'L');

        $pdf->Cell(30, 5, "", 0, 0, 'L');
        $pdf->Cell(100, 5, "KALIMANTAN BARAT", 0, 1, 'L');


        $pdf->Cell( 30,5,'','0',0,'C');
        $pdf->Cell( 160,5,'','B',1,'C');

        $pdf->SetFont('','B',12);
        $pdf->Cell( 190,5,'Faktur Penjualan','0',1,'C');

        $pdf->SetFont('','',10);
        $pdf->Cell( 40,5,'NO PELANGGAN','0',0,'L');
        $pdf->Cell( 100,5,':'.$no_pelanggan,'0',1,'L');
        $pdf->Cell( 40,5,'NO FAKTUR','0',0,'L');
        $pdf->Cell( 100,5,':'.$no_faktur,'0',1,'L');
        $pdf->Cell( 40,5,'TGL FAKTUR','0',0,'L');
        $pdf->Cell( 100,5,':'.date('d-m-Y', strtotime($tgl_faktur)),'0',1,'L');
        $pdf->Cell( 40,5,'NAMA','0',0,'L');
        $pdf->Cell( 100,5,':'.$nama,'0',1,'L');
        $pdf->Cell( 40,5,'ALAMAT','0',0,'L');
        $pdf->MultiCell(100, 5, ':'.substr($alamat, 0, 200), 0, 'L',0,1);

        $pdf->Cell( 40,5,'NPWP','0',0,'L');
        $pdf->Cell( 100,5,':'.$npwp,'0',1,'L');
        $pdf->Cell( 40,5,'TELEPON','0',0,'L');
        $pdf->Cell( 100,5,':'.$telepon,'0',1,'L');

        $pdf->Cell( 100,3,'','0',1,'L');

        $pdf->SetFont('','B',10);
        $size[0]=10;
        $size[1]=40;
        $size[2]=30;
        $size[3]=35;
        $size[4]=25;
        $size[5]=20;
        $size[6]=30;
        
        $pdf->Cell( $size[0],8,'No.','1',0,'C');
        $pdf->Cell( $size[1],8,'Keterangan','1',0,'C');
        $pdf->Cell( $size[2],8,'Tgl Kirim','1',0,'C');
        $pdf->Cell( $size[3],8,'No. Tiket','1',0,'C');
        $pdf->Cell( $size[4],8,'Jumlah','1',0,'C');
        $pdf->Cell( $size[5],8,'Harga','1',0,'C');
        $pdf->Cell( $size[6],8,'Tagihan (Rp)','1',1,'C');


    
      }
      
      
      

      $pdf->SetFont('','',9);
      $pdf->MultiCell($size[0], 8, $key+1, 'L', 'C',0,0);
      $pdf->MultiCell($size[1], 8, substr($value->KETERANGAN, 0, 40), 'L', 'L',0,0);
      $pdf->MultiCell($size[2], 8, date('d-m-Y', strtotime($value->DATE)), 'L', 'L',0,0);
      $pdf->MultiCell($size[3], 8, substr($value->NO_TIKET, 0, 50), 'L', 'C',0,0);
      $pdf->MultiCell($size[4], 8, number_format(round($value->NETO)).' Kg', 'L', 'R',0,0);
      $pdf->MultiCell($size[5], 8, number_format(round($value->HARGA)), 'L', 'R',0,0);
      $pdf->MultiCell($size[6]-0.1, 8, number_format(round($value->TOTAL_PENJUALAN)), 'L', 'R',0,0);
      $pdf->Cell( 0.1,8,'','L',1,'R');

      $total_kuantitas = $total_kuantitas+floatval($value->NETO);
      $total_sub = $total_sub+floatval($value->TOTAL_PENJUALAN);
      $dpp = $total_sub;
    }

/*
    for($i=0;$i<=1;$i++)
    {
      $pdf->Cell( $size[0],6,'','L',0,'C');
      $pdf->Cell( $size[1],6,'','L',0,'L');
      $pdf->Cell( $size[2],6,'','L',0,'C');
      $pdf->Cell( $size[3],6,'','L',0,'C');
      $pdf->Cell( $size[4],6,'','L',0,'R');
      $pdf->Cell( $size[5],6,'','L',0,'R');
      $pdf->Cell( $size[6]-0.1,6,'','L',0,'R');
      $pdf->Cell( 0.1,6,'','L',1,'R'); 
    }
    */

    #.............................paper head end
    $pdf->Cell( $size[0]+$size[1]+$size[2]+$size[3]+$size[4],8,'Total Kuantitas   '.number_format(round($total_kuantitas)),'1',0,'R');
    $pdf->Cell( $size[5]+$size[6],8,'','1',1,'L');

    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'Total Sub','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(round($total_sub)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');


    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'Dasar Pengenaan Pajak','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(round($dpp)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');


    $ppn = (10 * floatval($dpp))/100;
    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'PPN','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(round($ppn)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');

    $pph_22 = round(0.25 * floatval($dpp))/100;
    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'PPH 22 (0.25%)','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(round($pph_22)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');

    $total_tagihan = $dpp + $ppn - $pph_22;
    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'Total Tagihan','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(round($total_tagihan)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');



    $pdf->MultiCell(190 ,10,'#'.ucwords($this->terbilang($total_tagihan)).' Rupiah#',1,'L');




    $pdf->SetFont('','B',10);
    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(4);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 20,4,'Ket:','0',0,'L');
    $pdf->Cell( 100,4,$setting_value,'0',1,'L');



    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(5);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 20,4,'','0',0,'L');
    $pdf->Cell( 100,4,$setting_value,'0',1,'L');


    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(6);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    
    $pdf->MultiCell(190, 7, substr($setting_value, 0, 500), '0', 'L',0,1);




    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(7);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->MultiCell(190 ,7,$setting_value,0,'L');


    $pdf->SetFont('','',9);
    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(12);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 140,5,'','0',0,'L');
    $pdf->Cell( 50,5,$setting_value.','.date('d-m-Y', strtotime($tgl_faktur)),'0',1,'C');

    $pdf->SetFont('','',9);
    



    $pdf->Cell( 140,5,'','0',1,'L');


    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(8);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 140,4,'','0',0,'L');
    $pdf->Cell( 50,4,$setting_value,'0',1,'C');


    

    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(10);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 140,4,'','0',0,'L');
    $pdf->Cell( 50,4,$setting_value,'0',1,'C');


    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(11);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 140,5,'','0',0,'L');
    $pdf->Cell( 50,5,$setting_value,'0',1,'C');



    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(9);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    
    $pdf->Cell( 190,4,$setting_value,'0',1,'C');


    $pdf->Output("faktur_penjualan_".$no_faktur.".pdf");
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
