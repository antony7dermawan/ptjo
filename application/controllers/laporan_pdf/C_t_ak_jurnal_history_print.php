<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_jurnal_history_print extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_jurnal_history');
    $this->load->model('m_t_ak_jurnal_edit');
    $this->load->model('m_ak_m_coa');
    $this->load->model('m_ak_m_family');
    $this->load->model('m_ak_m_type');


    
  }

  public function index()
  {
    $pdf = new \TCPDF();
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage('P', 'mm', 'A4');
    $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
    
    #.............................paper head


    $pdf->SetFont('','B',12);
    $pdf->Cell(185, 8, "PT. JO PERDANA AGRI TECHNOLOGY", 0, 1, 'C');

    $pdf->SetFont('','',12);
    $pdf->Cell(185, 6, "History Akun Buku Besar", 0, 1, 'C');
    $pdf->Cell(185, 6, "Dari ".date('d-m-Y', strtotime($this->session->userdata('date_from_select_jurnal')))." Sampai ".date('d-m-Y', strtotime($this->session->userdata('date_to_select_jurnal')))." ", 0, 1, 'C');

    

    $read_select = $this->m_t_ak_jurnal_history->select($this->session->userdata('date_from_select_jurnal'),$this->session->userdata('date_to_select_jurnal'),$this->session->userdata('coa_id_jurnal_history'));
    foreach ($read_select as $key => $value) 
    {
      $no_akun_1[$key]=$value->NO_AKUN_1;
      $no_akun_2[$key]=$value->NO_AKUN_2;
      $no_akun_3[$key]=$value->NO_AKUN_3;
      $nama_akun[$key]=$value->NAMA_AKUN;
      $debit[$key]=$value->DEBIT;
      $kredit[$key]=$value->KREDIT;
      $catatan[$key]=$value->CATATAN;
      $no_voucer[$key]=$value->NO_VOUCER;
      $tanggal[$key]=date('d-m-Y', strtotime($value->DATE));

                if($value->NO_AKUN_3!='')
                {
                  $no_akun[$key]=$value->NO_AKUN_3;
                }
                elseif($value->NO_AKUN_2!='')
                {
                  $no_akun[$key]=$value->NO_AKUN_2;
                }
                else
                {
                  $no_akun[$key]=$value->NO_AKUN_1;
                }
    }
    $total_akun = $key;




    $pdf->Cell(25, 6, "Tanggal", 1, 0, 'C');
    $pdf->Cell(25, 6, "No Voucer", 1, 0, 'C');
    $pdf->Cell(25, 6, "No. Akun:", 1, 0, 'C');
    $pdf->Cell(35, 6, "Nama Akun", 1, 0, 'C');
    $pdf->Cell(25, 6, "Catatan", 1, 0, 'C');
    $pdf->Cell(25, 6, "Debit", 1, 0, 'C');
    $pdf->Cell(25, 6, "Kredit", 1, 1, 'C');

    $total_debit=0;
    $total_kredit=0;
    $total_baris_1_bon = 40;
    for($i=0;$i<=$total_akun;$i++)
    {
      $rmd=(float)($i/$total_baris_1_bon);
      $rmd=($rmd-(int)$rmd)*$total_baris_1_bon;
      if($i>$total_baris_1_bon and $rmd==0)
      {
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage('P', 'mm', 'A4');
        $pdf->SetFont('','B',12);
        $pdf->Cell(90, 11, "PT. JO PERDANA AGRI TECHNOLOGY", 0, 0, 'L');
        $pdf->SetFont('','B',18);
        $pdf->Cell(90, 11, "Bukti Jurnal", 0, 1, 'R');
        $pdf->SetFont('','',12);

        $pdf->Cell(30, 6, "No Voucer", 1, 0, 'C');
        $pdf->Cell(40, 6, $no_voucer, 1, 1, 'L');
        $pdf->Cell(30, 6, "Tanggal", 1, 0, 'C');
        $pdf->Cell(40, 6, $tanggal, 1, 1, 'L');


        $pdf->Cell(30, 1, "", 0, 1, 'C');

        $pdf->Cell(25, 6, "No. Akun:", 1, 0, 'C');
        $pdf->Cell(50, 6, "Nama Akun", 1, 0, 'C');
        $pdf->Cell(30, 6, "Debit", 1, 0, 'C');
        $pdf->Cell(30, 6, "Kredit", 1, 0, 'C');
        $pdf->Cell(50, 6, "Catatan", 1, 1, 'C');

      }
      $pdf->SetFont('','',10);
      $pdf->Cell(25, 6, $tanggal[$i], 'L', 0, 'C');
      $pdf->Cell(25, 6, substr($no_voucer[$i], 0, 10), 'L', 0, 'L');
      $pdf->Cell(25, 6, $no_akun[$i], 'L', 0, 'L');
      $pdf->Cell(35, 6, substr($nama_akun[$i], 0, 20), 'L', 0, 'L');
      $pdf->Cell(25, 6, substr($catatan[$i], 0, 10), 'L', 0, 'L');
      $pdf->Cell(25, 6, number_format(intval($debit[$i])), 'L', 0, 'C');
      $pdf->Cell(25, 6, number_format(intval($kredit[$i])), 'L', 0, 'C');

      $pdf->Cell(0.01, 6, "", 'L', 1, 'C');

      $total_debit=$total_debit+intval($debit[$i]);
      $total_kredit=$total_kredit+intval($kredit[$i]);

    }

    if($total_baris_1_bon>$i)
    {
      for($x=0;$x<($total_baris_1_bon-$i);$x++)
      {
        $pdf->Cell(25, 6, "", 'L', 0, 'C');
        $pdf->Cell(25, 6, "", 'L', 0, 'R');
        $pdf->Cell(25, 6, "", 'L', 0, 'C');
        $pdf->Cell(35, 6, "", 'L', 0, 'C');
        $pdf->Cell(25, 6, "", 'L', 0, 'C');
        $pdf->Cell(25, 6, "", 'L', 0, 'C');
        $pdf->Cell(25, 6, "", 'L', 0, 'C');
        $pdf->Cell(0.01, 6, "", 'L', 1, 'C');
      }
    }
    if($total_baris_1_bon<$i)
    {
      $rmd=(float)($i/$total_baris_1_bon);
      $rmd=($rmd-(int)$rmd)*$total_baris_1_bon;
      for($x=0;$x<($total_baris_1_bon-$rmd);$x++)
      {
        $pdf->Cell(25, 12, "", 'L', 0, 'C');
        $pdf->Cell(50, 12, "", 'L', 0, 'R');
        $pdf->Cell(30, 12, "", 'L', 0, 'C');
        $pdf->Cell(30, 12, "", 'L', 0, 'C');
        $pdf->Cell(50, 12, "", 'L', 0, 'C');
        $pdf->Cell(0.01, 12, "", 'L', 1, 'C');
      }
    }

    $pdf->Cell(110, 6, "", 'T', 0, 'C');
    $pdf->Cell(25, 6, "Total", 1, 0, 'R');
    $pdf->Cell(25, 6, number_format(intval($total_debit)), 1, 0, 'C');
    $pdf->Cell(25, 6, number_format(intval($total_kredit)), 1, 0, 'C');
    $pdf->Cell(0.1, 6, "", 'L', 1, 'C');

    $pdf->Cell(1, 1, "", 0, 1, 'C');





/*
    $y_0 = $pdf->GetY();
    $pdf->Cell(25, 0, "No. Akun:", 1, 0, 'C');

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->setXY($x, $y-$y_0);

    $pdf->MultiCell(50, 6, "Nama Akunmmmmmmmmm mmmam mmm mmmmmmmmmmm mmmmmmmm mmmm", 1, 'C',0,0);
    $y = $pdf->GetY();
    #$startY = $this->GetY();
    $pdf->Cell(30, $y, "Debit", 1, 0, 'C');
    $pdf->Cell(40, $y, "Kredit", 1, 1, 'C');



    $total_pembayaran = 0;
    $read_select = $this->m_t_ak_terima_pelanggan_metode_bayar->select($id);
    foreach ($read_select as $key => $value) 
    {
      $pdf->Cell(80, 6, $value->NAMA_AKUN, 1, 0, 'C');
      $pdf->Cell(30, 6, "1", 1, 0, 'C');
      $pdf->Cell(30, 6, "Rp", 1, 0, 'C');
      $pdf->Cell(40, 6, number_format(intval($value->JUMLAH)), 1, 1, 'C');

      $total_pembayaran = $total_pembayaran+intval($value->JUMLAH);
    }

    /*
    $pdf->Cell(45, 6, "Tanggal", 1, 0, 'C');
    $pdf->Cell(45, 6, "No. Form", 1, 0, 'C');
    $pdf->Cell(45, 6, "Tanggal Cek", 1, 0, 'C');
    $pdf->Cell(45, 6, "No. Cek", 1, 1, 'C');

    $pdf->Cell(45, 6, $tgl_faktur, 1, 0, 'C');
    $pdf->Cell(45, 6, $no_form, 1, 0, 'C');
    $pdf->Cell(45, 6, $tgl_faktur, 1, 0, 'C');
    $pdf->Cell(45, 6, "", 1, 1, 'C');




    $pdf->Cell(30, 1, "", 0, 1, 'C');

    $pdf->Cell(80, 6, "Bank:", 1, 0, 'C');
    $pdf->Cell(30, 6, "Nilai Tukar", 1, 0, 'C');
    $pdf->Cell(30, 6, "Mata Uang", 1, 0, 'C');
    $pdf->Cell(40, 6, "Jumlah Cek", 1, 1, 'C');


    $total_pembayaran = 0;
    $read_select = $this->m_t_ak_terima_pelanggan_metode_bayar->select($id);
    foreach ($read_select as $key => $value) 
    {
      $pdf->Cell(80, 6, $value->NAMA_AKUN, 1, 0, 'C');
      $pdf->Cell(30, 6, "1", 1, 0, 'C');
      $pdf->Cell(30, 6, "Rp", 1, 0, 'C');
      $pdf->Cell(40, 6, number_format(intval($value->JUMLAH)), 1, 1, 'C');

      $total_pembayaran = $total_pembayaran+intval($value->JUMLAH);
    }

    $pdf->Cell(30, 1, "", 0, 1, 'C');
    $pdf->SetFont('','B',12);


    $pdf->Cell(45, 6, "No. Faktur", 1, 0, 'C');
    $pdf->Cell(30, 6, "Tanggal", 1, 0, 'C');
    $pdf->Cell(35, 6, "Jumlah", 1, 0, 'C');
    $pdf->Cell(35, 6, "Terutang", 1, 0, 'C');
    $pdf->Cell(35, 6, "Total", 1, 1, 'C');
    $pdf->SetFont('','',12);



    $total_hutang = 0;
    $read_select = $this->m_t_ak_terima_pelanggan_no_faktur->select($id);
    foreach ($read_select as $key => $value) 
    {
      // BACA TERUTANG
      $read_select_in = $this->m_t_ak_terima_pelanggan->select_no_faktur_terutang($value->FAKTUR_PENJUALAN_ID);
      $sum_metode_bayar = 0;
      $sum_diskon = 0;
      foreach ($read_select_in as $key_in => $value_in) 
      {
        $get_sum_metode_bayar = $value_in->SUM_JUMLAH;
        $get_sum_diskon = $value_in->SUM_DISKON;

        $sum_metode_bayar = $sum_metode_bayar+$get_sum_metode_bayar;
        $sum_diskon = $sum_diskon+$get_sum_diskon;
      }

      $terutang = intval($value->TOTAL_PENJUALAN) - (intval($sum_metode_bayar)+intval($sum_diskon));

      $total_awal = intval($value->TOTAL_PENJUALAN) - intval($terutang);

      $pdf->Cell(45, 6, $value->NO_FAKTUR, 'L', 0, 'C');
      $pdf->Cell(30, 6, $value->DATE, 'L', 0, 'C');
      $pdf->Cell(35, 6, number_format(intval($value->TOTAL_PENJUALAN)), 'L', 0, 'R');
      $pdf->Cell(35, 6, number_format(intval($terutang)), 'L', 0, 'R');
      $pdf->Cell(35, 6, number_format(intval($total_awal)), 'L', 0, 'R');
      $pdf->Cell(0.01, 6, '', 'L', 1, 'R');


      $total_hutang = $total_hutang+intval($total_awal);
    }
    $last_row = 10;
    if($key<$last_row)
    {
      for($i=0; $i<=($last_row-$key);$i++)
      {
        $pdf->Cell(45, 6, '', 'L', 0, 'C');
        $pdf->Cell(30, 6, '', 'L', 0, 'C');
        $pdf->Cell(35, 6, '', 'L', 0, 'R');
        $pdf->Cell(35, 6, '', 'L', 0, 'R');
        $pdf->Cell(35, 6, '', 'L', 0, 'R');
        $pdf->Cell(0.01, 6, '', 'L', 1, 'R');
      }
    }

        $pdf->Cell(45, 6, '', 'T', 0, 'C');
        $pdf->Cell(30, 6, '', 'T', 0, 'C');
        $pdf->Cell(70, 6, 'Total Hutang', 1, 0, 'R');
        $pdf->Cell(35, 6, number_format(intval($total_hutang)), 1, 1, 'R');


    $total_diskon=0;
    $read_select = $this->m_t_ak_terima_pelanggan_diskon->select($id);
    foreach ($read_select as $key => $value) 
    {
      $total_diskon = $total_diskon+intval($value->JUMLAH);
    }


        $pdf->Cell(45, 6, '', 0, 0, 'C');
        $pdf->Cell(30, 6, '', 0, 0, 'C');
        $pdf->Cell(70, 6, 'Total Diskon', 1, 0, 'R');
        $pdf->Cell(35, 6, number_format(intval($total_diskon)), 1, 1, 'R');


        $pdf->Cell(45, 6, '', 0, 0, 'C');
        $pdf->Cell(30, 6, '', 0, 0, 'C');
        $pdf->Cell(70, 6, 'Total Pembayaran', 1, 0, 'R');
        $pdf->Cell(35, 6, number_format(intval($total_pembayaran)), 1, 1, 'R');


        $kelebihan_bayar = intval($total_pembayaran) - (intval($total_hutang) - intval($total_diskon));
        $pdf->Cell(45, 6, '', 0, 0, 'C');
        $pdf->Cell(30, 6, '', 0, 0, 'C');
        $pdf->Cell(70, 6, 'Kelebihan Bayar', 1, 0, 'R');
        $pdf->Cell(35, 6, number_format(intval($kelebihan_bayar)), 1, 1, 'R');


    $pdf->Cell(0.01, 1, 'Terbilang', 0, 1, 'L');
    $pdf->MultiCell(180 ,10,'#'.ucwords($this->terbilang($total_pembayaran)).' Rupiah#',1,'L');

    $pdf->Cell(0.01, 1, 'Catatan', 0, 1, 'L');
    $pdf->MultiCell(180 ,10,$catatan,1,'L');



    

    $pdf->Cell(45, 6, "Dibuat", 0, 0, 'C');
    $pdf->Cell(45, 6, "Diperiksa", 0, 0, 'C');
    $pdf->Cell(45, 6, "Disetujui", 0, 0, 'C');
    $pdf->Cell(45, 6, "Diketahui Oleh", 0, 1, 'C');

    $pdf->Cell(45, 6, "", 0, 0, 'C');
    $pdf->Cell(45, 6, "", 0, 0, 'C');
    $pdf->Cell(45, 6, "", 0, 0, 'C');
    $pdf->Cell(45, 6, "", 0, 1, 'C');

    $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(1);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell(45, 6, $setting_value, 0, 0, 'C');

    $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(2);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell(45, 6, $setting_value, 0, 0, 'C');

    $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(3);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell(45, 6, $setting_value, 0, 0, 'C');

    $read_select = $this->m_t_ak_terima_pelanggan_print_setting->select_id(4);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell(45, 6, $setting_value, 0, 1, 'C');


    $pdf->Cell(45, 6, "Tgl:", 0, 0, 'L');
    $pdf->Cell(45, 6, "Tgl:", 0, 0, 'L');
    $pdf->Cell(45, 6, "Tgl:", 0, 0, 'L');
    $pdf->Cell(45, 6, "Tgl:", 0, 1, 'L');

    $no_form='';
    */


    $pdf->Output("terima_pelanggan".$no_voucer[$total_akun].".pdf");
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
