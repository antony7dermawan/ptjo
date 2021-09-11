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

      class Lap_jurnal_per_sub_akun extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_ak_jurnal');
                

            }



            public function index($date_from_laporan,$date_to_laporan,$sub_id)
            {
              

              $total_day=intval(((round(abs(strtotime($date_from_laporan) - strtotime($date_to_laporan)) / (60*60*24),0))+1)/2);


                $date=date_create($date_from_laporan);
                date_add($date,date_interval_create_from_date_string("{$total_day} days"));
                $month_int = intval(date_format($date,"m"));


                  $spreadsheet = new Spreadsheet();


                  $alp='A';
                  $total_colom=22;
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
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'PT Jo Perdana Agri Technology');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');


                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Laporan Jurnal per Sub Akun');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Dari '.date('d-m-Y', strtotime($date_from_laporan)).' Sampai '.date('d-m-Y', strtotime($date_to_laporan)));
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  


                  $row=$row+1;
                  $sheet->setCellValue('A'.$row, 'No');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('B'.$row, 'No Voucer');
                  $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('C'.$row, 'Date');
                  $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('D'.$row, 'NO AKUN');
                  $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');

                  $sheet->setCellValue('E'.$row, 'Nama Akun');
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('F'.$row, 'Debit');
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('G'.$row, 'Kredit');
                  $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                  
                  $sheet->setCellValue('H'.$row, 'Created By');
                  $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('I'.$row, 'Updated By');
                  $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=8;
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

                  $data_logic = 0;
                  $key=0;
                  $total_debit = 0;
                  $total_kredit = 0;


                  $read_select = $this->m_t_ak_jurnal->select_by_sub_akun($date_from_laporan,$date_to_laporan,$sub_id);
                  foreach ($read_select as $key => $value) 
                  {   
                    $data_logic = 1;
                        if ($value->NO_AKUN_3 != '') {
                          $no_akun[$key] = $value->NO_AKUN_3;
                        } elseif ($value->NO_AKUN_2 != '') {
                          $no_akun[$key] = $value->NO_AKUN_2;
                        } else {
                          $no_akun[$key] = $value->NO_AKUN_1;
                        }

                        $total_debit = intval($value->DEBIT) + $total_debit;
                        $total_kredit = intval($value->KREDIT) + $total_kredit;


                        $no_voucer[$key] = $value->NO_VOUCER;
                        $r_date[$key] = date('d-m-Y', strtotime($value->DATE)) . " / " . date('H:i', strtotime($value->TIME));
                        $nama_akun[$key] = $value->NAMA_AKUN;
                        $debit[$key] = $value->DEBIT;
                        $kredit[$key] = $value->KREDIT;


                        $created_id[$key] = $value->CREATED_ID;
                        $r_created_by[$key]=$value->CREATED_BY;
                        $r_updated_by[$key]=$value->UPDATED_BY;
                  }
                  $total_data = $key;




                  if($data_logic==1)
                  {
                  for($i=0;$i<=$total_data;$i++)
                  {
                            $row=$row+1;
                            $sheet->setCellValue('A'.$row, $i+1);
                            $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('B'.$row, $no_voucer[$i] );
                            $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('C'.$row, $r_date[$i]);
                            $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('D'.$row, $no_akun[$i]);
                            $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('E'.$row, $nama_akun[$i]);
                            $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('F'.$row, $debit[$i]);
                            $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('G'.$row, $kredit[$i]);
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('H'.$row, $r_created_by[$i]);
                            $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('I'.$row, $r_updated_by[$i]);
                            $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');


                    
                        if ( $i > 0 and $created_id[$i] != $created_id[($i - 1)]) 
                        {
                          $alp='A';
                          $total_alp=8;
                          for($n=0;$n<=$total_alp;$n++)
                          {
                                $area = $alp.$row;
                                $spreadsheet->getActiveSheet()->getStyle($area)
                                          ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                
                                
                                $alp++;
                          }
                        }

                          $spreadsheet->getActiveSheet()
                                  ->getStyle('F'.$row.':G'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                          
                        
                        
                  }


                  $row = $row + 1;
                         
                           

                            $sheet->setCellValue('F'.$row, $total_debit);
                            $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('G'.$row, $total_kredit);
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=8;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                              
                              $alp++;
                        }

                          $spreadsheet->getActiveSheet()
                                  ->getStyle('F'.$row.':G'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                  

                  }#end of data logic ==1



                  $writer = new Xlsx($spreadsheet);
                  $filename = 'lap_jurnal_per_sub_akun';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
