<?php
if(isset($POST['id'])) {
    if(Service::updateService($POST['id'], $POST['name'], $POST['hours'], $POST['rate']) == true)
    {
        echo json_encode([
            'err' => false
            ]);
    } else {
        echo json_encode([
            'err' => true, 
            'msg' => 'Der skete en fejl ved indsættelse'
            ]);
    }
} else {
    echo json_encode([
        'err' => true,
        'msg' => 'Der var intet id i POST'
    ]);
}