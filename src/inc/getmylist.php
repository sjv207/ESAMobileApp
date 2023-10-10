<?php
// did we get the email via the link?
$email = NULL;
if (isset($_REQUEST['p']) && trim(($_REQUEST['p'])) && code_allowed($_REQUEST['p']))
    $email = ($_REQUEST['p']);

// if we have the email, check for consistency with cookie in database
if ($email) {
    $my_list = retrieve_my_list('', $email);
    if (count($my_list) > 0 && $db_esa_id != $esa_id) {
        $esa_id = $db_esa_id;
        update_cookie();
    } else {
        $my_list = retrieve_my_list($esa_id);
        if (count($my_list) > 0) {
            $pars = array(':email' => $email, ':esa_id' => $esa_id);
            $query = "UPDATE my_list SET email=:email WHERE esa_id=:esa_id";
            $done = send_mysql_query($query, $pars);
        }
    }
} else {
    // otherwise load list for this cookie
    $my_list = retrieve_my_list($esa_id);
}
?>