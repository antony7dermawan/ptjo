<?php

      use PhpOffice\PhpSpreadsheet\Spreadsheet;
      use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
      
      class Excel extends CI_Controller{

            public function print_excel()
            {
                  $spreadsheet = new Spreadsheet();
                  $sheet = $spreadsheet->getActiveSheet();
                  $sheet->setCellValue('A1', 'No');
                  $sheet->setCellValue('B1', 'Nama');
                  $sheet->setCellValue('C1', 'Kelas');
                  $sheet->setCellValue('D1', 'Jenis Kelamin');
                  $sheet->setCellValue('E1', 'Alamat');
                  

                  $writer = new Xlsx($spreadsheet);
                  $filename = 'Jurnal_Umum';
                  
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
                  header('Cache-Control: max-age=0');
      
                  $writer->save('php://output');
            }
      }
?>