<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*echo '<pre>';
print_r($data);
echo '</pre>';
exit;*/
?>

<div class="content-wrapper">
  <section class="content-header">
      <h1>
        Ivr
        <small> Insert</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('panel/ivr');?>">Ivr</a></li>
        <li class="active">Insert</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <form class="form-horizontal" method="post" id="ivr_form">
                <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="adm_name">Ivr Name *</label>
                      <div class="col-sm-4">
                        <input type="text" placeholder="Ivr Name" name = "ivr_name" id="ivr_name" class="form-control" value="<?php echo (isset($data->ivr_name)) ? $data->ivr_name : ''; ?>">
                        <span class="info"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="adm_ext">Ivr Template *</span></label>
                      <div class="col-sm-4">
                        <input type="text" placeholder="Ivr Template" name = "ivr_template" id="ivr_template" class="form-control" value="<?php echo (isset($data->ivr_template)) ? $data->ivr_template : ''; ?>">
                        <span class="info"></span>
                      </div>
                    </div>
                </div>

                <div class="box-footer">
                  <div class="col-md-2 col-sm-offset-2">
                    <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
                    <a href="<?php echo base_url('panel/ivr'); ?>" class="btn btn-default">Back</a>
                  </div>
                </div>

            </form>
          </div>
        </div>
      </div>
  </section>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    var id        = '<?php echo (isset($data->id)) ? $data->id : '' ; ?>';
    var decision  = '<?php echo $decision; ?>';
    var final     = (decision == 'edit') ? decision+'/'+id : decision;

    $('form#ivr_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
          url : base_url+'panel/ivr/'+final,
          type: "POST",
          data : $('#ivr_form').serialize(),
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(!data.status){
                $.each(data.e, function(key, val){
                  $('[name="'+key+'"] + .info').html(val);
                });
              }else{
                $().toastmessage('showToast', {
                  text     : decision+' data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/ivr');?>";
                  }
                });
              }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    });
  });
</script>