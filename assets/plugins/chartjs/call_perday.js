$(document).ready(function(){
	var callChart = '';
	var ids = $('#callChart').attr('data-id');
	// Get context with jQuery - using jQuery's .get() method.
  	var callChartCanvas = $("#callChart").get(0).getContext("2d");
  	// This will get the first returned node in the jQuery collection.
  	if (callChart) callChart.destroy();

  	callChart = new Chart(callChartCanvas);

  	var callChartData = {};

  	var callChartOptions = {
	    //Boolean - If we should show the scale at all
	    showScale: true,
	    //Boolean - Whether grid lines are shown across the chart
	    scaleShowGridLines: false,
	    //String - Colour of the grid lines
	    scaleGridLineColor: "rgba(0,0,0,.05)",
	    //Number - Width of the grid lines
	    scaleGridLineWidth: 1,
	    //Boolean - Whether to show horizontal lines (except X axis)
	    scaleShowHorizontalLines: true,
	    //Boolean - Whether to show vertical lines (except Y axis)
	    scaleShowVerticalLines: true,
	    //Boolean - Whether the line is curved between points
	    bezierCurve: true,
	    //Number - Tension of the bezier curve between points
	    bezierCurveTension: 0.3,
	    //Boolean - Whether to show a dot for each point
	    pointDot: false,
	    //Number - Radius of each point dot in pixels
	    pointDotRadius: 4,
	    //Number - Pixel width of point dot stroke
	    pointDotStrokeWidth: 1,
	    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
	    pointHitDetectionRadius: 20,
	    //Boolean - Whether to show a stroke for datasets
	    datasetStroke: true,
	    //Number - Pixel width of dataset stroke
	    datasetStrokeWidth: 2,
	    //Boolean - Whether to fill the dataset with a color
	    datasetFill: true,
	    //String - A legend template
	    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
	    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	    maintainAspectRatio: true,
	    //Boolean - whether to make the chart responsive to window resizing
	    responsive: true
	};
	/*callChart.destroy();*/
  	//Create the line chart
	$.post(base_url+"campaign/get_line_chart",{id : ids,type: "callperday",start_date : $('#from_date').val(),end_date : $('#to_date').val(),start_time : $('#from_time').val(),end_time : $('#to_time').val()},function(data, status){
		var obj = JSON.parse(data);
		callChartData = {
			labels: obj.graph.labels,
			datasets: [
					{
			        label: "Wrong Number",
			        fillColor: "rgba(60,141,188,0)",
			        strokeColor: "#ccc",
			        pointColor: "#ccc",
			        pointStrokeColor: "#ccc",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "#ccc",
			        data: obj.graph.wrong_number
				  },
				  {
			        label: "Busy",
			        fillColor: "rgba(60,141,188,0)",
			        strokeColor: "#337ab7",
			        pointColor: "#337ab7",
			        pointStrokeColor: "#337ab7",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "#337ab7",
			        data: obj.graph.busy
				  },
				  {
			        label: "Contacted",
			        fillColor: "rgba(0, 166, 90,0)",
			        strokeColor: "rgba(0, 166, 90,0.8)",
			        pointColor: "#00a65a",
			        pointStrokeColor: "rgba(0, 166, 90,1)",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "rgba(0, 166, 90,1)",
			        data: obj.graph.contacted
			      },
			      {
			        label: "Not Active",
			        fillColor: "rgba(243, 156, 18,0)",
			        strokeColor: "rgba(243, 156, 18,0.8)",
			        pointColor: "#f39c12",
			        pointStrokeColor: "rgba(243, 156, 18,1)",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "rgba(243, 156, 18,1)",
			        data: obj.graph.not_active
			      },
			      {
			        label: "Not Answer",
			        fillColor: "rgba(60,141,188,0)",
			        strokeColor: "rgba(60,141,188,0.8)",
			        pointColor: "#3b8bba",
			        pointStrokeColor: "rgba(60,141,188,1)",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "rgba(60,141,188,1)",
			        data: obj.graph.no_answer
				  },
				  {
			        label: "Reject",
			        fillColor: "rgba(221, 75, 57,0)",
			        strokeColor: "rgba(221, 75, 57,0.8)",
			        pointColor: "#dd4b39",
			        pointStrokeColor: "rgba(221, 75, 57,1)",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "rgba(221, 75, 57,1)",
			        data: obj.graph.reject
			      },
						{
				        label: "Call Back",
				        fillColor: "rgba(221, 75, 57,0)",
				        strokeColor: "rgba(221, 75, 57,0.8)",
				        pointColor: "#dd4b39",
				        pointStrokeColor: "rgba(221, 75, 57,1)",
				        pointHighlightFill: "#fff",
				        pointHighlightStroke: "rgba(221, 75, 57,1)",
				        data: obj.graph.call_back
				      }
			]

		};
		callChart.Line(callChartData, callChartOptions);
	});
  	//Create the line chart
	setInterval(function(){
        window.loading.hide();
		$.ajax({
			url:base_url+"campaign/get_line_chart",
			data:{id : ids,type: "callperday",start_date : $('#from_date').val(),end_date : $('#to_date').val(),start_time : $('#from_time').val(),end_time : $('#to_time').val()},
			type:'POST',
			success: function(data, status){
				//console.log(data);
				var obj = JSON.parse(data);

				callChartData = {
					labels: obj.graph.labels,
					datasets: [
						{
					        label: "Wrong Number",
					        fillColor: "rgba(60,141,188,0)",
					        strokeColor: "#ccc",
					        pointColor: "#ccc",
					        pointStrokeColor: "#ccc",
					        pointHighlightFill: "#fff",
					        pointHighlightStroke: "#ccc",
					        data: obj.graph.wrong_numb
						  },
						  {
					        label: "Busy",
					        fillColor: "rgba(60,141,188,0)",
					        strokeColor: "#337ab7",
					        pointColor: "#337ab7",
					        pointStrokeColor: "#337ab7",
					        pointHighlightFill: "#fff",
					        pointHighlightStroke: "#337ab7",
					        data: obj.graph.busy
						  },
						  {
					        label: "Contacted",
					        fillColor: "rgba(0, 166, 90,0)",
					        strokeColor: "rgba(0, 166, 90,0.8)",
					        pointColor: "#00a65a",
					        pointStrokeColor: "rgba(0, 166, 90,1)",
					        pointHighlightFill: "#fff",
					        pointHighlightStroke: "rgba(0, 166, 90,1)",
					        data: obj.graph.contacted
					      },
					      {
					        label: "Not Active",
					        fillColor: "rgba(243, 156, 18,0)",
					        strokeColor: "rgba(243, 156, 18,0.8)",
					        pointColor: "#f39c12",
					        pointStrokeColor: "rgba(243, 156, 18,1)",
					        pointHighlightFill: "#fff",
					        pointHighlightStroke: "rgba(243, 156, 18,1)",
					        data: obj.graph.not_active
					      },
					      {
					        label: "Not Answer",
					        fillColor: "rgba(60,141,188,0)",
					        strokeColor: "rgba(60,141,188,0.8)",
					        pointColor: "#3b8bba",
					        pointStrokeColor: "rgba(60,141,188,1)",
					        pointHighlightFill: "#fff",
					        pointHighlightStroke: "rgba(60,141,188,1)",
					        data: obj.graph.not_answer
						  },
						  {
					        label: "Reject",
					        fillColor: "rgba(221, 75, 57,0)",
					        strokeColor: "rgba(221, 75, 57,0.8)",
					        pointColor: "#dd4b39",
					        pointStrokeColor: "rgba(221, 75, 57,1)",
					        pointHighlightFill: "#fff",
					        pointHighlightStroke: "rgba(221, 75, 57,1)",
					        data: obj.graph.reject
					      },
								{
						        label: "Call Back",
						        fillColor: "rgba(221, 75, 57,0)",
						        strokeColor: "rgba(221, 75, 57,0.8)",
						        pointColor: "#dd4b39",
						        pointStrokeColor: "rgba(221, 75, 57,1)",
						        pointHighlightFill: "#fff",
						        pointHighlightStroke: "rgba(221, 75, 57,1)",
						        data: obj.graph.call_back
						      }
					]

				};
			  	callChartOptions.animationSteps= 1;
	  			callChart.Line(callChartData, callChartOptions);
		    },
		    beforeSend: function(){
                window.loading.hide();
            }
	    });
	}, 3000);

	$.post(base_url+"campaign/get_line_chart",{id : ids,type: "merchant_status",start_date : $('#from_date').val(),end_date : $('#to_date').val(),start_time : $('#from_time').val(),end_time : $('#to_time').val()},function(data, status){
		var obj = JSON.parse(data);
		var data_	=	obj.graph;
		/*console.log(data_);*/
		var li = '';

		li += '<li><i class="fa fa-circle-o" style="color:#FDB45C"></i>&nbsp;&nbsp;Callback&nbsp;&nbsp;'+data_.call_back+'</li>' ;
		li += '<li><i class="fa fa-circle-o" style="color:#F7464A"></i>&nbsp;&nbsp;Interest Meeting BD&nbsp;&nbsp;'+data_.interest_meeting_bd+'</li>' ;
		li += '<li><i class="fa fa-circle-o" style="color:#a74faf"></i>&nbsp;&nbsp;Interest Meeting Sales&nbsp;&nbsp;'+data_.interest_meeting_sales+'</li>' ;
		li += '<li><i class="fa fa-circle-o" style="color:#00a8b5"></i>&nbsp;&nbsp;No Interest&nbsp;&nbsp;'+data_.no_interest+'</li>' ;
		li += '<li><i class="fa fa-circle-o" style="color:#2b3595"></i>&nbsp;&nbsp;Follow UP BD&nbsp;&nbsp;'+data_.followup_bd+'</li>' ;
		li += '<li><i class="fa fa-circle-o" style="color:#393e46"></i>&nbsp;&nbsp;Follow UP Sales&nbsp;&nbsp;'+data_.followup_sales+'</li>' ;

		$('#legend_target').append(li);

		Chart.types.Pie.extend({
            showTooltip: function() {
                //this.chart.ctx.save();
                //Chart.types.Doughnut.prototype.showTooltip.apply(this, arguments);
                //this.chart.ctx.restore();
            }
        });

		if(obj.graph.interest_meeting_bd == 0){

			var datas = [
				{
					value : 100,
					color:"#13334c",
					highlight: "#13334c",
				}
			];

		}else{


			var datas = [
				{
					value : obj.graph.interest_meeting_bd,
					color:"#F7464A",
					highlight: "#FF5A5E",
					label: "Interest Meeting BD"
				},
				{
					value: obj.graph.interest_meeting_sales,
					color: "#a74faf",
					highlight: "#a74faf",
					label: "Interest Meeting Sales"
				},
				{
					value: obj.graph.no_interest,
					color: "#00a8b5",
					highlight: "#00a8b5",
					label: "No Interest"
				},
				{
					value: obj.graph.followup_bd,
					color: "#2b3595",
					highlight: "#2b3595",
					label: "Follow UP BD"
				},
				{
					value: obj.graph.followup_sales,
					color: "#393e46",
					highlight: "#393e46",
					label: "Follow UP Sales"
				},
				{
					value: obj.graph.call_back,
					color: "#FDB45C",
					highlight: "#FFC870",
					label: "Call back"
				}
			];
		}
		//console.log(datas);

		var options = {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		};
		var merchant_status = $("#merchant_status_Chart").get(0).getContext("2d");
		var myDoughnutChart = new Chart(merchant_status).Pie(datas,options,{
			segmentShowStroke: false,
            animationEasing: "easeInOutQuint"
		});
	});

	$('#re-fresh').click(function(){
		$.post(base_url+"campaign/get_line_chart",{id : ids,type: "callperday",start_date : $('#from_date').val(),end_date : $('#to_date').val(),start_time : $('#from_time').val(),end_time : $('#to_time').val()},function(data, status){
			var obj = JSON.parse(data);
			callChartData = {
				labels: obj.graph.labels,
				datasets: [
					{
			        label: "Wrong Number",
			        fillColor: "rgba(60,141,188,0)",
			        strokeColor: "#ccc",
			        pointColor: "#ccc",
			        pointStrokeColor: "#ccc",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "#ccc",
			        data: obj.graph.wrong_numb
				  },
				  {
			        label: "Busy",
			        fillColor: "rgba(60,141,188,0)",
			        strokeColor: "#337ab7",
			        pointColor: "#337ab7",
			        pointStrokeColor: "#337ab7",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "#337ab7",
			        data: obj.graph.busy
				  },
				  {
			        label: "Contacted",
			        fillColor: "rgba(0, 166, 90,0)",
			        strokeColor: "rgba(0, 166, 90,0.8)",
			        pointColor: "#00a65a",
			        pointStrokeColor: "rgba(0, 166, 90,1)",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "rgba(0, 166, 90,1)",
			        data: obj.graph.contacted
			      },
			      {
			        label: "Not Active",
			        fillColor: "rgba(243, 156, 18,0)",
			        strokeColor: "rgba(243, 156, 18,0.8)",
			        pointColor: "#f39c12",
			        pointStrokeColor: "rgba(243, 156, 18,1)",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "rgba(243, 156, 18,1)",
			        data: obj.graph.no_active
			      },
			      {
			        label: "Not Answer",
			        fillColor: "rgba(60,141,188,0)",
			        strokeColor: "rgba(60,141,188,0.8)",
			        pointColor: "#3b8bba",
			        pointStrokeColor: "rgba(60,141,188,1)",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "rgba(60,141,188,1)",
			        data: obj.graph.no_answer
				  },
				  {
			        label: "Reject",
			        fillColor: "rgba(221, 75, 57,0)",
			        strokeColor: "rgba(221, 75, 57,0.8)",
			        pointColor: "#dd4b39",
			        pointStrokeColor: "rgba(221, 75, 57,1)",
			        pointHighlightFill: "#fff",
			        pointHighlightStroke: "rgba(221, 75, 57,1)",
			        data: obj.graph.reject
			      }
				]
			};
			callChart.Line(callChartData, callChartOptions);
		});
	});
});
