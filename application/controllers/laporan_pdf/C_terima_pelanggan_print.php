<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_terima_pelanggan_print extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_terima_pelanggan_diskon');
    $this->load->model('m_t_ak_terima_pelanggan_metode_bayar');
    $this->load->model('m_t_ak_terima_pelanggan_no_faktur');
    $this->load->model('m_t_ak_terima_pelanggan');
    $this->load->model('m_t_ak_terima_pelanggan_print_setting');
    $this->load->model('m_t_ak_terima_pelanggan_diskon');
    $this->load->model('m_t_ak_terima_pelanggan_metode_bayar');


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
    $x_value = $pdf->GetX();
    $y_value = $pdf->GetY();
    $pdf->SetXY($x_value, $y_value-5);

    $pdf->SetFont('','B',10);
    $pdf->Cell(90, 8, "PT. JO PERDANA AGRI TECHNOLOGY", 0, 0, 'L');

    $pdf->SetFont('','B',12);
    $pdf->Cell(90, 8, "Terima Pelanggan", 0, 1, 'R');


    $pdf->SetFont('','',9);


    $read_select = $this->m_t_ak_terima_pelanggan->select_by_id($id);
    foreach ($read_select as $key => $value) 
    {
      $no_pelanggan=$value->NO_PELANGGAN;
      $no_form=$value->NO_FORM;
      $tgl_faktur=$value->DATE;
      $nama=$value->NAMA;
      $alamat=$value->ALAMAT;
      $npwp=$value->NPWP;
      $telepon=$value->TELEPON;
      $catatan=$value->KET;
    }


    $pdf->Cell(30, 5, "Diterima dr:", 1, 0, 'C');
    $pdf->Cell(150, 5, $nama, 1, 1, 'L');
    $pdf->Cell(30, 5, "Alamat:", 1, 0, 'C');
    $pdf->MultiCell(150, 5, ':'.substr($alamat, 0, 200), 1, 'L',0,1);


    $x_value = $pdf->GetX();
    $y_value = $pdf->GetY();
    $pdf->SetXY($x_value, $y_value+2);

    $pdf->Cell(45, 5, "Tanggal", 1, 0, 'C');
    $pdf->Cell(45, 5, "No. Form", 1, 0, 'C');
    $pdf->Cell(45, 5, "Tanggal Cek", 1, 0, 'C');
    $pdf->Cell(45, 5, "No. Cek", 1, 1, 'C');

    $pdf->Cell(45, 5, $tgl_faktur, 1, 0, 'C');
    $pdf->Cell(45, 5, $no_form, 1, 0, 'C');
    $pdf->Cell(45, 5, $tgl_faktur, 1, 0, 'C');
    $pdf->Cell(45, 5, "", 1, 1, 'C');




    $x_value = $pdf->GetX();
    $y_value = $pdf->GetY();
    $pdf->SetXY($x_value, $y_value+2);

    $pdf->Cell(80, 5, "Bank:", 1, 0, 'C');
    $pdf->Cell(30, 5, "Nilai Tukar", 1, 0, 'C');
    $pdf->Cell(30, 5, "Mata Uang", 1, 0, 'C');
    $pdf->Cell(40, 5, "Jumlah Cek", 1, 1, 'C');


    $total_pembayaran = 0;
    $read_select = $this->m_t_ak_terima_pelanggan_metode_bayar->select($id);
    foreach ($read_select as $key => $value) 
    {
      $pdf->Cell(80, 5, $value->NAMA_AKUN, 1, 0, 'C');
      $pdf->Cell(30, 5, "1", 1, 0, 'C');
      $pdf->Cell(30, 5, "Rp", 1, 0, 'C');
      $pdf->Cell(40, 5, number_format((floatval(intval($value->JUMLAH*100)))/100), 1, 1, 'C');

      $total_pembayaran = $total_pembayaran+floatval($value->JUMLAH);
    }





    $total_diskon=0;

    $read_select = $this->m_t_ak_terima_pelanggan_diskon->select($id);
    foreach ($read_select as $key => $value) 
    {
      $total_diskon = $total_diskon+floatval($value->JUMLAH);
    }



    $read_select = $this->m_t_ak_terima_pelanggan_metode_bayar->select($id);
    foreach ($read_select as $key => $value) 
    {
      $total_diskon = floatval($total_diskon) + floatval($value->ADM_BANK);
    }
    



    $x_value = $pdf->GetX();
    $y_value = $pdf->GetY();
    $pdf->SetXY($x_value, $y_value+2);

    $pdf->SetFont('','B',9);


    $pdf->Cell(45, 5, "No. Faktur", 1, 0, 'C');
    $pdf->Cell(30, 5, "Tanggal", 1, 0, 'C');
    $pdf->Cell(35, 5, "Jumlah", 1, 0, 'C');
    $pdf->Cell(35, 5, "Terutang", 1, 0, 'C');
    $pdf->Cell(35, 5, "Total", 1, 1, 'C');
    $pdf->SetFont('','',9);

    $total_payment_t = 0;
    $sum_total_penjualan=0;
    $sum_payment_t=0;
    $total_hutang = 0;
    $vivo_paymen = 0;
    $read_select = $this->m_t_ak_terima_pelanggan_no_faktur->select($id);
    foreach ($read_select as $key => $value) 
    {
      // BACA TERUTANG
      if($key == 0)
      { 
        $read_select_in = $this->m_t_ak_terima_pelanggan->select_no_faktur_terutang($value->FAKTUR_PENJUALAN_ID);
        $sum_metode_bayar = 0;
        $sum_diskon = 0;
        foreach ($read_select_in as $key_in => $value_in) 
        {
          $get_sum_metode_bayar = $value_in->SUM_JUMLAH;
          $get_sum_diskon = $value_in->SUM_DISKON;
          $get_sum_adm_bank = $value_in->SUM_ADM_BANK;



          $sum_payment_t  = $value_in->SUM_PAYMENT_T;
          $sum_metode_bayar = $sum_metode_bayar+$get_sum_metode_bayar;
          $sum_diskon = $sum_diskon+$total_diskon;
        }

        $vivo_paymen = $total_pembayaran +$total_diskon;
      }
      

      //$terutang = intval($value->TOTAL_PENJUALAN) - (intval($sum_metode_bayar)+intval($sum_diskon));
      
      $payment_t = floatval($value->PAYMENT_T);

      if($payment_t>=$vivo_paymen)
      {
        $terutang = $payment_t - $vivo_paymen;
        $vivo_paymen=0;
      }
      if($payment_t<$vivo_paymen)
      {
        $terutang = $vivo_paymen - $payment_t;
        $vivo_paymen=$vivo_paymen - $payment_t;
      }
      $total_payment_t = $total_payment_t + $payment_t;

      $total_awal = floatval($value->TOTAL_PENJUALAN);


      $sub_total_hutang = $total_awal - $terutang;
/*    
      if($payment_t==$total_awal)
      {
        $total_awal = intval($value->TOTAL_PENJUALAN);
        $vivo_paymen = $vivo_paymen - intval($value->TOTAL_PENJUALAN);
      }
      
      if($payment_t<$total_awal)
      {
        $total_awal = intval($value->TOTAL_PENJUALAN)- ($payment_t-$vivo_paymen);
        $vivo_paymen = $vivo_paymen - intval($value->TOTAL_PENJUALAN);
      }
      */
      
/*
      if($sum_payment_t > $get_sum_metode_bayar)
      {
        $total_awal =  ($total_awal-($payment_t-$total_pembayaran))+$sum_diskon;

        $sum_metode_bayar = $sum_metode_bayar-$total_awal;
      }
     */ //$total_awal = intval($value->TOTAL_PENJUALAN);
      

      $pdf->Cell(45, 5, $value->NO_FAKTUR, 'L', 0, 'C');
      $pdf->Cell(30, 5, $value->DATE, 'L', 0, 'C');
      $pdf->Cell(35, 5, number_format((floatval(intval($total_awal*100)))/100), 'L', 0, 'R');
      $pdf->Cell(35, 5, number_format((floatval(intval($terutang*100)))/100), 'L', 0, 'R');
      $pdf->Cell(35, 5, number_format((floatval(intval($sub_total_hutang*100)))/100), 'L', 0, 'R');
      $pdf->Cell(0.01, 5, '', 'L', 1, 'R');

      $sum_total_penjualan = $sum_total_penjualan + floatval($value->TOTAL_PENJUALAN);
      $total_hutang = $total_hutang + floatval($sub_total_hutang);
    }
    $last_row = $key+1;
    if($key<$last_row)
    {
      for($i=0; $i<=($last_row-$key);$i++)
      {
        $pdf->Cell(45, 5, '', 'L', 0, 'C');
        $pdf->Cell(30, 5, '', 'L', 0, 'C');
        $pdf->Cell(35, 5, '', 'L', 0, 'R');
        $pdf->Cell(35, 5, '', 'L', 0, 'R');
        $pdf->Cell(35, 5, '', 'L', 0, 'R');
        $pdf->Cell(0.01, 5, '', 'L', 1, 'R');
      }
    }

        $pdf->Cell(45, 5, '', 'T', 0, 'C');
        $pdf->Cell(65, 5, '', 'T', 0, 'C');
        $pdf->Cell(35, 5, 'Total Hutang', 1, 0, 'R');
        $pdf->Cell(35, 5, number_format((floatval(intval($total_hutang*100)))/100), 1, 1, 'R');


    

    //$pph_22 = intval(0.25 * floatval($sum_total_penjualan))/100;

    $pph_22 =0;

    $total_diskon = floatval($total_diskon) + $pph_22;

    

        $pdf->Cell(45, 5, '', 0, 0, 'C');
        $pdf->Cell(65, 5, '', 0, 0, 'C');
        $pdf->Cell(35, 5, 'Total Diskon', 1, 0, 'R');
        $pdf->Cell(35, 5, number_format((floatval(intval($total_diskon*100)))/100), 1, 1, 'R');


        $pdf->Cell(45, 5, '', 0, 0, 'C');
        $pdf->Cell(65, 5, '', 0, 0, 'C');
        $pdf->Cell(35, 5, 'Total Pembayaran', 1, 0, 'R');
        $pdf->Cell(35, 5,number_format((floatval(intval($total_pembayaran*100)))/100), 1, 1, 'R');


        

       
        $kelebihan_bayar = floatval($total_pembayaran) - (floatval($total_hutang) - floatval($total_diskon));

        $pdf->Cell(45, 5, '', 0, 0, 'C');
        $pdf->Cell(65, 5, '', 0, 0, 'C');
        $pdf->Cell(35, 5, 'Kelebihan Bayar', 1, 0, 'R');
        $pdf->Cell(35, 5, number_format((floatval(intval($kelebihan_bayar*100)))/100), 1, 1, 'R');

    $x_value = $pdf->GetX();
    $y_value = $pdf->GetY();
    $pdf->SetXY($x_value, $y_value-20);

    $pdf->Cell(0.01, 1, 'Terbilang', 0, 1, 'L');
  
    $pdf->MultiCell(105, 8, '#'.ucwords($this->terbilang($total_pembayaran)).' Rupiah#', '1', 'L',0,1);

    $pdf->Cell(0.01, 1, 'Catatan', 0, 1, 'L');
    $pdf->MultiCell(105, 8, $catatan, '1', 'L',0,1);


    

    $pdf->Cell(45, 5, "Dibuat", 0, 0, 'C');
    $pdf->Cell(45, 5, "Diperiksa", 0, 0, 'C');
    $pdf->Cell(45, 5, "Disetujui", 0, 0, 'C');
    $pdf->Cell(45, 5, "Diketahui Oleh", 0, 1, 'C');

    $pdf->Cell(45, 7, "", 0, 0, 'C');
    $pdf->Cell(45, 7, "", 0, 0, 'C');
    $pdf->Cell(45, 7, "", 0, 0, 'C');
    $pdf->Cell(45, 7, "", 0, 1, 'C');





    $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(1);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell(45, 5, $setting_value, 0, 0, 'C');

    $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(2);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell(45, 5, $setting_value, 0, 0, 'C');

    $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(3);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell(45, 5, $setting_value, 0, 0, 'C');

    $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(4);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell(45, 5, $setting_value, 0, 1, 'C');


    $pdf->Cell(45, 5, "Tgl:", 0, 0, 'L');
    $pdf->Cell(45, 5, "Tgl:", 0, 0, 'L');
    $pdf->Cell(45, 5, "Tgl:", 0, 0, 'L');
    $pdf->Cell(45, 5, "Tgl:", 0, 1, 'L');



    $pdf->Output("terima_pelanggan".$no_form.".pdf");
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
