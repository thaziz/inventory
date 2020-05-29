
    var callChart = '';
    var ids = $('#callChart').attr('data-id');
    // Get context with jQuery - using jQuery's .get() method.
    var ctx = $("#callChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var callChartData = {
    labels: [''],
    datasets: [
            {
            label: "Wrong Number",
            backgroundColor: "#ccc",
            borderColor: "#ccc",
            fill: false,
            //pointColor: "#ccc",
            //pointHighlightFill: "#fff",
            //pointHighlightStroke: "#ccc",
            data: [0]
          },
          {
            label: "Busy",
            backgroundColor: "#337ab7",
            borderColor: "#337ab7",
            fill: false,
            //pointColor: "#337ab7",
            //pointHighlightFill: "#fff",
            //pointHighlightStroke: "#337ab7",
            data: [0]
          },
          {
            label: "Contacted",
            backgroundColor: "rgba(0, 166, 90,0.8)",
            borderColor: "rgba(0, 166, 90,0.8)",
            fill: false,
            //pointColor: "#00a65a",
            //pointHighlightFill: "#fff",
            //pointHighlightStroke: "rgba(0, 166, 90,1)",
            data: [0]
          },
          {
            label: "Not Active",
            backgroundColor: "rgba(243, 156, 18,0.8)",
            borderColor: "rgba(243, 156, 18,0.8)",
            fill: false,
            //pointColor: "#f39c12",
            //pointHighlightFill: "#fff",
            //pointHighlightStroke: "rgba(243, 156, 18,1)",
            data: [0]
          },
          {
            label: "Not Answer",
            backgroundColor: "rgba(60,141,188,0.8)",
            borderColor: "rgba(60,141,188,0.8)",
            fill: false,
            //pointColor: "#3b8bba",
            //pointHighlightFill: "#fff",
            //pointHighlightStroke: "rgba(60,141,188,1)",
            data: [0]
          },
          {
            label: "Reject",
            backgroundColor: "rgba(221, 75, 57,0.8)",
            borderColor: "rgba(221, 75, 57,0.8)",
            fill: false,
            //pointColor: "#dd4b39",
            //pointHighlightFill: "#fff",
            //pointHighlightStroke: "rgba(221, 75, 57,1)",
            data: [0]
          },
                {
                label: "Callback",
                backgroundColor: "rgba(153, 102, 51,0.8)",
                borderColor: "rgba(153, 102, 51,0.8)",
                fill: false,
                data: [0]
              }
    ]

};

callChart = Chart.Line(ctx, {
        data: callChartData,
        options: {
            responsive: true,
            hoverMode: 'index',
            stacked: false,
            title: {
                display: false,
                text: 'Data Call in Campaign'
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                    }   
                }]
            },
            legend: {
                display: true
             },
             tooltip:{
                display: true
             },
             /*elements: {
                    point:{
                        radius: 0
                    }
                }*/
        }
    });
    /*callChart.destroy();*/
    //Create the line chart
    function set_line_data(data){
        var obj = data;
        callChartData.labels = obj.labels;
        callChartData.datasets[0].data = obj.wrong_number;
        callChartData.datasets[1].data = obj.busy;
        callChartData.datasets[2].data = obj.contacted;
        callChartData.datasets[3].data = obj.no_active;
        callChartData.datasets[4].data = obj.no_answer;
        callChartData.datasets[5].data = obj.reject;
        callChartData.datasets[6].data = obj.callback;
        callChart.update();
    }
    
