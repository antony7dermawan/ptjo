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

      class Lap_pemakaian_per_anggota extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_t_t_pemakaian');
                $this->load->model('m_t_t_t_pemakaian_rincian');
                

            }



            public function index($date_from_laporan,$date_to_laporan,$barang_id,$kategori_id,$sales_id,$pelanggan_id,$supplier_id,$no_polisi_id,$anggota_id,$pemakai_id,$lokasi_id)
            {
              $this->session->set_userdata('t_t_t_pemakaian_delete_logic', '0');

              $total_day=intval(((round(abs(strtotime($date_from_laporan) - strtotime($date_to_laporan)) / (60*60*24),0))+1)/2);


                $date=date_create($date_from_laporan);
                date_add($date,date_interval_create_from_date_string("{$total_day} days"));
                $month_int = intval(date_format($date,"m"));


                  $spreadsheet = new Spreadsheet();


                  $alp='A';
                  $total_colom=21;
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
                  $sheet->setCellValue('A'.$row, 'PT. JO PERDANA AGRI TECHNOLOGY');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');


                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Laporan Pemakaian per Anggota');
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
                  $sheet->setCellValue('B'.$row, 'Tanggal/Jam');
                  $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('C'.$row, 'Keterangan');
                  $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('D'.$row, 'INV');
                  $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('E'.$row, 'Nama Anggota');
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('F'.$row, 'Sales');
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('G'.$row, 'No Polisi');
                  $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('H'.$row, 'Supir');
                  $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('I'.$row, 'Lokasi');
                  $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');

                  $sheet->setCellValue('J'.$row, 'Kode');
                  $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('K'.$row, 'Nama Barang');
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('L'.$row, 'Banyaknya');
                  $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('M'.$row, 'Harga');
                  $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('N'.$row, 'Sub Total');
                  $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('O'.$row, 'Payment Method');
                  $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('P'.$row, 'Created By');
                  $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('Q'.$row, 'Updated By');
                  $sheet->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=16;
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

                  $sales_id = 0;

                  $read_select = $this->m_t_t_t_pemakaian->select_range_date_by_anggota($date_from_laporan,$date_to_laporan,$anggota_id);
                  foreach ($read_select as $key => $value) 
                  {   
                    $data_logic = 1;
                        $r_id[$key]=$value->ID;
                        $r_date[$key]=$value->DATE;
                        $r_time[$key]=$value->TIME;
                        $r_inv[$key]=$value->INV_HEAD.$value->INV;
                        
                        $r_ket[$key]=$value->KET;

                        $r_anggota[$key]=$value->ANGGOTA;
                        $r_sales[$key]=$value->SALES;
                        $r_no_polisi[$key]=$value->NO_POLISI;
                        $r_supir[$key]=$value->SUPIR;
                        $r_lokasi[$key]=$value->LOKASI;

                        $r_created_by[$key]=$value->CREATED_BY;
                        $r_updated_by[$key]=$value->UPDATED_BY;
                        $r_payment_method[$key]=$value->PAYMENT_METHOD;
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
                            $sheet->setCellValue('B'.$row, date('d-m-y', strtotime($r_date[$i])).'/'.date('H:i', strtotime($r_time[$i])));
                            $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('C'.$row, $r_ket[$i]);
                            $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('D'.$row, $r_inv[$i]);
                            $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('E'.$row, $r_anggota[$i]);
                            $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('F'.$row, $r_sales[$i]);
                            $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('G'.$row, $r_no_polisi[$i]);
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('H'.$row, $r_supir[$i]);
                            $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('I'.$row, $r_lokasi[$i]);
                            $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');


                            $sheet->setCellValue('O'.$row, $r_payment_method[$i]);
                            $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('P'.$row, $r_created_by[$i]);
                            $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('Q'.$row, $r_updated_by[$i]);
                            $sheet->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');


                        $read_select = $this->m_t_t_t_pemakaian_rincian->select($r_id[$i]);
                        
                        $sum_total_harga = 0;
                        foreach ($read_select as $key => $value) 
                        {
                         
                            $row=$row+1;
                            
                            
                            $sheet->setCellValue('J'.$row, $value->KODE_BARANG);
                            $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('K'.$row, $value->BARANG);
                            $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('L'.$row, $value->QTY);
                            $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('M'.$row, $value->HARGA);
                            $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('N'.$row, $value->SUB_TOTAL);
                            $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');


                            $sheet->setCellValue('P'.$row, $value->CREATED_BY);
                            $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('Q'.$row, $value->UPDATED_BY);
                            $sheet->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');
                          

                          $sum_total_harga = $sum_total_harga + $value->SUB_TOTAL;


                          $spreadsheet->getActiveSheet()
                                  ->getStyle('L'.$row.':N'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        }

                        $row = $row + 1;


                            $sheet->setCellValue('M'.$row, "TOTAL");
                            $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('N'.$row, $sum_total_harga);
                            $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');

                        $sum_sum_total_harga = $sum_sum_total_harga + $sum_total_harga;

                        $alp='A';
                        $total_alp=16;
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
                                  ->getStyle('N'.$row.':N'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                          
                        $row = $row + 1;
                        
                  }


                  $row = $row + 1;
                            $sheet->setCellValue('M'.$row, "TOTAL PEMAKAIAN:");
                            $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('N'.$row, $sum_sum_total_harga);
                            $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=16;
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
                                  ->getStyle('N'.$row.':N'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                  

                  }#end of data logic ==1



                  $writer = new Xlsx($spreadsheet);
                  $filename = 'Lap_pemakaian_per_anggota';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
