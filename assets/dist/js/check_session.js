/*var url = location.hostname;*/



if(typeof(EventSource) !== "undefined") {
	var source = new EventSource('/outbound/check_session/sess_avail');

	source.addEventListener('message', function(e){
		console.log('sdsdsd'+' '+event);
		/*if (event != 1) {
			window.location.href = location.hostname+'/outbound';
		}*/
	}, false);
} else {
	console.log('Sorry! No server-sent events support..');
  // Sorry! No server-sent events support..
} 