<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/vendor/autoload.php';

use \Dotenv\Dotenv;
use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;

if(getenv("ENVIRONMENT") !='production'){
$dotenv = new Dotenv(__DIR__);
$dotenv->load();
}
//print_r($dotenv);


//}

/** Task:1
 *  Sample php app deployment
 *  */
 echo"Hello world Text change <br>";
// print_r(getenv("REDIS_URL")); die;

/** Task:2
 * Redis Connection and store value redis cache
 *  */
// if(getenv("ENVIRONMENT") ==='local'){
//$redis_url = parse_url(getenv("REDIS_URL"));
//$redis = new Predis\Client($redis_url);
// }
$redis = new Predis\Client();
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
      echo "<br>\nOpened database successfully\n";

   
   $return = pg_query($db, "SELECT * from test_table");
   if(!$return) {
      echo pg_last_error($db);
      exit;
   } 
   while($row = pg_fetch_row($return)) {
     echo"<pre>"; print_r($row[0]);
   }
   echo "<br>Operation done successfully\n";
 
}
if(getenv("ENVIRONMENT")=='production'){

// installs global error and exception handlers
Rollbar::init(
  array(
    'access_token' => getenv("ROLLBAR_ACCESS_TOKEN"),
    'environment' => getenv("ENVIRONMENT")
  )
);

//Rollbar::log(Level::info(), 'yo yo message');
//throw new Exception('Test production exception');
} 


?>
