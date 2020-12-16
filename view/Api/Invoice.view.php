<?php
if(isset($POST['id'])) {
    if(Invoice::updateInvoice($POST['id']) == true)
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
        'msg' => 'Der var intet id i POST.'
    ]);
}