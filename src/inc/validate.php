<?php

function validateInput($key, $value, $arg = null)
{
    $arrayError = [];
    switch ($key) {
        case 'email':
            $result = filter_var($value, FILTER_VALIDATE_EMAIL);
            $arrayError['email'] = $result;
            break;
        case 'password':
            $result = ($value != $arg);
            $arrayError['password'] = $result;
            break;
        
    }
    return $result;

    
}
