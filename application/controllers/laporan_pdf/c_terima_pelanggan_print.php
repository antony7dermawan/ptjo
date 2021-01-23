<?php
defined('BASEPATH') or exit('No direct script access allowed');

class c_terima_pelanggan_print extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_terima_pelanggan_diskon');
    $this->load->model('m_t_ak_terima_pelanggan_metode_bayar');
    $this->load->model('m_t_ak_terima_pelanggan_no_faktur');
    $this->load->model('m_t_ak_terima_pelanggan');
    $this->load->model('m_t_ak_terima_pelanggan_print_setting');
  }

  public function index($id,$pks_id)
  {
    $pdf = new \TCPDF();
    $pdf->AddPage('P', 'mm', 'A4');
    $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
    
    #.............................paper head


    $pdf->SetFont('','B',12);
    $pdf->Cell(90, 11, "PT. JO PERDANA AGRI TECHNOLOGY", 0, 0, 'L');

    $pdf->SetFont('','B',18);
    $pdf->Cell(90, 11, "Terima Pelanggan", 0, 1, 'R');


    $pdf->SetFont('','',12);


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


    $pdf->Cell(30, 6, "Diterima dr:", 1, 0, 'C');
    $pdf->Cell(150, 6, $nama, 1, 1, 'L');
    $pdf->Cell(30, 6, "Alamat:", 1, 0, 'C');
    $pdf->Cell(150, 6, $alamat, 1, 1, 'L');


    $pdf->Cell(30, 1, "", 0, 1, 'C');

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

/*

    
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
        $pdf->Cell( 40,5,'NO PELANGGAN','0',0,'L');
        $pdf->Cell( 100,5,':'.$no_pelanggan,'0',1,'L');
        $pdf->Cell( 40,5,'NO FAKTUR','0',0,'L');
        $pdf->Cell( 100,5,':'.$no_faktur,'0',1,'L');
        $pdf->Cell( 40,5,'TGL FAKTUR','0',0,'L');
        $pdf->Cell( 100,5,':'.date('d-m-Y', strtotime($tgl_faktur)),'0',1,'L');
        $pdf->Cell( 40,5,'NAMA','0',0,'L');
        $pdf->Cell( 100,5,':'.$nama,'0',1,'L');
        $pdf->Cell( 40,5,'ALAMAT','0',0,'L');
        $pdf->Cell( 100,5,':'.$alamat,'0',1,'L');
        $pdf->Cell( 40,5,'NPWP','0',0,'L');
        $pdf->Cell( 100,5,':'.$npwp,'0',1,'L');
        $pdf->Cell( 40,5,'TELEPON','0',0,'L');
        $pdf->Cell( 100,5,':'.$telepon,'0',1,'L');

        $pdf->Cell( 100,3,'','0',1,'L');

        $pdf->SetFont('','B',13);
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
        $pdf->Cell( $size[6],8,'Jumlah','1',1,'C');
      }
      if($key>=$total_row_1_bon and $rmd==0)
      {
        $pdf->AddPage();
      }
      
      $pdf->SetFont('','',10);
      $pdf->Cell( $size[0],6,$key+1,'L',0,'C');
      $pdf->Cell( $size[1],6,$value->KETERANGAN,'L',0,'L');
      $pdf->Cell( $size[2],6,date('d-m-Y', strtotime($value->DATE)),'L',0,'C');
      $pdf->Cell( $size[3],6,$value->NO_TIKET,'L',0,'C');
      $pdf->Cell( $size[4],6,number_format(intval($value->NETO)).' Kg','L',0,'R');
      $pdf->Cell( $size[5],6,number_format(intval($value->HARGA)),'L',0,'R');
      $pdf->Cell( $size[6]-0.1,6,number_format(intval($value->TOTAL_PENJUALAN)),'L',0,'R');
      $pdf->Cell( 0.1,6,'','L',1,'R');

      $total_kuantitas = $total_kuantitas+intval($value->NETO);
      $total_sub = $total_sub+intval($value->TOTAL_PENJUALAN);
      $dpp = $total_sub;
    }

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

    #.............................paper head end
    $pdf->Cell( $size[0]+$size[1]+$size[2]+$size[3]+$size[4],8,'Total Kuantitas   '.number_format(intval($total_kuantitas)),'1',0,'R');
    $pdf->Cell( $size[5]+$size[6],8,'','1',1,'L');

    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'Total Sub','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(intval($total_sub)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');


    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'Dasar Pengenaan Pajak','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(intval($dpp)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');


    $ppn = (10 * intval($dpp))/100;
    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'PNN','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(intval($ppn)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');

    $pph_22 = (0.25 * intval($dpp))/100;
    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'PNN','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(intval($pph_22)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');

    $total_tagihan = $dpp + $ppn + $pph_22;
    $pdf->Cell( 0.1,8,'','L',0,'R');
    $pdf->Cell( $size[0]+$size[1]-0.1,8,'Total Tagihan','T',0,'L');
    $pdf->Cell( $size[2],8,':','T',0,'L');
    $pdf->Cell( $size[3]+$size[4]+$size[5]+$size[6]-0.1,8,number_format(intval($total_tagihan)),'T',0,'R');
    $pdf->Cell( 0.1,8,'','L',1,'R');



    $pdf->MultiCell(190 ,10,'#'.ucwords($this->terbilang($total_tagihan)).' Rupiah#',1,'L');




    $pdf->SetFont('','B',10);
    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(4);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 20,5,'Ket:','0',0,'L');
    $pdf->Cell( 100,5,$setting_value,'0',1,'L');



    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(5);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 20,5,'','0',0,'L');
    $pdf->Cell( 100,5,$setting_value,'0',1,'L');


    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(6);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 20,5,'','0',0,'L');
    $pdf->Cell( 100,5,$setting_value,'0',1,'L');




    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(7);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->MultiCell(190 ,10,$setting_value,0,'L');



    $pdf->SetFont('','',9);
    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(11);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 140,5,'','0',0,'L');
    $pdf->Cell( 50,5,$setting_value.','.date('d-m-Y'),'0',1,'C');



    $pdf->Cell( 140,5,'','0',1,'L');
    $pdf->Cell( 140,5,'','0',1,'L');


    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(8);
    foreach ($read_select as $key => $value) 
    {
      $setting_value=$value->SETTING_VALUE;
    }
    $pdf->Cell( 140,4,'','0',0,'L');
    $pdf->Cell( 50,4,$setting_value,'0',1,'C');


    $read_select = $this->m_t_ak_faktur_penjualan_print_setting->select_id(9);
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

    */
    $no_form='';

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
