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

      class Lap_ranking_sales extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_t_t_penjualan_rincian');
                

            }



            public function index($date_from_laporan,$date_to_laporan,$barang_id,$kategori_id,$sales_id,$pelanggan_id,$supplier_id,$no_polisi_id,$anggota_id,$pemakai_id,$lokasi_id)
            {
              


                  $spreadsheet = new Spreadsheet();


                  $alp='A';
                  $total_colom=3;
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
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'PT. JO PERDANA AGRI TECHNOLOGY');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');


                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Laporan Ranking Sales');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Dari '.date('d-m-Y', strtotime($date_from_laporan)).' Sampai '.date('d-m-Y', strtotime($date_to_laporan)));
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  


                  $row=$row+1;
                  $sheet->setCellValue('A'.$row, 'No');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('B'.$row, 'Nama Sales');
                  $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('C'.$row, 'QTY');
                  $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('D'.$row, 'TOTAL PENJUALAN');
                  $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                  

                        $alp='A';
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

                  $data_logic = 0;
                  $key=0;
                  $read_select = $this->m_t_t_t_penjualan_rincian->select_rekap_sales($date_from_laporan,$date_to_laporan);
                  foreach ($read_select as $key => $value) 
                  {   
                        $data_logic = 1;
                        $r_sales[$key]=$value->SALES;
                        $r_sum_qty[$key]=round($value->SUM_QTY);
                        $r_sub_total[$key]=round($value->SUM_SUB_TOTAL);
                  }
                  $total_data = $key;



                  $sum_sum_total_harga=0;

                  if($data_logic==1)
                  {
                    for($i=0;$i<=$total_data;$i++)
                    {
                              $row=$row+1;
                              $sheet->setCellValue('A'.$row, $i+1);
                              $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                              $sheet->setCellValue('B'.$row, $r_sales[$i]);
                              $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                              $sheet->setCellValue('C'.$row, $r_sum_qty[$i]);
                              $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                              $sheet->setCellValue('D'.$row, $r_sub_total[$i]);
                              $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                        $spreadsheet->getActiveSheet()
                                    ->getStyle('C'.$row.':D'.$row)
                                    ->getNumberFormat()
                                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    }
                  }#end of data logic ==1



                  $writer = new Xlsx($spreadsheet);
                  $filename = 'lap_ranking_sales';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
