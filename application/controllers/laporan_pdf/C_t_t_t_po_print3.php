<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_t_t_po_print3 extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    
    $this->load->model('m_t_po_print_setting');

    $this->load->model('m_t_t_t_pembelian');

    $this->load->model('m_t_t_t_pembelian_rincian'); 

    $this->load->model('m_t_m_d_supplier');
  }

  public function index($pembelian_id)
  {
    $pdf = new \TCPDF();
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage('P', 'mm', 'A4');
    $pdf->SetAutoPageBreak(true, 0);
    
        // Add Header
    
    #.............................paper head
    

    


    $pdf->SetFont('','',12);



    $read_select = $this->m_t_t_t_pembelian->select_by_id($pembelian_id);
    foreach ($read_select as $key => $value) 
    {
      $r_date = $value->NEW_DATE;
      $r_time = $value->TIME;
      $r_no_po = $value->INV;
      $supplier_id = $value->SUPPLIER_ID;
      $r_created_by = $value->CREATED_BY;
      $updated_by = $value->UPDATED_BY;
      $r_ket = $value->KET;
      $company = $value->COMPANY;

      $r_payment_method=$value->PAYMENT_METHOD;
      $r_nama_bank=$value->NAMA_BANK;
      $r_norek=$value->NOREK;
      $r_atas_nama=$value->ATAS_NAMA;
      $r_cabang=$value->CABANG;
      $r_nama_penerima=$value->ANGGOTA;
      $r_lainnya='';
    }


    $read_select = $this->m_t_m_d_supplier->select_by_id($supplier_id);
    foreach ($read_select as $key => $value) 
    {
      $r_supplier = $value->SUPPLIER;
      $r_telp_supplier = $value->NO_TELP;
      $r_alamat_supplier = $value->ALAMAT;
      $email = $value->EMAIL;
      $nik = $value->NIK;
      $npwp = $value->NPWP;
    }



        $size[0]=10;
        $size[1]=65;
        $size[2]=20;
        $size[3]=15;
        $size[4]=25;
        $size[5]=25;
        $size[6]=30;

    $total_sub_1 = 0;
    $total_row_1_bon = 15;
    $total_ppn = 0;
    $total_sub = 0;
    $read_select = $this->m_t_t_t_pembelian_rincian->select_list($pembelian_id);
    $sum_total_harga = 0;
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
        

        $pdf->Cell( 190,15,'','0',1,'C');

        $pdf->SetFont('','B',12);
        $pdf->Cell( 190,8,'Purchase Order','0',1,'C');

      
        
        $pdf->SetFont('','',10);

        $pdf->Cell( 20,5,'Kepada','0',0,'L');
        $pdf->Cell( 85,5,':'.$r_supplier,'0',0,'L');
        $pdf->Cell( 20,5,'Tanggal','0',0,'L');
        $pdf->Cell( 75,5,':'.date('d-m-Y', strtotime($r_date)),'0',1,'L');


        $pdf->Cell( 20,5,'Telp','0',0,'L');
        $pdf->Cell( 85,5,':'.$r_telp_supplier,'0',0,'L');
        
        $pdf->Cell( 20,5,'NO PO','0',0,'L');
        $pdf->Cell( 75,5,':'.$r_no_po,'0',1,'L');



        $pdf->MultiCell(20, 15, 'Alamat', '0', 'L',0,0);
        $pdf->MultiCell(85, 15,':'.substr($r_alamat_supplier, 0, 200), '0', 'L',0,0);
        $pdf->Cell( 20,15,'Penerima','0',0,'L');
        $pdf->Cell( 75,15,':'.$r_nama_penerima,'0',1,'L');

        //$pdf->Cell( 20,5,'Lainnya','0',0,'L');
        //$pdf->MultiCell(100, 5, ':'.substr($r_lainnya, 0, 200), 0, 'L',0,1);

       

        $pdf->Cell( 100,3,'','0',1,'L');

        $pdf->SetFont('','B',9);
        
        
        $pdf->Cell( $size[0],5,'No.','1',0,'C');
        $pdf->Cell( $size[1],5,'Nama/Jenis/Ukuran','1',0,'C');
        $pdf->Cell( $size[2],5,'Qty','1',0,'C');
        $pdf->Cell( $size[3],5,'Unit','1',0,'C');
        $pdf->Cell( $size[4],5,'Harga/Unit','1',0,'C');
        $pdf->Cell( $size[5],5,'Ppn(%)','1',0,'C');
        $pdf->Cell( $size[6],5,'Jumlah','1',1,'C');
      }
      
      
      $pdf->SetFont('','',8);
     
     
      $cell_height = 4;

      if( strlen($value->BARANG)>=40)
      {
        $cell_height = 8;
      }

      $pdf->MultiCell($size[0], $cell_height, $key+1, 'L', 'C',0,0);
      $pdf->MultiCell($size[1], $cell_height, $value->BARANG, 'L', 'L',0,0);
      $pdf->MultiCell($size[2], $cell_height, number_format(($value->QTY),2,'.',','), 'L', 'C',0,0);
      $pdf->MultiCell($size[3], $cell_height, $value->SATUAN, 'L', 'C',0,0);
      $pdf->MultiCell($size[4], $cell_height, number_format((floatval(round($value->HARGA*100)))/100,2, ',', '.'), 'L', 'R',0,0);
      $pdf->MultiCell($size[5], $cell_height, $value->PPN_PERCENTAGE, 'L', 'R',0,0);
      $pdf->MultiCell($size[6]-0.1, $cell_height, number_format((floatval(round(($value->SUB_TOTAL)*100)))/100,2, ',', '.'), 'L', 'R',0,0);
      $pdf->Cell( 0.1,$cell_height,'','L',1,'R');




      $total_sub_1 = $total_sub_1 + floatval($value->HARGA)*floatval($value->QTY);
      $total_ppn = $total_ppn+floatval($value->PPN_VALUE);
      $total_sub = $total_sub+($value->SUB_TOTAL);
     

      // if(($key<$total_row_1_bon and ($key+1)==$total_row_1_bon) or ($key>=$total_row_1_bon and ($rmd+1)==$total_row_1_bon))
      // {
      //   $pdf->Cell( 120,90,'','0',1,'L');
      //   $pdf->Cell( 120,5,'Hal.'.$pages.'/'.$total_sheet,'0',1,'L');
      // }
      
      
    }

    if($key<$total_row_1_bon)
    {
      $added_row = $total_row_1_bon-$key;
    }
    if($key>=$total_row_1_bon)
    {
      $added_row = $total_row_1_bon-$rmd;
    }

    // for($i=0;$i<=$added_row;$i++)
    // {
    //   $pdf->Cell( $size[0],6,'','L',0,'C');
    //   $pdf->Cell( $size[1],6,'','L',0,'L');
    //   $pdf->Cell( $size[2],6,'','L',0,'C');
    //   $pdf->Cell( $size[3],6,'','L',0,'C');
    //   $pdf->Cell( $size[4],6,'','L',0,'C');
    //   $pdf->Cell( $size[5],6,'','L',0,'C');

    //   $pdf->Cell( $size[6]-0.1,6,'','L',0,'R');
    //   $pdf->Cell( 0.1,6,'','L',1,'R'); 
    // }


    $nilai_ppn = $total_ppn/($key+1);
    #.............................paper head end
    //$pdf->Cell( $size[0]+$size[1]+$size[2]+$size[3]+$size[4]+$size[5],8,'Sub Total','1',0,'R');
    //$pdf->Cell( $size[6],8,number_format($total_sub_1)),'1',1,'R');

    //$pdf->Cell( $size[0]+$size[1]+$size[2]+$size[3]+$size[4]+$size[5],8,'PPN('.$nilai_ppn.'%)','1',0,'R');
    //$pdf->Cell( $size[6],8,number_format((intval($total_sub_1)*$nilai_ppn)/100),'1',1,'R');

    $pdf->Cell( $size[0]+$size[1]+$size[2]+$size[3]+$size[4]+$size[5],6,'Total DPP','1',0,'R');
    $pdf->Cell( $size[6],6,number_format((floatval(round($total_sub*100)))/100,2, ',', '.'),'1',1,'R');


    $pdf->Cell( $size[0]+$size[1]+$size[2]+$size[3]+$size[4]+$size[5],6,'PPN','1',0,'R');
    $pdf->Cell( $size[6],6,number_format((floatval(round($total_ppn*100)))/100,2, ',', '.'),'1',1,'R');

    $pdf->Cell( $size[0]+$size[1]+$size[2]+$size[3]+$size[4]+$size[5],6,'Total','1',0,'R');
    $pdf->Cell( $size[6],6,number_format((floatval(round(($total_sub+$total_ppn)*100)))/100,2, ',', '.'),'1',1,'R');

        $pdf->Cell( 80,5,'','0',1,'L');
        $pdf->Cell( 80,5,'Pembayaran','B',1,'L');

        $pdf->Cell( 40,5,'Transfer/Giro/Cek/Cash','0',0,'L');
        $pdf->Cell( 80,5,': '.$r_payment_method,'0',1,'L');
        $pdf->Cell( 40,5,'Nama Bank','0',0,'L');
        $pdf->Cell( 80,5,': '.$r_nama_bank,'0',1,'L');
        $pdf->Cell( 40,5,'No. Rek','0',0,'L');
        $pdf->Cell( 80,5,': '.$r_norek,'0',1,'L');
        $pdf->Cell( 40,5,'A/N','0',0,'L');
        $pdf->Cell( 80,5,': '.$r_atas_nama,'0',1,'L');
        $pdf->Cell( 40,5,'Cabang','0',0,'L');
        $pdf->Cell( 80,5,': '.$r_cabang,'0',1,'L');


        $pdf->Cell( 80,5,'','0',1,'L');
        $pdf->Cell( 40,5,'Konfirmasi Supplier','B',0,'L');
        $pdf->Cell( 150,5,'PT.Jo Perdana Agri Technology','0',1,'R');
        $pdf->Cell( 80,5,$r_supplier,'0',1,'L');


        $pdf->Cell( 80,5,'','0',1,'L');
        $pdf->Cell( 80,5,'','0',1,'L');


        $read_select = $this->m_t_po_print_setting->select_id(1); //Yang TTD PO
        foreach ($read_select as $key => $value) 
        {
          $setting_value=$value->SETTING_VALUE;
        }

        $pdf->Cell( 40,5,'','B',0,'L');
        $pdf->Cell( 110,5,'',0,0,'L');
        $pdf->Cell( 40,5,$setting_value,'B',1,'C');


        $pdf->Cell( 80,5,'','0',1,'L');
        $pdf->Cell( 190,5,'PERSETUJUAN PEMBELIAN','B',1,'C');



        $pdf->Cell( 100,7,'Disetujui Oleh,','0',0,'L');

        $pdf->Cell( 95,7,'Diketahui Oleh,','0',1,'L');

        $pdf->Cell( 0.01,10,'','L',0,'L');
        $pdf->Cell( 45,10,'','T',0,'L');
        $pdf->Cell( 0.01,10,'','L',0,'L');
        $pdf->Cell( 45,10,'Tanggal:','T',0,'L');
        $pdf->Cell( 0.01,10,'','L',0,'L');
        $pdf->Cell( 10,10,'','0',0,'L');
        $pdf->Cell( 0.01,10,'','L',0,'L');
        $pdf->Cell( 45,10,'','T',0,'L');
        $pdf->Cell( 0.01,10,'','L',0,'L');
        $pdf->Cell( 45,10,'Tanggal:','T',0,'L');
        $pdf->Cell( 0.01,10,'','L',1,'L');

        $read_select = $this->m_t_po_print_setting->select_id(2); //Nama Yang Setujui
        foreach ($read_select as $key => $value) 
        {
          $setting_value=$value->SETTING_VALUE;
        }
        $pdf->Cell( 0.01,10,'','L',0,'L');
        $pdf->Cell( 45,10,$setting_value,'B',0,'L');
        $pdf->Cell( 0.01,10,'','L',0,'L');

        $read_select = $this->m_t_po_print_setting->select_id(3); //Pangkat Yang Setujui
        foreach ($read_select as $key => $value) 
        {
          $setting_value=$value->SETTING_VALUE;
        }

        $pdf->Cell( 45,10,'Jabatan: '.$setting_value,'B',0,'L');
        $pdf->Cell( 0.01,10,'','L',0,'L');
        $pdf->Cell( 10,10,'','0',0,'L');
        $pdf->Cell( 0.01,10,'','L',0,'L');

        $read_select = $this->m_t_po_print_setting->select_id(4); //Nama Diketahui Oleh
        foreach ($read_select as $key => $value) 
        {
          $setting_value=$value->SETTING_VALUE;
        }

        $pdf->Cell( 45,10,$setting_value,'B',0,'L');
        $pdf->Cell( 0.01,10,'','L',0,'L');

        $read_select = $this->m_t_po_print_setting->select_id(5); //Pangkat Diketahui Oleh
        foreach ($read_select as $key => $value) 
        {
          $setting_value=$value->SETTING_VALUE;
        }
        $pdf->Cell( 45,10,'Jabatan: '.$setting_value,'B',0,'L');
        $pdf->Cell( 0.01,10,'','L',1,'L');


        if($r_ket!='')
        {
          $pdf->SetFont('','B',9);
          $pdf->Cell( 45,5,'Keterangan','0',0,'L');
          $pdf->MultiCell(100, 5, substr($r_ket, 0, 500), 0, 'L',0,1);
        }
        
        


       





    


    $pdf->Output("PO_".$r_no_po.".pdf");
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
