<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_wallboard extends MX_Controller {


   public function __construct(){       
       $this->menu = $this->menu_model->load_menu('admin', 'ticket');
       $this->load->library('form_validation');
       $this->load->model('Report_wallboard_model');
   }

   public function index($type,$auth){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
         $data['type']=$type;
    $this->load->view('report_wallboard',$data); 
    
      }else{  
        echo 'Authentication failed';
      }          
   }

   public function data($type){
    $tgl=date('Y-m-d',strtotime($_GET['tanggal']));
    $data['call']=$this
           ->Report_wallboard_model
           ->calls($type,$tgl);
    $data['agent_a']=$this
           ->Report_wallboard_model
           ->agent_activity($type,$tgl);
        $data['breakdown_fu']=$this
           ->Report_wallboard_model
           ->breakdown_follow_up($type,$tgl);

        $data['agent_lt']=$this
           ->Report_wallboard_model
           ->agent_level_ticket($type,$tgl);
        echo json_encode($data);

   }



   public function data_atas($type){    
    $tanggal=explode(' - ',$_GET['tanggal']);    
    $date1=date('Y-m-d',strtotime($tanggal[0]));
    $date2=date('Y-m-d',strtotime($tanggal[1]));

    $data['call']=$this
           ->Report_wallboard_model
           ->calls_atas($type,$date1,$date2);
        echo json_encode($data);

   }
   public function calls_atas_details(){
     $data['call']=$this
           ->Report_wallboard_model
           ->calls_atas_details('kanmo','2020-04-15','2020-04-20');
        echo json_encode($data);
   }



   public function data_bawah($type){    
    $tgl=date('Y-m-d',strtotime($_GET['tanggal']));
    
    $data['agent_a']=$this
           ->Report_wallboard_model
           ->agent_activity($type,$tgl);
        $data['breakdown_fu']=$this
           ->Report_wallboard_model
           ->breakdown_follow_up($type,$tgl);

        $data['agent_lt']=$this
           ->Report_wallboard_model
           ->agent_level_ticket($type,$tgl);
        echo json_encode($data);

   }



   function export($type=null,$auth=null){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
          $tanggal=$_POST['tanggal'];  
      if($_POST['tanggal']==''){
                echo json_encode('error');exit();
      }

           $tgl=date('Y-m-d',strtotime($tanggal));

    $data['call']=$this
           ->Report_wallboard_model
           ->calls($type,$tgl);
    $data['agent_a']=$this
           ->Report_wallboard_model
           ->agent_activity($type,$tgl);
    $data['breakdown_fu']=$this
           ->Report_wallboard_model
           ->breakdown_follow_up($type,$tgl);

    $data['agent_lt']=$this
           ->Report_wallboard_model
           ->agent_level_ticket($type,$tgl);
            

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
          
          $excel->getActiveSheet()->setTitle('A1','Laporan Wallboard :'.$tanggal);
          $excel->getActiveSheet()->setCellValue('A1', 'Laporan Wallboard :'.$tanggal);
              $excel->getActiveSheet()->getStyle('A1')->applyFromArray($title);;
              $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              

          

                  
                  
                  
                  

          

          $alpha='A';

          $excel->getActiveSheet()->setCellValue($alpha.'3','Inbound (%)');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Serviced (%)');
              $alpha++;
          /*$excel->getActiveSheet()->setCellValue($alpha.'3','AHT');
              $alpha++;*/
          /*$excel->getActiveSheet()->setCellValue($alpha.'3','Total Calls');
              $alpha++;*/
          $excel->getActiveSheet()->setCellValue($alpha.'3','Answered Call');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Abandoned Call');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Offered Call');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','SLA');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','early Abandoned');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Abandoned IVR');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Abn Call Reachout');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Abn Call Unique');              
          $excel->getActiveSheet()->getStyle('A3'.':'.$alpha.'3')->applyFromArray($header);
              $alpha++;


        

          $alpha='A';

          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["m"]);
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["k"]);
              $alpha++;
          /*$excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["j"]);
              $alpha++;*/
          /*$excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["l"]);
              $alpha++;*/
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["a"]);
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["b"]);
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["c"]);
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["d"]);
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["e"]);
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["f"]);
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["i"]);
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["g"].' ('.$data['call']["h"].')');
          $excel->getActiveSheet()->getStyle('A4'.':'.$alpha.'4')->applyFromArray($isi);
              $alpha++;



    

