<?php 

function response($message,$code)
{
    http_response_code($code);
    echo json_encode($message);
}
