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

      class Lap_flow_barang_per_kategori extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_t_t_penjualan');
                $this->load->model('m_t_t_t_penjualan_rincian');
                $this->load->model('m_t_t_t_retur_penjualan');
                $this->load->model('m_t_t_t_retur_penjualan_rincian');

                $this->load->model('m_t_t_t_pembelian');
                $this->load->model('m_t_t_t_pembelian_rincian');
                $this->load->model('m_t_t_t_retur_pembelian');
                $this->load->model('m_t_t_t_retur_pembelian_rincian');

                $this->load->model('m_t_m_d_barang');



                $this->load->model('m_lap_flow_barang_per_item');
                

            }



            public function index($date_from_laporan,$date_to_laporan,$barang_id,$kategori_id,$sales_id,$pelanggan_id,$supplier_id,$no_polisi_id,$anggota_id)
            {
              $this->session->set_userdata('t_t_t_penjualan_delete_logic', '0');
              $this->session->set_userdata('t_t_t_retur_penjualan_delete_logic', '0');
              $this->session->set_userdata('t_t_t_pembelian_delete_logic', '0');
              $this->session->set_userdata('t_t_t_retur_pembelian_delete_logic', '0');

              $key = 0;

              $first_logic = 0;
              $read_select = $this->m_t_m_d_barang->select_by_kategori($kategori_id);
              foreach ($read_select as $key => $value) 
              {
                $first_logic = 1;
                $array_barang_id[$key] = $value->BARANG_ID;
              }
              $total_array_barang_id = $key;

              


                  $spreadsheet = new Spreadsheet();


                  $alp='A';
                  $total_colom=28;
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
                  $sheet->setCellValue('A'.$row, 'Laporan Flow Barang Per Kategori');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':J'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Dari '.date('d-m-Y', strtotime($date_from_laporan)).' Sampai '.date('d-m-Y', strtotime($date_to_laporan)));
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  
                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->mergeCells('N'.$row.':P'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('N'.$row, 'Info Pembelian');
                  $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');



                  $spreadsheet->getActiveSheet()->mergeCells('Q'.$row.':U'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('Q'.$row, 'Info Penjualan');
                  $sheet->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');

                              $alp='M';
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp='P';
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp='V';
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                  $row=$row+1;
                  $sheet->setCellValue('A'.$row, 'No');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('B'.$row, 'Kode Barang');
                  $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('C'.$row, 'Nama Barang');
                  $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('D'.$row, 'Part Number');
                  $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('E'.$row, 'Merk Barang');
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('F'.$row, 'Date/Time');
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('G'.$row, 'INV');
                  $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('H'.$row, 'Ket');
                  $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('I'.$row, 'Stok Awal');
                  $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('J'.$row, 'QTY');
                  $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');

                  $sheet->setCellValue('K'.$row, 'Harga');
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('L'.$row, 'Sub Total');
                  $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('M'.$row, 'Stok Akhir');
                  $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');



                  $sheet->setCellValue('N'.$row, 'Supplier');
                  $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('O'.$row, 'INV Supplier');
                  $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('P'.$row, 'Payment Method');
                  $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');



                  $sheet->setCellValue('Q'.$row, 'Pelanggan');
                  $sheet->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('R'.$row, 'Sales');
                  $sheet->getStyle('R'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('S'.$row, 'No Polisi');
                  $sheet->getStyle('S'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('T'.$row, 'Supir');
                  $sheet->getStyle('T'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('U'.$row, 'Lokasi');
                  $sheet->getStyle('U'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('V'.$row, 'Payment Method');
                  $sheet->getStyle('V'.$row)->getAlignment()->setHorizontal('center');

                  $sheet->setCellValue('W'.$row, 'Created By');
                  $sheet->getStyle('W'.$row)->getAlignment()->setHorizontal('center');
                  $sheet->setCellValue('X'.$row, 'Updated By');
                  $sheet->getStyle('X'.$row)->getAlignment()->setHorizontal('center');

                              



                        $alp='A';
                        $total_alp=23;
                        for($n=0;$n<=$total_alp;$n++)
                        {
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp++;
                        }


                if($first_logic==1)
                {
                for($k=0;$k<=$total_array_barang_id;$k++)
                {

                
                  $data_logic = 0;
                  $key=0;
                  $read_select = $this->m_lap_flow_barang_per_item->select_range_date($date_from_laporan,$date_to_laporan,$array_barang_id[$k],$kategori_id);
                  foreach ($read_select as $key => $value) 
                  {   
                        $data_logic = 1;
                        $r_kode_barang[$k][$key]=$value->KODE_BARANG;
                        $r_barang[$k][$key]=$value->BARANG;
                        $r_part_number[$k][$key]=$value->PART_NUMBER;
                        $r_merk_barang[$k][$key]=$value->MERK_BARANG;
                        
                        $r_id[$k][$key]=$value->ID;
                        $r_date[$k][$key]=$value->DATE;
                        $r_time[$k][$key]=$value->TIME;
                        $r_ket[$k][$key]=$value->KET;
                        $r_inv[$k][$key]=$value->INV;
                        $r_table_code[$k][$key]=$value->TABLE_CODE;

                        $r_qty[$k][$key]=$value->QTY;
                        $r_harga[$k][$key]=$value->HARGA;
                        $r_sub_total[$k][$key]=$value->SUB_TOTAL;
                        $r_created_by[$k][$key]=$value->CREATED_BY;
                        $r_updated_by[$k][$key]=$value->UPDATED_BY;


                  }
                  $total_data = $key;




                  $sum_sum_total_harga=0;


                  $qty_pembelian =0;
                  $qty_penjualan =0;
                  $qty_retur_pembelian =0;
                  $qty_retur_penjualan =0;


                  if($data_logic==1)
                  {
                    $read_select = $this->m_t_t_t_pembelian_rincian->select_qty_before_date($date_from_laporan,$array_barang_id[$k]);
                    foreach ($read_select as $key => $value) 
                    {
                      $qty_pembelian = floatval($value->SUM_QTY);
                    }

                    $read_select = $this->m_t_t_t_penjualan_rincian->select_qty_before_date($date_from_laporan,$array_barang_id[$k]);
                    foreach ($read_select as $key => $value) 
                    {
                      $qty_penjualan = floatval($value->SUM_QTY);
                    }

                    $read_select = $this->m_t_t_t_retur_pembelian_rincian->select_qty_before_date($date_from_laporan,$array_barang_id[$k]);
                    foreach ($read_select as $key => $value) 
                    {
                      $qty_retur_pembelian = floatval($value->SUM_QTY);
                    }

                    $read_select = $this->m_t_t_t_retur_penjualan_rincian->select_qty_before_date($date_from_laporan,$array_barang_id[$k]);
                    foreach ($read_select as $key => $value) 
                    {
                      $qty_retur_penjualan = floatval($value->SUM_QTY);
                    }
                    $stok_awal = ($qty_pembelian + $qty_retur_penjualan ) - ($qty_penjualan+$qty_retur_pembelian);
                  }
                  if($data_logic==1)
                  {
                  for($i=0;$i<=$total_data;$i++)
                  {

                    if($i==0)
                    {

                      $row=$row+1;
                      $sheet->setCellValue('A'.$row, $i+1);
                      $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
                      $sheet->setCellValue('B'.$row, $r_kode_barang[$k][$i]);
                      $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('left');
                      $sheet->setCellValue('C'.$row, $r_barang[$k][$i]);
                      $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('left');
                      $sheet->setCellValue('D'.$row, $r_part_number[$k][$i]);
                      $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('left');
                      $sheet->setCellValue('E'.$row, $r_merk_barang[$k][$i]);
                      $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('left');


                      $sheet->setCellValue('I'.$row, $stok_awal);
                      $sheet->getStyle('I'.$row)->getAlignment()->setHorizontal('center');

                              $alp='M';
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp='P';
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp='V';
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    }

                    
                            $row=$row+1;
                            

                            if($r_table_code[$k][$i]=='PEMBELIAN')
                            {
                              $stok_awal = $stok_awal + $r_qty[$k][$i];
                              $read_select = $this->m_t_t_t_pembelian->select_by_id($r_id[$k][$i]);
                              foreach ($read_select as $key => $value) 
                              {
                                $supplier = $value->SUPPLIER;
                                $inv_supplier = $value->INV_SUPPLIER;
                                $payment_method = $value->PAYMENT_METHOD;

                                $sheet->setCellValue('N'.$row, $supplier);
                                $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('O'.$row, $inv_supplier);
                                $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('P'.$row, $payment_method);
                                $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');

                              }
                            }


                            if($r_table_code[$k][$i]=='RETUR_PEMBELIAN')
                            {
                              $stok_awal = $stok_awal - $r_qty[$k][$i];
                              $read_select = $this->m_t_t_t_retur_pembelian->select_by_id($r_id[$k][$i]);
                              foreach ($read_select as $key => $value) 
                              {
                                $supplier = $value->SUPPLIER;
                                $inv_supplier = $value->INV_SUPPLIER;
                                $payment_method = $value->PAYMENT_METHOD;

                                $sheet->setCellValue('N'.$row, $supplier);
                                $sheet->getStyle('N'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('O'.$row, $inv_supplier);
                                $sheet->getStyle('O'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('P'.$row, $payment_method);
                                $sheet->getStyle('P'.$row)->getAlignment()->setHorizontal('center');

                              }
                            }



                            if($r_table_code[$k][$i]=='PENJUALAN')
                            {
                              $stok_awal = $stok_awal - $r_qty[$k][$i];
                              $read_select = $this->m_t_t_t_penjualan->select_by_id($r_id[$k][$i]);
                              foreach ($read_select as $key => $value) 
                              {
                                $pelanggan = $value->PELANGGAN;
                                $sales = $value->SALES;
                                $no_polisi = $value->NO_POLISI;
                                $supir = $value->SUPIR;
                                $payment_method = $value->PAYMENT_METHOD;
                                $lokasi = $value->LOKASI;


                                $sheet->setCellValue('Q'.$row, $pelanggan);
                                $sheet->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('R'.$row, $sales);
                                $sheet->getStyle('R'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('S'.$row, $no_polisi);
                                $sheet->getStyle('S'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('T'.$row, $supir);
                                $sheet->getStyle('T'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('U'.$row, $lokasi);
                                $sheet->getStyle('U'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('V'.$row, $payment_method);
                                $sheet->getStyle('V'.$row)->getAlignment()->setHorizontal('center');

                              }
                            }



                            if($r_table_code[$k][$i]=='RETUR_PENJUALAN')
                            {
                              $stok_awal = $stok_awal + $r_qty[$k][$i];
                              $read_select = $this->m_t_t_t_retur_penjualan->select_by_id($r_id[$k][$i]);
                              foreach ($read_select as $key => $value) 
                              {
                                $pelanggan = $value->PELANGGAN;
                                $sales = $value->SALES;
                                $no_polisi = $value->NO_POLISI;
                                $supir = $value->SUPIR;
                                $payment_method = $value->PAYMENT_METHOD;
                                $lokasi = $value->LOKASI;


                                $sheet->setCellValue('Q'.$row, $pelanggan);
                                $sheet->getStyle('Q'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('R'.$row, $sales);
                                $sheet->getStyle('R'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('S'.$row, $no_polisi);
                                $sheet->getStyle('S'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('T'.$row, $supir);
                                $sheet->getStyle('T'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('U'.$row, $lokasi);
                                $sheet->getStyle('U'.$row)->getAlignment()->setHorizontal('center');
                                $sheet->setCellValue('V'.$row, $payment_method);
                                $sheet->getStyle('V'.$row)->getAlignment()->setHorizontal('center');

                              }
                            }

                            
                            $sheet->setCellValue('F'.$row, date('d-m-y', strtotime($r_date[$k][$i])).'/'.date('H:i', strtotime($r_time[$k][$i])));
                            $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('G'.$row, $r_inv[$k][$i]);
                            $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('left');
                            $sheet->setCellValue('H'.$row, $r_ket[$k][$i]);
                            $sheet->getStyle('H'.$row)->getAlignment()->setHorizontal('left');
                            


                            $sheet->setCellValue('J'.$row, $r_qty[$k][$i]);
                            $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('K'.$row, $r_harga[$k][$i]);
                            $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('L'.$row, $r_sub_total[$k][$i]);
                            $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('M'.$row, $stok_awal);
                            $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');

                            


                            
                            $sheet->setCellValue('W'.$row, $r_created_by[$k][$i]);
                            $sheet->getStyle('W'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('X'.$row, $r_updated_by[$k][$i]);
                            $sheet->getStyle('X'.$row)->getAlignment()->setHorizontal('center');
                        
                                               
                              $alp='M';
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp='P';
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                              $alp='V';
                              $area = $alp.$row;
                              $spreadsheet->getActiveSheet()->getStyle($area)
                                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


                        
                          $spreadsheet->getActiveSheet()
                                  ->getStyle('I'.$row.':M'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                          
                        
                  }


                  $row = $row + 1;
                            $sheet->setCellValue('L'.$row, "STOK AKHIR:");
                            $sheet->getStyle('L'.$row)->getAlignment()->setHorizontal('center');
                            $sheet->setCellValue('M'.$row, $stok_awal);
                            $sheet->getStyle('M'.$row)->getAlignment()->setHorizontal('center');

                        $alp='A';
                        $total_alp=23;
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
                                  ->getStyle('M'.$row.':M'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                  

                  }#end of data logic ==1

                }#end loop array barang id
                }#end first logic ==1



                  $writer = new Xlsx($spreadsheet);
                  $filename = 'Lap_flow_barang_per_kategori';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
