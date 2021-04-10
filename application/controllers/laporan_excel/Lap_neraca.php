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

      class Lap_neraca extends CI_Controller{

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
                  $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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









                  //...............judul Aktiva Aktiva


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Aktiva Aktiva');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  //...............judul Aktiva Aktiva end





                  //...............judul Aktiva Lancar


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Aktiva Lancar');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  //...............judul Aktiva Lancar end




                  // start......................................................total_Total Kas dan Bank


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Kas dan Bank');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_kas_dan_bank = 0;
                  $read_select = $this->m_ak_m_coa->select_type(4,$date_from_laporan,$date_to_laporan);

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
                          $total_kas_dan_bank = $total_kas_dan_bank + $read_saldo;
                        }
                        $kb_coa_id[]=$value->ID;
                        $kb_no_akun_1[]=$value->NO_AKUN_1;
                        $kb_no_akun_2[]=$value->NO_AKUN_2;
                        $kb_no_akun_3[]=$value->NO_AKUN_3;
                        $kb_nama_akun[]=$value->NAMA_AKUN;
                        $kb_type_id[]=$value->TYPE_ID;
                        $kb_type[]=$value->TYPE;
                        $kb_db_k_id[]=$value->DB_K_ID;
                        $kb_family_id[]=$value->FAMILY_ID;
                        $kb_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $kb_coa_id[0]='';
                        $kb_no_akun_1[0]='';
                        $kb_no_akun_2[0]='';
                        $kb_no_akun_3[0]='';
                        $kb_nama_akun[0]='';
                        $kb_type_id[0]='';
                        $kb_type[0]='';
                        $kb_db_k_id[0]='';
                        $kb_family_id[0]='';
                        $kb_saldo[0]='';
                  }
                  
                  foreach( array_keys($kb_coa_id) as $total_kb_coa_id){}


                  for($i=0;$i<=$total_kb_coa_id;$i++)
                  {
                      if($kb_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $kb_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $kb_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($kb_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $kb_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $kb_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($kb_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $kb_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $kb_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Kas dan Bank');
                  $sheet->setCellValue('K'.$row, $total_kas_dan_bank);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Kas dan Bank
















                  // start......................................................Total Akun Piutang


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Akun Piutang');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_akun_piutang = 0;
                  $read_select = $this->m_ak_m_coa->select_type(6,$date_from_laporan,$date_to_laporan);

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
                          $total_akun_piutang = $total_akun_piutang + $read_saldo;
                        }
                        $ap_coa_id[]=$value->ID;
                        $ap_no_akun_1[]=$value->NO_AKUN_1;
                        $ap_no_akun_2[]=$value->NO_AKUN_2;
                        $ap_no_akun_3[]=$value->NO_AKUN_3;
                        $ap_nama_akun[]=$value->NAMA_AKUN;
                        $ap_type_id[]=$value->TYPE_ID;
                        $ap_type[]=$value->TYPE;
                        $ap_db_k_id[]=$value->DB_K_ID;
                        $ap_family_id[]=$value->FAMILY_ID;
                        $ap_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $ap_coa_id[0]='';
                        $ap_no_akun_1[0]='';
                        $ap_no_akun_2[0]='';
                        $ap_no_akun_3[0]='';
                        $ap_nama_akun[0]='';
                        $ap_type_id[0]='';
                        $ap_type[0]='';
                        $ap_db_k_id[0]='';
                        $ap_family_id[0]='';
                        $ap_saldo[0]='';
                  }
                  
                  foreach( array_keys($ap_coa_id) as $total_ap_coa_id){}


                  for($i=0;$i<=$total_ap_coa_id;$i++)
                  {
                      if($ap_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $ap_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $ap_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($ap_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $ap_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $ap_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($ap_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $ap_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $ap_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Akun Piutang');
                  $sheet->setCellValue('K'.$row, $total_akun_piutang);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Akun Piutang















                  // start......................................................total_persediaan


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Persediaan');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_persediaan = 0;
                  $read_select = $this->m_ak_m_coa->select_type(8,$date_from_laporan,$date_to_laporan);

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
                          $total_persediaan = $total_persediaan + $read_saldo;
                        }
                        $tp_coa_id[]=$value->ID;
                        $tp_no_akun_1[]=$value->NO_AKUN_1;
                        $tp_no_akun_2[]=$value->NO_AKUN_2;
                        $tp_no_akun_3[]=$value->NO_AKUN_3;
                        $tp_nama_akun[]=$value->NAMA_AKUN;
                        $tp_type_id[]=$value->TYPE_ID;
                        $tp_type[]=$value->TYPE;
                        $tp_db_k_id[]=$value->DB_K_ID;
                        $tp_family_id[]=$value->FAMILY_ID;
                        $tp_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $tp_coa_id[0]='';
                        $tp_no_akun_1[0]='';
                        $tp_no_akun_2[0]='';
                        $tp_no_akun_3[0]='';
                        $tp_nama_akun[0]='';
                        $tp_type_id[0]='';
                        $tp_type[0]='';
                        $tp_db_k_id[0]='';
                        $tp_family_id[0]='';
                        $tp_saldo[0]='';
                  }
                  
                  foreach( array_keys($tp_coa_id) as $total_tp_coa_id){}


                  for($i=0;$i<=$total_tp_coa_id;$i++)
                  {
                      if($tp_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $tp_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $tp_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($tp_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $tp_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $tp_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($tp_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $tp_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $tp_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Persediaan');
                  $sheet->setCellValue('K'.$row, $total_persediaan);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Persediaan














                  // start......................................................total_Aktiva Lancar Lainnya


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Aktiva Lancar Lainnya');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_aktiva_lancar_lainnya = 0;
                  $read_select = $this->m_ak_m_coa->select_type(7,$date_from_laporan,$date_to_laporan);

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
                          $total_aktiva_lancar_lainnya = $total_aktiva_lancar_lainnya + $read_saldo;
                        }
                        $al_coa_id[]=$value->ID;
                        $al_no_akun_1[]=$value->NO_AKUN_1;
                        $al_no_akun_2[]=$value->NO_AKUN_2;
                        $al_no_akun_3[]=$value->NO_AKUN_3;
                        $al_nama_akun[]=$value->NAMA_AKUN;
                        $al_type_id[]=$value->TYPE_ID;
                        $al_type[]=$value->TYPE;
                        $al_db_k_id[]=$value->DB_K_ID;
                        $al_family_id[]=$value->FAMILY_ID;
                        $al_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $al_coa_id[0]='';
                        $al_no_akun_1[0]='';
                        $al_no_akun_2[0]='';
                        $al_no_akun_3[0]='';
                        $al_nama_akun[0]='';
                        $al_type_id[0]='';
                        $al_type[0]='';
                        $al_db_k_id[0]='';
                        $al_family_id[0]='';
                        $al_saldo[0]='';
                  }
                  
                  foreach( array_keys($al_coa_id) as $total_al_coa_id){}


                  for($i=0;$i<=$total_al_coa_id;$i++)
                  {
                      if($al_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $al_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $al_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($al_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $al_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $al_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($al_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $al_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $al_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Aktiva lancar lainnya');
                  $sheet->setCellValue('K'.$row, $total_aktiva_lancar_lainnya);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Aktiva lancar lainnya





                  //........................................start Total Aktiva lancar
                  
                  $total_aktiva_lancar = $total_aktiva_lancar_lainnya + $total_persediaan + $total_akun_piutang + $total_kas_dan_bank;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Aktiva lancar');
                  $sheet->setCellValue('K'.$row, $total_aktiva_lancar);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end Total Aktiva lancar





                  //...............judul nilai history





                  //...............judul Aktiva Tetap


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Aktiva Tetap');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  //...............judul Aktiva Tetap end








                  // start......................................................totat_Nilai History


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Nilai History');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_nilai_history = 0;
                  $read_select = $this->m_ak_m_coa->select_type(3,$date_from_laporan,$date_to_laporan);

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
                          $total_nilai_history = $total_nilai_history + $read_saldo;
                        }
                        $at_coa_id[]=$value->ID;
                        $at_no_akun_1[]=$value->NO_AKUN_1;
                        $at_no_akun_2[]=$value->NO_AKUN_2;
                        $at_no_akun_3[]=$value->NO_AKUN_3;
                        $at_nama_akun[]=$value->NAMA_AKUN;
                        $at_type_id[]=$value->TYPE_ID;
                        $at_type[]=$value->TYPE;
                        $at_db_k_id[]=$value->DB_K_ID;
                        $at_family_id[]=$value->FAMILY_ID;
                        $at_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $at_coa_id[0]='';
                        $at_no_akun_1[0]='';
                        $at_no_akun_2[0]='';
                        $at_no_akun_3[0]='';
                        $at_nama_akun[0]='';
                        $at_type_id[0]='';
                        $at_type[0]='';
                        $at_db_k_id[0]='';
                        $at_family_id[0]='';
                        $at_saldo[0]='';
                  }
                  
                  foreach( array_keys($at_coa_id) as $totat_at_coa_id){}


                  for($i=0;$i<=$totat_at_coa_id;$i++)
                  {
                      if($at_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $at_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $at_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($at_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $at_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $at_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($at_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $at_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $at_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Nilai History');
                  $sheet->setCellValue('K'.$row, $total_nilai_history);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end total_nilai_history












                  // start.....................................................Total Akumulasi Penyusutan


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Akumulasi Penyusutan');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_akumulasi_penyusutan = 0;
                  $read_select = $this->m_ak_m_coa->select_type(14,$date_from_laporan,$date_to_laporan);

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
                          $total_akumulasi_penyusutan = $total_akumulasi_penyusutan + $read_saldo;
                        }
                        $ap_coa_id[]=$value->ID;
                        $ap_no_akun_1[]=$value->NO_AKUN_1;
                        $ap_no_akun_2[]=$value->NO_AKUN_2;
                        $ap_no_akun_3[]=$value->NO_AKUN_3;
                        $ap_nama_akun[]=$value->NAMA_AKUN;
                        $ap_type_id[]=$value->TYPE_ID;
                        $ap_type[]=$value->TYPE;
                        $ap_db_k_id[]=$value->DB_K_ID;
                        $ap_family_id[]=$value->FAMILY_ID;
                        $ap_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $ap_coa_id[0]='';
                        $ap_no_akun_1[0]='';
                        $ap_no_akun_2[0]='';
                        $ap_no_akun_3[0]='';
                        $ap_nama_akun[0]='';
                        $ap_type_id[0]='';
                        $ap_type[0]='';
                        $ap_db_k_id[0]='';
                        $ap_family_id[0]='';
                        $ap_saldo[0]='';
                  }
                  
                  foreach( array_keys($ap_coa_id) as $totap_ap_coa_id){}


                  for($i=0;$i<=$totap_ap_coa_id;$i++)
                  {
                      if($ap_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $ap_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $ap_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($ap_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $ap_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $ap_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($ap_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $ap_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $ap_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Akumulasi Penyusutan');
                  $sheet->setCellValue('K'.$row, $total_akumulasi_penyusutan);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Akumulasi Penyusutan






                  //........................................start Total Aktiva Tetap
                  
                  $total_aktiva_tetap = $total_akumulasi_penyusutan + $total_nilai_history ;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Aktiva Tetap');
                  $sheet->setCellValue('K'.$row, $total_aktiva_tetap);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end Total Aktiva Tetap





                  //........................................start Total Aktiva Aktiva
                  
                  $total_aktiva_aktiva = $total_aktiva_lancar + $total_aktiva_tetap ;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Aktiva Aktiva');
                  $sheet->setCellValue('K'.$row, $total_aktiva_aktiva);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end Total Aktiva Aktiva







                  //...............judul Kewajiban dan Ekuitas


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Kewajiban dan Ekuitas');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  //...............judul Kewajiban dan Ekuitas end





                  //...............judul Kewajiban


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Kewajiban');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  //...............judul Kewajiban end




                  //...............judul Kewajiban Lancar


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Kewajiban Lancar');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  //...............judul Kewajiban Lancar end










                  // start.....................................................total_akun_akun_hutang


                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Akun-Akun Hutang');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_akun_akun_hutang = 0;
                  $read_select = $this->m_ak_m_coa->select_type(9,$date_from_laporan,$date_to_laporan);

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
                          $total_akun_akun_hutang = $total_akun_akun_hutang + $read_saldo;
                        }
                        $ah_coa_id[]=$value->ID;
                        $ah_no_akun_1[]=$value->NO_AKUN_1;
                        $ah_no_akun_2[]=$value->NO_AKUN_2;
                        $ah_no_akun_3[]=$value->NO_AKUN_3;
                        $ah_nama_akun[]=$value->NAMA_AKUN;
                        $ah_type_id[]=$value->TYPE_ID;
                        $ah_type[]=$value->TYPE;
                        $ah_db_k_id[]=$value->DB_K_ID;
                        $ah_family_id[]=$value->FAMILY_ID;
                        $ah_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $ah_coa_id[0]='';
                        $ah_no_akun_1[0]='';
                        $ah_no_akun_2[0]='';
                        $ah_no_akun_3[0]='';
                        $ah_nama_akun[0]='';
                        $ah_type_id[0]='';
                        $ah_type[0]='';
                        $ah_db_k_id[0]='';
                        $ah_family_id[0]='';
                        $ah_saldo[0]='';
                  }
                  
                  foreach( array_keys($ah_coa_id) as $totah_ah_coa_id){}


                  for($i=0;$i<=$totah_ah_coa_id;$i++)
                  {
                      if($ah_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $ah_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $ah_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($ah_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $ah_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $ah_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($ah_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $ah_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $ah_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Akun-Akun Hutang');
                  $sheet->setCellValue('K'.$row, $total_akun_akun_hutang);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Akun-Akun Hutang












                  // start.....................................................total_Kewajiban lancar lain

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Kewajiban Lancar Lain');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_kewajiban_lancar_lain = 0;
                  $read_select = $this->m_ak_m_coa->select_type(11,$date_from_laporan,$date_to_laporan);

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
                          $total_kewajiban_lancar_lain = $total_kewajiban_lancar_lain + $read_saldo;
                        }
                        $kll_coa_id[]=$value->ID;
                        $kll_no_akun_1[]=$value->NO_AKUN_1;
                        $kll_no_akun_2[]=$value->NO_AKUN_2;
                        $kll_no_akun_3[]=$value->NO_AKUN_3;
                        $kll_nama_akun[]=$value->NAMA_AKUN;
                        $kll_type_id[]=$value->TYPE_ID;
                        $kll_type[]=$value->TYPE;
                        $kll_db_k_id[]=$value->DB_K_ID;
                        $kll_family_id[]=$value->FAMILY_ID;
                        $kll_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $kll_coa_id[0]='';
                        $kll_no_akun_1[0]='';
                        $kll_no_akun_2[0]='';
                        $kll_no_akun_3[0]='';
                        $kll_nama_akun[0]='';
                        $kll_type_id[0]='';
                        $kll_type[0]='';
                        $kll_db_k_id[0]='';
                        $kll_family_id[0]='';
                        $kll_saldo[0]='';
                  }
                  
                  foreach( array_keys($kll_coa_id) as $totkll_kll_coa_id){}


                  for($i=0;$i<=$totkll_kll_coa_id;$i++)
                  {
                      if($kll_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $kll_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $kll_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($kll_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $kll_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $kll_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($kll_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $kll_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $kll_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Kewajiban Lancar Lain');
                  $sheet->setCellValue('K'.$row, $total_kewajiban_lancar_lain);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Kewajiban Lancar Lain




                  //........................................start Total Kewajiban lancar
                  
                  $total_kewajiban_lancar = $total_akun_akun_hutang + $total_kewajiban_lancar_lain;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Kewajiban lancar');
                  $sheet->setCellValue('K'.$row, $total_kewajiban_lancar);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end Total Kewajiban lancar


                  





                  // start.....................................................total_kewajiban_jangka_panjang

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Kewajiban Jangka Panjang');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_kewajiban_jangka_panjang = 0;
                  $read_select = $this->m_ak_m_coa->select_type(13,$date_from_laporan,$date_to_laporan);

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
                          $total_kewajiban_jangka_panjang = $total_kewajiban_jangka_panjang + $read_saldo;
                        }
                        $kjp_coa_id[]=$value->ID;
                        $kjp_no_akun_1[]=$value->NO_AKUN_1;
                        $kjp_no_akun_2[]=$value->NO_AKUN_2;
                        $kjp_no_akun_3[]=$value->NO_AKUN_3;
                        $kjp_nama_akun[]=$value->NAMA_AKUN;
                        $kjp_type_id[]=$value->TYPE_ID;
                        $kjp_type[]=$value->TYPE;
                        $kjp_db_k_id[]=$value->DB_K_ID;
                        $kjp_family_id[]=$value->FAMILY_ID;
                        $kjp_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $kjp_coa_id[0]='';
                        $kjp_no_akun_1[0]='';
                        $kjp_no_akun_2[0]='';
                        $kjp_no_akun_3[0]='';
                        $kjp_nama_akun[0]='';
                        $kjp_type_id[0]='';
                        $kjp_type[0]='';
                        $kjp_db_k_id[0]='';
                        $kjp_family_id[0]='';
                        $kjp_saldo[0]='';
                  }
                  
                  foreach( array_keys($kjp_coa_id) as $totkjp_kjp_coa_id){}


                  for($i=0;$i<=$totkjp_kjp_coa_id;$i++)
                  {
                      if($kjp_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $kjp_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $kjp_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($kjp_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $kjp_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $kjp_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($kjp_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $kjp_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $kjp_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Kewajiban Jangka Panjang');
                  $sheet->setCellValue('K'.$row, $total_kewajiban_jangka_panjang);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Kewajiban jangka panjang







                  //........................................start Total Kewajiban
                  
                  $total_kewajiban = $total_kewajiban_lancar + $total_kewajiban_jangka_panjang;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Kewajiban');
                  $sheet->setCellValue('K'.$row, $total_kewajiban);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end Total Kewajiban










                  // start.....................................................Total Ekuitas

                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Ekuitas');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');


                  $total_ekuitas = 0;
                  $read_select = $this->m_ak_m_coa->select_type(2,$date_from_laporan,$date_to_laporan);

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
                          $total_ekuitas = $total_ekuitas + $read_saldo;
                        }
                        $eku_coa_id[]=$value->ID;
                        $eku_no_akun_1[]=$value->NO_AKUN_1;
                        $eku_no_akun_2[]=$value->NO_AKUN_2;
                        $eku_no_akun_3[]=$value->NO_AKUN_3;
                        $eku_nama_akun[]=$value->NAMA_AKUN;
                        $eku_type_id[]=$value->TYPE_ID;
                        $eku_type[]=$value->TYPE;
                        $eku_db_k_id[]=$value->DB_K_ID;
                        $eku_family_id[]=$value->FAMILY_ID;
                        $eku_saldo[]=$read_saldo;
                      }
                  }
                  if($logic_db==0)
                  {
                        $eku_coa_id[0]='';
                        $eku_no_akun_1[0]='';
                        $eku_no_akun_2[0]='';
                        $eku_no_akun_3[0]='';
                        $eku_nama_akun[0]='';
                        $eku_type_id[0]='';
                        $eku_type[0]='';
                        $eku_db_k_id[0]='';
                        $eku_family_id[0]='';
                        $eku_saldo[0]='';
                  }
                  
                  foreach( array_keys($eku_coa_id) as $toteku_eku_coa_id){}


                  for($i=0;$i<=$toteku_eku_coa_id;$i++)
                  {
                      if($eku_family_id[$i]==1)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
                        $sheet->setCellValue('B'.$row, $eku_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $eku_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($eku_family_id[$i]==2)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('C'.$row.':H'.$row);
                        $sheet->setCellValue('C'.$row, $eku_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $eku_saldo[$i]);



                        $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                      }
                      if($eku_family_id[$i]==3)
                      {
                        $row=$row+1;
                        $baris_1_page = $baris_1_page+1;

                        $spreadsheet->getActiveSheet()->mergeCells('D'.$row.':H'.$row);
                        $sheet->setCellValue('D'.$row, $eku_nama_akun[$i]);
                        $sheet->setCellValue('J'.$row, $eku_saldo[$i]);



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


                        $row=$row+1;

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
                        $sheet->setCellValue('A'.$row, 'Neraca (Standard)');
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

                  $sheet->setCellValue('A'.$row, 'Total Ekuitas');
                  $sheet->setCellValue('K'.$row, $total_ekuitas);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                  //........................................end Total Ekuitas








                  //........................................start Total Kewajiban dan Ekuitas
                  
                  $total_kewajiban_dan_ekuitas = $total_kewajiban + $total_ekuitas;
                  $row=$row+1;
                  $baris_1_page = $baris_1_page+1;
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
                  $spreadsheet->getActiveSheet()->mergeCells('K'.$row.':L'.$row);
                  $sheet = $spreadsheet->getActiveSheet();

                  $sheet->setCellValue('A'.$row, 'Total Kewajiban dan Ekuitas');
                  $sheet->setCellValue('K'.$row, $total_kewajiban_dan_ekuitas);
                  $sheet->getStyle('K'.$row)->getAlignment()->setHorizontal('left');
                  $spreadsheet->getActiveSheet()
                                  ->getStyle('J'.$row.':L'.$row)
                                  ->getNumberFormat()
                                  ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


                  //........................................end Total Kewajiban dan Ekuitas

     





                  $writer = new Xlsx($spreadsheet);
                  $filename = 'lap_neraca';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
