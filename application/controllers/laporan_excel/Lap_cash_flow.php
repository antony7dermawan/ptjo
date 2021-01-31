<?php

      use PhpOffice\PhpSpreadsheet\Spreadsheet;
      use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
      use PhpOffice\PhpSpreadsheet\Helper\Sample;
      use PhpOffice\PhpSpreadsheet\IOFactory;
      use PhpOffice\PhpSpreadsheet\RichText\RichText;
      use PhpOffice\PhpSpreadsheet\Shared\Date;
      use PhpOffice\PhpSpreadsheet\Style\Alignment;
      use PhpOffice\PhpSpreadsheet\Style\Border;
      use PhpOffice\PhpSpreadsheet\Style\Color;
      use PhpOffice\PhpSpreadsheet\Style\Fill;
      use PhpOffice\PhpSpreadsheet\Style\Font;
      use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
      use PhpOffice\PhpSpreadsheet\Style\Protection;
      use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
      use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
      use PhpOffice\PhpSpreadsheet\Worksheet\ColumnDimension;
      use PhpOffice\PhpSpreadsheet\Worksheet;

      class Lap_cash_flow extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_m_a_pks');
                $this->load->model('m_t_t_a_penjualan_pks');
                $this->load->model('m_t_ak_jurnal');
                

            }



            public function index($date_from_laporan,$date_to_laporan)
            {
              $total_day=intval(((round(abs(strtotime($date_from_laporan) - strtotime($date_to_laporan)) / (60*60*24),0))+1)/2);


                $date=date_create($date_from_laporan);
                date_add($date,date_interval_create_from_date_string("{$total_day} days"));
                $month_int = intval(date_format($date,"m"));


                  $spreadsheet = new Spreadsheet();


                  $alp='A';
                  $total_colom=15;
                  for($x=0;$x<=$total_colom;$x++)
                  {
                    $spreadsheet->getActiveSheet()
                          ->getColumnDimension($alp)
                          ->setAutoSize(true);
                    $last_colom_alp = $alp;
                    $alp++;
                  }


                  $row=1;

                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':K'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'PT Jo Perdana Agri Technology');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');


                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':K'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Laporan Cash Flow');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':K'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Dari '.date('d-m-Y', strtotime($date_from_laporan)).' Sampai '.date('d-m-Y', strtotime($date_to_laporan)));
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  $area = 'A'.$row.':K'.$row;
                  $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->mergeCells('M'.$row.':N'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('O'.$row.':P'.$row);
                  $sheet->setCellValue('M'.$row, 'Bulanan');
                  $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('O'.$row, 'Harian(30 Hari)');
                  $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');

                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }


                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
                  $sheet->setCellValue('A'.$row, 'Pendapatan:');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }

                  $row=$row+1;
                  $sheet->setCellValue('B'.$row, 'Penjualan TBS');
                  $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('D'.$row, 'Bruto(Kg)');
                  $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('E'.$row, 'Sortase(Kg)');
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('F'.$row, 'Neto(Kg)');
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');

                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }

                        
                  $read_select = $this->m_t_m_a_pks->select();
                  foreach ($read_select as $key => $value) 
                  {
                        $pks_id[$key]=$value->PKS_ID;
                        $pks[$key]=$value->PKS;
                  }
                  $total_pks_id = $key;



                  $total_sum_bruto=0;
                  $total_sum_sortase_kg=0;
                  $total_sum_neto=0;
                  $total_sum_total_penjualan=0;

                  for($i=0;$i<=$total_pks_id;$i++)
                  {
                        $read_select = $this->m_t_t_a_penjualan_pks->select_base_date_pks_id($pks_id[$i],$date_from_laporan,$date_to_laporan);
                        $sum_bruto = 0;
                        $sum_sortase_kg = 0;
                        $sum_neto = 0;
                        $sum_total_penjualan = 0;
                        foreach ($read_select as $key => $value) 
                        {
                              $sum_bruto=$sum_bruto+$value->BRUTO;
                              $sum_sortase_kg=$sum_sortase_kg+$value->SORTASE_KG;
                              $sum_neto=$sum_neto+$value->NETO;
                              $sum_total_penjualan=$sum_total_penjualan+$value->TOTAL_PENJUALAN;
                        }

                        $total_sum_bruto = $total_sum_bruto + $sum_bruto;
                        $total_sum_sortase_kg = $total_sum_sortase_kg + $sum_sortase_kg;
                        $total_sum_neto = $total_sum_neto + $sum_neto;
                        $total_sum_total_penjualan = $total_sum_total_penjualan + $sum_total_penjualan;

                        $row=$row+1;
                        $sheet->setCellValue('B'.$row, '~ '.$pks[$i]);
                        $sheet->setCellValue('D'.$row, $sum_bruto);
                        $sheet->setCellValue('E'.$row, $sum_sortase_kg);
                        $sheet->setCellValue('F'.$row, $sum_neto);
                        $sheet->setCellValue('H'.$row, 'Rp');
                        $sheet->setCellValue('I'.$row, $sum_total_penjualan);


                        $sheet->setCellValue('M'.$row, intval($sum_total_penjualan/$month_int));
                        $sheet->setCellValue('O'.$row, intval($sum_total_penjualan/30));

                        $spreadsheet->getActiveSheet()
                                  ->getStyle('D'.$row.':P'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }
                  }

                  $row = $row+1;
                  $area = 'D'.$row.':K'.$row;
                  $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                  $sheet->setCellValue('D'.$row, $total_sum_bruto);
                  $sheet->setCellValue('E'.$row, $total_sum_sortase_kg);
                  $sheet->setCellValue('F'.$row, $total_sum_neto);
                  $sheet->setCellValue('J'.$row, 'Rp');
                  $sheet->setCellValue('K'.$row, $total_sum_total_penjualan);


                  $sheet->setCellValue('N'.$row, intval($total_sum_total_penjualan/$month_int));
                  $sheet->setCellValue('P'.$row, intval($total_sum_total_penjualan/30));

                  $spreadsheet->getActiveSheet()
                              ->getStyle('D'.$row.':P'.$row)
                              ->getNumberFormat()
                              ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                  

                  $alp='M';
                  $total_alp=3;
                  for($n=0;$n<=$total_alp;$n++)
                  {
                        $area = $alp.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $alp++;
                  }






                  // .................................................................................pendapatan lain lain

                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
                  $sheet->setCellValue('A'.$row, 'Pendapatan lain lain:');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');
                  
                  $alp='M';
                  $total_alp=3;
                  for($n=0;$n<=$total_alp;$n++)
                  {
                        $area = $alp.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $alp++;
                  }
                  

                  $total_saldo = 0;
                  $value_logic=0;
                  $read_select = $this->m_t_ak_jurnal->select_used_jurnal(12,$date_from_laporan,$date_to_laporan);
                  foreach ($read_select as $key => $value) 
                  {
                        $value_logic=1;
                        $a_5_coa_id[$key]=$value->ID;
                        $a_5_no_akun_1[$key]=$value->NO_AKUN_1;
                        $a_5_no_akun_2[$key]=$value->NO_AKUN_2;
                        $a_5_no_akun_3[$key]=$value->NO_AKUN_3;
                        $a_5_db_k_id[$key]=$value->DB_K_ID;
                        $a_5_type_id[$key]=$value->TYPE_ID;
                        $a_5_nama_akun[$key]=$value->NAMA_AKUN;
                        $a_5_sum_debit[$key]=$value->DEBIT;
                        $a_5_sum_kredit[$key]=$value->KREDIT;
                        $a_5_no_voucer[$key]=$value->NO_VOUCER;
                  }

                  $total_a_5_coa_id = $key;

                  if($value_logic==1)
                  {
                        for($i=0;$i<=$total_a_5_coa_id;$i++)
                        {
                          /*
                              $saldo=0;
                              if($a_5_db_k_id[$i]==1)//debit == 1
                              {
                                    $saldo = $a_5_sum_debit[$i]-$a_5_sum_kredit[$i];
                              }

                              if($a_5_db_k_id[$i]==2)//kredit == 2
                              {
                                    $saldo = $a_5_sum_kredit[$i]-$a_5_sum_debit[$i];
                              }
                              */

                              $saldo = $a_5_sum_kredit[$i];

                              $total_saldo = $total_saldo + $saldo;
                              
                              if($a_5_no_akun_3[$i]!='')
                              {
                                    $no_akun=$a_5_no_akun_3[$i];
                              }
                              elseif($a_5_no_akun_2[$i]!='')
                              {
                                    $no_akun=$a_5_no_akun_2[$i];
                              }
                              else
                              {
                                    $no_akun=$a_5_no_akun_1[$i];
                              }
                              $row=$row+1;
                              $sheet->setCellValue('B'.$row, $a_5_no_voucer[$i].'/'.$a_5_nama_akun[$i]);
                              $sheet->setCellValue('H'.$row, 'Rp');
                              $sheet->setCellValue('I'.$row, $saldo);


                              $sheet->setCellValue('M'.$row, intval($saldo/$month_int));
                              $sheet->setCellValue('O'.$row, intval($saldo/30));

                              $spreadsheet->getActiveSheet()
                                        ->getStyle('D'.$row.':P'.$row)
                                        ->getNumberFormat()
                                        ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                              $alp='M';
                              $total_alp=3;
                              for($n=0;$n<=$total_alp;$n++)
                              {
                                    $area = $alp.$row;
                                    $spreadsheet->getActiveSheet()->getStyle($area)
                                              ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                    $spreadsheet->getActiveSheet()->getStyle($area)
                                              ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                    $spreadsheet->getActiveSheet()->getStyle($area)
                                              ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                    $spreadsheet->getActiveSheet()->getStyle($area)
                                              ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                    $alp++;
                              }
                        }
                        $row = $row+1;
                        $area = 'D'.$row.':K'.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                    ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        
                        $sheet->setCellValue('J'.$row, 'Rp');
                        $sheet->setCellValue('K'.$row, $total_saldo);


                        $sheet->setCellValue('N'.$row, intval($total_saldo/$month_int));
                        $sheet->setCellValue('P'.$row, intval($total_saldo/30));

                        $spreadsheet->getActiveSheet()
                                    ->getStyle('D'.$row.':P'.$row)
                                    ->getNumberFormat()
                                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        

                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }




                        

                  }
                  // end...............................................................................pendapatan lain lain

                        $row = $row+1;
                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }

                        $total_pendapatan_kotor = $total_sum_total_penjualan + $total_saldo;
                        $row = $row+1;
                        $spreadsheet->getActiveSheet()->getStyle('K'.$row)->getFont()->setBold(true);
                        $area = 'D'.$row.':K'.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                    ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
                        $sheet->setCellValue('A'.$row, 'Total Pendapatan Kotor');
                        $sheet->setCellValue('J'.$row, 'Rp');
                        $sheet->setCellValue('K'.$row, $total_pendapatan_kotor);


                        $sheet->setCellValue('N'.$row, intval($total_pendapatan_kotor/$month_int));
                        $sheet->setCellValue('P'.$row, intval($total_pendapatan_kotor/30));

                        $spreadsheet->getActiveSheet()
                                    ->getStyle('D'.$row.':P'.$row)
                                    ->getNumberFormat()
                                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }


                        $row = $row+1;
                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }








                  // ...................................................................Biaya Operasional Bulanan:

                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
                  $sheet->setCellValue('A'.$row, 'Biaya Operasional Bulanan:');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');
                  
                  $alp='M';
                  $total_alp=3;
                  for($n=0;$n<=$total_alp;$n++)
                  {
                        $area = $alp.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $alp++;
                  }

                  $total_saldo = 0;
                  $value_logic=0;
                  $read_select = $this->m_t_ak_jurnal->select_used_jurnal(7,$date_from_laporan,$date_to_laporan);
                  foreach ($read_select as $key => $value) 
                  {
                        $value_logic=1;
                        $a_7_coa_id[$key]=$value->ID;
                        $a_7_no_akun_1[$key]=$value->NO_AKUN_1;
                        $a_7_no_akun_2[$key]=$value->NO_AKUN_2;
                        $a_7_no_akun_3[$key]=$value->NO_AKUN_3;
                        $a_7_db_k_id[$key]=$value->DB_K_ID;
                        $a_7_type_id[$key]=$value->TYPE_ID;
                        $a_7_nama_akun[$key]=$value->NAMA_AKUN;
                        $a_7_sum_debit[$key]=$value->DEBIT;
                        $a_7_sum_kredit[$key]=$value->KREDIT;
                        $a_7_no_voucer[$key]=$value->NO_VOUCER;
                  }

                  $total_a_7_coa_id = $key;

                  if($value_logic==1)
                  {
                        for($i=0;$i<=$total_a_7_coa_id;$i++)
                        {
                          /*
                              $saldo=0;
                              if($a_7_db_k_id[$i]==1)//debit == 1
                              {
                                    $saldo = $a_7_sum_debit[$i]-$a_7_sum_kredit[$i];
                              }

                              if($a_7_db_k_id[$i]==2)//kredit == 2
                              {
                                    $saldo = $a_7_sum_kredit[$i]-$a_7_sum_debit[$i];
                              }
                              */

                              $saldo = $a_7_sum_debit[$i];

                              $total_saldo = $total_saldo + $saldo;
                              
                              if($a_7_no_akun_3[$i]!='')
                              {
                                    $no_akun=$a_7_no_akun_3[$i];
                              }
                              elseif($a_7_no_akun_2[$i]!='')
                              {
                                    $no_akun=$a_7_no_akun_2[$i];
                              }
                              else
                              {
                                    $no_akun=$a_7_no_akun_1[$i];
                              }
                              $row=$row+1;
                              $sheet->setCellValue('B'.$row, $a_7_no_voucer[$i].'/'.$a_7_nama_akun[$i]);
                              $sheet->setCellValue('H'.$row, 'Rp');
                              $sheet->setCellValue('I'.$row, $saldo);


                              $sheet->setCellValue('M'.$row, intval($saldo/$month_int));
                              $sheet->setCellValue('O'.$row, intval($saldo/30));

                              $spreadsheet->getActiveSheet()
                                        ->getStyle('D'.$row.':P'.$row)
                                        ->getNumberFormat()
                                        ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                              $alp='M';
                              $total_alp=3;
                              for($n=0;$n<=$total_alp;$n++)
                              {
                                    $area = $alp.$row;
                                    $spreadsheet->getActiveSheet()->getStyle($area)
                                              ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                    $spreadsheet->getActiveSheet()->getStyle($area)
                                              ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                    $spreadsheet->getActiveSheet()->getStyle($area)
                                              ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                    $spreadsheet->getActiveSheet()->getStyle($area)
                                              ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                    $alp++;
                              }
                        }
                        $row = $row+1;
                        $area = 'D'.$row.':K'.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                    ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        
                        $sheet->setCellValue('J'.$row, 'Rp');
                        $sheet->setCellValue('K'.$row, $total_saldo);


                        $sheet->setCellValue('N'.$row, intval($total_saldo/$month_int));
                        $sheet->setCellValue('P'.$row, intval($total_saldo/30));

                        $spreadsheet->getActiveSheet()
                                    ->getStyle('D'.$row.':P'.$row)
                                    ->getNumberFormat()
                                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        

                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }




                        $row = $row+1;
                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }


                  }
                  // end........................................................................Biaya Operasional Bulanan:


                        $total_pengeluaran =  $total_saldo;
                        $row = $row+1;
                        $spreadsheet->getActiveSheet()->getStyle('K'.$row)->getFont()->setBold(true);
                        $area = 'D'.$row.':K'.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                    ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
                        $sheet->setCellValue('A'.$row, 'Total Pengeluaran');
                        $sheet->setCellValue('J'.$row, 'Rp');
                        $sheet->setCellValue('K'.$row, $total_pengeluaran);


                        $sheet->setCellValue('N'.$row, intval($total_pengeluaran/$month_int));
                        $sheet->setCellValue('P'.$row, intval($total_pengeluaran/30));

                        $spreadsheet->getActiveSheet()
                                    ->getStyle('D'.$row.':P'.$row)
                                    ->getNumberFormat()
                                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }

                  $row=$row+1;
                  $alp='M';
                  $total_alp=3;
                  for($n=0;$n<=$total_alp;$n++)
                  {
                        $area = $alp.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                  ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $alp++;
                  }





                        $total_cash_flow_bersih =  $total_pendapatan_kotor-$total_pengeluaran;
                        $row = $row+1;
                        $spreadsheet->getActiveSheet()->getStyle('K'.$row)->getFont()->setBold(true);
                        $area = 'D'.$row.':K'.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                                    ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
                        $sheet->setCellValue('A'.$row, 'Total Cash Flow Bersih');
                        $sheet->setCellValue('J'.$row, 'Rp');
                        $sheet->setCellValue('K'.$row, $total_cash_flow_bersih);


                        $sheet->setCellValue('N'.$row, intval($total_cash_flow_bersih/$month_int));
                        $sheet->setCellValue('P'.$row, intval($total_cash_flow_bersih/30));

                        $spreadsheet->getActiveSheet()
                                    ->getStyle('D'.$row.':P'.$row)
                                    ->getNumberFormat()
                                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $alp='M';
                        $total_alp=3;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }






                  $writer = new Xlsx($spreadsheet);
                  $filename = 'lap_cash_flow';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
