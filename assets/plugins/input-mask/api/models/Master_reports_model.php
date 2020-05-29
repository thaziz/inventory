<?php

class master_reports_model extends CI_Model {

   private $pref = '';
   var $table = 'v_ticket';
   
   public function __construct(){
       parent::__construct();
       $this->table = $this->pref.$this->table;
   }

   public function list_data($type,$periode_awal=null,$periode_akhir=null,$level){

    $brands=$this->db->select('brand_name')
    ->get('v_brand')->result();


  if($type!='kanmo'){
      $brands=[];
      $brands[0]=(object)array('brand_name'=>'nespresso');
  }



    $tickets = $this->db->select('meta_category,main_category,category,sub_category,brand,status')
        ->where('date(open_date) >= "'. date('Y-m-d', strtotime($periode_awal)). '" and date(open_date) <= "'. date('Y-m-d', strtotime($periode_akhir)).'"')
        ->order_by('meta_category,main_category,category,sub_category')
        ->group_by('meta_category,main_category,category,sub_category')
        ->get($this->table)->result();




//query total open
  $brandOpen = $this->db->select("IF(status='open',1,0) as total,meta_category,main_category, category,sub_category,brand")
      ->where('type',$type)
      ->where('date(open_date) >= "'. date('Y-m-d', strtotime($periode_awal)). '" and date(open_date) <= "'. date('Y-m-d', strtotime($periode_akhir)).'"')
      ->get($this->table)->result();


//query total close
  $brandClose=$this->db->select("IF(status='closed',1,0) as total ,meta_category 
                    ,main_category,category,sub_category,brand")
           ->where('type',$type)
           ->where('date(open_date) >= "'. date('Y-m-d', strtotime($periode_awal)). '" and date(open_date) <= "'. date('Y-m-d', strtotime($periode_akhir)).'"')
           ->get($this->table)->result();


  
//revisi
    $meta='';
    $main='';
    $category='';
    $datas=[];
    $kate='';
    $subkategory='';
    $sub_kate='';
    $jml_main_cat=''; 
    $jml_meta_cat=''; 
    $j=0;
    $index=0;
    $category_open=0;
    $category_close=0;
    $totalPresentase=0;

    $jumlahTotal=$this->findBrandOpenClose('','','','','','grant_total_all',                     $brandClose,$type);

    foreach ($tickets as $key => $ticket) {
  // total  kategori pada masing2

/*if($level==3 || $level==4 || $level==0){ 
    if($sub_kate!=$ticket->meta_category.$ticket->main_category.$ticket->category.$ticket->sub_category){
        $j=$key; 
      if ( $key!=0){
          $datas[$index]['type']='c';
          $datas[$index]['meta_categorys']=$tickets[$j-1]->meta_category;
          $datas[$index]['main_categorys']=$tickets[$j-1]->main_category;  
          $datas[$index]['meta_category']='';
          $datas[$index]['main_category']='';  
          $datas[$index]['category']=$tickets[$j-1]->category;  
          $datas[$index]['categorys']=$tickets[$j-1]->category;  
          $datas[$index]['sub_category']=$tickets[$j-1]->sub_category.' Total';  
          $datas[$index]['sub_categorys']=$tickets[$j-1]->sub_category.' Total';  
          
    foreach ($brands as $brand) {
          $datas[$index][$brand->brand_name]['open']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                $tickets[$j-1]->main_category,
                                                $tickets[$j-1]->category,
                                                $tickets[$j-1]->sub_category,
                                                  $brand->brand_name,
                                                  'sub_category',
                                                  $brandOpen,$type);


          $datas[$index][$brand->brand_name]['close']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                $tickets[$j-1]->main_category,
                                                $tickets[$j-1]->category,
                                                  $tickets[$j-1]->sub_category,
                                                  $brand->brand_name,
                                                  'sub_category',
                                                  $brandClose,$type);


      }
          $datas[$index]['open']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                $tickets[$j-1]->main_category,
                                                $tickets[$j-1]->category,
                                                  $tickets[$j-1]->sub_category,
                                                  '',
                                                  'grant_total_sub_category',
                                                  $brandOpen,$type);



            $datas[$index]['close']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                $tickets[$j-1]->main_category,
                                                $tickets[$j-1]->category,
                                                $tickets[$j-1]->sub_category,
                                                  '',
                                                  'grant_total_sub_category',
                                                  $brandClose,$type);



    $datas[$index]['presentase']='';
    $index++;

        }
      $sub_kate=$ticket->meta_category.$ticket->main_category.$ticket->category.$ticket->sub_category;
    }
}*/
if($level==3 || $level==4 || $level==0){ 
    if($kate!=$ticket->meta_category.$ticket->main_category.$ticket->category){
        $j=$key; 
      if ( $key!=0){
          $datas[$index]['type']='c';
          $datas[$index]['meta_categorys']=$tickets[$j-1]->meta_category;
          $datas[$index]['main_categorys']=$tickets[$j-1]->main_category;  
          $datas[$index]['meta_category']='';
          $datas[$index]['main_category']='';  
          $datas[$index]['category']=$tickets[$j-1]->category.' Total';  
          $datas[$index]['categorys']=$tickets[$j-1]->category.' Total';  
          $datas[$index]['sub_category']='';  
          
    foreach ($brands as $brand) {
          $datas[$index][$brand->brand_name]['open']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                $tickets[$j-1]->main_category,
                                                $tickets[$j-1]->category,
                                                  '',
                                                  $brand->brand_name,
                                                  'category',
                                                  $brandOpen,$type);


          $datas[$index][$brand->brand_name]['close']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                $tickets[$j-1]->main_category,
                                                $tickets[$j-1]->category,
                                                  '',
                                                  $brand->brand_name,
                                                  'category',
                                                  $brandClose,$type);


      }
          $datas[$index]['open']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                $tickets[$j-1]->main_category,
                                                $tickets[$j-1]->category,
                                                  '',
                                                  '',
                                                  'grant_total_category',
                                                  $brandOpen,$type);



            $datas[$index]['close']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                $tickets[$j-1]->main_category,
                                                $tickets[$j-1]->category,
                                                  '',
                                                  '',
                                                  'grant_total_category',
                                                  $brandClose,$type);



    $datas[$index]['presentase']='';
    $index++;

        }
      $kate=$ticket->meta_category.$ticket->main_category.$ticket->category;
    }
}

    //jml main_category
