$(document).ready(function(){
    /*var ctx = document.getElementById("status_data_Chart").getContext('2d');
    var ids =   $('#status_data_Chart').attr('data-id');
    var options =   {
        scaleBeginAtZero : true,
        animation : true,
        animationSteps : 60,
        animationEasing : "easeOutQuart",
        scales: {
            xAxes: [{
                barThickness : 1
            }],
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    barThickness : 1
                }
            }]
        }
    };
    $.get(base_url+"campaign/status_data",{id : ids},function(data, status){
        if (status == 'success') {
            var obj     =   JSON.parse(data);
            var results =   obj.result;
            new Chart(ctx).Bar(results,options);
        } else {
            alert('Status data goes wrong');
        }
    });*/
    var ids =   $('#answer-st').attr('data-id');
    $.get(base_url+"campaign/status_data",{id : ids},function(data, status){
        var obj     = JSON.parse(data);
        var res_    =   obj.result;
        for (var index = 0; index < res_.length; index++) {
            if (res_[index].status == 'status empty') {
                $('#status-empty').append(res_[index].status_count);
                $('#status-empty-width').css({"width":res_[index].status_count+'%'});
            }else if(res_[index].status == 'Call Back'){
                $('#call-back').append(res_[index].status_count);
                $('#call-back-width').css({"width":res_[index].status_count+'%'});
            }else if(res_[index].status == 'Complete'){
                $('#complete').append(res_[index].status_count);
                $('#complete-width').css({"width":res_[index].status_count+'%'});
            }else if(res_[index].status == 'NPU'){
                $('#npu').append(res_[index].status_count);
                $('#npu-width').css({"width":res_[index].status_count+'%'});
            }
        }
    });
});