<?php
echo 'HTTPS-'.$_SERVER['HTTPS'];
echo "<br>";
echo 'SERVER_NAME-'.$_SERVER['SERVER_NAME'];
echo "<br>";
echo 'HTTP_HOST-'.$_SERVER['HTTP_HOST'];
echo "<br>";
echo 'HTTP_REFERER-'.$_SERVER['HTTP_REFERER'];
echo "<br>";
echo 'HTTP_USER_AGENT-'.$_SERVER['HTTP_USER_AGENT'];
echo "<br>";
echo 'SCRIPT_NAME-'.$_SERVER['SCRIPT_NAME'];
?>
<?php phpinfo(); ?>