<?php

require 'PhpSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\shared\Date;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

session_start();


$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet()->setTitle("Sheet1");





$spreadsheet->getDefaultStyle()
      ->getFont()
      ->setName('Arial')
      ->setSize(12);


  









include('web_setting/db_connection.php');
$date_to_select=$_SESSION['date_to_select'];
$date_from_select=$_SESSION['date_from_select'];



$gudang_id= $_SESSION['GUDANG_ID'];

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




$link_name = "Refresh:0";
$colom_name[0]='No';
$colom_name[1]='Barang';
$colom_name[2]='Kode Barang';
$colom_name[3]='Part Number';
$colom_name[4]='Posisi';
$colom_name[5]='Stock Awal';


$colom_name[6]='In Date';
$colom_name[7]='In Inv';
$colom_name[8]='In Inv Supplier';
$colom_name[9]='In TNBK';
$colom_name[10]='In QTY';

$colom_name[11]='Out Date';
$colom_name[12]='Out Inv';
$colom_name[13]='Out TNBK';
$colom_name[14]='Out QTY';
$colom_name[15]='Out QTY BARBUT';

$colom_name[16]='Harga';
$colom_name[17]='Stock Akhir';
$colom_name[18]='Cretaed By';
$colom_name[19]='Nama Transaksi';


foreach( array_keys($colom_name) as $total_colom){}



$DB_TABLE_NAME = 'T_T_T_PENJUALAN';




$select_db = "SELECT  DISTINCT(T_M_D_BARANG.PART_NUMBER),T_M_D_BARANG.KODE_BARANG,T_M_D_BARANG.BARANG,T_M_D_BARANG.BARANG_ID,T_M_D_BARANG.POSISI FROM T_M_D_BARANG INNER JOIN T_T_T_PEMBELIAN_RINCIAN ON T_T_T_PEMBELIAN_RINCIAN.BARANG_ID = T_M_D_BARANG.BARANG_ID where T_M_D_BARANG.GUDANG_ID='{$gudang_id}' ";



$select_ex = $conn->prepare($select_db);
$select_ex->execute();
$select_db = $select_ex->fetchAll(PDO::FETCH_BOTH);
if($select_db != NULL)
{
    foreach($select_db as $select_db_a)
    {
        $part_number[] = ($select_db_a['PART_NUMBER']);
        $barang[] = ($select_db_a['BARANG']);
        $barang_id[] = ($select_db_a['BARANG_ID']);
        $posisi[] = ($select_db_a['POSISI']);
        $kode_barang[] = ($select_db_a['KODE_BARANG']);
    }

}
if($select_db == NULL)
{
  $part_number[0] = '';
  $barang[0] = '';
  $barang_id[0] = '';
  $posisi[0] = '';
  $kode_barang[0] = '';
}
foreach( array_keys($barang_id) as $total_barang_id){}