if($level==2 || $level==3 || $level==4 || $level==0){
    if($jml_main_cat!=$ticket->meta_category.$ticket->main_category){
        $j=$key; 
      if ( $key!=0){
    $datas[$index]['type']='main_c';
    $datas[$index]['meta_categorys']=$tickets[$j-1]->meta_category;
    $datas[$index]['main_categorys']=$tickets[$j-1]->main_category.' Total';  

    $datas[$index]['meta_category']='';
    $datas[$index]['main_category']=$tickets[$j-1]->main_category.' Total';  
    $datas[$index]['category']='';  
    $datas[$index]['categorys']='';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {
      $datas[$index][$brand->brand_name]['open']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                  $tickets[$j-1]->main_category,
                                                  '',
                                                  '',
                                                  $brand->brand_name,
                                                  'main_category',
                                                  $brandOpen,$type);


      $datas[$index][$brand->brand_name]['close']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                  $tickets[$j-1]->main_category,
                                                  '',
                                                  '',
                                                  $brand->brand_name,
                                                  'main_category',
                                                  $brandClose,$type);
  }

  $datas[$index]['open']=$this->findBrandOpenClose($tickets[$j-1]->meta_category,
                            $tickets[$j-1]->main_category,
                            '',
                            '',
                            '',
                            'grant_total_main_category',
                            $brandOpen,$type);


  $datas[$index]['close']=$this->findBrandOpenClose($tickets[$j-1]->meta_category,
                            $tickets[$j-1]->main_category,
                            '',
                            '',
                            '',
                            'grant_total_main_category',
                            $brandClose,$type);
  

    $datas[$index]['presentase']=
      number_format((($datas[$index]['close']/(int)$jumlahTotal)*100),'2','.',',') .'%';
      

    $index++;

        }
      
      $jml_main_cat=$ticket->meta_category.$ticket->main_category;
    }
}


