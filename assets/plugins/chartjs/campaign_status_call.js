$(document).ready(function(){
    var ctx = document.getElementById("status_call_Chart").getContext('2d');
    var ids =   $('#status_call_Chart').attr('data-id');
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
    $.get(base_url+"campaign/status_call",{id : ids},function(data, status){
        if (status == 'success') {
            var obj     =   JSON.parse(data);
            var results =   obj.result;
            new Chart(ctx).Bar(results,options);
        } else {
            alert('Status data goes wrong');
        }
    });
});