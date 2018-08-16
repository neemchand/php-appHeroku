<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

/** Task:1
 *  Sample php app deployment
 *  */
 echo"Hello world Text change <br>";


/** Task:2
 * Redis Connection and store value redis cache
 *  */
$redis_url = parse_url(getenv("REDIS_URL"));
 echo"<pre>"; print_r($redis_url); die;

$redis = new Predis\Client($redis_url);
$redis->set("hello_world", "Hi from redis cache php!");
$value = $redis->get("hello_world");
print_r($value);



/** Task:3
 * PSql Connection and get data from db
 **/

    
$url = parse_url(getenv("DATABASE_URL"));
//echo"<pre>"; print_r($row[0]); die;
  $host =  $url["host"];
  $username = $url["user"];
  $password = $url["pass"];
  $database = substr($url["path"], 1);
	
   $host        = "host = $host ";
   $port        = "port = 5432";
   $dbname      = "dbname = $database";
   $credentials = "user = $username password=$password";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
      echo "\nOpened database successfully\n";

   
   $return = pg_query($db, "SELECT * from test_table");
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
