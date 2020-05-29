<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_reports extends MX_Controller {


   public function __construct(){       
       $this->menu = $this->menu_model->load_menu('admin', 'ticket');
       $this->load->library('form_validation');
       $this->load->model('master_reports_model');
   }

   public function index($type,$auth){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
         $data['type']=$type;
    $this->load->view('master_reports',$data); 
    
      }else{  
        echo 'Authentication failed';
      }          
   }
   public function report($type=null,$auth=null){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
      $ranges=$_POST['range'];  
      $range=explode(' - ',$ranges);
      $level=$_POST['level'];  
    if($_POST['range']==''){
              echo json_encode('error');exit();
    }

           $periode_awal=date('Y-m-d',strtotime($range[0]));
           $periode_akhir=date('Y-m-d',strtotime($range[1]));
           $data=$this
           ->master_reports_model
           ->list_data($type,$periode_awal,$periode_akhir,$level);
            echo json_encode($data);    
      }else{
        echo 'Authentication failed';
      }   
       
   }

  function export($type=null,$auth=null){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
          $ranges=$_POST['range'];  
          $range=explode(' - ',$ranges);
          $level=$_POST['level'];  
      if($_POST['range']==''){
                echo json_encode('error');exit();
      }

           $periode_awal=date('Y-m-d',strtotime($range[0]));
           $periode_akhir=date('Y-m-d',strtotime($range[1]));
           $data=$this
           ->master_reports_model
           ->list_data($type,$periode_awal,$periode_akhir,$level);
            

           $this->load->library('PHPExcel/PHPExcel');
          $this->load->library("PHPExcel/PHPExcel/IOFactory");
          $excel = new PHPExcel;

          $header = array(
                 'font'  => array(
                   'bold'  => true,
                 ),
                 'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );

          $outline = array(
                              'borders' => array(
                                'outline' => array(
                                  'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                              )
                            );
          


  $brand='';
  $headerExcel=[];

          $header_ = $headerExcel;          
          $excel->setActiveSheetIndex(0);
          $excel->getActiveSheet()->setTitle('Master Report '.ucfirst($type));
          $alpha='A';
if($level==1 || $level==2 || $level==3 || $level==4 || $level==0){          
          $excel->getActiveSheet()->setCellValue($alpha.'1','Meta Category');
              $alpha++;
}

if($level==2 || $level==3 || $level==4 || $level==0){
          $excel->getActiveSheet()->setCellValue($alpha.'1','Main Category');
              $alpha++;
}
if($level==3 || $level==4 || $level==0){
          $excel->getActiveSheet()->setCellValue($alpha.'1','Category');
              $alpha++;
}
if($level==4 || $level==0){
          $excel->getActiveSheet()->setCellValue($alpha.'1','sub Category');
              $alpha++;
}

          foreach ($data['brands'] as $key => $value) {
            $merge=$alpha;
            $excel->getActiveSheet()->setCellValue($alpha.'1',$value->brand_name);
            $excel->getActiveSheet()->setCellValue($merge.'2','Open');
            $alpha++;
            $excel->getActiveSheet()->setCellValue($alpha.'2','Close');
            $merge=$merge.'1:'.$alpha.'1';
            $excel->getActiveSheet()->mergeCells("$merge");
            $alpha++;
          }
          $merge=$alpha;
          $excel->getActiveSheet()->setCellValue($alpha.'1','Grand Total');
          $excel->getActiveSheet()->setCellValue($merge.'2','Open');
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'2','Close');
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'2','%');
          $merge=$merge.'1:'.$alpha.'1';
          $excel->getActiveSheet()->mergeCells("$merge");

          $excel->getActiveSheet()->getStyle('A1'.':'.$alpha.'1')->applyFromArray($header);
          $excel->getActiveSheet()->getStyle('A2'.':'.$alpha.'2')->applyFromArray($header);
          


          $idx = 3;
          $total_open =0;
          $total_closed =0;
          $alpha_open = 'A';
          $a1 = "";
          $a2 = "";
          $a3 = "";
          foreach ($data['data'] as $key => $val) {
              $alpha='A';
              $from=$alpha.$idx;
              if($level==1 || $level==2 || $level==3 || $level==4 || $level==0){          
                if($a1!=$val['meta_categorys']){
                    $excel->getActiveSheet()->setCellValue($alpha.$idx, $val['meta_categorys']);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
                    $a1=$val['meta_categorys'];
                }else{
                    $excel->getActiveSheet()->setCellValue($alpha.$idx,null);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
                }
              }
              if($level==2 || $level==3 || $level==4 || $level==0){          
                  if($a2!=$val['main_categorys']){
                  $excel->getActiveSheet()->setCellValue($alpha.$idx, $val['main_categorys']);
                  $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                  $alpha++;
                  $a2=$val['main_categorys'];
                  }else{
                    $excel->getActiveSheet()->setCellValue($alpha.$idx,null);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
                  }
              }
              if($level==3 || $level==4 || $level==0){          
                    $excel->getActiveSheet()->setCellValue($alpha.$idx, $val['categorys']);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
              }
              if($level==4 || $level==0){
                    $excel->getActiveSheet()->setCellValue($alpha.$idx, $val['sub_category']);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
              }
                    foreach ($data['brands'] as $key => $brand) {
                      $c=$brand->brand_name;
    $excel->getActiveSheet()->setCellValue($alpha.$idx, $val[$c]['open']);
    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
    $alpha++;


    $excel->getActiveSheet()->setCellValue($alpha.$idx, $val[$c]['close']);
    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
    $alpha++;
                    }

$excel->getActiveSheet()->setCellValue($alpha.$idx, $val['open']);
$excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
    $alpha++;
$excel->getActiveSheet()->setCellValue($alpha.$idx, $val['close']);
$excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
    $alpha++;
$excel->getActiveSheet()->setCellValue($alpha.$idx, $val['presentase']);
$excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
$to=$alpha.$idx;
    $alpha++;

                $idx++;   
if($val['type']=='meta_c'){                

  $excel->getActiveSheet()->getStyle($from.":".$to)->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('eedb2');
}

if($val['type']!='')                
$excel->getActiveSheet()->getStyle($from.":".$to)->getFont()->setBold( true );


}





            $filename='Master Report '.ucfirst($type).' '.date('Y-m-d H:i:s').'.xlsx';
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = IOFactory::createWriter($excel, 'Excel2007');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');


      }else{
        echo 'Authentication failed';
      }   
       
   }







   // atas

   public function report_atas($type=null,$auth=null){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
      $ranges=$_POST['range'];  
      $level=$_POST['level'];  
      $range=explode(' - ',$ranges);
    if($_POST['range']==''){
              echo json_encode('error');exit();
    }
           $periode_awal=date('Y-m-d',strtotime($range[0]));
           $periode_akhir=date('Y-m-d',strtotime($range[1]));
           $data=$this
           ->master_reports_model
           ->list_data_atas($type,$periode_awal,$periode_akhir,$level);
            echo json_encode($data);    
      }else{
        echo 'Authentication failed';
      }   
       
   }


   function export_data_atas($type=null,$auth=null){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
          $ranges=$_POST['range'];  
          $range=explode(' - ',$ranges);
          $level=$_POST['level'];
      if($_POST['range']==''){
                echo json_encode('error');exit();
      }

           $periode_awal=date('Y-m-d',strtotime($range[0]));
           $periode_akhir=date('Y-m-d',strtotime($range[1]));
           $data=$this
           ->master_reports_model
           ->list_data_atas($type,$periode_awal,$periode_akhir,$level);
            
           $this->load->library('PHPExcel/PHPExcel');
          $this->load->library("PHPExcel/PHPExcel/IOFactory");
          $excel = new PHPExcel;

          $header = array(
                 'font'  => array(
                   'bold'  => true,
                 ),
                 'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );


          $BStyle = array(
              'borders' => array(
                'outline' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
              )
            );
  $brand='';
  $headerExcel=[];
$indexHeader=0;
if($level==1 || $level==2 || $level==3 || $level==4 || $level==0){          
  $headerExcel[$indexHeader]='Meta Category';
  $indexHeader++;
}
if($level==2 || $level==3 || $level==4 || $level==0){          
  $headerExcel[$indexHeader]='Main Category';
  $indexHeader++;
}
if($level==3 || $level==4 || $level==0){          
  $headerExcel[$indexHeader]='Category';
  $indexHeader++;
}
if($level==4 || $level==0){          
  $headerExcel[$indexHeader]='Sub Category';
  $indexHeader++;
}

if($type=='kanmo')
foreach ($data['brands'] as $key => $value) {
  $headerExcel[$indexHeader]=$value->brand_name;
  $indexHeader++;  
}
$headerExcel[$indexHeader]='Grand Total';
$indexHeader++;
$headerExcel[$indexHeader]='%';
$indexHeader++;




            $header_ = $headerExcel;
       

          
          $excel->setActiveSheetIndex(0);
          $excel->getActiveSheet()->setTitle('Master Report '.ucfirst($type));
          $alpha='A';

          for ($i=0; $i < count($header_); $i++) { 
      $excel->getActiveSheet()->setCellValue($alpha.'1', $header_[$i]);
    $excel->getActiveSheet()->getStyle($alpha.'1')->applyFromArray($header);
    
         
                $alpha++;
          }
  
          





          $idx = 2;
          $total_open =0;
          $total_closed =0;
          $alpha_open = 'A';
          $a1 = "";
          $a2 = "";
          $a3 = "";
          foreach ($data['data'] as $key => $val) {
              $alpha='A';
              $from=$alpha.$idx;
              if($level==1 || $level==2 || $level==3 || $level==4 || $level==0){          
                if($a1!=$val['meta_categorys']){
                    $excel->getActiveSheet()->setCellValue($alpha.$idx, $val['meta_categorys']);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
                    $a1=$val['meta_categorys'];
                }else{
                    $excel->getActiveSheet()->setCellValue($alpha.$idx,null);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
                }
              }
              if($level==2 || $level==3 || $level==4 || $level==0){          
                  if($a2!=$val['main_categorys']){
                  $excel->getActiveSheet()->setCellValue($alpha.$idx, $val['main_categorys']);
                  $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                  $alpha++;
                  $a2=$val['main_categorys'];
                  }else{
                    $excel->getActiveSheet()->setCellValue($alpha.$idx,null);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
                  }
              }
              if($level==3 || $level==4 || $level==0){          
                    $excel->getActiveSheet()->setCellValue($alpha.$idx, $val['categorys']);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
              }
              if($level==4 || $level==0){          
                    $excel->getActiveSheet()->setCellValue($alpha.$idx, $val['sub_category']);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    $alpha++;
              }

                    foreach ($data['brands'] as $key => $brand) {
                      $c=$brand->brand_name;

    $excel->getActiveSheet()->setCellValue($alpha.$idx, $val[$c]);
    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
    $alpha++;
                    }

$excel->getActiveSheet()->setCellValue($alpha.$idx, $val['close']);
$excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
    $alpha++;
$excel->getActiveSheet()->setCellValue($alpha.$idx, $val['presentase']);
$excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);




$to=$alpha.$idx;
    $alpha++;
    $idx++;   
if($val['type']=='meta_c'){                
  $excel->getActiveSheet()->getStyle($from.":".$to)->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('eedb2');
}
if($val['type']!=''){
$excel->getActiveSheet()->getStyle($from.":".$to)->getFont()->setBold( true );
}







            }




            $filename='Master Report '.ucfirst($type).' '.date('Y-m-d H:i:s').'.xlsx';
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = IOFactory::createWriter($excel, 'Excel2007');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');


      }else{
        echo 'Authentication failed';
      }   
       
   }


  
  

}