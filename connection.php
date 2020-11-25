<?php 
    function connection_establish(){
        $servername = 'localhost';
        $username = "root";
        $password = "";
        $database = "portalbeadando";
        $conn = new mysqli($servername, $username, $password);
        $conn->select_db($database);
        if ($conn ->connect_error){
            die ("Connection failed: ".$conn->connect_error);
        }
        //echo "Connected succesfully<br>";
        $conn->set_charset("utf8");
        return $conn;
    }    
?>