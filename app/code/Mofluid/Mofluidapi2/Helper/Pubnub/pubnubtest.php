<?php 
require_once('Pubnub.php');

//$pubnub = new Pubnub( 'pub-c-16bc9d47-ed69-46d6-87a6-867ab472a4d3', 'sub-c-4816f7e4-8744-11e3-a9a9-02ee2ddab7fe');
$pubnub = new Pubnub( 'pub-c-daee4585-9572-40fe-81c2-c695ed9a9821', 'sub-c-8b2b5942-a3a2-11e3-bb2f-02ee2ddab7fe');
$info = $pubnub->publish(array(
    'channel' => 'my_channel',
    'message' => 'my test data for application'
));
 print_r($info);die;