for($i=0;$i<=$total_barang_id;$i++)
{

  $DB_TABLE_NAME_IN = 'T_T_T_PEMBELIAN_RINCIAN';
  $select_db_in = "SELECT sum(SISA_QTY)SISA_QTY FROM {$DB_TABLE_NAME_IN} where BARANG_ID='{$barang_id[$i]}' and (SUPPLIER_ID=0 OR SUPPLIER_ID=1) and GUDANG_ID='{$gudang_id}'";
  $select_ex_in = $conn->prepare($select_db_in);
  $select_ex_in->execute();
  $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
  if($select_db_in != NULL)
  {
    foreach($select_db_in as $select_db_a_in)
    {
      $union_sisa_qty[$i] = ($select_db_a_in['SISA_QTY']);
    }
  }
  if($select_db_in == NULL)
  {
    $union_sisa_qty[0] = '0';
  }
  

  $TABLE_PENJUALAN = 'T_T_T_PENJUALAN';
  $TABLE_PENJUALAN_R = 'T_T_T_PENJUALAN_RINCIAN';
  $TABLE_PEMBELIAN = 'T_T_T_PEMBELIAN';
  $TABLE_PEMBELIAN_R = 'T_T_T_PEMBELIAN_RINCIAN';
  $TABLE_COPOTAN = 'T_T_T_COPOTAN';
  $TABLE_COPOTAN_R = 'T_T_T_COPOTAN_RINCIAN';
  $TABLE_SPK = 'T_T_T_SPK';
  $TABLE_SPK_R = 'T_T_T_SPK_RINCIAN';

  $TABLE_PINLOK = 'T_T_T_PINDAH_LOKASI';
  $TABLE_PINLOK_R='T_T_T_PINLOK_RINCIAN';


  $TABLE_R_PENJUALAN = 'T_T_T_RETUR_PENJUALAN';
  $TABLE_R_PENJUALAN_R = 'T_T_T_RETUR_PENJUALAN_RINCIAN';
  $TABLE_R_PEMBELIAN = 'T_T_T_RETUR_PEMBELIAN';
  $TABLE_R_PEMBELIAN_R = 'T_T_T_RETUR_PEMBELIAN_RINCIAN';
  $TABLE_R_COPOTAN = 'T_T_T_RETUR_COPOTAN';
  $TABLE_R_COPOTAN_R = 'T_T_T_RETUR_COPOTAN_RINCIAN';



  $select_db = "SELECT {$TABLE_PENJUALAN}.CREATED_BY,{$TABLE_PENJUALAN}.TIME,{$TABLE_PENJUALAN_R}.ID,{$TABLE_PENJUALAN}.INV_MAS,{$TABLE_PENJUALAN}.DATE,{$TABLE_PENJUALAN}.GUDANG_ID, {$TABLE_PENJUALAN_R}.BARANG,{$TABLE_PENJUALAN_R}.HARGA,{$TABLE_PENJUALAN_R}.QTY,{$TABLE_PENJUALAN}.TABLE_CODE
FROM {$TABLE_PENJUALAN} INNER JOIN {$TABLE_PENJUALAN_R} ON {$TABLE_PENJUALAN_R}.PENJUALAN_ID = {$TABLE_PENJUALAN}.ID where {$TABLE_PENJUALAN_R}.BARANG_ID='{$barang_id[$i]}' and {$TABLE_PENJUALAN}.DATE>='{$date_from_select}' and {$TABLE_PENJUALAN}.DATE<='{$date_to_select}' and {$TABLE_PENJUALAN}.GUDANG_ID='{$gudang_id}'";
  $select_db .= " UNION ";
  $select_db .= "SELECT {$TABLE_PEMBELIAN}.CREATED_BY,{$TABLE_PEMBELIAN}.TIME,{$TABLE_PEMBELIAN_R}.ID,{$TABLE_PEMBELIAN}.INV_MAS,{$TABLE_PEMBELIAN}.DATE,{$TABLE_PEMBELIAN}.GUDANG_ID, {$TABLE_PEMBELIAN_R}.BARANG,{$TABLE_PEMBELIAN_R}.HARGA,{$TABLE_PEMBELIAN_R}.QTY,{$TABLE_PEMBELIAN}.TABLE_CODE
FROM {$TABLE_PEMBELIAN}
INNER JOIN {$TABLE_PEMBELIAN_R} ON {$TABLE_PEMBELIAN_R}.PEMBELIAN_ID = {$TABLE_PEMBELIAN}.ID where {$TABLE_PEMBELIAN_R}.BARANG_ID='{$barang_id[$i]}' and {$TABLE_PEMBELIAN}.DATE>='{$date_from_select}' and {$TABLE_PEMBELIAN}.DATE<='{$date_to_select}' and ({$TABLE_PEMBELIAN_R}.SUPPLIER_ID=0 or {$TABLE_PEMBELIAN_R}.SUPPLIER_ID=1) and {$TABLE_PEMBELIAN}.GUDANG_ID='{$gudang_id}'";
  $select_db .= " UNION ";
  $select_db .= "SELECT {$TABLE_COPOTAN}.CREATED_BY,{$TABLE_COPOTAN}.TIME,{$TABLE_COPOTAN_R}.ID,{$TABLE_COPOTAN}.INV_MAS,{$TABLE_COPOTAN}.DATE,{$TABLE_COPOTAN}.GUDANG_ID, {$TABLE_COPOTAN_R}.BARANG,{$TABLE_COPOTAN_R}.HARGA,{$TABLE_COPOTAN_R}.QTY,{$TABLE_COPOTAN}.TABLE_CODE
FROM {$TABLE_COPOTAN}
INNER JOIN {$TABLE_COPOTAN_R} ON {$TABLE_COPOTAN_R}.COPOTAN_ID = {$TABLE_COPOTAN}.ID where {$TABLE_COPOTAN_R}.BARANG_ID='{$barang_id[$i]}' and {$TABLE_COPOTAN}.DATE>='{$date_from_select}' and {$TABLE_COPOTAN}.DATE<='{$date_to_select}' and {$TABLE_COPOTAN}.GUDANG_ID='{$gudang_id}'";
  $select_db .= " UNION ";
  $select_db .= "SELECT {$TABLE_R_COPOTAN}.CREATED_BY,{$TABLE_R_COPOTAN}.TIME,{$TABLE_R_COPOTAN_R}.ID,{$TABLE_R_COPOTAN}.INV_MAS,{$TABLE_R_COPOTAN}.DATE,{$TABLE_R_COPOTAN}.GUDANG_ID, {$TABLE_R_COPOTAN_R}.BARANG,{$TABLE_R_COPOTAN_R}.HARGA,{$TABLE_R_COPOTAN_R}.QTY,{$TABLE_R_COPOTAN}.TABLE_CODE
FROM {$TABLE_R_COPOTAN}
INNER JOIN {$TABLE_R_COPOTAN_R} ON {$TABLE_R_COPOTAN_R}.RETUR_COPOTAN_ID = {$TABLE_R_COPOTAN}.ID where {$TABLE_R_COPOTAN_R}.BARANG_ID='{$barang_id[$i]}' and {$TABLE_R_COPOTAN}.DATE>='{$date_from_select}' and {$TABLE_R_COPOTAN}.DATE<='{$date_to_select}' and {$TABLE_R_COPOTAN}.GUDANG_ID='{$gudang_id}'";
  $select_db .= " UNION ";
  $select_db .= "SELECT {$TABLE_R_PEMBELIAN}.CREATED_BY,{$TABLE_R_PEMBELIAN}.TIME,{$TABLE_R_PEMBELIAN_R}.ID,{$TABLE_R_PEMBELIAN}.INV_MAS,{$TABLE_R_PEMBELIAN}.DATE,{$TABLE_R_PEMBELIAN}.GUDANG_ID, {$TABLE_R_PEMBELIAN_R}.BARANG,{$TABLE_R_PEMBELIAN_R}.HARGA,{$TABLE_R_PEMBELIAN_R}.QTY,{$TABLE_R_PEMBELIAN}.TABLE_CODE
FROM {$TABLE_R_PEMBELIAN}
INNER JOIN {$TABLE_R_PEMBELIAN_R} ON {$TABLE_R_PEMBELIAN_R}.RETUR_PEMBELIAN_ID = {$TABLE_R_PEMBELIAN}.ID where {$TABLE_R_PEMBELIAN_R}.BARANG_ID='{$barang_id[$i]}' and {$TABLE_R_PEMBELIAN}.DATE>='{$date_from_select}' and {$TABLE_R_PEMBELIAN}.DATE<='{$date_to_select}' and {$TABLE_R_PEMBELIAN}.GUDANG_ID='{$gudang_id}'";
  $select_db .= " UNION ";
  $select_db .= "SELECT {$TABLE_R_PENJUALAN}.CREATED_BY,{$TABLE_R_PENJUALAN}.TIME,{$TABLE_R_PENJUALAN_R}.ID,{$TABLE_R_PENJUALAN}.INV_MAS,{$TABLE_R_PENJUALAN}.DATE,{$TABLE_R_PENJUALAN}.GUDANG_ID, {$TABLE_R_PENJUALAN_R}.BARANG,{$TABLE_R_PENJUALAN_R}.HARGA,{$TABLE_R_PENJUALAN_R}.QTY,{$TABLE_R_PENJUALAN}.TABLE_CODE
FROM {$TABLE_R_PENJUALAN} INNER JOIN {$TABLE_R_PENJUALAN_R} ON {$TABLE_R_PENJUALAN_R}.RETUR_PENJUALAN_ID = {$TABLE_R_PENJUALAN}.ID where {$TABLE_R_PENJUALAN_R}.BARANG_ID='{$barang_id[$i]}' and {$TABLE_R_PENJUALAN}.DATE>='{$date_from_select}' and {$TABLE_R_PENJUALAN}.DATE<='{$date_to_select}' and {$TABLE_R_PENJUALAN}.GUDANG_ID='{$gudang_id}'";
  $select_db .= " UNION ";
  $select_db .= "SELECT {$TABLE_PINLOK}.CREATED_BY,{$TABLE_PINLOK}.TIME,{$TABLE_PINLOK_R}.ID,{$TABLE_PINLOK}.INV_MAS,{$TABLE_PINLOK}.DATE,{$TABLE_PINLOK}.GUDANG_ID, {$TABLE_PINLOK_R}.BARANG,{$TABLE_PINLOK_R}.HARGA,{$TABLE_PINLOK_R}.QTY,{$TABLE_PINLOK}.TABLE_CODE
FROM {$TABLE_PINLOK} INNER JOIN {$TABLE_PINLOK_R} ON {$TABLE_PINLOK_R}.PINDAH_LOKASI_ID = {$TABLE_PINLOK}.ID where {$TABLE_PINLOK_R}.BARANG_ID='{$barang_id[$i]}' and {$TABLE_PINLOK}.DATE>='{$date_from_select}' and {$TABLE_PINLOK}.DATE<='{$date_to_select}' and {$TABLE_PINLOK}.NEW_GUDANG_ID='{$gudang_id}'";
  $select_db .= " UNION ";
  $select_db .= "SELECT {$TABLE_PINLOK}.CREATED_BY,{$TABLE_PINLOK}.TIME,{$TABLE_PINLOK_R}.ID,{$TABLE_PINLOK}.INV_MAS,{$TABLE_PINLOK}.DATE,{$TABLE_PINLOK}.GUDANG_ID, {$TABLE_PINLOK_R}.BARANG,{$TABLE_PINLOK_R}.HARGA,{$TABLE_PINLOK_R}.QTY,t1.TABLE_CODE FROM {$TABLE_PINLOK} INNER JOIN {$TABLE_PINLOK_R} ON {$TABLE_PINLOK_R}.PINDAH_LOKASI_ID = {$TABLE_PINLOK}.ID INNER JOIN (VALUES ('PINLOK','OUT_PINLOK')) t1 (C1, TABLE_CODE) ON {$TABLE_PINLOK}.TABLE_CODE=t1.C1 where {$TABLE_PINLOK_R}.BARANG_ID='{$barang_id[$i]}' and {$TABLE_PINLOK}.DATE>='{$date_from_select}' and {$TABLE_PINLOK}.DATE<='{$date_to_select}' and {$TABLE_PINLOK}.GUDANG_ID='{$gudang_id}'";



  

  #$select_db .= " UNION ";
  #$select_db .= "SELECT {$TABLE_SPK}.TIME,{$TABLE_SPK}.ID,{$TABLE_SPK}.INV_MAS,{$TABLE_SPK}.DATE,{$TABLE_SPK}.GUDANG_ID, {$TABLE_SPK_R}.BARANG,{$TABLE_SPK_R}.HARGA,{$TABLE_SPK_R}.QTY,{$TABLE_SPK}.TABLE_CODE FROM {$TABLE_SPK} INNER JOIN {$TABLE_SPK_R} ON {$TABLE_SPK_R}.SPK_ID = {$TABLE_SPK}.ID where {$TABLE_SPK_R}.BARANG_ID='{$barang_id[$i]}' and {$TABLE_SPK}.DATE>='{$date_from_select}' and {$TABLE_SPK}.DATE<='{$date_to_select}' and {$TABLE_SPK}.GUDANG_ID='{$gudang_id}'";

  $select_db .= " order by DATE,TIME asc";


  $select_ex = $conn->prepare($select_db);
  $select_ex->execute();
  $select_db = $select_ex->fetchAll(PDO::FETCH_BOTH);
  if($select_db != NULL)
  {
      foreach($select_db as $select_db_a)
      {
          $union_time[$i][] = ($select_db_a['TIME']);
          $union_id[$i][] = ($select_db_a['ID']);
          $union_inv_mas[$i][] = ($select_db_a['INV_MAS']);
          $union_date[$i][] = ($select_db_a['DATE']);
          $union_gudang_id[$i][] = ($select_db_a['GUDANG_ID']);
          $union_barang[$i][] = ($select_db_a['BARANG']);
          $union_harga[$i][] = ($select_db_a['HARGA']);
          $union_created_by[$i][] = ($select_db_a['CREATED_BY']);


          

          $union_qty[$i][] = ($select_db_a['QTY']);
          $union_table_code[$i][] = ($select_db_a['TABLE_CODE']);

      }

  }
  if($select_db == NULL)
  {
    $union_time[$i][0] = '';
    $union_id[$i][0] = '';
    $union_inv_mas[$i][0] = '';
    $union_date[$i][0] = '';
    $union_gudang_id[$i][0] = '';
    $union_barang[$i][0] = '';
    $union_harga[$i][0] = '';
    $union_qty[$i][0] = '';
    $union_table_code[$i][0] ='';
    $union_created_by[$i][0] ='';
  }
  foreach( array_keys($union_id[$i]) as $total_union_id[$i]){}

}





