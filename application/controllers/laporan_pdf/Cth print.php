<?php

include('web_setting/db_connection.php');
session_start();
date_default_timezone_set('Asia/Jakarta');
$username= $_SESSION['USERNAME'];
$password= $_SESSION['PASSWORD'];
$password2= $_SESSION['PASSWORD2'];
$gudang_id= $_SESSION['GUDANG_ID'];
$level_user_id= $_SESSION['LEVEL_USER_ID'];

$DB_TABLE_NAME_IN = 'T_M_D_LEVEL_USER';
$select_db = "SELECT * FROM {$DB_TABLE_NAME_IN} where LEVEL_USER_ID='{$level_user_id}'";
$select_ex = $conn->prepare($select_db);
$select_ex->execute();
$select_db = $select_ex->fetchAll(PDO::FETCH_BOTH);
if($select_db != NULL)
{
  foreach($select_db as $select_db_a)
  {
    $level_user = ($select_db_a['LEVEL_USER']);
  }
}


$today = date('Y-m-d');
#...............................................go to page by menu
$DB_TABLE_NAME_IN = 'T_M_D_NAMA_GUDANG';
$select_db = "SELECT GUDANG FROM {$DB_TABLE_NAME_IN} where GUDANG_ID='{$gudang_id}'";
$select_ex = $conn->prepare($select_db);
$select_ex->execute();
$select_db = $select_ex->fetchAll(PDO::FETCH_BOTH);
if($select_db != NULL)
{
    foreach($select_db as $select_db_a)
    {
        $nama_gudang = ($select_db_a['GUDANG']);
    }

}
if($select_db == NULL)
{
        $nama_gudang = '';
}

$pembelian_id = $_SESSION['PEMBELIAN_ID'];
$supplier = $_SESSION['SUPPLIER'];
$inv_sp = $_SESSION['INV_SP'];
$inv_mas = $_SESSION['INV_MAS'];
$date = $_SESSION['DATE'];
$time = $_SESSION['TIME'];
$created_by = $_SESSION['CREATED_BY'];


$colom_name[0]='No';
$colom_name[1]='Kode';
$colom_name[2]='Nama Barang';
$colom_name[3]='PN';
$colom_name[4]='Merk';
$colom_name[5]='Qty';
$colom_name[6]='Harga';
$colom_name[7]='Sub Total';
$colom_name[8]='S.Qty';

$colom_name_sql[0]='ID';
$colom_name_sql[1]='BARANG_ID';
$colom_name_sql[2]='BARANG';
$colom_name_sql[3]='BARANG_ID';
$colom_name_sql[4]='BARANG_ID';
$colom_name_sql[5]='QTY';
$colom_name_sql[6]='HARGA';
$colom_name_sql[7]='SUB_TOTAL';
$colom_name_sql[8]='SISA_QTY_TT';

$width[0]=5;
$width[1]=30;
$width[2]=65;
$width[3]=25;
$width[4]=13;
$width[5]=10;
$width[6]=20;
$width[7]=20;
$width[8]=12;


$kolom_total = 7;


$DB_TABLE_NAME = 'T_T_T_PEMBELIAN_RINCIAN';



$select_db = "SELECT {$colom_name_sql[0]} FROM {$DB_TABLE_NAME} where PEMBELIAN_ID = '{$pembelian_id}' and GUDANG_ID='{$gudang_id}'";
$select_ex = $conn->prepare($select_db);
$select_ex->execute();
$select_get = $select_ex->fetchAll(PDO::FETCH_BOTH);
if($select_get != NULL)
{
  foreach($select_get as $select_db_a)
  {
    $grade_id[] = ($select_db_a[$colom_name_sql[0]]);
  }
}
if($select_get == NULL)
{
  $grade_id[0]='';
}
foreach( array_keys($grade_id) as $total_data){}



$select_db = "SELECT * FROM {$DB_TABLE_NAME}  where PEMBELIAN_ID = '{$pembelian_id}' and GUDANG_ID='{$gudang_id}'";
$select_ex = $conn->prepare($select_db);
$select_ex->execute();
$select_get = $select_ex->fetchAll(PDO::FETCH_BOTH);
foreach( array_keys($colom_name_sql) as $total_colom){}
if($select_get!=null)
{
  for($i=0;$i<=$total_colom;$i++)
  {
    
      foreach($select_get as $select_s)
      {
        $colom_data[$i][]= ($select_s[$colom_name_sql[$i]]);
      }
    
  }

  foreach( array_keys($colom_data[0]) as $total_row){}
}


