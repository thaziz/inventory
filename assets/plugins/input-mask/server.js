var socket  = require( 'socket.io' );
var express = require('express');
var app     = express();
var server  = require('http').createServer(app);

var io      = socket.listen( server );
var port    = process.env.PORT || 3000;

const https = require('https');
const fs = require('fs');

const bodyParser = require('body-parser');
const mysql = require('mysql');

var md5 = require('md5');




 

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {

/*
setInterval(() => {
     socket.emit('news_by_server', 'Cow goes moo'); 

}, 200);
*/


  socket.on( 'new_count_message', function( data ) {
    io.sockets.emit( 'new_count_message', { 
    	new_count_message: data.new_count_message

    });
  });

  socket.on( 'update_count_message', function( data ) {
    io.sockets.emit( 'update_count_message', {
    	update_count_message: data.update_count_message 
    });
  });

  socket.on( 'new_message', function( data ) {
    io.sockets.emit( 'new_message', {
    	name: data.name,
    	email: data.email,
    	subject: data.subject,
    	created_at: data.created_at,
    	id: data.id
    });
  });

  
});





//

// parse application/json
app.use(bodyParser.json());
 
//create database connection
/*const conn = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'ci_chat'
});
 */
const conn = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'dut4_MEDIA',
  database: 'kanmo'
});
 

//connect to database
conn.connect((err) =>{
  if(err) throw err;
  console.log('Mysql Connected...');
});
 
//show all products
app.get('/api/products',(req, res) => {
  let sql = "SELECT * FROM message";
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
  });
});
 
//show single product
app.get('/api/products/:id',(req, res) => {
  let sql = "SELECT * FROM product WHERE product_id="+req.params.id;
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
  });
});
 






 app.post('/my_webhook_url', function (req, res) {
 	
 	var phone = req.query.phone; // get
    var $_data = req.body; // New messages in the "body" variable
    

    if (typeof $_data['messages'] !== 'undefined') {
    	$_data=$_data['messages'][0];
    	$match = $_data['author'].replace(/\D/g,'');      
        $_data['phone'] = $match;
        $data = {'id':$_data['id'], 'wa_number':$_data['phone'], 'status':'unread', 'chat_time':Unix_timestamp($_data['time']), 'is_reply':1};
		
		if($_data['type']=='chat'){
	    			$data['wa_text']=$_data['body'];
	    }

		if($_data['type']=='image'){

			var ext = $_data['body'].match(/(.jpeg)|(.png)|(.jpg)|(.gif)/);
        	$data['wa_text']='e';
	    	$data['wa_images'] = (md5($_data['body']));
//console.log($data['wa_images']);return false;
//const file = fs.createWriteStream("a/"+$data['wa_images']+".jpg");

const file = fs.createWriteStream("/var/www/html/kanmo/assets/wa_images/"+$data['wa_images']+".jpg");


const request = https.get($_data['body'], function(response) {
	if(response){
  		response.pipe(file);
  	}
});

	    }	   
        
	}


	let data = $data;
  let sql = "INSERT INTO whatsapp_chat SET ?";
  let query = conn.query(sql, data,(err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
  });
  
  console.log(data);

});












//add new product
app.post('/api/products',(req, res) => {
  let data = { id: 'false_17472822486@c.us_DF38E6A25B42CC8CCE57EC40F',
  wa_number: '17472822486',
  status: 'unread',
  chat_time: '3/1/2019 6:21:01',
  is_reply: 1,
  wa_text: 'e',
  wa_images: 'b641f54342d572b2d21d27491206ce29' }
;
  let sql = "INSERT INTO whatsapp_chat SET ?";
  let query = conn.query(sql, data,(err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
  });
});
 
//update product
app.put('/api/products/:id',(req, res) => {
  let sql = "UPDATE product SET product_name='"+req.body.product_name+"', product_price='"+req.body.product_price+"' WHERE product_id="+req.params.id;
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
  });
});
 
//Delete product
app.delete('/api/products/:id',(req, res) => {
  let sql = "DELETE FROM product WHERE product_id="+req.params.id+"";
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
      res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
  });
});




function Unix_timestamp(t)
{

var dt = new Date(t*1000);
var date = dt.getDate();
var bln = dt.getMonth();
var th = dt.getFullYear();
var hr = dt.getHours();
var m = "0" + dt.getMinutes();
var s = "0" + dt.getSeconds();
return date + '/' +bln + '/' +th + ' ' + hr+ ':' + m.substr(-2) + ':' + s.substr(-2);  
}
