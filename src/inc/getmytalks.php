<?php
$mytalks = array();
if ($email) {
    foreach ($sessions_sorted as $sid => $sortid) {
        foreach ($sessions[$sid]['papers'] as $paper) {
            if ($paper['presenter_email'] == $email && (!in_array($sid, $mytalks)))
                $mytalks[] = $sid;
        }
    }
}

?>