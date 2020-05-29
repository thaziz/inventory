<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_report extends MX_Controller {


   public function __construct(){       
       $this->menu = $this->menu_model->load_menu('admin', 'ticket');
       $this->load->library('form_validation');
       $this->load->model('ticket_report_model');
   }
   
   public function index($type,$auth){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
           $data=$this->ticket_report_model->filer_data();
           $data['type']=$type;
           $data['agent']=$this->ticket_report_model->agent_list($type);
           $data['range']=date('M d, Y',strtotime('-30 days')) .'  -  '.date('M d, Y');
           
           $this->load->view('ticket_report',$data); 
      }else{
        echo 'Authentication failed';
      }          
   }
   public function report($type=null){
  $periode_thn='';
  $periode_awal='';
  $periode_akhir='';
  $weekly=[];
  $range=[];
  $default=$_POST['default'];
  $status=$_POST['status'];

  $minggu=$_POST['minggu'];
  $ranges=$_POST['range'];  
  $weekly=explode(' - ',$minggu);
  $range=explode(' - ',$ranges);

  if($_POST['jenis']=='Quarterly' || $_POST['jenis']=='Yearly'){
    if($_POST['tahun']==''){
      echo json_encode('error');exit();
    }
    $periode_awal=date('Y-m-d',strtotime('1-01-'.$_POST['tahun']));
    $periode_akhir=date('Y-m-t',strtotime('1-12-'.$_POST['tahun']));
  }else if($_POST['jenis']=='Daily'){
     if($status=='r'){
          if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }else if($_POST['jenis']=='Weekly'){
    if($status=='y'){
          if($_POST['tahun']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
         $periode_akhir=date('Y-m-t',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
    }else if($status=='w'){
         if($_POST['minggu']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($weekly[0]));
         $periode_akhir=date('Y-m-d',strtotime($weekly[1]));
    }else if($status=='r'){
          if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }else if($_POST['jenis']=='Monthly'){
    if($status=='y'){
          if($_POST['tahun']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
         $periode_akhir=date('Y-m-t',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
    }else if($status=='w'){
           if($_POST['minggu']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($weekly[0]));
         $periode_akhir=date('Y-m-d',strtotime($weekly[1]));
    }else if($status=='r'){
           if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }
       $data = 
       $this->ticket_report_model->
       load($type,$periode_awal,
        $periode_akhir,
        $periode_thn,
        $default);
       
       foreach ($data as $key => $value) {
          if($value->co!=NULL && $value->co!=0){
          $a = $value->co/$value->total_closed;
          }else{
            $a=0;
          }
          $day = floor($a/86400);
          $hours = floor(($a / 3600) % 24);
          $mins = floor($a / 60 % 60);
          $secs = floor($a % 60);
          
          $data[0]->co = ($day>0?$day.'days ':'').sprintf('%02d:%02d:%02d', $hours, $mins, $secs);;
          }
         
       echo json_encode($data);    
   }
   public function data_table($type=null){
  $periode_thn='';
  $periode_awal='';
  $periode_akhir='';
  $weekly=[];
  $range=[];
  $default=$_POST['default'];
  $status=$_POST['status'];
  $minggu=$_POST['minggu'];
  $ranges=$_POST['range'];  
  $weekly=explode(' - ',$minggu);
  $range=explode(' - ',$ranges);

  if($_POST['jenis']=='Quarterly' || $_POST['jenis']=='Yearly'){
    if($_POST['tahun']==''){
      echo json_encode('error');exit();
    }
    $periode_awal=date('Y-m-d',strtotime('1-01-'.$_POST['tahun']));
    $periode_akhir=date('Y-m-t',strtotime('1-12-'.$_POST['tahun']));
  }else if($_POST['jenis']=='Daily'){
     if($status=='r'){
          if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }else if($_POST['jenis']=='Weekly'){
    if($status=='y'){
          if($_POST['tahun']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
         $periode_akhir=date('Y-m-t',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
    }else if($status=='w'){
         if($_POST['minggu']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($weekly[0]));
         $periode_akhir=date('Y-m-d',strtotime($weekly[1]));
    }else if($status=='r'){
          if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }else if($_POST['jenis']=='Monthly'){
    if($status=='y'){
          if($_POST['tahun']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
         $periode_akhir=date('Y-m-t',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
    }else if($status=='w'){
           if($_POST['minggu']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($weekly[0]));
         $periode_akhir=date('Y-m-d',strtotime($weekly[1]));
    }else if($status=='r'){
           if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }

        $data = $this->ticket_report_model->
        load_data($type,$periode_awal,
        $periode_akhir,
        $periode_thn,
        $default);
        echo json_encode($data);  
   }
   public function report_call($type){
$periode_thn='';
  $periode_awal='';
  $periode_akhir='';
  $weekly=[];
  $range=[];
  $default=$_POST['default'];
  $status=$_POST['status'];
  $minggu=$_POST['minggu'];
  $ranges=$_POST['range'];  
  $weekly=explode(' - ',$minggu);
  $range=explode(' - ',$ranges);

  if($_POST['jenis']=='Quarterly' || $_POST['jenis']=='Yearly'){
    if($_POST['tahun']==''){
      echo json_encode('error');exit();
    }
    $periode_awal=date('Y-m-d',strtotime('1-01-'.$_POST['tahun']));
    $periode_akhir=date('Y-m-t',strtotime('1-12-'.$_POST['tahun']));
  }else if($_POST['jenis']=='Daily'){
     if($status=='r'){
          if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }else if($_POST['jenis']=='Weekly'){
    if($status=='y'){
          if($_POST['tahun']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
         $periode_akhir=date('Y-m-t',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
    }else if($status=='w'){
         if($_POST['minggu']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($weekly[0]));
         $periode_akhir=date('Y-m-d',strtotime($weekly[1]));
    }else if($status=='r'){
          if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }else if($_POST['jenis']=='Monthly'){
    if($status=='y'){
          if($_POST['tahun']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
         $periode_akhir=date('Y-m-t',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
    }else if($status=='w'){
           if($_POST['minggu']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($weekly[0]));
         $periode_akhir=date('Y-m-d',strtotime($weekly[1]));
    }else if($status=='r'){
           if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }
    

      $data = $this->ticket_report_model->call_count($periode_awal,$periode_akhir, $type, isset($_POST['agent'])?$_POST['agent']:null);
      echo json_encode($data);
   }
   public function report_email($type){
    $periode_thn='';
  $periode_awal='';
  $periode_akhir='';
  $weekly=[];
  $range=[];
  $default=$_POST['default'];
  $status=$_POST['status'];
  $minggu=$_POST['minggu'];
  $ranges=$_POST['range'];  
  $weekly=explode(' - ',$minggu);
  $range=explode(' - ',$ranges);

  if($_POST['jenis']=='Quarterly' || $_POST['jenis']=='Yearly'){
    if($_POST['tahun']==''){
      echo json_encode('error');exit();
    }
    $periode_awal=date('Y-m-d',strtotime('1-01-'.$_POST['tahun']));
    $periode_akhir=date('Y-m-t',strtotime('1-12-'.$_POST['tahun']));
  }else if($_POST['jenis']=='Daily'){
     if($status=='r'){
          if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }else if($_POST['jenis']=='Weekly'){
    if($status=='y'){
          if($_POST['tahun']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
         $periode_akhir=date('Y-m-t',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
    }else if($status=='w'){
         if($_POST['minggu']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($weekly[0]));
         $periode_akhir=date('Y-m-d',strtotime($weekly[1]));
    }else if($status=='r'){
          if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }else if($_POST['jenis']=='Monthly'){
    if($status=='y'){
          if($_POST['tahun']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
         $periode_akhir=date('Y-m-t',strtotime('1-'.$_POST['bulan'].'-'.$_POST['tahun']));
    }else if($status=='w'){
           if($_POST['minggu']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($weekly[0]));
         $periode_akhir=date('Y-m-d',strtotime($weekly[1]));
    }else if($status=='r'){
           if($_POST['range']==''){
              echo json_encode('error');exit();
          }
         $periode_awal=date('Y-m-d',strtotime($range[0]));
         $periode_akhir=date('Y-m-d',strtotime($range[1]));
    }
  }
      $data = $this->ticket_report_model->email_count($periode_awal,$periode_akhir, $type);
      echo json_encode($data);
   }
   public function export($type, $auth){
    if($auth=='3ec8112b9e277cf4d24c85136fc9ee95'){
         $data = $this->ticket_report_model->load_data($type);
         $this->load->library('PHPExcel/PHPExcel');
          $this->load->library("PHPExcel/PHPExcel/IOFactory");
          $excel = new PHPExcel;
          if($type=='kanmo')
            $header_ = array($_POST['jenis'].' Level','Brand','Source','Main Category','Category','Sub Category','Open Status','Closed Status');
          else
            $header_ = array($_POST['jenis'].' Level','Source','Main Category','Category','Open Status','Closed Status');
          $excel->setActiveSheetIndex(0);
          $excel->getActiveSheet()->setTitle('Report '.ucfirst($type));
          $alpha='A';
          for ($i=0; $i < count($header_); $i++) { 
                $excel->getActiveSheet()->setCellValue($alpha.'1', $header_[$i]);
                $alpha++;
          }
          $idx = 2;
          $total_open =0;
          $total_closed =0;
          $alpha_open = 'A';
          for ($i=0; $i < count($data); $i++) { 
              $alpha='A';
                foreach ($data[$i] as $key => $value) {
                  if($type=='nespresso' && ($key=='brand' || $key=='sub_category')){
                    continue;
                  }
                    $excel->getActiveSheet()->setCellValue($alpha.$idx, $value);
                    $excel->getActiveSheet()->getColumnDimension($alpha)->setAutoSize(true);
                    if($key=='total_open'){
                      $total_open +=$value;
                      $alpha_open = $alpha;
                    }else if($key=='total_closed'){
                      $total_closed +=$value;
                    }
                    $alpha++;
                }
                $idx++;   
            }
            $excel->getActiveSheet()->setCellValue(chr(ord($alpha_open) - 1).$idx, 'Total');
            $excel->getActiveSheet()->setCellValue($alpha_open.$idx, $total_open);
            $alpha_open++;
            $excel->getActiveSheet()->setCellValue($alpha_open.$idx, $total_closed);

            $filename='Report '.ucfirst($type).' '.date('Y-m-d H:i:s').'.xlsx';
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

   public function test_count(){
    $data = $this->ticket_report_model->email_count('2019-04-08',date('Y-m-d'), 'nespresso');
    print_r($data);
   }
   

}