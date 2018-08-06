<?php
echo"Hello world Text change <br>";
//postgres://fcvbkebobrnglo:5e964f89185ffc0aa3177ea7880e85f19cf4a1e954f36c7589a0e115a57ed2a7@ec2-54-228-219-2.eu-west-1.compute.amazonaws.com:5432/d14ekichol45s8
   $host        = "host = ec2-54-228-219-2.eu-west-1.compute.amazonaws.com";
   $port        = "port = 5432";
   $dbname      = "dbname = d14ekichol45s8";
   $credentials = "user = fcvbkebobrnglo password=5e964f89185ffc0aa3177ea7880e85f19cf4a1e954f36c7589a0e115a57ed2a7";

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


?>
