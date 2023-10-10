<?php

// if add request, add session to my program
if (isset($_REQUEST['addtolist']) && $_REQUEST['addtolist'] && isset($_REQUEST['s']) && isset($sessions[$_REQUEST['s']]) && (!in_array($_REQUEST['s'], $my_list))) {
    $my_list[] = $_REQUEST['s'];
    $pars = array(':esa_id' => $esa_id, ':email' => $email, 'session_id' => $_REQUEST['s']);
    $query = "INSERT INTO my_list SET esa_id=:esa_id, email=:email, session_id=:session_id";
    $done = send_mysql_query($query, $pars);
    echo '
    <script>
    // it needed to click back twice after the post request. this fixes it.
    window.history.back()
    </script>';
}

// if delete request, delete session from my program
if (isset($_REQUEST['delfromlist']) && $_REQUEST['delfromlist'] && isset($_REQUEST['s']) && in_array($_REQUEST['s'], $my_list)) {
    if (($key = array_search($_REQUEST['s'], $my_list)) !== false) {
        unset($my_list[$key]);
        $pars = array(':esa_id' => $esa_id, 'session_id' => $_REQUEST['s']);
        $query = "DELETE FROM my_list WHERE esa_id=:esa_id AND session_id=:session_id";
        $done = send_mysql_query($query, $pars);
        echo '
        <script>
        // it needed to click back twice after the post request. this fixes it.
        window.history.back()
        </script>';
    }
}

?>