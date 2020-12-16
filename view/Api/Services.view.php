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
    if(Validate::intBetween($POST['hours'], 1, 20) == false) {
        $err++;
        $msg[$err] = '<p>Hours must be numeric.s</p>';
    }

    //Check that the rate is an integer
    if(Validate::intBetween($POST['rate'], 1, 20) == false) {
        $err++;
        $msg[$err] = '<p>Rate must be numeric.s</p>';
    }

    /*
     If no errors, run service update method.
     If this returns true, return no errors, else return error with msg.

     If there are errors, return the error messages.
    */
    if($err == 0) {
        if(Service::updateService($POST['id'], $POST['name'], intval($POST['hours']), intval($POST['rate'])) == true)
        {
            Log::insertLog('Service with id: ' . $id . ' - updated & approved. </br> {Name: ' . $name . ', Hours: ' . $hours . ', Rate: '. $rate, 0 );
            echo json_encode([
                'err' => false
                ]);
        } else {
            Log::insertLog('Service with id: ' . $id . ' - was not updated & approved due to a database related error.', 1);
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