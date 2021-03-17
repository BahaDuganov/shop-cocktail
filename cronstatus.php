<?php
  
// Parse magento's local.xml to get db info, if local.xml is found
   // die('Musharraf');
if (file_exists('app/etc/local.xml')) {
  $xml = simplexml_load_file('app/etc/local.xml');
  
$tblprefix = $xml->global->resources->db->table_prefix;
$dbhost = $xml->global->resources->default_setup->connection->host;
$dbuser = $xml->global->resources->default_setup->connection->username;
$dbpass = $xml->global->resources->default_setup->connection->password;
$dbname = $xml->global->resources->default_setup->connection->dbname;
  
}else {
    exit('Failed to open app/etc/local.xml');
}
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$sql = "SELECT * FROM " . $tblprefix . "cron_schedule";
if ($result=mysqli_query($link,$sql))
  {
  // Fetch one and one row
  while ($row=mysqli_fetch_row($result))
    {
    printf ("%s (%s)\n",$row[0],$row[1]);
    }
  // Free result set
  mysqli_free_result($result);
}
//mysql_close($conn);
?>