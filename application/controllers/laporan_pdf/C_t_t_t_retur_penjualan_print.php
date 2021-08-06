<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_t_t_retur_penjualan_print extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_t_t_penjualan');

    $this->load->model('m_t_t_t_retur_penjualan');

    $this->load->model('m_t_t_t_retur_penjualan_rincian'); 

    $this->load->model('m_t_m_d_pelanggan');
    
  }

  public function index($retur_penjualan_id)
  {
    $this->session->set_userdata('t_t_t_retur_penjualan_delete_logic', '0');

    $pdf = new \TCPDF();
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage('L',  array(210,148));
    $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
    
    #.............................paper head


    


    $pdf->SetFont('','',12);

    $read_select = $this->m_t_t_t_retur_penjualan->select_by_id($retur_penjualan_id);
    foreach ($read_select as $key => $value) 
    {
      $date = $value->DATE;
      $time = $value->TIME;
      $inv = $value->INV;
      $penjualan_id = $value->PENJUALAN_ID;
      $created_by = $value->CREATED_BY;
      $updated_by = $value->UPDATED_BY;
      $ket = $value->KET;
      $company = $value->COMPANY;
      
    }


    $read_select = $this->m_t_t_t_penjualan->select_by_id($penjualan_id);
    foreach ($read_select as $key => $value) 
    {
      $pelanggan_id = $value->PELANGGAN_ID;    
    }


    $read_select = $this->m_t_m_d_pelanggan->select_by_id($pelanggan_id);
    foreach ($read_select as $key => $value) 
    {
      $pelanggan = $value->PELANGGAN;
      $no_telp = $value->NO_TELP;
      $alamat = $value->ALAMAT;
      $email = $value->EMAIL;
    }







    $read_select = $this->m_t_t_t_retur_penjualan_rincian->select($retur_penjualan_id);
    foreach ($read_select as $key => $value) 
    {
      $kode_barang[$key]=$value->KODE_BARANG;
      $barang[$key]=$value->BARANG;
      $qty[$key]=$value->QTY;
      $satuan[$key]=$value->SATUAN;
      $harga[$key]=$value->HARGA;
      $sub_total[$key]=$value->SUB_TOTAL;
      $sisa_qty_tt[$key]=$value->SISA_QTY_TT;
    }
    $total_baris_transaksi = $key;


    $colom_width[0] = 10;
    $colom_width[1] = 30;
    $colom_width[2] = 60;
    $colom_width[3] = 20;
    $colom_width[4] = 25;
    
    $colom_width[5] = 25;
    $colom_width[6] = 20;


    $no_hal = 1;
    $total_all=0;
    $total_baris_1_bon = 12;
    $baris_height = 4;

    $jumlah_hal = intval($total_baris_transaksi/$total_baris_1_bon)+1;
    for($i=0;$i<=$total_baris_transaksi;$i++)
    {
      $rmd=(float)($i/$total_baris_1_bon);
      $rmd=($rmd-(int)$rmd)*$total_baris_1_bon;
      if(($i>=$total_baris_1_bon and $rmd==0) or $i==0)
      {
        if($i>0)
        {
          $pdf->SetPrintHeader(false);
          $pdf->SetPrintFooter(false);
          $pdf->AddPage('L',  array(210,148));
        }
        


        
        

        $x_value = $pdf->GetX();
        $y_value =5;
        $pdf->SetXY($x_value, $y_value);

        $pdf->SetFont('','B',11);
        $pdf->Cell(130, 6, "", 0, 0, 'C');
        $pdf->Cell(30, 6, "RETUR PENJUALAN", 0, 1, 'L');

        $pdf->SetFont('','',9);
        $pdf->Cell(130, 4, "", 0, 0, 'C');
        $pdf->Cell(30, 4, 'PT Jo Perdana Agri Technology', 0, 1, 'L');
        
        $pdf->SetFont('','',8);
        $pdf->Cell(130, 4, "", 0, 0, 'C');
        $pdf->Cell(30, 4, $company.', '.date('d-m-Y', strtotime($date)), 0, 1, 'L');

        $pdf->SetFont('','',8);
        $pdf->Cell(130, 4, "", 0, 0, 'C');
        $pdf->Cell(20, 4, "No. Faktur", 0, 0, 'L');
        $pdf->Cell(20, 4, ': '.$inv, 0, 1, 'L');

        $pdf->Cell(130, 4, "", 0, 1, 'C');
        


       


        $x_value = $pdf->GetX();
        $y_value =5;
        $pdf->SetXY($x_value, $y_value);
        
        $pdf->SetFont('','',9);
        $pdf->Cell(25, 6, "Pelanggan", 0, 0, 'L');
        $pdf->Cell(90, 6, ':  '.$pelanggan, 0, 1, 'L');
        $pdf->Cell(25, 6, "Alamat", 0, 0, 'L');
        $pdf->MultiCell(90, 6, ':  '.substr($alamat, 0, 50), '0', 'L',0,1);
        $pdf->Cell(25, 6, "No Telp", 0, 0, 'L');
        $pdf->MultiCell(90, 6, ':  '.substr($no_telp, 0, 50), '0', 'L',0,1);


        $x_value = $pdf->GetX();
        $y_value = $pdf->GetY();
        $pdf->SetXY($x_value, $y_value+1);

        $pdf->MultiCell(25, 6,'Keterangan', '0', 'L',0,0);
        $pdf->MultiCell(90, 6,':  '. substr($ket, 0, 200), '0', 'L',0,1);



        $pdf->Cell(190, 1, "Hal. ".$no_hal.'/'.$jumlah_hal, 'B', 1, 'R');

        $no_hal = $no_hal+1;

        $pdf->SetFont('','',8);
        $pdf->Cell($colom_width[0], 8, "NO", 'B', 0, 'C');
        $pdf->Cell($colom_width[1], 8, "KODE", 'BL', 0, 'C');
        $pdf->Cell($colom_width[2], 8, "NAMA BARANG", 'BL', 0, 'C');
        $pdf->Cell($colom_width[3], 8, "BANYAKNYA", 'BL', 0, 'C');
        $pdf->Cell($colom_width[4], 8, "HARGA", 'BL', 0, 'C');
        $pdf->Cell($colom_width[5]+$colom_width[6], 8, "JUMLAH", 'BL', 1, 'C');

      }



      $pdf->SetFont('','',8);

      $pdf->MultiCell($colom_width[0], $baris_height, ($i+1).'.', '0', 'C',0,0);
      $pdf->MultiCell($colom_width[1], $baris_height, substr($kode_barang[$i], 0, 12), 'L', 'L',0,0);
      $pdf->MultiCell($colom_width[2], $baris_height, substr($barang[$i], 0, 20), 'L', 'L',0,0);
      $pdf->MultiCell($colom_width[3], $baris_height, number_format(round($qty[$i])).' '.$satuan[$i], 'L', 'C',0,0);

      $pdf->MultiCell($colom_width[4], $baris_height, number_format(round($harga[$i])), 'L', 'C',0,0);

      


      $pdf->MultiCell($colom_width[5]+$colom_width[6], $baris_height, number_format(round($sub_total[$i])), 'L', 'R',0,0);
      
    

      $pdf->Cell(0.01, $baris_height, "", '0', 1, 'C');

      $total_all=$total_all+floatval($sub_total[$i]);


      if($rmd==$total_baris_1_bon-1)
      {
        $pdf->MultiCell(150, 8, 'Terbilang : #'.ucwords($this->terbilang($total_all)).' Rupiah#' , 'T', 'L',0,0);
        $pdf->MultiCell(15, 8, 'Total' , 'T', 'R',0,0);
        $pdf->MultiCell(25, 8, number_format(round($total_all)) , 'T', 'R',0,1);
        $total_all=0;
        
        $pdf->Cell(40, 6, "NB: Barang yang sudah dibeli tidak dapat ditukar/dikembalikan", 0, 1, 'L');

            $pdf->Cell(40, 6, "DITERIMA OLEH:", 0, 0, 'C');
            $pdf->Cell(5, 6, "", 0, 0, 'C');
            $pdf->Cell(40, 6, "DIPERIKSA OLEH:", 0, 0, 'C');
            $pdf->Cell(5, 6, "", 0, 0, 'C');
            $pdf->Cell(40, 6, "DIKIRIM OLEH:", 0, 0, 'C');
            $pdf->Cell(5, 6, "", 0, 0, 'C');
            $pdf->Cell(40, 6, "HORMAT KAMI:", 0, 1, 'C');

            $pdf->Cell(40, 12, "", 'B', 0, 'C');
            $pdf->Cell(5, 12, "", 0, 0, 'C');
            $pdf->Cell(40, 12, "", 'B', 0, 'C');
            $pdf->Cell(5, 12, "", 0, 0, 'C');
            $pdf->Cell(40, 12, "", 'B', 0, 'C');
            $pdf->Cell(5, 12, "", 0, 0, 'C');
            $pdf->Cell(40, 12, "", 'B', 1, 'C');

        $dibuat_oleh = $created_by;
        if($updated_by!='')
        {
          $dibuat_oleh = $updated_by;
        }
        $pdf->Cell(20, 12, "Dibuat Oleh", 0, 0, 'L');
        $pdf->Cell(20, 12,': '. $dibuat_oleh.' / '. date('d-m-y', strtotime($date)). ' / '.date('H:i', strtotime($time)), 0, 1, 'L');


      }

    }

    if($total_baris_1_bon>$i)
    {
      for($x=0;$x<($total_baris_1_bon-$i);$x++)
      {
        $pdf->MultiCell($colom_width[0], $baris_height,'', '0', 'C',0,0);
        $pdf->MultiCell($colom_width[1], $baris_height, '', 'L', 'L',0,0);
        $pdf->MultiCell($colom_width[2], $baris_height, '', 'L', 'L',0,0);
        $pdf->MultiCell($colom_width[3], $baris_height, '', 'L', 'C',0,0);
        $pdf->MultiCell($colom_width[4], $baris_height, '', 'L', 'C',0,0);
        $pdf->MultiCell($colom_width[5]+$colom_width[6], $baris_height, '', 'L', 'R',0,0);
        $pdf->Cell(0.01, $baris_height, "", '0', 1, 'C');
      }
    }
    if($total_baris_1_bon<$i)
    {
      $rmd=(float)($i/$total_baris_1_bon);
      $rmd=($rmd-(int)$rmd)*$total_baris_1_bon;
      for($x=0;$x<($total_baris_1_bon-$rmd);$x++)
      {
        
        $pdf->MultiCell($colom_width[0], $baris_height,'', '0', 'C',0,0);
        $pdf->MultiCell($colom_width[1], $baris_height, '', 'L', 'L',0,0);
        $pdf->MultiCell($colom_width[2], $baris_height, '', 'L', 'L',0,0);
        $pdf->MultiCell($colom_width[3], $baris_height, '', 'L', 'C',0,0);
        $pdf->MultiCell($colom_width[4], $baris_height, '', 'L', 'C',0,0);
        $pdf->MultiCell($colom_width[5]+$colom_width[6], $baris_height, '', 'L', 'R',0,0);
        $pdf->Cell(0.01, $baris_height, "", '0', 1, 'C');
      }
    }

    $pdf->MultiCell(150, 8, 'Terbilang : #'.ucwords($this->terbilang($total_all)).' Rupiah#' , 'T', 'L',0,0);
    $pdf->MultiCell(15, 8, 'Total' , 'T', 'R',0,0);
    $pdf->MultiCell(25, 8, number_format(round($total_all)) , 'T', 'R',0,1);

    

        $pdf->Cell(40, 6, "DITERIMA OLEH:", 0, 0, 'C');
        $pdf->Cell(10, 6, "", 0, 0, 'C');
        $pdf->Cell(40, 6, "DIPERIKSA OLEH:", 0, 0, 'C');
        $pdf->Cell(10, 6, "", 0, 0, 'C');
        $pdf->Cell(40, 6, "DIKIRIM OLEH:", 0, 0, 'C');
        $pdf->Cell(10, 6, "", 0, 0, 'C');
        $pdf->Cell(40, 6, "HORMAT KAMI:", 0, 1, 'C');

        $pdf->Cell(40, 12, "", 0, 0, 'C');
        $pdf->Cell(10, 12, "", 0, 0, 'C');
        $pdf->Cell(40, 12, "", 0, 0, 'C');
        $pdf->Cell(10, 12, "", 0, 0, 'C');
        $pdf->Cell(40, 12, "", 0, 0, 'C');
        $pdf->Cell(10, 12, "", 0, 0, 'C');
        $pdf->Cell(40, 12, "", 0, 1, 'C');

        $pdf->Cell(40, 6, "Tgl:", 'T', 0, 'C');
        $pdf->Cell(10, 6, "", 0, 0, 'C');
        $pdf->Cell(40, 6, "Tgl:", 'T', 0, 'C');
        $pdf->Cell(10, 6, "", 0, 0, 'C');
        $pdf->Cell(40, 6, "Tgl:", 'T', 0, 'C');
        $pdf->Cell(10, 6, "", 0, 0, 'C');
        $pdf->Cell(40, 6, "Tgl:", 'T', 1, 'C');


        $dibuat_oleh = $created_by;
        if($updated_by!='')
        {
          $dibuat_oleh = $updated_by;
        }
        $pdf->Cell(20, 12, "Dibuat Oleh", 0, 0, 'L');
        $pdf->Cell(20, 12,': '. $dibuat_oleh.' / '. date('d-m-Y', strtotime($date)). ' / '.date('H:i', strtotime($time)), 0, 1, 'L');



    $pdf->Output("penjualan".$inv.".pdf");
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
