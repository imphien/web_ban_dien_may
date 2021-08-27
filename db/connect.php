<?php

$conn = mysqli_connect('localhost','root','','bandienmay');

if(mysqli_connect_errno())
{
    echo "Faile to connect to MySql:".mysqli_connect_error();
}

?>