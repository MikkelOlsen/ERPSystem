<?php
if(isset($POST['id'])) {
    $err = 0;
    $msg = [];
    if(Validate::stringBetween($POST['name']) == false) {
        $err++;
        $msg[$err] = '<p>Name must not contain special characters.</p>';
    }

    if(!Validate::intBetween(intval($POST['hours']), 1, 20) == false) {
        $err++;
        $msg[$err] = '<p>Hours must be numeric.s</p>';
    }

    if(!Validate::intBetween(intval($POST['rate']), 1, 20) == false) {
        $err++;
        $msg[$err] = '<p>Rate must be numeric.s</p>';
    }

    if($err == 0) {
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
            'msg' => $msg
        ]);
    }
    
} else {
    echo json_encode([
        'err' => true,
        'msg' => 'Der var intet id i POST'
    ]);
}