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

      class lap_laba_rugi extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_m_a_pks');
                $this->load->model('m_t_t_a_penjualan_pks');
                $this->load->model('m_t_ak_jurnal');
                $this->load->model('m_ak_m_coa');

            }



            public function index($date_from_laporan,$date_to_laporan)
            {
              $total_baris_1_page = 55;
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
                  $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                  $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(2);
                  $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15);


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
                  $sheet->setCellValue('A'.$row, 'Laba Rugi (Standard)');
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
                  $sheet->setCellValue('A'.$row, 'Keterangan');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('J'.$row, 'Saldo');
                  $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('left');




                  // start......................................................total_pendapatan_operasi


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Pendapatan operasi');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_pendapatan_operasi = 0;
                  $read_select = $this->m_ak_m_coa->select_type(5,$date_from_laporan,$date_to_laporan);

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
                        if($value->FAMILY_ID==3)
                        {
                          $total_pendapatan_operasi = $total_pendapatan_operasi + $read_saldo;
                        }
                        $p_coa_id[]=$value->ID;
                        $p_no_akun_1[]=$value->NO_AKUN_1;
                        $p_no_akun_2[]=$value->NO_AKUN_2;
                        $p_no_akun_3[]=$value->NO_AKUN_3;
                        $p_nama_akun[]=$value->NAMA_AKUN;
                        $p_type_id[]=$value->TYPE_ID;
                        $p_type[]=$value->TYPE;
                        $p_db_k_id[]=$value->DB_K_ID;
                        $p_family_id[]=$value->FAMILY_ID;
                        $p_saldo[]=$read_saldo;
                      }
                  }
                  foreach( array_keys($p_coa_id) as $total_p_coa_id){}


                  for($i=0;$i<=$total_p_coa_id;$i++)
                  {
                      if($p_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $p_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $p_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($p_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $p_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $p_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($p_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $p_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $p_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }

                    //end page checking
                      if($baris_1_page>=$total_baris_1_page)
                      {

                        $row=$row+2;
                        $baris_1_page = 0;
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('A'.$row, 'ACIEN Business & Accounting Software');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                        $row=$row+5;

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
                        $sheet->setCellValue('A'.$row, 'Laba Rugi (Standard)');
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
                        $sheet->setCellValue('A'.$row, 'Keterangan');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('J'.$row, 'Saldo');
                        $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('left');
                      }
                      //end page checking
                      
                  }

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Pendapatan operasi');
                  $sheet->setCellValue('K'.$row, $total_pendapatan_operasi);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end total_pendapatan_operasi











                  // start......................................................total_cost_of_goods_sold

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Cost of Goods Sold');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  $total_cost_of_goods_sold = 0;
                  $read_select = $this->m_ak_m_coa->select_type(12,$date_from_laporan,$date_to_laporan);

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
                        if($value->FAMILY_ID==3)
                        {
                          $total_cost_of_goods_sold = $total_cost_of_goods_sold + $read_saldo;
                        }
                        $cg_coa_id[]=$value->ID;
                        $cg_no_akun_1[]=$value->NO_AKUN_1;
                        $cg_no_akun_2[]=$value->NO_AKUN_2;
                        $cg_no_akun_3[]=$value->NO_AKUN_3;
                        $cg_nama_akun[]=$value->NAMA_AKUN;
                        $cg_type_id[]=$value->TYPE_ID;
                        $cg_type[]=$value->TYPE;
                        $cg_db_k_id[]=$value->DB_K_ID;
                        $cg_family_id[]=$value->FAMILY_ID;
                        $cg_saldo[]=$read_saldo;
                      }
                  }
                  foreach( array_keys($cg_coa_id) as $total_cg_coa_id){}


                  for($i=0;$i<=$total_cg_coa_id;$i++)
                  {
                      if($cg_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $cg_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $cg_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($cg_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $cg_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $cg_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($cg_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $cg_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $cg_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }

                      //end page checking
                      if($baris_1_page>=$total_baris_1_page)
                      {

                        $row=$row+2;
                        $baris_1_page = 0;
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('A'.$row, 'ACIEN Business & Accounting Software');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                        $row=$row+5;
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
                        $sheet->setCellValue('A'.$row, 'Laba Rugi (Standard)');
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
                        $sheet->setCellValue('A'.$row, 'Keterangan');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('J'.$row, 'Saldo');
                        $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('left');
                      }
                      //end page checking

                  }

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Cost of Goods Sold');
                  $sheet->setCellValue('K'.$row, $total_cost_of_goods_sold);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end total_cost_of_goods_sold
                  


                  //........................................start pendapatan_kotor
                  
                  $pendapatan_kotor = $total_pendapatan_operasi + $total_cost_of_goods_sold;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'PENDAPATAN KOTOR');
                  $sheet->setCellValue('K'.$row, $pendapatan_kotor);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end pendapatan_kotor












                  // start......................................................beban_operasi

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Beban Operasi');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  $total_beban_operasi = 0;
                  $read_select = $this->m_ak_m_coa->select_type(15,$date_from_laporan,$date_to_laporan);

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
                        if($value->FAMILY_ID==3)
                        {
                          $total_beban_operasi = $total_beban_operasi + $read_saldo;
                        }
                        $bo_coa_id[]=$value->ID;
                        $bo_no_akun_1[]=$value->NO_AKUN_1;
                        $bo_no_akun_2[]=$value->NO_AKUN_2;
                        $bo_no_akun_3[]=$value->NO_AKUN_3;
                        $bo_nama_akun[]=$value->NAMA_AKUN;
                        $bo_type_id[]=$value->TYPE_ID;
                        $bo_type[]=$value->TYPE;
                        $bo_db_k_id[]=$value->DB_K_ID;
                        $bo_family_id[]=$value->FAMILY_ID;
                        $bo_saldo[]=$read_saldo;
                      }
                  }
                  foreach( array_keys($bo_coa_id) as $total_bo_coa_id){}


                  for($i=0;$i<=$total_bo_coa_id;$i++)
                  {
                      if($bo_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $bo_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $bo_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($bo_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $bo_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $bo_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($bo_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $bo_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $bo_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }

                      //end page checking
                      if($baris_1_page>=$total_baris_1_page)
                      {

                        $row=$row+2;
                        $baris_1_page = 0;
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('A'.$row, 'ACIEN Business & Accounting Software');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                        $row=$row+5;
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
                        $sheet->setCellValue('A'.$row, 'Laba Rugi (Standard)');
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
                        $sheet->setCellValue('A'.$row, 'Keterangan');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('J'.$row, 'Saldo');
                        $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('left');
                      }
                      //end page checking

                  }

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Beban Operasi');
                  $sheet->setCellValue('K'.$row, $total_beban_operasi);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end beban_operasi




                  //........................................start pendapatan 1
                  
                  $pendapatan_1 = $pendapatan_kotor - $total_beban_operasi;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'PENDAPATAN');
                  $sheet->setCellValue('K'.$row, $pendapatan_1);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end pendapatan 1











                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Pendapatan lain dan beban');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  // start......................................................total_pendapatan_lain

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Pendapatan lain');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  $total_pendapatan_lain = 0;
                  $read_select = $this->m_ak_m_coa->select_type(12,$date_from_laporan,$date_to_laporan);

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
                        if($value->FAMILY_ID==3)
                        {
                          $total_pendapatan_lain = $total_pendapatan_lain + $read_saldo;
                        }
                        $pl_coa_id[]=$value->ID;
                        $pl_no_akun_1[]=$value->NO_AKUN_1;
                        $pl_no_akun_2[]=$value->NO_AKUN_2;
                        $pl_no_akun_3[]=$value->NO_AKUN_3;
                        $pl_nama_akun[]=$value->NAMA_AKUN;
                        $pl_type_id[]=$value->TYPE_ID;
                        $pl_type[]=$value->TYPE;
                        $pl_db_k_id[]=$value->DB_K_ID;
                        $pl_family_id[]=$value->FAMILY_ID;
                        $pl_saldo[]=$read_saldo;
                      }
                  }
                  foreach( array_keys($pl_coa_id) as $total_pl_coa_id){}


                  for($i=0;$i<=$total_pl_coa_id;$i++)
                  {
                      if($pl_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $pl_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $pl_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($pl_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $pl_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $pl_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($pl_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $pl_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $pl_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }

                      //end page checking
                      if($baris_1_page>=$total_baris_1_page)
                      {

                        $row=$row+2;
                        $baris_1_page = 0;
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('A'.$row, 'ACIEN Business & Accounting Software');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                        $row=$row+5;
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
                        $sheet->setCellValue('A'.$row, 'Laba Rugi (Standard)');
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
                        $sheet->setCellValue('A'.$row, 'Keterangan');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('J'.$row, 'Saldo');
                        $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('left');
                      }
                      //end page checking

                  }

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Pendapatan Lain');
                  $sheet->setCellValue('K'.$row, $total_pendapatan_lain);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end total_pendapatan_lain





                  // start......................................................total_beban_lain_lain

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Pendapatan lain');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  $total_beban_lain_lain = 0;
                  $read_select = $this->m_ak_m_coa->select_type(10,$date_from_laporan,$date_to_laporan);

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
                        if($value->FAMILY_ID==3)
                        {
                          $total_beban_lain_lain = $total_beban_lain_lain + $read_saldo;
                        }
                        $bl_coa_id[]=$value->ID;
                        $bl_no_akun_1[]=$value->NO_AKUN_1;
                        $bl_no_akun_2[]=$value->NO_AKUN_2;
                        $bl_no_akun_3[]=$value->NO_AKUN_3;
                        $bl_nama_akun[]=$value->NAMA_AKUN;
                        $bl_type_id[]=$value->TYPE_ID;
                        $bl_type[]=$value->TYPE;
                        $bl_db_k_id[]=$value->DB_K_ID;
                        $bl_family_id[]=$value->FAMILY_ID;
                        $bl_saldo[]=$read_saldo;
                      }
                  }
                  foreach( array_keys($bl_coa_id) as $total_bl_coa_id){}


                  for($i=0;$i<=$total_bl_coa_id;$i++)
                  {
                      if($bl_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $bl_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $bl_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($bl_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $bl_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $bl_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($bl_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;
                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $bl_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $bl_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }

                      //end page checking
                      if($baris_1_page>=$total_baris_1_page)
                      {

                        $row=$row+2;
                        $baris_1_page = 0;
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('A'.$row, 'ACIEN Business & Accounting Software');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                        $row=$row+5;
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
                        $sheet->setCellValue('A'.$row, 'Laba Rugi (Standard)');
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
                        $sheet->setCellValue('A'.$row, 'Keterangan');
                        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('J'.$row, 'Saldo');
                        $sheet->getStyle('J'.$row)->getAlignment()->setHorizontal('left');
                      }
                      //end page checking

                  }

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Beban lain-lain');
                  $sheet->setCellValue('K'.$row, $total_beban_lain_lain);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end total_beban_lain_lain





                  //........................................start Total Pendapatan lain dan beban
                  
                  $total_pendapatan_lain_dan_beban = $total_pendapatan_lain - $total_beban_lain_lain;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Pendapatan lain dan beban');
                  $sheet->setCellValue('K'.$row, $total_pendapatan_lain_dan_beban);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end Total Pendapatan lain dan beban


                  //........................................start Laba(Rugi) Bersih
                  $laba_rugi_bersih = ($pendapatan_1 + $total_pendapatan_lain)-$total_beban_lain_lain;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Laba(Rugi) Bersih');
                  $sheet->setCellValue('K'.$row, $laba_rugi_bersih);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end Laba(Rugi) Bersih






                  // end page
                  $row=$row+($total_baris_1_page - $baris_1_page);
                  $baris_1_page = 0;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':M'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'ACIEN Business & Accounting Software');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $writer = new Xlsx($spreadsheet);
                  $filename = 'Jurnal_Umum';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>