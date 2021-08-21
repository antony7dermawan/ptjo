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

      class Lap_beli_per_supplier extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_t_t_pembelian');
                $this->load->model('m_t_t_t_pembelian_rincian');
                $this->load->model('m_t_m_d_supplier');

            }



            public function index($date_from_laporan,$date_to_laporan,$barang_id,$kategori_id,$sales_id,$pelanggan_id,$supplier_id,$no_polisi_id,$anggota_id,$pemakai_id,$lokasi_id)
            {
              $this->session->set_userdata('t_t_t_pembelian_delete_logic', '0');

              $total_day=intval(((round(abs(strtotime($date_from_laporan) - strtotime($date_to_laporan)) / (60*60*24),0))+1)/2);


                $date=date_create($date_from_laporan);
                date_add($date,date_interval_create_from_date_string("{$total_day} days"));
                $month_int = intval(date_format($date,"m"));


                  $spreadsheet = new Spreadsheet();


                  $alp='A';
                  $total_colom=20;
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
                  $sheet->setCellValue('A'.$row, 'Laporan Pembelian per Supplier');
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
                  $sheet->setCellValue('E'.$row, 'Nama Supplier');
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('F'.$row, 'INV Supplier');
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('G'.$row, 'Kode');
                  $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('H'.$row, 'Nama Barang');
                  $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('I'.$row, 'Banyaknya');
                  $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('J'.$row, 'Harga');
                  $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('K'.$row, 'Sub Total');
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('L'.$row, 'Sudah Dibayarkan');
                  $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('M'.$row, 'Sisa Hutang');
                  $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('N'.$row, 'Payment Method');
                  $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('O'.$row, 'Created By');
                  $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('P'.$row, 'Updated By');
                  $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=15;
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
                  $read_select = $this->m_t_t_t_pembelian->select_range_date_per_supplier($date_from_laporan,$date_to_laporan,$supplier_id);
                  foreach ($read_select as $key => $value) 
                  {   
                    $data_logic = 1;
                        $r_id[$key]=$value->ID;
                        $r_date[$key]=$value->DATE;
                        $r_time[$key]=$value->TIME;
                        $r_inv[$key]=$value->INV;
                        $r_inv_supplier[$key]=$value->INV_SUPPLIER;
                        $r_ket[$key]=$value->KET;
                        $r_supplier[$key]=$value->SUPPLIER;
                        $r_payment_t[$key]=$value->PAYMENT_T;

                        $r_created_by[$key]=$value->CREATED_BY;
                        $r_updated_by[$key]=$value->UPDATED_BY;
                        $r_payment_method[$key]=$value->PAYMENT_METHOD;
                  }
                  $total_data = $key;



                  $sum_sum_total_harga=0;
                  $sum_sisa_hutang = 0;
                  $sum_payment_t = 0;

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
                            $sheet->setCellValue('E'.$row, $r_supplier[$i]);
                            $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('F'.$row, $r_inv_supplier[$i]);
                            $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('L'.$row, $r_payment_t[$i]);
                            $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('N'.$row, $r_payment_method[$i]);
                            $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');

                            $sheet->setCellValue('O'.$row, $r_created_by[$i]);
                            $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('P'.$row, $r_updated_by[$i]);
                            $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');

                            $spreadsheet->getActiveSheet()
                                  ->getStyle('L'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $read_select = $this->m_t_t_t_pembelian_rincian->select($r_id[$i]);
                        
                        $sum_total_harga = 0;
                        foreach ($read_select as $key => $value) 
                        {
                         
                            $row=$row+1;
                            
                            
                            $sheet->setCellValue('G'.$row, $value->KODE_BARANG);
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('H'.$row, $value->BARANG);
                            $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('I'.$row, $value->QTY);
                            $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('J'.$row, $value->HARGA);
                            $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('K'.$row, $value->SUB_TOTAL);
                            $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                            

                            $sheet->setCellValue('O'.$row, $value->CREATED_BY);
                            $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('P'.$row, $value->UPDATED_BY);
                            $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');
                          

                          $sum_total_harga = $sum_total_harga + $value->SUB_TOTAL;


                          $spreadsheet->getActiveSheet()
                                  ->getStyle('I'.$row.':K'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        }

                        $row = $row + 1;

                        $sisa_hutang = $sum_total_harga - $r_payment_t[$i];

                            $sheet->setCellValue('J'.$row, "TOTAL");
                            $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('K'.$row, $sum_total_harga);
                            $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('L'.$row, $r_payment_t[$i]);
                            $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('M'.$row, $sisa_hutang);
                            $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');

                        $sum_sum_total_harga = $sum_sum_total_harga + $sum_total_harga;
                        $sum_payment_t = $sum_payment_t + $r_payment_t[$i];
                        $sum_sisa_hutang = $sum_sisa_hutang + $sisa_hutang;


                        $alp='A';
                        $total_alp=15;
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
                                  ->getStyle('K'.$row.':M'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                          
                        $row = $row + 1;
                        
                  }


                  $row = $row + 1;
                            $sheet->setCellValue('J'.$row, "TOTAL PEMBELIAN:");
                            $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('K'.$row, $sum_sum_total_harga);
                            $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('L'.$row, $sum_payment_t);
                            $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('M'.$row, $sum_sisa_hutang);
                            $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');
                        $alp='A';
                        $total_alp=15;
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
                                  ->getStyle('K'.$row.':M'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                  

                  }#end of data logic ==1



                  $writer = new Xlsx($spreadsheet);
                  $filename = 'lap_pembelian_per_supplier';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
