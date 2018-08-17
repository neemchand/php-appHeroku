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

Rollbar::init(
  array(
    'access_token' => getenv("ROLLBAR_ACCESS_TOKEN"),
    'environment' => getenv("ENVIRONMENT")
  )
);


/** Task:1
 *  Sample php app deployment
 *  */
 echo"Task1:Hello world Text change <br>";

/** Task:2
 * Redis Connection and store value redis cache
 *  */
try{

$redis = new Predis\Client(getenv("REDIS_URL"));
$redis->set("hello_world", "Hi from redis cache php!");
$value = $redis->get("hello_world");
 echo"Task2: Redis connection--".print_r($value);  

} catch (\Exception $e) {
    Rollbar::log(Level::ERROR, $e);
}


/** Task:3
 * PSql Connection and get data from db
 **/
/** Task:4
 * Rollbar Connection and heroku setup
 **/
 try{
  $url = parse_url(getenv("DATABASE_URL"));
  $host =  $url["host"];
  $username = $url["user"];
  $password = $url["pass"];
  $port = $url["port"];
  $database = substr($url["path"], 1);
	
   $host        = "host = $host ";
   $port        = "port = $port";
   $dbname      = "dbname = $database";
   $credentials = "user = $username password=$password";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
      echo "<br>Task2:\nOpened database successfully\n";

   
   $return = pg_query($db, "SELECT * from test_table");
   if(!$return) {
      echo pg_last_error($db);
      exit;
   } 
   while($row = pg_fetch_row($return)) {
     echo"<pre>"; print_r($row[0]);
   }
   echo "<br>Task3: Db query executed successfully\n";
 
  }
 echo "<br>Task4: Rollbar integration successfull\n";
} catch (\Exception $e) {
    Rollbar::log(Level::ERROR, $e);
}


?>
