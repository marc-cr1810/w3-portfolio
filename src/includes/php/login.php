<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Login
{
    public static function isLoggedIn()
    {
        global $db;
        
        if (isset($_COOKIE['SNID'])) {
            $sha1_snid = sha1($_COOKIE['SNID']);

            if ($db->querySingle("SELECT EXISTS(SELECT UserID FROM LoginTokens WHERE Token='$sha1_snid');"))
            {
                $user_id = $db->querySingle("SELECT UserID FROM LoginTokens WHERE Token='$sha1_snid'", true)['UserID'];

                if (isset($_COOKIE['SNID_']))
                {
                    return $user_id;
                }
                else
                {
                    $cstrong = True;
                    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                    $sha1_token = sha1($token);
                    $db->query("INSERT INTO LoginTokens VALUES ('$sha1_token', $user_id);");
                    $db->query("DELETE FROM LoginTokens WHERE Token='$sha1_snid';");

                    setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', "", TRUE, TRUE);
                    setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', "", FALSE, TRUE);

                    return $user_id;
                }
            }
        }

        return false;
    }
}
?>