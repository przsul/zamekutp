var express = require('express');
var app = express();

app.use(express.static('public'))

var mysql      = require('mysql');  
var connection = mysql.createConnection({  
  host     : 'localhost',  
  user     : 'przemek',  
  password : '',  
  database : 'zamekutp'  
});        

app.get('/rows', function (req, res) {

  connection.query('SELECT * FROM persons', function(err, rows, fields) {  
      if (err) throw err;  

      res.json(rows); 

  });
});

app.listen(3000, function () {
  console.log('Example app listening on port 3000!');
});