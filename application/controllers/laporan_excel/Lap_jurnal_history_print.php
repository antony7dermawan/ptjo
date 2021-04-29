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

      class Lap_jurnal_history_print extends CI_Controller{

            public function __construct()
            {
                parent::__construct();

                $this->load->model('m_t_ak_jurnal_history');
                $this->load->model('m_t_ak_jurnal_edit');
                $this->load->model('m_ak_m_coa');
                $this->load->model('m_ak_m_family');
                $this->load->model('m_ak_m_type');

            }



            public function index()
            {
              $total_baris_1_page = 55;
              $baris_1_page = 0;
                  $spreadsheet = new Spreadsheet();


                  
                  $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                  $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                  $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                  $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                  $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                  $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);


                  $row=1;
                  $baris_1_page = $baris_1_page+1;

                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, date('d-m-Y'));
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                  

                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'PT Jo Perdana Agri Technology');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');


                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Laporan History');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                  $row=$row+1;
                  $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                  $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A'.$row, 'Dari '.date('d-m-Y', strtotime($this->session->userdata('date_from_select_jurnal'))).' Sampai '.date('d-m-Y', strtotime($this->session->userdata('date_to_select_jurnal'))));
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');


                $read_select = $this->m_t_ak_jurnal_history->select($this->session->userdata('date_from_select_jurnal'),$this->session->userdata('date_to_select_jurnal'),$this->session->userdata('coa_id_jurnal_history'));
                foreach ($read_select as $key => $value) 
                {
                  $no_akun_1[$key]=$value->NO_AKUN_1;
                  $no_akun_2[$key]=$value->NO_AKUN_2;
                  $no_akun_3[$key]=$value->NO_AKUN_3;
                  $nama_akun[$key]=$value->NAMA_AKUN;
                  $debit[$key]=$value->DEBIT;
                  $kredit[$key]=$value->KREDIT;
                  $catatan[$key]=$value->CATATAN;
                  $no_voucer[$key]=$value->NO_VOUCER;
                  $tanggal[$key]=date('d-m-Y', strtotime($value->DATE));

                            if($value->NO_AKUN_3!='')
                            {
                              $no_akun[$key]=$value->NO_AKUN_3;
                            }
                            elseif($value->NO_AKUN_2!='')
                            {
                              $no_akun[$key]=$value->NO_AKUN_2;
                            }
                            else
                            {
                              $no_akun[$key]=$value->NO_AKUN_1;
                            }
                }
                $total_akun = $key;


                  $row=$row+1;
                  $sheet->setCellValue('A'.$row, 'Tanggal');
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('B'.$row, 'No Voucer');
                  $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('C'.$row, 'No. Akun:');
                  $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('D'.$row, 'Nama Akun');
                  $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('E'.$row, 'Catatan');
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('F'.$row, 'Debit');
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('G'.$row, 'Kredit');
                  $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('left');
                  
                  $alp='A';
                  for($x=0;$x<=6;$x++)
                  {

                      $area = $alp.$row;
                      $spreadsheet->getActiveSheet()->getStyle($area)
                            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                      $spreadsheet->getActiveSheet()->getStyle($area)
                            ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                      $spreadsheet->getActiveSheet()->getStyle($area)
                            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                      $spreadsheet->getActiveSheet()->getStyle($area)
                            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                    $alp++;
                  }
                

                $total_debit=0;
                $total_kredit=0;
                $total_baris_1_bon = 40;
                for($i=0;$i<=$total_akun;$i++)
                {
                  $rmd=(float)($i/$total_baris_1_bon);
                  $rmd=($rmd-(int)$rmd)*$total_baris_1_bon;
                  if($i>$total_baris_1_bon and $rmd==0)
                  {
                    $row=$row+1;
                    $baris_1_page = $baris_1_page+1;

                    $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setCellValue('A'.$row, date('d-m-Y'));
                    $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');

                    

                    $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setCellValue('A'.$row, 'PT Jo Perdana Agri Technology');
                    $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');


                    $row=$row+1;
                    $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setCellValue('A'.$row, 'Laporan Cash Flow');
                    $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');

                    $row=$row+1;
                    $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setCellValue('A'.$row, 'Dari '.date('d-m-Y', strtotime($date_from_laporan)).' Sampai '.date('d-m-Y', strtotime($date_to_laporan)));
                    $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');


                    $row=$row+1;
                    $sheet->setCellValue('A'.$row, 'Tanggal');
                    $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');
                    $sheet->setCellValue('B'.$row, 'No Voucer');
                    $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('left');
                    $sheet->setCellValue('C'.$row, 'No. Akun:');
                    $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('left');
                    $sheet->setCellValue('D'.$row, 'Nama Akun');
                    $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('left');
                    $sheet->setCellValue('E'.$row, 'Catatan');
                    $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('left');
                    $sheet->setCellValue('F'.$row, 'Debit');
                    $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('left');
                    $sheet->setCellValue('G'.$row, 'Kredit');
                    $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('left');
                    $alp='A';
                    for($x=0;$x<=6;$x++)
                    {
                        $area = $alp.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                      $alp++;
                    }

                  }
                  $row=$row+1;
                  $sheet->setCellValue('A'.$row, $tanggal[$i]);
                  $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('B'.$row, $no_voucer[$i]);
                  $sheet->getStyle('B'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('C'.$row, $no_akun[$i]);
                  $sheet->getStyle('C'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('D'.$row, $nama_akun[$i]);
                  $sheet->getStyle('D'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('E'.$row, $catatan[$i]);
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('F'.$row,intval($debit[$i]));
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('G'.$row, intval($kredit[$i]));
                  $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('left');

                  $spreadsheet->getActiveSheet()
                                    ->getStyle('F'.$row.':G'.$row)
                                    ->getNumberFormat()
                                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $alp='A';
                    for($x=0;$x<=6;$x++)
                    {
                        $area = $alp.$row;
                        
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                      $alp++;
                    }
                  
                  $total_debit=$total_debit+intval($debit[$i]);
                  $total_kredit=$total_kredit+intval($kredit[$i]);

                }

                if($total_baris_1_bon>$i)
                {
                  for($x=0;$x<($total_baris_1_bon-$i);$x++)
                  {
                    $row=$row+1;

                    $alp='A';
                    for($z=0;$z<=6;$z++)
                    {
                        $area = $alp.$row;
                        
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                      $alp++;
                    }
                  }
                }
                if($total_baris_1_bon<$i)
                {
                  $rmd=(float)($i/$total_baris_1_bon);
                  $rmd=($rmd-(int)$rmd)*$total_baris_1_bon;
                  for($x=0;$x<($total_baris_1_bon-$rmd);$x++)
                  {
                    $row=$row+1;
                    $alp='A';
                    for($z=0;$z<=6;$z++)
                    {
                        $area = $alp.$row;
                        
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                      $alp++;
                    }
                  }
                }

                  $sheet->setCellValue('E'.$row, 'Total');
                  $sheet->getStyle('E'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('F'.$row,intval($total_debit));
                  $sheet->getStyle('F'.$row)->getAlignment()->setHorizontal('left');
                  $sheet->setCellValue('G'.$row, intval($total_kredit));
                  $sheet->getStyle('G'.$row)->getAlignment()->setHorizontal('left');

                    $alp='A';
                    for($x=0;$x<=6;$x++)
                    {
                        $area = $alp.$row;
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                        $spreadsheet->getActiveSheet()->getStyle($area)
                              ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                      $alp++;
                    }

                  $spreadsheet->getActiveSheet()
                                    ->getStyle('F'.$row.':G'.$row)
                                    ->getNumberFormat()
                                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

               

                  $writer = new Xlsx($spreadsheet);
                  $filename = 'history_jurnal';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>
