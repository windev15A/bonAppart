<?php

function isConnected(){
    return isset($_SESSION['user']) ?? false;
    // if(isset($_SESSION['user'])){
    //     return true;
    // }else{
    //     return false;
    // }
}