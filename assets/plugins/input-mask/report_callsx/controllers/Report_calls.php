<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_calls extends MX_Controller {


   public function __construct(){       
       $this->menu = $this->menu_model->load_menu('admin', 'ticket');
       $this->load->library('form_validation');
       $this->load->model('Report_calls_model');
   }

   public function index($type,$auth){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
         $data['type']=$type;
         $data['range']=date('M d, Y') .'  -  '.date('M d, Y');
         $data['weekly']=date('Y-m-d',strtotime("-1 week")) .'  -  '.date('Y-m-d');
         $data['monthly']=date('m-Y');
    $this->load->view('report_agent_activity',$data); 
    
      }else{  
        echo 'Authentication failed';
      }          
   }

   public function data($t){
    $hide_lg='none';
    
    $tanggal=explode(' - ',$_GET['tanggal']);

    if($_GET['jenis']=='Date'){
      $date=date('Y-m-d',strtotime($tanggal[0]));
      $date2=date('Y-m-d',strtotime($tanggal[1]));
      if($date==$date2){
        $hide_lg='';
      }

    }
    if($_GET['jenis']=='Range'){
      $date=date('Y-m-d',strtotime($tanggal[0]));
      $date2=date('Y-m-d',strtotime($tanggal[1]));
      
    }
   


    $data['agent_a']=$this
           ->Report_calls_model
           ->agent_activity($date,$date2);
    $data['hide']=$hide_lg;
    $data['date']=$date;

        echo json_encode($data);

   }



   function export($type=null,$auth=null){
     if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
$hide_lg='none';
    
    $tanggal=explode(' - ',$_GET['tanggal']);

    if($_GET['jenis']=='Date'){
      $date=date('Y-m-d',strtotime($tanggal[0]));
      $date2=date('Y-m-d',strtotime($tanggal[1]));
      if($date==$date2){
        $hide_lg='';
      }

    }
    if($_GET['jenis']=='Range'){
      $date=date('Y-m-d',strtotime($tanggal[0]));
      $date2=date('Y-m-d',strtotime($tanggal[1]));
      
    }
   

    $data['agent_a']=$this
           ->Report_calls_model
           ->agent_activity($date,$date2);
         //  var_dump($data);exit();
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

          $isi= array(
                 'font'  => array(
                   'bold'  => false,
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


              $title = array(
               'font'  => array(
                   'bold'  => true,
                   'color' => array(
                       'rgb' => '000000'
                   ),
                   'size'  => 11,
                   'name'  => 'Tahoma'
               ));

          
          $headerExcel=[];
          $header_ = $headerExcel;          
          $excel->setActiveSheetIndex(0);
          $text='';
          if($_GET['jenis']=='Range'){
              $text='Calls '.$_GET['jenis'].' : '.$date.' / '.$date2;
          }

          if($_GET['jenis']=='Date'){
            $text='Calls '.$_GET['jenis'].' : '.$date;
            
          }

          $excel->getActiveSheet()->setTitle('A1',$text);
          $excel->getActiveSheet()->setCellValue('A1',$text);
              $excel->getActiveSheet()->getStyle('A1')->applyFromArray($title);
              $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

             
          if($_GET['jenis']=='Range'){
            $excel->getActiveSheet()->mergeCells("A1:E1");
          }

          if($_GET['jenis']=='Date'){
            $excel->getActiveSheet()->mergeCells("A1:F1");
            
          }

          

          

          

          $alpha='A';

         
    

//agent activity

          
          

              

          $alpha='A';
          if($hide_lg==''){
          $excel->getActiveSheet()->setCellValue($alpha.'3','Date');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          }
          

          $excel->getActiveSheet()->setCellValue($alpha.'3',"Agent's name");
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;

          $excel->getActiveSheet()->setCellValue($alpha.'3','Inbound Call');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Outgoing Calls');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Type');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Total Calls');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
         
          
          $idx=4;  
          $rank=1;

          for ($i=0;$i<count($data['agent_a']); $i++) { 
              $value=$data['agent_a'][$i];
            $alpha='A';
              if($hide_lg==''){
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$date);
              $alpha++;
              }

              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["name"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["incoming"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["outgoing"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["type"]);
              $alpha++;


              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["total_calls"]);
           //   $alpha++;
              /*$excel->getActiveSheet()->setCellValue($alpha.$idx,$rank);*/
              $excel->getActiveSheet()->getStyle('A3'.':'.$alpha.$idx)->applyFromArray($isi);
              $alpha++;
              $idx++;   
              $rank++;

          }
         
$idx++;   
$idx++;   
         

            $filename='Report Agent Activity '.ucfirst($type).' '.date('Y-m-d H:i:s').'.xlsx';
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser 
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = IOFactory::createWriter($excel, 'Excel2007');  
            $objWriter->save('php://output');


      }else{
        echo 'Authentication failed';
      }   
       
   }
 }