//jml meta_category
if($level==1 || $level==2 || $level==3 || $level==4 || $level==0){
    if($jml_meta_cat!=$ticket->meta_category){
        $j=$key; 
      if ( $key!=0){
    $datas[$index]['type']='meta_c';
    $datas[$index]['meta_categorys']=$tickets[$j-1]->meta_category.' Total';
    $datas[$index]['main_categorys']='';  

    $datas[$index]['meta_category']=$tickets[$j-1]->meta_category.' Total';
    $datas[$index]['main_category']='';  
    $datas[$index]['category']='';  
    $datas[$index]['categorys']='  ';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {

      $datas[$index][$brand->brand_name]['open']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                  '',
                                                  '',
                                                  '',
                                                  $brand->brand_name,
                                                  'meta_category',
                                                  $brandOpen,$type);

  $datas[$index][$brand->brand_name]['close']=$this->findBrandOpenClose(
                                                  $tickets[$j-1]->meta_category,
                                                  '',
                                                  '',
                                                  '',
                                                  $brand->brand_name,
                                                  'meta_category',
                                                  $brandClose,$type);
    }
  $datas[$index]['open']=$this->findBrandOpenClose($tickets[$j-1]->meta_category,
                            '',
                            '',
                            '',
                            '',
                            'grant_total_meta_category',
                            $brandOpen,$type);


  $datas[$index]['close']=$this->findBrandOpenClose($tickets[$j-1]->meta_category,
                            '',
                            '',
                            '',
                            '',
                            'grant_total_meta_category',
                            $brandClose,$type);

    $datas[$index]['presentase']=
      number_format((($datas[$index]['close']/(int)$jumlahTotal)*100),'2','.',',') .'%';
    $totalPresentase+=($datas[$index]['close']/(int)$jumlahTotal)*100;

    $index++;

        }
      
      $jml_meta_cat=$ticket->meta_category;
    }
}


// detail
    $open=0;
    $close=0;
if($level==0 || $level==4){
          $datas[$index]['type']='';
      $datas[$index]['meta_categorys']=$ticket->meta_category;
      if($meta!=$ticket->meta_category){  
          $datas[$index]['meta_category']=$ticket->meta_category;
          $meta=$ticket->meta_category;
      }else{
          $datas[$index]['meta_category']='';
      }
      $datas[$index]['main_categorys']=$ticket->main_category;  
      if($main!=$ticket->meta_category.$ticket->main_category){    
             $datas[$index]['main_category']=$ticket->main_category;  
             $main=$ticket->meta_category.$ticket->main_category;
      }else{
          $datas[$index]['main_category']='';  
      }

      $datas[$index]['category']=$ticket->category;
      
      if($category!=$ticket->meta_category.$ticket->main_category.$ticket->category){    
           $datas[$index]['categorys']=$ticket->category;
           $category=$ticket->meta_category.$ticket->main_category.$ticket->category;
      }
      else{
          $datas[$index]['categorys']='';  
      }
      $datas[$index]['sub_categorys']=$ticket->sub_category;  
      if($subkategory!=$ticket->meta_category.$ticket->main_category.$ticket->category.$ticket->sub_category){/*    echo ($subkategory.'!='.$ticket->meta_category.$ticket->main_category.$ticket->category.$ticket->sub_category.'<br>');*/
        
             $datas[$index]['sub_category']=$ticket->sub_category;  
             $subkategory=$ticket->meta_category.$ticket->main_category.$ticket->category.$ticket->sub_category;
      }else{
          $datas[$index]['sub_category']='';  
      }
      foreach ($brands as $brand) {
  $datas[$index][$brand->brand_name]['open']=
  $this->findBrandOpenClose($ticket->meta_category,$ticket->main_category,$ticket->category,$ticket->sub_category,$brand->brand_name,'detail',$brandOpen,$type);

  $open+=(int)$datas[$index][$brand->brand_name]['open'];
  
  $datas[$index][$brand->brand_name]['close']=$this->findBrandOpenClose($ticket->meta_category,$ticket->main_category,$ticket->category,$ticket->sub_category,$brand->brand_name,'detail',$brandClose,$type);

  $close+=(int)$datas[$index][$brand->brand_name]['close'];
                
      }
  $datas[$index]['open']=$open;  
  $datas[$index]['close']=$close;
  $datas[$index]['presentase']='';
  $index++;
    }
}
// selesai  detail


