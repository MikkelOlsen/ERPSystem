<?php
if(isset($POST['id'])) {
    if(Invoice::updateInvoice($POST['id']) == true)
    {
        Log::insertLog("Invoice with id: " . $id . ' - approved.', 0 );
        echo json_encode([
            'err' => false
            ]);
    } else {
        Log::insertLog("Invoice with id: " . $id . ' - was not approved due to a database related error.', 1);
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