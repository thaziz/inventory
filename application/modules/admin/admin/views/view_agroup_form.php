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
        Agent Group
        <small> Insert</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('panel/admin');?>">Administrator</a></li>
        <li><a href="<?=base_url('panel/admin/agent_group');?>">Agent Group</a></li>
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
                      <label class="col-sm-2 control-label" for="group_name">Group Name *</label>
                      <div class="col-sm-4">
                        <input type="text" placeholder="Group Name" name = "group_name" id="group_name" class="form-control" value="<?php echo (isset($data->group_name)) ? $data->group_name : ''; ?>">
                        <span class="info"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="description">Description</span></label>
                      <div class="col-sm-4">
                        <textarea placeholder="Group Description" name = "description" id="description" class="form-control"><?php echo (isset($data->description)) ? $data->description : ''; ?></textarea>
                        <span class="info"></span>
                      </div>
                    </div>
                </div>

                <div class="box-footer">
                  <div class="col-md-2 col-sm-offset-2">
                    <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
                    <a href="<?php echo base_url('panel/admin/agent_group'); ?>" class="btn btn-default">Back</a>
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
    var id        = '<?php echo (isset($data->group_id)) ? $data->group_id : '' ; ?>';
    var decision  = '<?php echo $decision; ?>';
    var final     = (decision == 'edit') ? decision+'/'+id : decision;

    $('form#ivr_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
          url : base_url+'panel/admin/agent_group/'+final,
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
                    window.location = "<?=base_url('panel/admin/agent_group');?>";
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