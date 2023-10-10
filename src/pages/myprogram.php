<?php
// a special page with a list oft the sessions that I put on "My program"
// joint events and my own talk are automatically on there


$my_program = array();
//error_log(json_encode( $mytalks));
//error_log(json_encode( $my_list));

foreach ($my_list as $sid) {
    if (isset($sessions[$sid])) {
        $my_program[$sessions[$sid]['sortid']] = $sid;
    }
}
;
foreach ($mytalks as $mysid) {
    if (!in_array($mysid, $my_program))
        $my_program[$sessions[$mysid]['sortid']] = $mysid;
}
foreach ($joint_events as $sid => $event)
    $my_program[$event['sortid']] = $sid;
ksort($my_program);

//error_log(json_encode($my_program));


echo '
<!-- mylist -->
<div data-role="page" id="mylist">';

create_header(title: $name_mylist, login: TRUE);

echo '
  <div data-role="content">
    <ul data-role="listview" data-theme="a" data-inset="true">';

$previous_session_day = "dummy";
error_log(json_encode($date_arrays));


foreach ($my_program as $session) {

    $current_session_day = substr($session, 0, 2);
    if ($current_session_day != $previous_session_day) {
        echo '<li data-role="list-divider">' . $date_arrays[$current_session_day] . '</li>';
    }
    $previous_session_day = $current_session_day;
    if (isset($sessions[$session])) {
        $thislist = array();

        foreach ($sessions[$session]['papers'] as $paper) {

            if (strtolower(substr($paper['title'], 0, 6)) == 'aaaaaa') {
                $thislist[] = $paper['presenter_fname'] . ' ' . $paper['presenter_lname'] . '';
            } else {

                $thislist[] = $paper['presenter_fname'] . ' ' . $paper['presenter_lname'] . ': ' . $paper['title'];
            }
        }



        echo '<li><a href="#' . $session . '" class="ui-mini"';
        if (in_array($session, $mytalks))
            echo ' style="background: ' . $mytalk_highlight_color . ';"';
        echo '>';
        // we dont need the day anymore

        echo $date_arrays[$current_session_day] . ' ' . $sessions[$session]['timeslot'] . '<br>';
        //echo $sessions[$session]['timeslot'].'<br>';
        //echo '<font color="#BB2E29">';
        echo '<font style="font-size: large;">' . $sessions[$session]['room'] . ' - </font><font style="color: #BB2E29; font-size: large">' . $sessions[$session]['name'] . '<br>';
        echo '</font>';
        echo '<font style="color: #555555; font-weight: normal;">' . implode('<br>', $thislist) . '</font>';
        echo '</a></li>';
    } elseif (isset($joint_events[$session])) {
        echo '<li style="background: ' . $event_highlight_color . ';">';
        if ($joint_events[$session]['event_summary'])
            echo '<a href="#' . $session . '" class="ui-mini" style="background: ' . $event_highlight_color . ';">';
        else
            echo '<div style="font-size: 12.5px; font-weight: bold;">';
        // we dont need the day anymore
        echo $date_arrays[$current_session_day] . ' ' . $joint_events[$session]['timeslot'] . '<br>';
        //echo $joint_events[$session]['timeslot'].'<br>';

        echo '<font style="font-size: large;">' . $joint_events[$session]['event_name'] . ' - ' . $joint_events[$session]['room'] . '<br></font>';
        echo '<font style="color: #555555; font-weight: bold;">' . $joint_events[$session]['event_title'] . '</font>';
        if ($joint_events[$session]['event_presenter_fname'])
            echo ": " . $joint_events[$session]['event_presenter_fname'] . " " . $joint_events[$session]['event_presenter_lname'];
        if ($joint_events[$session]['event_summary'])
            echo '</a>';
        else
            echo '</div>';
        echo '</li>';

    }
}

echo '</ul>';

// end content, end page
create_footer(close_before: TRUE, close_after: TRUE);

?>