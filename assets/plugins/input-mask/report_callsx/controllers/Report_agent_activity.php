<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_agent_activity extends MX_Controller {


   public function __construct(){       
       $this->menu = $this->menu_model->load_menu('admin', 'ticket');
       $this->load->library('form_validation');
       $this->load->model('Report_agent_activity_model');
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
    $type=$_POST['qeu'];
    
    $tanggal=explode(' - ',$_POST['tanggal']);

    if($_POST['jenis']=='Daily'){
      $date=date('Y-m-d',strtotime($tanggal[0]));
      $date2=date('Y-m-d',strtotime($tanggal[1]));
      if($date==$date2){
        $hide_lg='';
      }

    }
    if($_POST['jenis']=='Weekly'){
      $date=date('Y-m-d',strtotime($tanggal[0]));
      $date2=date('Y-m-d',strtotime($tanggal[1]));
      
    }
    if($_POST['jenis']=='Monthly'){
      $date=date('Y-m-d',strtotime('1-'.$_POST['tanggal']));
      $date2=date('Y-m-t',strtotime('1-'.$_POST['tanggal']));
    }


    $data['agent_a']=$this
           ->Report_agent_activity_model
           ->agent_activity($type,$date,$date2);
    $data['hide']=$hide_lg;

        echo json_encode($data);

   }



   function export($type=null,$auth=null){
    $hide_lg='none';
        $type=$_POST['qeu'];
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
          $tanggal=$_POST['tanggal'];  
      if($_POST['tanggal']==''){
                echo json_encode('error');exit();
      }

    $tanggal=explode(' - ',$_POST['tanggal']);
    if($_POST['jenis']=='Daily'){
      $date=date('Y-m-d',strtotime($tanggal[0]));
      $date2=date('Y-m-d',strtotime($tanggal[1]));
      if($date==$date2){
        $hide_lg='';
      }

    }
    if($_POST['jenis']=='Weekly'){
      $date=date('Y-m-d',strtotime($tanggal[0]));
      $date2=date('Y-m-d',strtotime($tanggal[1]));
      
    }
    if($_POST['jenis']=='Monthly'){
      $date=date('Y-m-d',strtotime('1-'.$_POST['tanggal']));
      $date2=date('Y-m-t',strtotime('1-'.$_POST['tanggal']));
    }

    $data['agent_a']=$this
           ->Report_agent_activity_model
           ->agent_activity($type,$date,$date2);

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
          
          $excel->getActiveSheet()->setTitle('A1','Report Agent Activity '.$type.' : '.$date.' / '.$date2);
          $excel->getActiveSheet()->setCellValue('A1', 'Report Agent Activity '.$type.' : '.$date.' / '.$date2);
              $excel->getActiveSheet()->getStyle('A1')->applyFromArray($title);
              $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

              $excel->getActiveSheet()->mergeCells("A1:L1");
              

          

          

          

          $alpha='A';

         
    

//agent activity

          
          

              

          $alpha='A';
          $excel->getActiveSheet()->setCellValue($alpha.'3','Agent Name');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          if($hide_lg==''){
          $excel->getActiveSheet()->setCellValue($alpha.'3','Login Time');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          }
          $excel->getActiveSheet()->setCellValue($alpha.'3','Inbound Call');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Outgoing Calls');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Agent Abandoned');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Number of Tickets raised');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','No of Tickets Closed');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Call Total');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Ticket Total');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Bonus for being on time');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Weigh agent wise Total');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Rank');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true); 
          $excel->getActiveSheet()->getStyle('A3'.':'.$alpha.'3')->applyFromArray($header);
          $alpha++;

/*tr += '<tr>';
                tr += '<td>'+res.agent_a[i].name+'</td>';
                tr += '<td>'+res.agent_a[i].login+'</td>';
                tr += '<td>'+res.agent_a[i].incoming+'</td>';
                tr += '<td>'+res.agent_a[i].outgoing+'</td>';
                tr += '<td>'+res.agent_a[i].raised+'</td>';
                tr += '<td>'+res.agent_a[i].closed+'</td>';
                tr += '<td>'+res.agent_a[i].call_total+'</td>';
                tr += '<td>'+res.agent_a[i].ticket_total+'</td>';
                tr += '<td>'+res.agent_a[i].bonus+'</td>';
                tr += '<td>'+res.agent_a[i].weigh+'</td>';
                tr += '<td>'+rank+'</td>';
                tr += '</tr>';
                rank++;*/
                

          
          $idx=4;  
          $rank=1;

          for ($i=count($data['agent_a'])-1; $i>=0 ; $i--) { 
              $value=$data['agent_a'][$i];
            $alpha='A';
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["name"]);
              $alpha++;
              if($hide_lg==''){
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["login"]);
              $alpha++;
              }
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["incoming"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["outgoing"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["abandoned_in_number"]);
              $alpha++;


              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["raised"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["closed"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["call_total"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["ticket_total"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["bonus"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["weigh"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$rank);
              $excel->getActiveSheet()->getStyle('A4'.':'.$alpha.$idx)->applyFromArray($isi);
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