if($select_get==null)
{
  for($i=0;$i<=$total_colom;$i++)
  {
  $colom_data[$i][0]='';
  }
  $total_row=0;
}




require('fpdf17/fpdf.php');

































$last_row=10;


$paper_height=250+($last_row*5);


#$pdf = new FPDF('P','mm','A4');
$pdf = new FPDF('P','mm',array(210,$paper_height));
$pdf->SetMargins(5, 2);





$total_baris_1_bon = 10;
$total_bon = intval($total_row/$total_baris_1_bon);
$starter_loop=0;
$end_loop=($total_baris_1_bon-1);

$total_biaya = 0;
for($a=0;$a<=$total_bon;$a++)
{
  
       $pdf->AddPage();

          //set font to arial, bold, 14pt
          $pdf->SetFont('Arial','B',13);

          //Cell(width , height , text , border , end line , [align] )
          #$this->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'L', false );

          //judul
          $pdf->Cell(190,7,$nama_gudang,0,1,'L');
          $pdf->Cell(190,7,'Bon Pembelian',0,1,'C');



          $pdf->SetFont('Arial','',10);
          //1 of line
          $pdf->Cell(20 ,6,'Inv MAS',0,0);
          $pdf->Cell(80 ,6,': '.$inv_mas,0,0);
          $pdf->Cell(20 ,6,'No Invoice',0,0);
          $pdf->Cell(80 ,6,': '.$inv_sp,0,1);



          $pdf->Cell(20 ,6,'Supplier',0,0);
          $pdf->Cell(80 ,6,': '.$supplier,0,0);
          $pdf->Cell(20 ,6,'Tanggal',0,0);
          $pdf->Cell(80 ,6,': '.$date,0,1);







          for($x=0;$x<=$total_colom;$x++)
          {
            if($x<$total_colom)
            {
              $pdf->Cell($width[$x] ,10,$colom_name[$x],1,0,'C');
            }
            if($x==$total_colom)
            {
              $pdf->Cell($width[$x] ,10,$colom_name[$x],1,1,'C');
            }
          }





          $pdf->SetFont('Arial','',8);


for ($i = $starter_loop; $i <= $end_loop; $i++)
{
  if($i<=$total_row)
  {
    for($x=0;$x<=$total_colom;$x++)
    {
      if($x==0)
      {
        $pdf->Cell($width[$x] ,5,($i+1),'L',0,'C');
      }
      if($x>0 and $x<$total_colom)
      {
        if($x==$kolom_total or $x==6)
        {
          $pdf->Cell($width[$x] ,5,number_format($colom_data[$x][$i])),'',0,'C');
        }
        elseif($x==1) 
        {
          $DB_TABLE_NAME_IN = 'T_M_D_BARANG';
          $select_db = "SELECT * FROM {$DB_TABLE_NAME_IN} where GUDANG_ID='{$gudang_id}' and BARANG_ID='{$colom_data[$x][$i]}'";
          $select_ex = $conn->prepare($select_db);
          $select_ex->execute();
          $select_db = $select_ex->fetchAll(PDO::FETCH_BOTH);
          if($select_db != NULL)
          {
              foreach($select_db as $select_db_a)
              {
                $kode_barang = ($select_db_a['KODE_BARANG']);
                $satuan_id = ($select_db_a['SATUAN_ID']);
                $merk_barang = ($select_db_a['MERK_BARANG']);
                $pn = ($select_db_a['PART_NUMBER']);
              }
            $DB_TABLE_NAME_IN = 'T_M_D_SATUAN';
            $select_db_in = "SELECT * FROM {$DB_TABLE_NAME_IN} where SATUAN_ID='{$satuan_id}'";
            $select_ex_in = $conn->prepare($select_db_in);
            $select_ex_in->execute();
            $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
            if($select_db_in != NULL)
            {
                foreach($select_db_in as $select_db_a_in)
                {
                  $satuan = ($select_db_a_in['SATUAN']);
                }
            }
            if($select_db_in == NULL)
            {
              $satuan = '';
            }
          }
          if($select_db == NULL)
          {
            $kode_barang = '';
            $satuan = '';
            $merk_barang ='';
            $pn = '';
          }

          $pdf->Cell($width[$x] ,5,$kode_barang,'',0,'L');
        }
        
        elseif($x==3)
        {
          $pdf->Cell($width[$x] ,5,$pn,'',0,'L');
        }
        elseif($x==4)
        {
          $pdf->Cell($width[$x] ,5,$merk_barang,'',0,'C');
        }
        elseif($x==5)
        {
          $pdf->Cell($width[$x] ,5,$colom_data[$x][$i].' '.$satuan,'',0,'C');
        }
        
        else
        {
          $pdf->Cell($width[$x] ,5,$colom_data[$x][$i],'',0,'L');
        }
      }
      if($x==$total_colom)
      {
        $pdf->Cell($width[$x] ,5,$colom_data[$x][$i],'R',1,'C');
      }
      if($x==$kolom_total)
      {
        $total_biaya = $total_biaya + intval($colom_data[$x][$i]);
      }
    }
  }
  if($i>=$total_row)
  {
    $pdf->Cell( 100,5,'','L',0,'C');
    $pdf->Cell( 100,5,'','R',1,'C');
  }
}
  $starter_loop = $starter_loop+$total_baris_1_bon;
  $end_loop = $end_loop+($total_baris_1_bon-1);

