<?php

    // DECLARATION
    $fetchData = array();
    $content = $_GET['content'];
    $content = json_decode($content, true);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "mydb";

    //Connect to DB
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    //RESPONSE
    echo "<tr><th> INPUT </th>";
    foreach($content as $input)
        echo "<td>".$input."</td>";
    echo "</tr>";
    DataIn($content);
    DataOut();
    

     //INPUT to DATABASE
    function DataIn($content){
        global $conn;
        $mysqlIN = "INSERT INTO random(RandNumber) VALUES(?)";
        $resultIN = $conn->prepare($mysqlIN);

        if(!$resultIN)
            die("Error: " . $conn ->error); 

        foreach($content as $values){
            $resultIN->bind_param("i", $values);
            $resultIN->execute();
        }
        $resultIN->close();
    }

    //OUTPUT from DATABASE
    //Want to output the last 5 digit only
    function DataOut(){
        global $conn;
        $mysqlOUT = "SELECT * FROM random ORDER BY NUM DESC LIMIT 5";
        $resultOUT = $conn->query($mysqlOUT);
    
        if (!$resultOUT)  
            die ("Error: " . $conn->error);
        
        echo "<tr><th>OUTPUT</th>";
        while ($output = $resultOUT->fetch_assoc()) {
            echo "<td>" . $output['RandNumber'] . "</td>";
        }
        echo "</tr>";
        $conn->close();
    }

    //CREATE DATABASE  
    //$mysql ="CREATE DATABASE mydb;";

    //CREATE TABLE
    //$mysql ="CREATE TABLE RandNum(testing INT NOT NULL);";

    //DELETE data in DATABASE
    //$mysql = "DELETE FROM RandNum;"
?>