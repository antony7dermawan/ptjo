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

      class Lap_po extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_po');
                $this->load->model('m_t_po_rincian');
                

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
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'PT Jo Perdana Agri Technology');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');


                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Laporan PO');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Dari '.date('d-m-Y', strtotime($date_from_laporan)).' Sampai '.date('d-m-Y', strtotime($date_to_laporan)));
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  


                  $row=$row+1;
                  $sheet->setCellValue('A'.$row, 'Tanggal');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('B'.$row, 'Supplier');
                  $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('C'.$row, 'No PO');
                  $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('D'.$row, 'Nama Barang');
                  $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('E'.$row, 'QTY');
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('F'.$row, 'Unit');
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('G'.$row, 'Harga Barang');
                  $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('H'.$row, 'Total Harga');
                  $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('I'.$row, 'Keterangan');
                  $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('J'.$row, 'Created By');
                  $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=9;
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

                        
                  $read_select = $this->m_t_po->select_range_date($date_from_laporan,$date_to_laporan);
                  foreach ($read_select as $key => $value) 
                  {
                        $r_id[$key]=$value->ID;
                        $r_date[$key]=$value->DATE;
                        $r_time[$key]=$value->TIME;
                        $r_no_po[$key]=$value->NO_PO;
                        $r_supplier[$key]=$value->SUPPLIER;
                        $r_ket[$key]=$value->KET;
                        $r_created_by[$key]=$value->CREATED_BY;
                  }
                  $total_po_id = $key;



                  $sum_sum_total_harga=0;

                  for($i=0;$i<=$total_po_id;$i++)
                  {
                        $read_select = $this->m_t_po_rincian->select($r_id[$i]);
                        
                        $sum_total_harga = 0;
                        foreach ($read_select as $key => $value) 
                        {
                          if($key==0)
                          {
                            $row=$row+1;
                            $sheet->setCellValue('A'.$row, $r_date[$i]);
                            $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('B'.$row, $r_supplier[$i]);
                            $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('C'.$row, $r_no_po[$i]);
                            $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('D'.$row, $value->NAMA_BARANG);
                            $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('E'.$row, $value->QTY);
                            $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('F'.$row, $value->SATUAN);
                            $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('G'.$row, $value->HARGA);
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('H'.$row, $value->SUB_TOTAL);
                            $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('I'.$row, $r_ket[$i]);
                            $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('J'.$row, $r_created_by[$i]);
                            $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                          }
                          if($key!=0)
                          {
                            $row=$row+1;
                            $sheet->setCellValue('A'.$row, '');
                            $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('B'.$row, $r_supplier[$i]);
                            $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('C'.$row, '');
                            $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('D'.$row, $value->NAMA_BARANG);
                            $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('E'.$row, $value->QTY);
                            $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('F'.$row, $value->SATUAN);
                            $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('G'.$row, $value->HARGA);
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('H'.$row, $value->SUB_TOTAL);
                            $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('I'.$row, $r_ket[$i]);
                            $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('J'.$row, $r_created_by[$i]);
                            $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                          }

                          $sum_total_harga = $sum_total_harga + $value->SUB_TOTAL;


                          $spreadsheet->getActiveSheet()
                                  ->getStyle('E'.$row.':E'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                          $spreadsheet->getActiveSheet()
                                  ->getStyle('G'.$row.':H'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        }

                        $row = $row + 1;


                            $sheet->setCellValue('G'.$row, "TOTAL");
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('H'.$row, $sum_total_harga);
                            $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');

                        $sum_sum_total_harga = $sum_sum_total_harga + $sum_total_harga;

                        $alp='A';
                        $total_alp=9;
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
                                  ->getStyle('E'.$row.':E'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                          $spreadsheet->getActiveSheet()
                                  ->getStyle('G'.$row.':H'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        $row = $row + 1;
                        
                  }


                  $row = $row + 1;
                            $sheet->setCellValue('G'.$row, "TOTAL KESELURUHAN:");
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('H'.$row, $sum_sum_total_harga);
                            $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=9;
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
                                  ->getStyle('E'.$row.':E'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                          $spreadsheet->getActiveSheet()
                                  ->getStyle('G'.$row.':H'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                  





                  $writer = new Xlsx($spreadsheet);
                  $filename = 'lap_po';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