$width_total_b = 0;
$width_total_a = 0;
for($x=0;$x<=$total_colom;$x++)
{
  if($x<$kolom_total)
  {
    $width_total_b = $width[$x]+$width_total_b;
  }
  if($x>$kolom_total)
  {
    $width_total_a = $width[$x]+$width_total_a;
  }
}

if($total_bon==$a)
{
  $pdf->SetFont('Arial','B',10);
  $pdf->Cell(0.1 ,5,'','L',0,'C');
  $pdf->Cell($width_total_b ,5,'TOTAL BIAYA','T',0,'R');
  $pdf->Cell(0.1 ,5,'','L',0,'C');
  $pdf->Cell($width[$kolom_total] ,5,number_format($total_biaya)),'T',0,'C');
  $pdf->Cell(0.1 ,5,'','L',0,'C');
  $pdf->Cell(($width_total_a-0.3) ,5,'','T',0,'C');
  $pdf->Cell(0.1 ,5,'','L',1,'C');
}

if($total_bon!=$a)
{
  $pdf->SetFont('Arial','B',10);
  $pdf->Cell(0.1 ,5,'','L',0,'C');
  $pdf->Cell($width_total_b ,5,'TOTAL BIAYA','T',0,'R');
  $pdf->Cell(0.1 ,5,'','L',0,'C');
  $pdf->Cell($width[$kolom_total] ,5,'~','T',0,'C');
  $pdf->Cell(0.1 ,5,'','L',0,'C');
  $pdf->Cell(($width_total_a-0.3) ,5,'','T',0,'C');
  $pdf->Cell(0.1 ,5,'','L',1,'C');
}












$pdf->SetFont('Arial','',10);
$pdf->Cell(0.1 ,5,'','L',0,'C');
$pdf->Cell(45 ,5,'Disetujui','T',0,'R');
$pdf->Cell(94.9 ,5,'Dikeluarkan','T',0,'C');
$pdf->Cell(60 ,5,'Diterima','T',0,'C');
$pdf->Cell(0.1 ,5,'','L',1,'C');

$pdf->Cell(0.1 ,15,'','L',0,'C');
$pdf->Cell(45 ,15,'',0,0,'R');
$pdf->Cell(94.9 ,15,'',0,0,'C');
$pdf->Cell(60 ,15,'',0,0,'C');
$pdf->Cell(0.1 ,15,'','L',1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(200 ,5,'Operator: '.$username.' '.date('d-m-Y').' '.date('H:i').' ','T',1,'L');

}





$pdf->Output();
?>



<script type="text/javascript">

 	printlayer('print_this');
    function printlayer(layer)
    {
     var restorepage = document.body.innerHTML;
     var printcontent = document.getElementById(layer).innerHTML;
     document.body.innerHTML = printcontent;
     
     var css = '@page { size: portrait; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

	style.type = 'text/css';
	style.media = 'print';

	if (style.styleSheet){
	  style.styleSheet.cssText = css;
	} else {
	  style.appendChild(document.createTextNode(css));
	}

	head.appendChild(style);

	window.print();
     //window.close();

    }
  </script>
