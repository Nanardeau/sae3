<?php
$socket = fsockopen("127.0.0.1", 8080);
fwrite($socket, "CONN test0 mdp0\n");
$data = fread($socket, 1024);
fwrite($socket, "VERIFATT\n");

$numComAtt = fread($socket, 1024);
echo $numComAtt;
if($numComAtt != "NULL"){

    fwrite($socket, "INIT ".$numComAtt . "\n");
//    $data = fread($socket, 1024);
}

fclose($socket);