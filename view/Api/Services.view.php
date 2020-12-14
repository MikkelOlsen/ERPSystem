<?php
//Check if there's an ID in post values, if not return an error.
if(isset($POST['id'])) {
    //Init error count and message array
    $err = 0;
    $msg = [];

    //Check that the name deoesn't contain special characters.
    if(Validate::stringBetween($POST['name']) == false) {
        $err++;
        $msg[$err] = '<p>Name must not contain special characters.</p>';
    }

    //Check that the hours is an integer
    if(!Validate::intBetween(intval($POST['hours']), 1, 20) == false) {
        $err++;
        $msg[$err] = '<p>Hours must be numeric.s</p>';
    }

    //Check that the rate is an integer
    if(!Validate::intBetween(intval($POST['rate']), 1, 20) == false) {
        $err++;
        $msg[$err] = '<p>Rate must be numeric.s</p>';
    }

    /*
     If no errors, run service update method.
     If this returns true, return no errors, else return error with msg.

     If there are errors, return the error messages.
    */
    if($err == 0) {
        if(Service::updateService($POST['id'], $POST['name'], $POST['hours'], $POST['rate']) == true)
        {
            echo json_encode([
                'err' => false
                ]);
        } else {
            echo json_encode([
                'err' => true, 
                'msg' => 'An error occured during the update.'
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
        'msg' => 'There was no ID in the data.'
    ]);
}