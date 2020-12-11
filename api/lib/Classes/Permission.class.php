<?php

class Permission extends Database
{

    public static function Login(array $DATA) : bool
    {
        try
        {
            $PASSWORD = (new self)->query("SELECT password FROM users WHERE username = :USERNAME",
            [
                ':USERNAME' => $DATA['username']
            ])->fetch();
            if($PASSWORD !== false)
            {
                if(password_verify($DATA['password'], $PASSWORD->password))
                {
                    if(self::SesssionSet($DATA['username']) == true)
                    {
                        return true;
                    }
                    return false;
                }
                return false;
            }
            return false;
        } 
            catch(PDOException $e)
        {
            return false;
        }
    }

    public static function Logout() : bool
    {
        try
        {
            unset($_SESSION['USER']);
            return true;
        } catch(PDOException $e)
        {
            return false;
        }
    }

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

    public static function LoginCheck() : bool
    {
        if(isset($_SESSION['USER']))
        {
            $USERDATA = (new self)->query("SELECT userId FROM users WHERE userId = :USERID", [':USERID' => $_SESSION['USER']['USERID']])->fetchAll();
            if(sizeof($USERDATA) == 1)
            {
                return true;
            }
            return false;
        } 
        return false;
    }

    public static function LevelCheck(string $REQLEVEL) : bool
    {
        if(self::LoginCheck() == true)
        {
            $USERLEVEL = (new self)->query("SELECT roleLevel FROM userroles WHERE roleId = :ID", [':ID' => $_SESSION['USER']['USERROLE']])->fetch();
            if($USERLEVEL->roleLevel >= $REQLEVEL)
            {
                return true;
            }
            return false;
        }
        return false;
    }
}
