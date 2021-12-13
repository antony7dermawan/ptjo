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

      class Lap_info_stok extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                
                $this->load->model('m_t_m_d_barang');
                

            }



            public function index()
            {


              $this->session->set_userdata('t_m_d_company_delete_logic', '0');
              $this->session->set_userdata('t_m_d_kategori_delete_logic', '0');
              
              $this->session->set_userdata('t_m_d_barang_delete_logic', '0');

             


                  $spreadsheet = new Spreadsheet();


                  $alp='A';
                  $total_colom=13;
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
                  $sheet->setCellValue('A'.$row, 'Laporan Info Stok');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

              
                  


                  $row=$row+1;


                  $alpa='A';
                  $sheet->setCellValue($alpa.$row, 'No');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Kode Barang');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Nama Barang');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Merk Barang');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Part Number');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Posisi');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Qty');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');



                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Harga Jual');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');



                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Min Stock');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Max Stock');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                  $alpa++;

                  $sheet->setCellValue($alpa.$row, 'Kategori');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');

                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Jenis Barang');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                







                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Created By');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');


                  $alpa++;
                  $sheet->setCellValue($alpa.$row, 'Updated By');
                  $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');
                 



                        $alp='A';
                        $total_alp=13;
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

                  $read_select = $this->m_t_m_d_barang->select_info_stock();
                  foreach ($read_select as $key => $value) 
                  {   
                        $data_logic = 1;
                        $r_id[$key]=$value->ID;
                        $r_kode_barang[$key]=$value->KODE_BARANG;
                        $r_barang[$key]=$value->BARANG;
                        $r_merk_barang[$key]=$value->MERK_BARANG;
                        $r_part_number[$key]=$value->PART_NUMBER;
                        $r_posisi[$key]=$value->POSISI;
                        $r_sum_sisa_qty[$key]=$value->SUM_SISA_QTY;
                        $r_harga_jual[$key]=$value->HARGA_JUAL;
                        $r_minimum_stok[$key]=$value->MINIMUM_STOK;
                        $r_maximum_stok[$key]=$value->MAXIMUM_STOK;
                        $r_kategori[$key]=$value->KATEGORI;
                        $r_jenis_barang[$key]=$value->JENIS_BARANG;
             







                        $r_created_by[$key]=$value->CREATED_BY;
                        $r_updated_by[$key]=$value->UPDATED_BY;
                  }
                  $total_data = $key;



                  $sum_all_target_party=0;
                  $sum_all_value_kebun=0;
                  $sum_all_value_pabrik=0;
                  $sum_all_sisa=0;
                  $sum_all_susut=0;

                  if($data_logic==1)
                  {
                  for($i=0;$i<=$total_data;$i++)
                  {
                            $row=$row+1;

                            $alpa='A';
                            $sheet->setCellValue($alpa.$row, $i+1);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');

                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_kode_barang[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('left');



                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_barang[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('left');

                          
                            

                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_merk_barang[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('left');

                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_part_number[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('left');

                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_posisi[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('right');


                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_sum_sisa_qty[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('left');


                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_harga_jual[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('left');


                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_minimum_stok[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('right');



                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_maximum_stok[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('right');


                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_kategori[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('right');



                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_jenis_barang[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('right');




                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_created_by[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');

                            $alpa++;
                            $sheet->setCellValue($alpa.$row, $r_updated_by[$i]);
                            $sheet->getStyle($alpa.$row)->getAlignment()->setHorizontal('center');




                        

                        


                       

                          $spreadsheet->getActiveSheet()
                                  ->getStyle('F'.$row.':S'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                          
                  }


                        

                  

                  }#end of data logic ==1



                  $writer = new Xlsx($spreadsheet);
                  $filename = 'Lap_info_stok';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