$alp='A';
for($x=0;$x<=$total_colom;$x++)
{
  $spreadsheet->getActiveSheet()
        ->getColumnDimension($alp)
        ->setAutoSize(true);
  $last_colom_alp = $alp;
  $alp++;
}

#$spreadsheet->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFont()->setBold(true);
#$sheet->getStyle('A:B')->getAlignment()->setHorizontal('center');

$row=1;
$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.$last_colom_alp.$row);
$row=$row+1;
$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.$last_colom_alp.$row);
$spreadsheet->getActiveSheet()
      ->setCellValue('A'.$row,$nama_gudang);
$sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

$row=$row+1;
$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.$last_colom_alp.$row);
$spreadsheet->getActiveSheet()
      ->setCellValue('A'.$row,"LAPORAN BARANG");
$sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
$row=$row+1;
$spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.$last_colom_alp.$row);
$spreadsheet->getActiveSheet()
      ->setCellValue('A'.$row,"Periode ".$date_from_select." - ".$date_to_select);
$sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');




$alp='A';
$row=$row+1;
for($x=0;$x<=$total_colom;$x++)
{
    $spreadsheet->getActiveSheet()
      ->setCellValue($alp.$row,$colom_name[$x]);

    $area = $alp.$row;
    $spreadsheet->getActiveSheet()->getStyle($area)
          ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $spreadsheet->getActiveSheet()->getStyle($area)
          ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $spreadsheet->getActiveSheet()->getStyle($area)
          ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    $spreadsheet->getActiveSheet()->getStyle($area)
          ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
  $alp++;
}

