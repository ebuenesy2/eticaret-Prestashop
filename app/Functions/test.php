<?php


//! Test Örnek
function testExampleFunction(){

    $DB["test1"] =  $_ENV["DB_DATABASE"];
    $DB["test2"] =  "test2 value";

    return $DB; 
}
//! Test Örnek Son

function testExampleOnlyFunction(){
    return "testExample";
}


?>