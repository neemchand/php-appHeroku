<?php
echo"Hello world Text <br>";

   $host        = "host = ec2-54-217-218-80.eu-west-1.compute.amazonaws.com";
   $port        = "port = 5432";
   $dbname      = "dbname = dcuu3pkru941ct";
   $credentials = "user = uwafvrfbblvzim password=1725cba0327d8b02d829db492705dbc6787176c582358e2b71bde6dbb23f97c0";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
      echo "\nOpened database successfully\n";

	 $sql =<<<EOF
      SELECT * from test_table;
EOF;
   
   $return = pg_query($db, $sql);
   if(!$return) {
      echo pg_last_error($db);
      exit;
   } 
   while($row = pg_fetch_row($return)) {
     echo"<pre>"; print_r($row[0]); die;
   }
   echo "Operation done successfully\n";
 
}

 // $db_connection = pg_connect("host=ec2-54-217-218-80.eu-west-1.compute.amazonaws.com dbname=dcuu3pkru941ct user=uwafvrfbblvzim password=1725cba0327d8b02d829db492705dbc6787176c582358e2b71bde6dbb23f97c0");
 // $result = pg_query($db_connection, "SELECT * FROM test_table");
 // echo"<pre>"; print_r($result); die;


?>