$row=$row+1;
$no_row=0;

for($i=0;$i<=$total_barang_id;$i++)
{

  $DB_TABLE_NAME_IN = 'T_T_T_PEMBELIAN_RINCIAN';
  $select_db_in = "SELECT sum(QTY)QTY FROM {$DB_TABLE_NAME_IN} where BARANG_ID='{$barang_id[$i]}' and (SUPPLIER_ID=0 OR SUPPLIER_ID=1) and DATE>='{$date_from_select}' and DATE<='{$date_to_select}' and GUDANG_ID='{$gudang_id}'";
  $select_ex_in = $conn->prepare($select_db_in);
  $select_ex_in->execute();
  $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
  if($select_db_in != NULL)
  {
    foreach($select_db_in as $select_db_a_in)
    {
      $sum_qty_pembelian = floatval($select_db_a_in['QTY']);
    }
  }
  if($select_db_in == NULL)
  {
    $sum_qty_pembelian = '0';
  }

  $DB_TABLE_NAME_IN = 'T_T_T_RETUR_PEMBELIAN_RINCIAN';
  $select_db_in = "SELECT sum(QTY)QTY FROM {$DB_TABLE_NAME_IN} where BARANG_ID='{$barang_id[$i]}' and DATE>='{$date_from_select}' and DATE<='{$date_to_select}' and GUDANG_ID='{$gudang_id}'";
  $select_ex_in = $conn->prepare($select_db_in);
  $select_ex_in->execute();
  $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
  if($select_db_in != NULL)
  {
    foreach($select_db_in as $select_db_a_in)
    {
      $sum_qty_retur_pembelian = floatval($select_db_a_in['QTY']);
    }
  }
  if($select_db_in == NULL)
  {
    $sum_qty_retur_pembelian = '0';
  }

  $DB_TABLE_NAME_IN = 'T_T_T_PENJUALAN_RINCIAN';
  $select_db_in = "SELECT sum(QTY)QTY FROM {$DB_TABLE_NAME_IN} where BARANG_ID='{$barang_id[$i]}' and DATE>='{$date_from_select}' and DATE<='{$date_to_select}' and GUDANG_ID='{$gudang_id}'";
  $select_ex_in = $conn->prepare($select_db_in);
  $select_ex_in->execute();
  $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
  if($select_db_in != NULL)
  {
    foreach($select_db_in as $select_db_a_in)
    {
      $sum_qty_penjualan = floatval($select_db_a_in['QTY']);
    }
  }
  if($select_db_in == NULL)
  {
    $sum_qty_penjualan = '0';
  }

  $DB_TABLE_NAME_IN = 'T_T_T_RETUR_PENJUALAN_RINCIAN';
  $select_db_in = "SELECT sum(QTY)QTY FROM {$DB_TABLE_NAME_IN} where BARANG_ID='{$barang_id[$i]}' and DATE>='{$date_from_select}' and DATE<='{$date_to_select}' and GUDANG_ID='{$gudang_id}'";
  $select_ex_in = $conn->prepare($select_db_in);
  $select_ex_in->execute();
  $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
  if($select_db_in != NULL)
  {
    foreach($select_db_in as $select_db_a_in)
    {
      $sum_qty_retur_penjualan = floatval($select_db_a_in['QTY']);
    }
  }
  if($select_db_in == NULL)
  {
    $sum_qty_retur_penjualan = '0';
  }

  $DB_TABLE_NAME_IN = 'T_T_T_COPOTAN_RINCIAN';
  $select_db_in = "SELECT sum(QTY)QTY FROM {$DB_TABLE_NAME_IN} where BARANG_ID='{$barang_id[$i]}' and DATE>='{$date_from_select}' and DATE<='{$date_to_select}' and GUDANG_ID='{$gudang_id}'";
  $select_ex_in = $conn->prepare($select_db_in);
  $select_ex_in->execute();
  $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
  if($select_db_in != NULL)
  {
    foreach($select_db_in as $select_db_a_in)
    {
      $sum_qty_copotan = floatval($select_db_a_in['QTY']);
    }
  }
  if($select_db_in == NULL)
  {
    $sum_qty_copotan = '0';
  }

  $DB_TABLE_NAME_IN = 'T_T_T_RETUR_COPOTAN_RINCIAN';
  $select_db_in = "SELECT sum(QTY)QTY FROM {$DB_TABLE_NAME_IN} where BARANG_ID='{$barang_id[$i]}' and DATE>='{$date_from_select}' and DATE<='{$date_to_select}' and GUDANG_ID='{$gudang_id}'";
  $select_ex_in = $conn->prepare($select_db_in);
  $select_ex_in->execute();
  $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
  if($select_db_in != NULL)
  {
    foreach($select_db_in as $select_db_a_in)
    {
      $sum_qty_retur_copotan = floatval($select_db_a_in['QTY']);
    }
  }
  if($select_db_in == NULL)
  {
    $sum_qty_retur_copotan = '0';
  }


  $DB_TABLE_NAME_IN = 'T_T_T_PINLOK_RINCIAN';
  $select_db_in = "SELECT sum(QTY)QTY FROM {$DB_TABLE_NAME_IN} where BARANG_ID='{$barang_id[$i]}' and DATE>='{$date_from_select}' and DATE<='{$date_to_select}' and GUDANG_TUJUAN='{$gudang_id}'";
  $select_ex_in = $conn->prepare($select_db_in);
  $select_ex_in->execute();
  $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
  if($select_db_in != NULL)
  {
    foreach($select_db_in as $select_db_a_in)
    {
      $sum_qty_pinlok = floatval($select_db_a_in['QTY']);
    }
  }
  if($select_db_in == NULL)
  {
    $sum_qty_pinlok = '0';
  }

  $DB_TABLE_NAME_IN = 'T_T_T_PINLOK_RINCIAN';
  $select_db_in = "SELECT sum(QTY)QTY FROM {$DB_TABLE_NAME_IN} where BARANG_ID='{$barang_id[$i]}' and DATE>='{$date_from_select}' and DATE<='{$date_to_select}' and GUDANG_ID='{$gudang_id}'";
  $select_ex_in = $conn->prepare($select_db_in);
  $select_ex_in->execute();
  $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
  if($select_db_in != NULL)
  {
    foreach($select_db_in as $select_db_a_in)
    {
      $sum_qty_pinlok_out = floatval($select_db_a_in['QTY']);
    }
  }
  if($select_db_in == NULL)
  {
    $sum_qty_pinlok_out = '0';
  }

#sum copotan gak boleh
  $sisa_qty_excel= ($union_sisa_qty[$i]-($sum_qty_pembelian+$sum_qty_retur_penjualan+0+0))+($sum_qty_penjualan+$sum_qty_retur_pembelian+$sum_qty_retur_copotan+$sum_qty_pinlok_out);

  $stok_awal = $sisa_qty_excel;
  $t_qty_out=0;
  $t_qty_in=0;
  $t_sisa_qty_excel=0;



  if($union_id[$i][0] =='')
  {
    $no_row = $no_row+1;
    $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$row,$no_row)
                ->setCellValue('B'.$row,$barang[$i])
                ->setCellValue('C'.$row,$kode_barang[$i])
                ->setCellValue('D'.$row,$part_number[$i])
                ->setCellValue('E'.$row,$posisi[$i])
                ->setCellValue('F'.$row,$stok_awal)

                ->setCellValue('G'.$row,'') #in date
                ->setCellValue('H'.$row,'') #in inv
                ->setCellValue('I'.$row,'') #in inv sp
                ->setCellValue('J'.$row,'') #in tnbk
                ->setCellValue('K'.$row,'') #in qty
                

                ->setCellValue('L'.$row,'') #out date
                ->setCellValue('M'.$row,'') #out inv
                ->setCellValue('N'.$row,'') #out tnbk
                ->setCellValue('O'.$row,'') #out qty
                ->setCellValue('P'.$row,'') #out qty barbut


                ->setCellValue('Q'.$row,'')
                ->setCellValue('R'.$row,'')
                ->setCellValue('S'.$row,'')
                ->setCellValue('T'.$row,'');
  }

  for($i_in=0;$i_in<=$total_union_id[$i];$i_in++)
  {
    
    if($union_table_code[$i][$i_in]=='PENJUALAN' or $union_table_code[$i][$i_in]=='RETUR_PEMBELIAN' or $union_table_code[$i][$i_in]=='RETUR_COPOTAN' or $union_table_code[$i][$i_in]=='OUT_PINLOK')
    {
      if($union_table_code[$i][$i_in]=='PENJUALAN')
      {
        $DB_TABLE_NAME_IN = 'T_T_T_PENJUALAN';
        $select_db_in = "SELECT T_M_D_PELANGGAN.NO_UNIT,T_M_D_PELANGGAN.TNBK,T_T_T_PENJUALAN_RINCIAN.BARBUT_QTY FROM T_T_T_PENJUALAN_RINCIAN INNER JOIN T_T_T_PENJUALAN on T_T_T_PENJUALAN_RINCIAN.PENJUALAN_ID=T_T_T_PENJUALAN.ID INNER JOIN T_M_D_PELANGGAN on T_T_T_PENJUALAN.TNBK_ID=T_M_D_PELANGGAN.TNBK_ID where T_T_T_PENJUALAN_RINCIAN.ID={$union_id[$i][$i_in]}";
        $select_ex_in = $conn->prepare($select_db_in);
        $select_ex_in->execute();
        $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
        if($select_db_in != NULL)
        {
          foreach($select_db_in as $select_db_a_in)
          {
            $data_tnbk = ($select_db_a_in['TNBK']);
            $data_no_unit = ($select_db_a_in['NO_UNIT']);
            $data_barbut = ($select_db_a_in['BARBUT_QTY']);
          }
        }
        if($select_db_in == NULL)
        {
          $data_tnbk = '';
          $data_barbut = '';
          $data_no_unit = '';
        }
      }

      if($union_table_code[$i][$i_in]=='RETUR_PEMBELIAN' or $union_table_code[$i][$i_in]=='RETUR_COPOTAN' or $union_table_code[$i][$i_in]=='OUT_PINLOK')
      {
        $data_tnbk = '';
        $data_barbut = '';
        $data_no_unit = '';
      }

      $sisa_qty_excel = $sisa_qty_excel - $union_qty[$i][$i_in];
      $no_row = $no_row+1;
      if($i_in==0)
      {
        $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$row,$no_row)
                ->setCellValue('B'.$row,$barang[$i])
                ->setCellValue('C'.$row,$kode_barang[$i])
                ->setCellValue('D'.$row,$part_number[$i])
                ->setCellValue('E'.$row,$posisi[$i])
                ->setCellValue('F'.$row,$stok_awal)

                ->setCellValue('G'.$row,'') #in date
                ->setCellValue('H'.$row,'') #in inv
                ->setCellValue('I'.$row,'') #in inv sp
                ->setCellValue('J'.$row,'') #in tnbk
                ->setCellValue('K'.$row,'') #in qty
                

                ->setCellValue('L'.$row,'') #out date
                ->setCellValue('M'.$row,'') #out inv
                ->setCellValue('N'.$row,'') #out tnbk
                ->setCellValue('O'.$row,'') #out qty
                ->setCellValue('P'.$row,'') #out qty barbut


                ->setCellValue('Q'.$row,'')
                ->setCellValue('R'.$row,'')
                ->setCellValue('S'.$row,'')
                ->setCellValue('T'.$row,'');
        $row=$row+1;
        $no_row = $no_row+1;  
        $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$row,$no_row)
                ->setCellValue('B'.$row,$barang[$i])
                ->setCellValue('C'.$row,$kode_barang[$i])
                ->setCellValue('D'.$row,$part_number[$i])
                ->setCellValue('E'.$row,$posisi[$i])
                ->setCellValue('F'.$row,'')

                ->setCellValue('G'.$row,'') #in date
                ->setCellValue('H'.$row,'') #in inv
                ->setCellValue('I'.$row,'') #in inv sp
                ->setCellValue('J'.$row,'') #in tnbk
                ->setCellValue('K'.$row,'') #in qty
                

                ->setCellValue('L'.$row,$union_date[$i][$i_in].' '.$union_time[$i][$i_in]) #out date
                ->setCellValue('M'.$row,$union_inv_mas[$i][$i_in]) #out inv
                ->setCellValue('N'.$row,$data_no_unit.'/'.$data_tnbk) #out tnbk
                ->setCellValue('O'.$row,$union_qty[$i][$i_in]) #out qty
                ->setCellValue('P'.$row,$data_barbut) #out qty barbut


                ->setCellValue('Q'.$row,$union_harga[$i][$i_in])
                ->setCellValue('R'.$row,$sisa_qty_excel)
                ->setCellValue('S'.$row,$union_created_by[$i][$i_in])
                ->setCellValue('T'.$row,$union_table_code[$i][$i_in]);


      }
      if($i_in>0)
      {
        $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$row,$no_row)
                ->setCellValue('B'.$row,$barang[$i])
                ->setCellValue('C'.$row,$kode_barang[$i])
                ->setCellValue('D'.$row,$part_number[$i])
                ->setCellValue('E'.$row,$posisi[$i])
                ->setCellValue('F'.$row,'') # stok awal

                ->setCellValue('G'.$row,'') #in date
                ->setCellValue('H'.$row,'') #in inv
                ->setCellValue('I'.$row,'') #in inv sp
                ->setCellValue('J'.$row,'') #in tnbk
                ->setCellValue('K'.$row,'') #in qty
                

                ->setCellValue('L'.$row,$union_date[$i][$i_in].' '.$union_time[$i][$i_in]) #out date
                ->setCellValue('M'.$row,$union_inv_mas[$i][$i_in]) #out inv
                ->setCellValue('N'.$row,$data_no_unit.'/'.$data_tnbk) #out tnbk
                ->setCellValue('O'.$row,$union_qty[$i][$i_in]) #out qty
                ->setCellValue('P'.$row,$data_barbut) #out qty barbut


                ->setCellValue('Q'.$row,$union_harga[$i][$i_in])
                ->setCellValue('R'.$row,$sisa_qty_excel)
                ->setCellValue('S'.$row,$union_created_by[$i][$i_in])
                ->setCellValue('T'.$row,$union_table_code[$i][$i_in]);
      }
      
    $t_qty_out = $t_qty_out+ $union_qty[$i][$i_in];
    }

    if($union_table_code[$i][$i_in]=='PEMBELIAN' or $union_table_code[$i][$i_in]=='SPK' or $union_table_code[$i][$i_in]=='COPOTAN' or $union_table_code[$i][$i_in]=='RETUR_PENJUALAN' or $union_table_code[$i][$i_in]=='PINLOK' or $union_table_code[$i][$i_in]=='PEMBELIAN-AUTO')
    {
      $data_inv_sp ='';
      $data_tnbk ='';
      $data_no_unit = '';
      if($union_table_code[$i][$i_in]=='COPOTAN')
      {
        $select_db_in = "SELECT T_M_D_PELANGGAN.NO_UNIT,T_M_D_PELANGGAN.TNBK FROM T_T_T_COPOTAN_RINCIAN INNER JOIN T_T_T_COPOTAN on T_T_T_COPOTAN_RINCIAN.COPOTAN_ID=T_T_T_COPOTAN.ID INNER JOIN T_M_D_PELANGGAN on T_T_T_COPOTAN.TNBK_ID=T_M_D_PELANGGAN.TNBK_ID where T_T_T_COPOTAN_RINCIAN.ID={$union_id[$i][$i_in]}";
        $select_ex_in = $conn->prepare($select_db_in);
        $select_ex_in->execute();
        $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
        if($select_db_in != NULL)
        {
          foreach($select_db_in as $select_db_a_in)
          {
            $data_tnbk = ($select_db_a_in['TNBK']);
            $data_no_unit = ($select_db_a_in['NO_UNIT']);
          }
        }
        if($select_db_in == NULL)
        {
          $data_tnbk = '';
          $data_no_unit = '';
        }
      }
      if($union_table_code[$i][$i_in]=='PEMBELIAN' or $union_table_code[$i][$i_in]=='PEMBELIAN-AUTO' or $union_table_code[$i][$i_in]=='SPK')
      {
        $select_db_in = "SELECT T_T_T_PEMBELIAN.INV_SP FROM T_T_T_PEMBELIAN_RINCIAN INNER JOIN T_T_T_PEMBELIAN on T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID=T_T_T_PEMBELIAN.ID  where T_T_T_PEMBELIAN_RINCIAN.ID={$union_id[$i][$i_in]}";
        $select_ex_in = $conn->prepare($select_db_in);
        $select_ex_in->execute();
        $select_db_in = $select_ex_in->fetchAll(PDO::FETCH_BOTH);
        if($select_db_in != NULL)
        {
          foreach($select_db_in as $select_db_a_in)
          {
            $data_inv_sp = ($select_db_a_in['INV_SP']);
          }
        }
        if($select_db_in == NULL)
        {
          $data_inv_sp = '';
        }
      }


      $sisa_qty_excel = $sisa_qty_excel + $union_qty[$i][$i_in];
      $no_row = $no_row+1;
      if($i_in==0)
      {
        $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$row,$no_row)
                ->setCellValue('B'.$row,$barang[$i])
                ->setCellValue('C'.$row,$kode_barang[$i])
                ->setCellValue('D'.$row,$part_number[$i])
                ->setCellValue('E'.$row,$posisi[$i])
                ->setCellValue('F'.$row,$stok_awal)

                ->setCellValue('G'.$row,'') #in date
                ->setCellValue('H'.$row,'') #in inv
                ->setCellValue('I'.$row,'') #in inv sp
                ->setCellValue('J'.$row,'') #in tnbk
                ->setCellValue('K'.$row,'') #in qty
                

                ->setCellValue('L'.$row,'') #out date
                ->setCellValue('M'.$row,'') #out inv
                ->setCellValue('N'.$row,'') #out tnbk
                ->setCellValue('O'.$row,'') #out qty
                ->setCellValue('P'.$row,'') #out qty barbut


                ->setCellValue('Q'.$row,'')
                ->setCellValue('R'.$row,'')
                ->setCellValue('S'.$row,'')
                ->setCellValue('T'.$row,'');
        $row=$row+1;
        $no_row = $no_row+1;  
        $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$row,$no_row)
                ->setCellValue('B'.$row,$barang[$i])
                ->setCellValue('C'.$row,$kode_barang[$i])
                ->setCellValue('D'.$row,$part_number[$i])
                ->setCellValue('E'.$row,$posisi[$i])
                ->setCellValue('F'.$row,'') # stok awal

                ->setCellValue('G'.$row,$union_date[$i][$i_in].' '.$union_time[$i][$i_in]) #in date
                ->setCellValue('H'.$row,$union_inv_mas[$i][$i_in]) #in inv
                ->setCellValue('I'.$row,$data_inv_sp) #in inv sp
                ->setCellValue('J'.$row,$data_no_unit.'/'.$data_tnbk) #in tnbk
                ->setCellValue('K'.$row,$union_qty[$i][$i_in]) #in qty
                

                ->setCellValue('L'.$row,'') #out date
                ->setCellValue('M'.$row,'') #out inv
                ->setCellValue('N'.$row,'') #out tnbk
                ->setCellValue('O'.$row,'') #out qty
                ->setCellValue('P'.$row,'') #out qty barbut


                ->setCellValue('Q'.$row,$union_harga[$i][$i_in])
                ->setCellValue('R'.$row,$sisa_qty_excel)
                ->setCellValue('S'.$row,$union_created_by[$i][$i_in])
                ->setCellValue('T'.$row,$union_table_code[$i][$i_in]);

      }
      if($i_in>0)
      {
        $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$row,$no_row)
                ->setCellValue('B'.$row,$barang[$i])
                ->setCellValue('C'.$row,$kode_barang[$i])
                ->setCellValue('D'.$row,$part_number[$i])
                ->setCellValue('E'.$row,$posisi[$i])
                ->setCellValue('F'.$row,'') # stok awal

                ->setCellValue('G'.$row,$union_date[$i][$i_in].' '.$union_time[$i][$i_in]) #in date
                ->setCellValue('H'.$row,$union_inv_mas[$i][$i_in]) #in inv
                ->setCellValue('I'.$row,$data_inv_sp) #in inv sp
                ->setCellValue('J'.$row,$data_no_unit.'/'.$data_tnbk) #in tnbk
                ->setCellValue('K'.$row,$union_qty[$i][$i_in]) #in qty
                

                ->setCellValue('L'.$row,'') #out date
                ->setCellValue('M'.$row,'') #out inv
                ->setCellValue('N'.$row,'') #out tnbk
                ->setCellValue('O'.$row,'') #out qty
                ->setCellValue('P'.$row,'') #out qty barbut


                ->setCellValue('Q'.$row,$union_harga[$i][$i_in])
                ->setCellValue('R'.$row,$sisa_qty_excel)
                ->setCellValue('S'.$row,$union_created_by[$i][$i_in])
                ->setCellValue('T'.$row,$union_table_code[$i][$i_in]);
      }
      
    $t_qty_in = $t_qty_in+ $union_qty[$i][$i_in];
    }
    
    $row=$row+1;
  }
    $alp='A';
    for($x=0;$x<=$total_colom;$x++)
    {
      $area = $alp.$row;
      $spreadsheet->getActiveSheet()->getStyle($area)
            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $spreadsheet->getActiveSheet()->getStyle($area)
            ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $spreadsheet->getActiveSheet()->getStyle($alp.$row)
            ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
      $alp++;
    }
    $spreadsheet->getActiveSheet()
                ->setCellValue('E'.$row,'Total')
                ->setCellValue('K'.$row,$t_qty_in)
                ->setCellValue('O'.$row,$t_qty_out)
                ->setCellValue('R'.$row,$union_sisa_qty[$i]);
  $row=$row+3;
}







header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="lap_barang.xlsx"');
$writer = IOFactory::createWriter($spreadsheet,'Xlsx');
$writer->save('php://output');






?>