//agent activity

          
          $excel->getActiveSheet()->setCellValue('A6','Agent Activity');



          $alpha='A';
          $excel->getActiveSheet()->setCellValue($alpha.'7','Agent Name');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Login Time');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Incoming Calls');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Outgoing Calls');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Agent Abandoned');
              $alpha++;              
          $excel->getActiveSheet()->setCellValue($alpha.'7','Total Minutes');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','AVG Handling Time');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Total Follow UP');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Total Break');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Total Other');
              $alpha++;
          $excel->getActiveSheet()->getStyle('A7'.':'.$alpha.'7')->applyFromArray($header);


          
          $idx=8;    
          foreach ($data['agent_a'] as $key => $value) {
            $alpha='A';
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["name"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["login"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["incoming"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["outgoing"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["abandoned_in_number"]);
              $alpha++;              
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["total_minutes"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["avg"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["follow"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["break"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["other"]);
              $excel->getActiveSheet()->getStyle('A8'.':'.$alpha.$idx)->applyFromArray($isi);
              $alpha++;
              $idx++;   

          }
          
      

$idx++;   
          $excel->getActiveSheet()->setCellValue('A'.$idx,'Breakdown Follow up Type in Munutes');
          $idx++;   

          $alpha='A';
          $from=$idx;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Agent Name');
              $alpha++;

          foreach ($data['breakdown_fu']['break'] as $key => $value) {
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value->description);  
              $alpha++;
              $alpha;
          }

          $excel->getActiveSheet()->getStyle('A'.$from.':'.'F'.$from)->applyFromArray($header);

          $idx++;

          foreach ($data['breakdown_fu']['data'] as $key => $value) {
                $alpha='A';
                $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["name"]);
                $alpha++;
                $from=$idx;
              foreach ($data['breakdown_fu']['break'] as $key => $v) {
                
                if($value[$v->description]==null){
                    $excel->getActiveSheet()->setCellValue($alpha.$idx,"00:00:00");
                    $excel->getActiveSheet()->getStyle('A'.$from.':'.$alpha.$idx)->applyFromArray($isi);
                    $alpha++;
                }else{
                    $excel->getActiveSheet()->setCellValue($alpha.$idx,$value[$v->description]);
                    $excel->getActiveSheet()->getStyle('A'.$from.':'.$alpha.$idx)->applyFromArray($isi);

                    $alpha++;
                }            
            }
            $idx++;
          }

          
          $idx++;
          $idx++;



          $excel->getActiveSheet()->setCellValue('A'.$idx,'Agent Level Tickets');
          $idx++;   


          $alpha='A';
          $from=$idx;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Agent Name');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Number of Tickets raised');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'No of Tickets Closed');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Average Ticket closed time');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Number of Comments');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Closed <5 days');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Closed <10 Days');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Open >  5 days');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Open >  10 days');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'All Open');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $excel->getActiveSheet()->getStyle('A'.$idx.':'.$alpha.$from)->applyFromArray($header);
          $alpha++;
          $idx++;