if(count($tickets)!=0){
  // total bawah
if($level==3 || $level==4 || $level==0){ 
    $datas[$index]['type']='c';
    $datas[$index]['meta_categorys']=$tickets[$j]->meta_category;
    $datas[$index]['main_categorys']=$tickets[$j]->main_category;  
    $datas[$index]['meta_category']='';
    $datas[$index]['main_category']='';  
    $datas[$index]['category']=$tickets[$j]->category.' Total';  
    $datas[$index]['categorys']=$tickets[$j]->category.' Total';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {

  
      $datas[$index][$brand->brand_name]['open']=$this->findBrandOpenClose(
                                                   $tickets[$j]->meta_category,
                                                   $tickets[$j]->main_category,
                                                   $tickets[$j]->category,
                                                   '',
                                                   $brand->brand_name,
                                                   'category',
                                                   $brandOpen,$type);




  $datas[$index][$brand->brand_name]['close']=$this->findBrandOpenClose(
                                                   $tickets[$j]->meta_category,
                                                   $tickets[$j]->main_category,
                                                   $tickets[$j]->category,
                                                   '',
                                                   $brand->brand_name,
                                                   'category',
                                                   $brandClose,$type);
          


      }
  $datas[$index]['open']=$this->findBrandOpenClose($tickets[$j]->meta_category,
                                                   $tickets[$j]->main_category,
                                                   $tickets[$j]->category,
                                                   '',
                                                   '',
                                                   'grant_total_category',
                                                   $brandOpen,$type);

  $datas[$index]['close']=$this->findBrandOpenClose($tickets[$j]->meta_category,
                                                   $tickets[$j]->main_category,
                                                   $tickets[$j]->category,
                                                   '',
                                                   '',
                                                   'grant_total_category',
                                                   $brandClose,$type);
    $datas[$index]['presentase']='';
    $index++;
}




if($level==2 || $level==3 || $level==4 || $level==0){
    $datas[$index]['type']='main_c';
    $datas[$index]['meta_categorys']=$tickets[$j]->meta_category;
    $datas[$index]['main_categorys']=$tickets[$j]->main_category .' Total';  
    $datas[$index]['meta_category']='';
    $datas[$index]['main_category']=$tickets[$j]->main_category .' Total';  
    $datas[$index]['category']='';  
    $datas[$index]['categorys']='';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {
      $datas[$index][$brand->brand_name]['open']=$this->findBrandOpenClose(
                                                  $tickets[$j]->meta_category,
                                                  $tickets[$j]->main_category,
                                                  '',
                                                  '',
                                                  $brand->brand_name,
                                                  'main_category',
                                                  $brandOpen,$type);

          
      $datas[$index][$brand->brand_name]['close']=$this->findBrandOpenClose(
                                                  $tickets[$j]->meta_category,
                                                  $tickets[$j]->main_category,
                                                  '',
                                                  '',
                                                  $brand->brand_name,
                                                  'main_category',
                                                  $brandClose,$type);
  }

  $datas[$index]['open']=$this->findBrandOpenClose($tickets[$j]->meta_category,
                                                  $tickets[$j]->main_category,
                                                  '',
                                                  '',
                                                  '',
                                                  'grant_total_main_category',
                                                  $brandOpen,$type);


  $datas[$index]['close']=$this->findBrandOpenClose($tickets[$j]->meta_category,
                                                  $tickets[$j]->main_category,
                                                  '',
                                                  '',
                                                  '',
                                                  'grant_total_main_category',
                                                  $brandClose,$type);

    $datas[$index]['presentase']= number_format((($datas[$index]['close']/(int)$jumlahTotal)*100),'2','.',',') .'%';
    $index++;
}

if($level==1 || $level==2 || $level==3 || $level==4 || $level==0){
    $datas[$index]['type']='meta_c';
    $datas[$index]['meta_categorys']=$tickets[$j]->meta_category.' Total';
    $datas[$index]['main_categorys']='';  
    $datas[$index]['meta_category']=$tickets[$j]->meta_category.' Total';
    $datas[$index]['main_category']='';  
    $datas[$index]['category']='';  
    $datas[$index]['categorys']='';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {

      $datas[$index][$brand->brand_name]['open']=$this->findBrandOpenClose(
                                                  $tickets[$j]->meta_category,
                                                  '',
                                                  '',
                                                  '',
                                                  $brand->brand_name,
                                                  'meta_category',
                                                  $brandOpen,$type);

  $datas[$index][$brand->brand_name]['close']=$this->findBrandOpenClose(
                                                  $tickets[$j]->meta_category,
                                                  '',
                                                  '',
                                                  '',
                                                  $brand->brand_name,
                                                  'meta_category',
                                                  $brandClose,$type);
    }


  $datas[$index]['open']=$this->findBrandOpenClose($tickets[$j]->meta_category,
                            '',
                            '',
                            '',
                            '',
                            'grant_total_meta_category',
                            $brandOpen,$type);
  $datas[$index]['close']=$this->findBrandOpenClose($tickets[$j]->meta_category,
                            '',
                            '',
                            '',
                            '',
                            'grant_total_meta_category',
                            $brandClose,$type);

    $datas[$index]['presentase']=
      number_format((($datas[$index]['close']/(int)$jumlahTotal)*100),'2','.',',') .'%';
    $totalPresentase+=($datas[$index]['close']/(int)$jumlahTotal)*100;

    $index++;
}


//total terakhir
    $datas[$index]['type']='akhir';
    $datas[$index]['meta_categorys']='Grand Total';
    $datas[$index]['main_categorys']='          ';  
    $datas[$index]['meta_category']='Grand Total';
    $datas[$index]['main_category']='';  
    $datas[$index]['category']='       ';    
    $datas[$index]['categorys']='';    
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {
      $datas[$index][$brand->brand_name]['open']=$this->findBrandOpenClose('','','','',$brand->brand_name,
        'grant_total_brand',$brandOpen,$type);

    
    $datas[$index][$brand->brand_name]['close']=$this->findBrandOpenClose('','','','',$brand->brand_name,
      'grant_total_brand',$brandClose,$type);

      }

    $datas[$index]['open']=$this->findBrandOpenClose('','','','','','grant_total_all',                     $brandOpen,$type);
    $datas[$index]['close']=$this->findBrandOpenClose('','','','','','grant_total_all',                     $brandClose,$type);
    $datas[$index]['presentase']=
    number_format($totalPresentase,'0','.',',').'%';
  }


    $data=['brands'=>$brands,'data'=>$datas];
    return $data;
   }
    function findBrandOpenClose($meta_category=null,$main_category=null,$category=null,
                                $sub_category=null,$brand=null,$fungsi,$data,$type){
      $type=strtolower($type);
      $totalBrandOpenClose=0;
      //menghitung detail
      
              if($fungsi=='detail'){
                      foreach ($data as $key => $val) {
                        if($type=='nespresso'){
                          $brand='nespresso';
                          $val->brand='nespresso';
                        }
                        if($meta_category==$val->meta_category
                            && $main_category==$val->main_category
                            && $category==$val->category
                            && $sub_category==$val->sub_category
                            && $brand==$val->brand){
                               $totalBrandOpenClose+=$val->total;
                            }
                      }
              }

              if($fungsi=='sub_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                          $brand='nespresso';
                          $val->brand='nespresso';
                        }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              && $category==$val->category
                              && $sub_category==$val->sub_category
                              && $brand==$val->brand){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }

              if($fungsi=='category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                          $brand='nespresso';
                          $val->brand='nespresso';
                        }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              && $category==$val->category
                              && $brand==$val->brand){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }


              if($fungsi=='main_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                          $brand='nespresso';
                          $val->brand='nespresso';
                        }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              && $brand==$val->brand){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }

              if($fungsi=='meta_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                              $brand='nespresso';
                              $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category
                              && $brand==$val->brand){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }

              if($fungsi=='grant_total_sub_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                              $brand='nespresso';
                              $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              && $category==$val->category
                              && $sub_category==$val->sub_category){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }

              if($fungsi=='grant_total_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                              $brand='nespresso';
                              $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              && $category==$val->category){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }

              if($fungsi=='grant_total_main_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                              $brand='nespresso';
                              $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              ){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }


              if($fungsi=='grant_total_meta_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                              $brand='nespresso';
                              $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }

              if($fungsi=='grant_total_brand'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                              $brand='nespresso';
                              $val->brand='nespresso';
                          }
                          if($brand==$val->brand){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }


              if($fungsi=='grant_total_all'){
                        foreach ($data as $key => $val) {
                                 $totalBrandOpenClose+=$val->total;
                        }
              }

              return $totalBrandOpenClose;
    }

   //data atas

    public function list_data_atas($type,
    $periode_awal=null,$periode_akhir=null,$level){
   $brands=$this->db->select('brand_name')->get('v_brand')->result();

    if($type!='kanmo'){
        $brands=[];
        $brands[0]=(object)array('brand_name'=>'nespresso');
    }
  
  /*nespresso*/

    $tickets = $this->db->select('meta_category,main_category,category,sub_category,brand,status')
    ->where('type',$type)
    ->where('date(open_date) >= "'. date('Y-m-d', strtotime($periode_awal)). '" and date(open_date) <= "'. date('Y-m-d', strtotime($periode_akhir)).'"')
    ->order_by('meta_category,main_category,category,sub_category')
    ->group_by('meta_category,main_category,category,sub_category')
    ->get($this->table)->result();


  $all_data=$this->db->select("1 as total, meta_category,main_category, 
            category,sub_category,brand")
            ->where('type',$type)
            ->where('date(open_date) >= "'. date('Y-m-d', strtotime($periode_awal)). '" and date(open_date) <= "'. date('Y-m-d', strtotime($periode_akhir)).'"')
            ->get($this->table)
            ->result();
  




    $meta='';
    $main='';
    $category='';
    $datas=[];
    $kate=''; 
    $jml_main_cat=''; 
    $jml_meta_cat='';
    $j=0;
    $index=0;
    $category_open=0;
    $category_close=0;
    $totalPresentase=0;
    $rowSpanC=0;

    $jumlahTotal=$this->findAll('','','','','','grant_total_all',$all_data,$type);


    foreach ($tickets as $key => $ticket) {
    //total category

if($level==3 || $level==4 || $level==0){ 
    if($kate!=$ticket->meta_category.$ticket->main_category.$ticket->category){
        $j=$key; 
      if ( $key!=0){
    $datas[$index]['type']='c';
    $datas[$index]['rowSpanC']=$rowSpanC;
    $datas[$index]['meta_categorys']=$tickets[$j-1]->meta_category;
    $datas[$index]['main_categorys']=$tickets[$j-1]->main_category;  

    $datas[$index]['meta_category']='';
    $datas[$index]['main_category']='';  
    $datas[$index]['category']=$tickets[$j-1]->category.' Total';  
    $datas[$index]['categorys']=$tickets[$j-1]->category.' Total';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {

          $datas[$index][$brand->brand_name]=$this->findAll($tickets[$j-1]->meta_category,
                                        $tickets[$j-1]->main_category,
                                        $tickets[$j-1]->category,
                                        '',
                                        $brand->brand_name,
                                        'category',
                                        $all_data,
                                        $type); 

  
    }
  $datas[$index]['close']=$this->findAll($tickets[$j-1]->meta_category,
                                  $tickets[$j-1]->main_category,
                                  $tickets[$j-1]->category,
                                  '',
                                  '',
                                  'grant_total_category',
                                  $all_data,
                                  $type);  
    $datas[$index]['presentase']='';
    $index++;

        }
      $kate=$ticket->meta_category.$ticket->main_category.$ticket->category;
    }
}

//jml main_category
if($level==2 || $level==3 || $level==4 || $level==0){
    if($jml_main_cat!=$ticket->meta_category.$ticket->main_category){
        $j=$key; 
      if ( $key!=0){
    $datas[$index]['type']='main_c';
    $datas[$index]['meta_categorys']=$tickets[$j-1]->meta_category;
    $datas[$index]['main_categorys']=$tickets[$j-1]->main_category.' Total';  

    $datas[$index]['meta_category']='';
    $datas[$index]['main_category']=$tickets[$j-1]->main_category.' Total';  
    $datas[$index]['category']='';  
    $datas[$index]['categorys']='';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {
        $datas[$index][$brand->brand_name]=$this->findAll($tickets[$j-1]->meta_category,
                                                      $tickets[$j-1]->main_category,
                                                      '',
                                                      '',
                                                      $brand->brand_name,
                                                      'main_category',
                                                      $all_data
                                                      ,$type); 


    }
  $datas[$index]['close']=$this->findAll($tickets[$j-1]->meta_category,
                                          $tickets[$j-1]->main_category,
                                          '',
                                          '',
                                          '',
                                          'grant_total_main_category',
                                          $all_data
                                          ,$type);  

    $datas[$index]['presentase']=number_format((($datas[$index]['close']/(int)$jumlahTotal)*100),'2','.',',') .'%';
    $index++;

        }
      
      $jml_main_cat=$ticket->meta_category.$ticket->main_category;
    }
}


//jml meta_category
if($level==1 || $level==2 || $level==3 || $level==4 || $level==0){
    if($jml_meta_cat!=$ticket->meta_category){
        $j=$key; 
      if ( $key!=0){
    $datas[$index]['type']='meta_c';
    $datas[$index]['meta_categorys']=$tickets[$j-1]->meta_category.' Total';
    $datas[$index]['main_categorys']='';  

    $datas[$index]['meta_category']=$tickets[$j-1]->meta_category.' Total';
    $datas[$index]['main_category']='';  
    $datas[$index]['category']='';  
    $datas[$index]['categorys']='';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {
          $datas[$index][$brand->brand_name]=$this->findAll($tickets[$j-1]->meta_category,
                                                      '',
                                                      '',
                                                      '',
                                                      $brand->brand_name,
                                                      'meta_category',
                                                      $all_data,
                                                      $type); 

    }
  $datas[$index]['close']=$this->findAll($tickets[$j-1]->meta_category,
                                          '',
                                          '',
                                          '',
                                          '',
                                          'grant_total_meta_category',
                                          $all_data,
                                          $type);  

    $datas[$index]['presentase']=
      number_format((($datas[$index]['close']/(int)$jumlahTotal)*100),'2','.',',') .'%';
    $totalPresentase+=($datas[$index]['close']/(int)$jumlahTotal)*100;

    $index++;

        }
      
      $jml_meta_cat=$ticket->meta_category;
    }
}


//detail



    $open=0;
    $close=0;
    $rowSpanC++;
  
if($level==0 || $level==4){

    $datas[$index]['type']='';
        $datas[$index]['meta_categorys']=$ticket->meta_category;
        $datas[$index]['main_categorys']=$ticket->main_category;  
      if($meta!=$ticket->meta_category){  
          $datas[$index]['meta_category']=$ticket->meta_category;
          $meta=$ticket->meta_category;
      }else{
          $datas[$index]['meta_category']='';
      }

      if($main!=$ticket->meta_category.$ticket->main_category){    
             $datas[$index]['main_category']=$ticket->main_category;  
             $main=$ticket->meta_category.$ticket->main_category;
      }else{
          $datas[$index]['main_category']='';  
      }

      $datas[$index]['category']=$ticket->category;
      
      if($category!=$ticket->meta_category.$ticket->main_category.$ticket->category){
           $datas[$index]['categorys']=$ticket->category;
           $category=$ticket->meta_category.$ticket->main_category.$ticket->category;
      }
      else{
          $datas[$index]['categorys']='';  
      }
      $datas[$index]['sub_category']=$ticket->sub_category;    
      foreach ($brands as $brand) {
  $datas[$index][$brand->brand_name]=$this->findAll($ticket->meta_category,$ticket->main_category,
                    $ticket->category,$ticket->sub_category,$brand->brand_name,'detail',$all_data,$type);

  $close+=(int)$datas[$index][$brand->brand_name];
      }
  
  $datas[$index]['close']=$close;
  $datas[$index]['presentase']='';
  $datas[$index]['rowSpanC']='';

  $index++;
}


    }

if(count($tickets)!=0){
  if($level==3 || $level==4 || $level==0){ 
  $datas[$index]['type']='c';
    $datas[$index]['meta_categorys']=$tickets[$j-1]->meta_category;
    $datas[$index]['main_categorys']='';  

    $datas[$index]['meta_category']='';
    $datas[$index]['main_category']='';  
    $datas[$index]['category']=$tickets[$j]->category.' Total';  
    $datas[$index]['categorys']=$tickets[$j]->category.' Total';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {
          $datas[$index][$brand->brand_name]=$this->findAll($tickets[$j]->meta_category,
                                                        $tickets[$j]->main_category,
                                                        $tickets[$j]->category,
                                                        '',
                                                        $brand->brand_name,
                                                        'category',
                                                        $all_data,
                                                        $type);
    }
  $datas[$index]['close']=$this->findAll($tickets[$j]->meta_category,
                                                        $tickets[$j]->main_category,
                                                        $tickets[$j]->category,
                                                        '',
                                                        $brand->brand_name,
                                                        'grant_total_category',
                                                        $all_data,
                                                        $type);
    $datas[$index]['presentase']='';
    $index++;
}

//total main category
if($level==2 || $level==3 || $level==4 || $level==0){
  $datas[$index]['type']='main_c';
  $datas[$index]['meta_categorys']=$tickets[$j]->meta_category;
    $datas[$index]['main_categorys']=$tickets[$j]->main_category.' Total';  

  $datas[$index]['meta_category']='';
    $datas[$index]['main_category']=$tickets[$j]->main_category.' Total';  
    $datas[$index]['category']='';  
    $datas[$index]['categorys']='';  
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {
          $datas[$index][$brand->brand_name]=$this->findAll($tickets[$j]->meta_category,
                                                        $tickets[$j]->main_category,
                                                        'coba',
                                                        '',
                                                        $brand->brand_name,
                                                        'main_category',
                                                        $all_data,
                                                        $type);
    }
  $datas[$index]['close']=$this->findAll($tickets[$j]->meta_category,
                                                        $tickets[$j]->main_category,
                                                        '',
                                                        '',
                                                        $brand->brand_name,
                                                        'grant_total_main_category',
                                                        $all_data,
                                                        $type);
    $datas[$index]['presentase']=number_format((($datas[$index]['close']/(int)$jumlahTotal)*100),'2','.',',') .'%';
    $index++;
}

//meta category
if($level==1 || $level==2 || $level==3 || $level==4 || $level==0){
    $datas[$index]['type']='meta_c';
    $datas[$index]['meta_categorys']=$tickets[$j]->meta_category.' Total';
    $datas[$index]['main_categorys']='';  


    $datas[$index]['meta_category']=$tickets[$j]->meta_category.' Total';
    $datas[$index]['main_category']=$tickets[$j]->category;  
    $datas[$index]['category']='';  
    $datas[$index]['categorys']='';  
    $datas[$index]['sub_category']='';  

    foreach ($brands as $brand) {

          $datas[$index][$brand->brand_name]=$this->findAll($tickets[$j]->meta_category,
                                                        '',
                                                        '',
                                                        '',
                                                        $brand->brand_name,
                                                        'meta_category',
                                                        $all_data,
                                                        $type);
    }
  $datas[$index]['close']=$this->findAll($tickets[$j]->meta_category,
                                                        '',
                                                        '',
                                                        '',
                                                        $brand->brand_name,
                                                        'grant_total_meta_category',
                                                        $all_data,
                                                        $type);
    $datas[$index]['presentase']=      number_format((($datas[$index]['close']/(int)$jumlahTotal)*100),'2','.',',') .'%';
    $totalPresentase+=($datas[$index]['close']/(int)$jumlahTotal)*100;

    $index++;
}



$datas[$index]['type']='akhir';
$datas[$index]['meta_categorys']='Grand Total';
    $datas[$index]['main_categorys']='   ';  
  $datas[$index]['meta_category']='Grand Total';
    $datas[$index]['main_category']='';  
    $datas[$index]['category']='          ';    
    $datas[$index]['categorys']='';    
    $datas[$index]['sub_category']='';  
    foreach ($brands as $brand) {
      $datas[$index][$brand->brand_name]=$this->findAll('','','','',$brand->brand_name,
                                    'grant_total_brand',$all_data,$type);

      }
    $datas[$index]['close']=$this->findAll('','','','','','grant_total_all',$all_data,$type);
    $datas[$index]['presentase']=
    number_format($totalPresentase,'2','.',',').'%';
  }


    $data=['brands'=>$brands,'data'=>$datas];
    return $data;
   }


    function findAll($meta_category=null,$main_category=null,$category=null,
                                $sub_category=null,$brand=null,$fungsi,$data,$type){
      $totalBrandOpenClose=0;
      //menghitung detail
      $type=strtolower($type);

              if($fungsi=='detail'){
                      foreach ($data as $key => $val) {
                        if($type=='nespresso'){
                          $brand='nespresso';
                          $val->brand='nespresso';
                        }
                        if($meta_category==$val->meta_category
                            && $main_category==$val->main_category
                            && $category==$val->category
                            && $sub_category==$val->sub_category
                            && $brand==$val->brand){
                               $totalBrandOpenClose+=$val->total;
                            }
                      }
              }


              if($fungsi=='category'){

                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                            $brand='nespresso';
                            $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              && $category==$val->category
                              && $brand==$val->brand){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }


              if($fungsi=='main_category'){

                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                            $brand='nespresso';
                            $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              && $brand==$val->brand){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }

              if($fungsi=='meta_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                            $brand='nespresso';
                            $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category
                              && $brand==$val->brand){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }


              if($fungsi=='grant_total_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                            $brand='nespresso';
                            $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              && $category==$val->category){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }

              if($fungsi=='grant_total_main_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                            $brand='nespresso';
                            $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category
                              && $main_category==$val->main_category
                              ){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }


              if($fungsi=='grant_total_meta_category'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                            $brand='nespresso';
                            $val->brand='nespresso';
                          }
                          if($meta_category==$val->meta_category){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }

              if($fungsi=='grant_total_brand'){
                        foreach ($data as $key => $val) {
                          if($type=='nespresso'){
                            $brand='nespresso';
                            $val->brand='nespresso';
                          }
                          if($brand==$val->brand){
                                 $totalBrandOpenClose+=$val->total;
                              }
                        }
              }


              if($fungsi=='grant_total_all'){
                        foreach ($data as $key => $val) {
                                 $totalBrandOpenClose+=$val->total;
                        }
              }

              return $totalBrandOpenClose;
    }





}
