<?php

class Invoice extends Database
{

    private static function SesssionSet(string $USERNAME) : bool
    {
        $USERDATA = (new self)->query("SELECT userId, fullname, userRole, userEmail, userKm, avatar
                            FROM `users`
                            INNER JOIN userroles
                            ON users.userRole = userroles.roleId
                            WHERE username = :USERNAME", [':USERNAME' => $USERNAME])->fetch();
        if($USERDATA !== false)
        {
            $_SESSION['USER'] = [
                'USERID' => $USERDATA->userId,
                'AVATAR' => $USERDATA->avatar,
                'FULLNAME' => $USERDATA->fullname,
                'USERROLE' => $USERDATA->userRole,
                'USEREMAIL' => $USERDATA->userEmail,
                'USERKM' => $USERDATA->userKm
            ];
            return true;
        }
        return false;
    }

    public static function getInvoice() : array {
      return (new self)->query("SELECT * FROM estimations")->fetchAll();
    }

}