foreach ($data['agent_lt'] as $key => $value) {
          $alpha='A';
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["agent"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["raised"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["closed"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["avg"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["comment"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["closed_day5"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["closed_day10"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["open_day5"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["open_day10"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["open_all"]);
          $excel->getActiveSheet()->getStyle('A'.$idx.':'.$alpha.$idx)->applyFromArray($isi);
          $alpha++;
          $idx++;
}


          
    

    
    


            $filename='Report Wallboard '.ucfirst($type).' '.date('Y-m-d H:i:s').'.xlsx';
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser 
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = IOFactory::createWriter($excel, 'Excel2007');  
            $objWriter->save('php://output');


      }else{
        echo 'Authentication failed';
      }   
       
   }



   //export atas

   function export_atas($type=null,$auth=null){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
          $tanggal=$_POST['tanggal'];  
      if($_POST['tanggal']==''){
                echo json_encode('error');exit();
      }

    $tanggal=explode(' - ',$_POST['tanggal']);    
    $date1=date('Y-m-d',strtotime($tanggal[0]));
    $date2=date('Y-m-d',strtotime($tanggal[1]));

    $data['call']=$this
           ->Report_wallboard_model
           ->calls_atas($type,$date1,$date2);
    
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
          
          $excel->getActiveSheet()->setTitle('A1','Report Wallboard :'.$date1 .' - '. $date2);
          $excel->getActiveSheet()->setCellValue('A1', 'Report Wallboard :'.$date1 .' - '. $date2);
              $excel->getActiveSheet()->getStyle('A1')->applyFromArray($title);;
              $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              

          $alpha='A';
          $excel->getActiveSheet()->setCellValue($alpha.'3','Inbound (%)');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Serviced (%)');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Answered Call');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Abandoned Call');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Offered Call');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','SLA');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','early Abandoned');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Abandoned IVR');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Abn Call Reachout');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'3','Abn Call Unique');              
          $excel->getActiveSheet()->getStyle('A3'.':'.$alpha.'3')->applyFromArray($header);
              $alpha++;


        

          $alpha='A';

          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["m"]);
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["k"]);
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
              $alpha++;
          /*$excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["l"]);
              $alpha++;*/
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["a"]);
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["b"]);
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["c"]);
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["d"]);
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["e"]);
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["f"]);
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["i"]);
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'4',$data['call']["g"].' ('.$data['call']["h"].')');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);          
          $excel->getActiveSheet()->getStyle('A4'.':'.$alpha.'4')->applyFromArray($isi);
              $alpha++;


            $filename='Report Wallboard'.ucfirst($type).' '.date('Y-m-d H:i:s').'.xlsx';
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser 
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = IOFactory::createWriter($excel, 'Excel2007');  
            $objWriter->save('php://output');


      }else{
        echo 'Authentication failed';
      }   
       
   }




   //export bawah

   function export_bawah($type=null,$auth=null){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
          $tanggal=$_POST['tanggal'];  
      if($_POST['tanggal']==''){
                echo json_encode('error');exit();
      }

           $tgl=date('Y-m-d',strtotime($tanggal));

    
    $data['agent_a']=$this
           ->Report_wallboard_model
           ->agent_activity($type,$tgl);
    $data['breakdown_fu']=$this
           ->Report_wallboard_model
           ->breakdown_follow_up($type,$tgl);

    $data['agent_lt']=$this
           ->Report_wallboard_model
           ->agent_level_ticket($type,$tgl);
            

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
          
          $excel->getActiveSheet()->setTitle('A1','Laporan Wallboard :'.$tanggal);
          $excel->getActiveSheet()->setCellValue('A1', 'Laporan Wallboard :'.$tanggal);
              $excel->getActiveSheet()->getStyle('A1')->applyFromArray($title);;
              $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              

          

                  
                  
                  

//agent activity
          $excel->getActiveSheet()->setCellValue('A6','Agent Activity');



          $alpha='A';
          $excel->getActiveSheet()->setCellValue($alpha.'7','Agent Name');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Login Time');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Incoming Calls');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Outgoing Calls');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Agent Abandoned');
              $alpha++;              
          $excel->getActiveSheet()->setCellValue($alpha.'7','Total Minutes');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','AVG Handling Time');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Total Follow UP');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Total Break');
              $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.'7','Total Other');
              $alpha++;
          $excel->getActiveSheet()->getStyle('A7'.':'.$alpha.'7')->applyFromArray($header);


          
          $idx=8;    
          foreach ($data['agent_a'] as $key => $value) {
            $alpha='A';
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["name"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["login"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["incoming"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["outgoing"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["abandoned_in_number"]);
              $alpha++;              
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["total_minutes"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["avg"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["follow"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["break"]);
              $alpha++;
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["other"]);
              $excel->getActiveSheet()->getStyle('A8'.':'.$alpha.$idx)->applyFromArray($isi);
              $alpha++;
              $idx++;   

          }
          
      

$idx++;   
          $excel->getActiveSheet()->setCellValue('A'.$idx,'Breakdown Follow up Type in Munutes');
          $idx++;   

          $alpha='A';
          $from=$idx;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Agent Name');
              $alpha++;

          foreach ($data['breakdown_fu']['break'] as $key => $value) {
              $excel->getActiveSheet()->setCellValue($alpha.$idx,$value->description);  
              $alpha++;
              $alpha;
          }

          $excel->getActiveSheet()->getStyle('A'.$from.':'.'F'.$from)->applyFromArray($header);

          $idx++;

          foreach ($data['breakdown_fu']['data'] as $key => $value) {
                $alpha='A';
                $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["name"]);
                $alpha++;
                $from=$idx;
              foreach ($data['breakdown_fu']['break'] as $key => $v) {
                
                if($value[$v->description]==null){
                    $excel->getActiveSheet()->setCellValue($alpha.$idx,"00:00:00");
                    $excel->getActiveSheet()->getStyle('A'.$from.':'.$alpha.$idx)->applyFromArray($isi);
                    $alpha++;
                }else{
                    $excel->getActiveSheet()->setCellValue($alpha.$idx,$value[$v->description]);
                    $excel->getActiveSheet()->getStyle('A'.$from.':'.$alpha.$idx)->applyFromArray($isi);

                    $alpha++;
                }            
            }
            $idx++;
          }

          
          $idx++;
          $idx++;



          $excel->getActiveSheet()->setCellValue('A'.$idx,'Agent Level Tickets');
          $idx++;   


          $alpha='A';
          $from=$idx;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Agent Name');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Number of Tickets raised');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'No of Tickets Closed');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Average Ticket closed time');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Number of Comments');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Closed <5 days');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Closed <10 Days');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Open >  5 days');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'Open >  10 days');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,'All Open');
          $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
          $excel->getActiveSheet()->getStyle('A'.$idx.':'.$alpha.$from)->applyFromArray($header);
          $alpha++;
          $idx++;

foreach ($data['agent_lt'] as $key => $value) {
          $alpha='A';
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["agent"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["raised"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["closed"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["avg"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["comment"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["closed_day5"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["closed_day10"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["open_day5"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["open_day10"]);
          $alpha++;
          $excel->getActiveSheet()->setCellValue($alpha.$idx,$value["open_all"]);
          $excel->getActiveSheet()->getStyle('A'.$idx.':'.$alpha.$idx)->applyFromArray($isi);
          $alpha++;
          $idx++;
}


          
    

    
    


            $filename='Report Wallboard '.ucfirst($type).' '.date('Y-m-d H:i:s').'.xlsx';
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

//ini controller