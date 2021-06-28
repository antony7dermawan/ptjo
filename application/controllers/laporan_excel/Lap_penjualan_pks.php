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

      class Lap_penjualan_pks extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_t_a_penjualan_pks');
                

            }



            public function index($date_from_laporan,$date_to_laporan)
            {
              $this->session->set_userdata('t_t_t_pembelian_delete_logic', '0');

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
                  $sheet->setCellValue('A'.$row, 'Laporan Penjualan TBS');
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
                  $sheet->setCellValue('B'.$row, 'TANGGAL PENGIRIMAN');
                  $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('C'.$row, 'DIVISI');
                  $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('D'.$row, 'PKS');
                  $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('E'.$row, 'NOMOR POLISI');
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('F'.$row, 'NAMA SUPIR');
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('G'.$row, 'KENDARAAN');
                  $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('H'.$row, 'NO TIKET');
                  $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('I'.$row, 'BRUTO');
                  $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('J'.$row, 'SORTASE (%)');
                  $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('K'.$row, 'SORTASE (Kg)');
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('L'.$row, 'NETO');
                  $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('M'.$row, 'Uang Jalan');
                  $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('N'.$row, 'Harga');
                  $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('O'.$row, 'Total Penjualan');
                  $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('P'.$row, 'PPN');
                  $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('Q'.$row, 'Created By');
                  $sheet->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('R'.$row, 'Updated By');
                  $sheet->getStyle('R'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=17;
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
                  $read_select = $this->m_t_t_a_penjualan_pks->select_laporan($date_from_laporan,$date_to_laporan,0);
                  foreach ($read_select as $key => $value) 
                  {   
                    $data_logic = 1;
                        $r_id[$key]=$value->ID;
                        $r_date[$key]=$value->DATE;
                        $r_divisi[$key]=$value->DIVISI;
                        $r_pks[$key]=$value->PKS;
                        $r_no_polisi[$key]=$value->NO_POLISI;
                        $r_supir[$key]=$value->SUPIR;
                        $r_kendaraan[$key]=$value->KENDARAAN;
                        $r_no_tiket[$key]=$value->NO_TIKET;
                        $r_bruto[$key]=$value->BRUTO;
                        $r_sortase_percentage[$key]=$value->SORTASE_PERCENTAGE;
                        $r_sortase_kg[$key]=$value->SORTASE_KG;
                        $r_neto[$key]=$value->NETO;
                        $r_total_uang_jalan[$key]=$value->TOTAL_UANG_JALAN;
                        $r_harga[$key]=$value->HARGA;
                        $r_total_penjualan[$key]=$value->TOTAL_PENJUALAN;
                        $r_ppn[$key]=$value->PPN;

                        $r_created_by[$key]=$value->CREATED_BY;
                        $r_updated_by[$key]=$value->UPDATED_BY;
                  }
                  $total_data = $key;



                  $sum_neto=0;
                  $sum_uang_jalan=0;
                  $sum_total_penjualan=0;

                  if($data_logic==1)
                  {
                  for($i=0;$i<=$total_data;$i++)
                  {
                            $row=$row+1;
                            $sheet->setCellValue('A'.$row, $i+1);
                            $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('B'.$row, date('d-m-y', strtotime($r_date[$i])) );
                            $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('C'.$row, $r_divisi[$i]);
                            $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('D'.$row, $r_pks[$i]);
                            $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('E'.$row, $r_no_polisi[$i]);
                            $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('F'.$row, $r_supir[$i]);
                            $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('G'.$row, $r_kendaraan[$i]);
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('H'.$row, $r_no_tiket[$i]);
                            $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('I'.$row, $r_bruto[$i]);
                            $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('J'.$row, $r_sortase_percentage[$i]);
                            $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('K'.$row, $r_sortase_kg[$i]);
                            $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');



                            $sheet->setCellValue('L'.$row, $r_neto[$i]);
                            $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('M'.$row, $r_total_uang_jalan[$i]);
                            $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('N'.$row, $r_harga[$i]);
                            $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('O'.$row, $r_total_penjualan[$i]);
                            $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('P'.$row, $r_ppn[$i]);
                            $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('Q'.$row, $r_created_by[$i]);
                            $sheet->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('R'.$row, $r_updated_by[$i]);
                            $sheet->getStyle('R'.$row)->getAlignment()->setHorizontal('center');


                       

                        $sum_neto = $sum_neto + $r_neto[$i];
                        $sum_uang_jalan = $sum_uang_jalan + $r_total_uang_jalan[$i];
                        $sum_total_penjualan = $sum_total_penjualan + $r_total_penjualan[$i];

                        $alp='A';
                        $total_alp=17;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              
                              $alp++;
                        }

                          $spreadsheet->getActiveSheet()
                                  ->getStyle('I'.$row.':P'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                          
                        
                        
                  }


                  $row = $row + 1;
                         
                            $sheet->setCellValue('L'.$row, $sum_neto);
                            $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('M'.$row, $sum_uang_jalan);
                            $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('O'.$row, $sum_total_penjualan);
                            $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=17;
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
                                  ->getStyle('I'.$row.':P'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                  

                  }#end of data logic ==1



                  $writer = new Xlsx($spreadsheet);
                  $filename = 'lap_penjualan_tbs';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
