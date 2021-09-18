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

      class Lap_saldo_akun_parent_1_per_sub_akun extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_m_a_pks');
                $this->load->model('m_t_t_a_penjualan_pks');
                $this->load->model('m_t_ak_jurnal');
                $this->load->model('m_ak_m_coa');
                $this->load->model('m_ak_m_type');
            }



            public function index($date_from_laporan,$date_to_laporan,$sub_id)
            {
              $total_baris_1_page = 45;
              $baris_1_page = 0;
                  $spreadsheet = new Spreadsheet();


                  
                  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(30);
                  $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                  $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);


                  $row=1;
                  $baris_1_page = $baris_1_page+1;

                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, date('d-m-Y'));
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');



                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'PT Jo Perdana Agri Technology');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Laporan Akun Parent 1 per Sub Akun');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Dari '.date('d-m-Y', strtotime($date_from_laporan)).' Sampai '.date('d-m-Y', strtotime($date_to_laporan)));
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Filtered by: Dari Tanggal, ke Tanggal');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Nama Akun Parent 1');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('J'.$row, 'Saldo');
                  $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('left');


                $total_saldo = 0;

                $read_select = $this->m_ak_m_type->select();
                foreach ($read_select as $key => $value)
                {
                  $type_id[$key]=$value->TYPE_ID;
                  $type[$key]=$value->TYPE;
                }

                $total_type_id = $key;

                for($k=0;$k<=$total_type_id;$k++)
                {

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, $type[$k]);
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $alp='A';
                        $total_alp=11;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                            
                              $alp++;
                        }



                  $total_per_type = 0;
                  $read_select = $this->m_ak_m_coa->select_type_sub_akun($type_id[$k],$date_from_laporan,$date_to_laporan,$sub_id);

                  $logic_db=0;
                  foreach ($read_select as $key => $value) 
                  {
                    
                    $sum_debit=0;
                    $sum_kredit=0;
                    if($value->FAMILY_ID==3)
                    {
                      $read_select_in = $this->m_ak_m_coa->select_sum_family_id_3($value->ID,$date_from_laporan,$date_to_laporan);
                      foreach ($read_select_in as $key_in => $value_in) 
                      {
                        $sum_debit=$value_in->SUM_DEBIT;
                        $sum_kredit=$value_in->SUM_KREDIT;
                      }
                    }
                    if($value->FAMILY_ID==2)
                    {
                      $read_select_in = $this->m_ak_m_coa->select_sum_family_id_2($value->ID,$date_from_laporan,$date_to_laporan);
                      foreach ($read_select_in as $key_in => $value_in) 
                      {
                        $sum_debit=$value_in->SUM_DEBIT;
                        $sum_kredit=$value_in->SUM_KREDIT;
                      }
                    }
                    if($value->FAMILY_ID==1)
                    {
                      $read_select_in = $this->m_ak_m_coa->select_sum_family_id_1($value->ID,$date_from_laporan,$date_to_laporan);
                      foreach ($read_select_in as $key_in => $value_in) 
                      {
                        $sum_debit=$value_in->SUM_DEBIT;
                        $sum_kredit=$value_in->SUM_KREDIT;
                      }
                    }
                      if($value->DB_K_ID==1)
                      {
                        $read_saldo=$sum_debit-$sum_kredit;
                      }
                      if($value->DB_K_ID==2)
                      {
                        $read_saldo=$sum_kredit-$sum_debit;
                      }

                      if($read_saldo!=0)
                      {
                        $logic_db=1;
                        if($value->FAMILY_ID==3)
                        {
                          $total_per_type = $total_per_type + $read_saldo;
                        }
                        $kb_coa_id[$k][]=$value->ID;
                        $kb_no_akun_1[$k][]=$value->NO_AKUN_1;
                        $kb_no_akun_2[$k][]=$value->NO_AKUN_2;
                        $kb_no_akun_3[$k][]=$value->NO_AKUN_3;
                        $kb_nama_akun[$k][]=$value->NAMA_AKUN;
                        $kb_type_id[$k][]=$value->TYPE_ID;
                        $kb_type[$k][]=$value->TYPE;
                        $kb_db_k_id[$k][]=$value->DB_K_ID;
                        $kb_family_id[$k][]=$value->FAMILY_ID;
                        $kb_saldo[$k][]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $kb_coa_id[$k][0]='';
                        $kb_no_akun_1[$k][0]='';
                        $kb_no_akun_2[$k][0]='';
                        $kb_no_akun_3[$k][0]='';
                        $kb_nama_akun[$k][0]='';
                        $kb_type_id[$k][0]='';
                        $kb_type[$k][0]='';
                        $kb_db_k_id[$k][0]='';
                        $kb_family_id[$k][0]='';
                        $kb_saldo[$k][0]='';
                  }
                  
                  foreach( array_keys($kb_coa_id[$k]) as $total_kb_coa_id){}


                  for($i=0;$i<=$total_kb_coa_id;$i++)
                  {
                      if($kb_family_id[$k][$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $kb_nama_akun[$k][$i]);
                        $sheet->setCellValue('J'.$row, $kb_saldo[$k][$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      // if($kb_family_id[$i]==2)
                      // {
                      //   $row=$row+1;
                      //   $baris_1_page = $baris_1_page+1;

                      //   $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                      //   $sheet->setCellValue('C'.$row, $kb_nama_akun[$i]);
                      //   $sheet->setCellValue('J'.$row, $kb_saldo[$i]);



                      //   $spreadsheet->getActiveSheet()
                      //             ->getStyle('J'.$row.':L'.$row)
                      //             ->getNumberFormat()
                      //             ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      // }
                      // if($kb_family_id[$i]==3)
                      // {
                      //   $row=$row+1;
                      //   $baris_1_page = $baris_1_page+1;

                      //   $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                      //   $sheet->setCellValue('D'.$row, $kb_nama_akun[$i]);
                      //   $sheet->setCellValue('J'.$row, $kb_saldo[$i]);



                      //   $spreadsheet->getActiveSheet()
                      //             ->getStyle('J'.$row.':L'.$row)
                      //             ->getNumberFormat()
                      //             ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      // }

                    // //end page checking
                    //   if($baris_1_page>=$total_baris_1_page)
                    //   {

                    //     $row=$row+2;
                    //     $baris_1_page = 0;
                    //     $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    //     $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                    //     $sheet = $spreadsheet->getActiveSheet();
                    //     $sheet->setCellValue('A'.$row, 'ACIEN Business & Accounting Software');
                    //     $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                    //     $row=$row+1;

                    //     $baris_1_page = $baris_1_page+1;
                    //     $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    //     $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                    //     $sheet = $spreadsheet->getActiveSheet();
                    //     $sheet->setCellValue('A'.$row, date('d-m-Y'));
                    //     $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');



                    //     $row=$row+1;
                    //     $baris_1_page = $baris_1_page+1;
                    //     $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    //     $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                    //     $sheet = $spreadsheet->getActiveSheet();
                    //     $sheet->setCellValue('A'.$row, 'PT Jo Perdana Agri Technology');
                    //     $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                    //     $row=$row+1;
                    //     $baris_1_page = $baris_1_page+1;
                    //     $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    //     $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                    //     $sheet = $spreadsheet->getActiveSheet();
                    //     $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
                    //     $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                    //     $row=$row+1;
                    //     $baris_1_page = $baris_1_page+1;
                    //     $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    //     $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                    //     $sheet = $spreadsheet->getActiveSheet();
                    //     $sheet->setCellValue('A'.$row, 'Dari '.date('d-m-Y', strtotime($date_from_laporan)).' Sampai '.date('d-m-Y', strtotime($date_to_laporan)));
                    //     $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                        
                    //     $row=$row+1;
                    //     $baris_1_page = $baris_1_page+1;
                    //     $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    //     $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                    //     $sheet = $spreadsheet->getActiveSheet();
                    //     $sheet->setCellValue('A'.$row, 'Filtered by: Dari Tanggal, ke Tanggal');
                    //     $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                    //     $row=$row+1;
                    //     $baris_1_page = $baris_1_page+1;
                    //     $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                    //     $sheet = $spreadsheet->getActiveSheet();
                    //     $sheet->setCellValue('A'.$row, 'Keterangan');
                    //     $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                    //     $sheet = $spreadsheet->getActiveSheet();
                    //     $sheet->setCellValue('J'.$row, 'Saldo');
                    //     $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('left');
                    //   }
                      //end page checking
                      
                  }


                  $total_saldo = $total_saldo + $total_per_type;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total '.$type[$k]);
                  $sheet->setCellValue('K'.$row, $total_per_type);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Kas dan Bank

                }




                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Total Saldo');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('L'.$row, $total_saldo);
                  $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('left');

                  $alp='A';
                        $total_alp=11;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                            
                              $alp++;
                        }

                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);




     





                  $writer = new Xlsx($spreadsheet);
                  $filename = 'lap_saldo_akun_parent_1_per_sub_akun';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
