<?php
// a page with a list of my own talks
echo '
    <!-- mytalks -->
    <div data-role="page" id="mytalks">
        <div data-role="header" data-theme="a">
            <h1>' . $name_mytalk . '</h1>
            <!-- <a href="#indexPage" class="ui-btn-left">Back</a> -->
            <a href="#" class="ui-btn-left" data-rel="back">Back</a>
        </div>
        <div data-role="content">
            <ul data-role="listview" data-theme="a" data-inset="true">';
foreach ($mytalks as $session) {
    $thislist = array();
    foreach ($sessions[$session]['papers'] as $paper) {

        if (strtolower(substr($paper['title'], 0, 6)) == 'aaaaaa') {
            $thislist[] = $paper['presenter_fname'] . ' ' . $paper['presenter_lname'] . '';
        } else {



            $thislist[] = $paper['presenter_fname'] . ' ' . $paper['presenter_lname'] . ': ' . $paper['title'];
        }



    }
    echo '<li><a href="#' . $session . '" class="ui-mini">';
    error_log(json_encode($date_arrays));
    error_log(json_encode($session));


    error_log(substr($session, 0, 2));
    error_log($date_arrays[substr($session, 0, 2)]);

    echo $date_arrays[substr($session, 0, 2)] . ' ' . $sessions[$session]['timeslot'] . '<br>';
    echo $sessions[$session]['room'] . ' ' . $sessions[$session]['name'] . '<br>';
    echo '<font style="color: #555555; font-weight: normal;">' . implode('<br>', $thislist) . '</font>';
    echo '</a></li>';
}
echo '      </ul>
        </div>
        <div data-role="footer" data-theme="a">
            <h1>' . $footer . '</h1>
        </div>
    </div>
            ';


// for each event, output a page with its information
foreach ($joint_events as $sid => $s) {
    if ($s['event_summary']) {
        error_log(json_encode($sid));


        echo '
        <div data-role="page" id="' . $sid . '">
            <div data-role="header" data-theme="a">
                <h1>' . $date_arrays[substr($sid, 0, 2)] . ' <br> ' . $s['timeslot'] . '</h1>
                <a href="#mylist" class="ui-btn-left" data-rel="back">Back</a>
            </div>';
        if (strtolower(substr($p['event_name'], 0, 11)) == 'cancelled: ') {
            echo '<div data-role="content">
                <h3 class="ui-bar ui-bar-a" style="color: #AAAAAA;">' . $s['event_name'] . ' - ' . $s['room'] . '</h3>';
        } else {
            echo '<div data-role="content">
                <h3 class="ui-bar ui-bar-a">' . $s['event_name'] . ' - ' . $s['room'] . '</h3>';
        }
                
        echo '  <ul data-role="listview" data-theme="a" data-inset="true">';
        echo '      <li style="white-space:normal;">';
        if ($s['event_title'] != 'Chair') {
            echo '<font style="color: #000000; font-weight: bold;">' . $s['event_title'] . '</font><br>';
        }
        
        echo $s['event_summary'];
        echo '      </li>';
        echo '   </ul>
            </div>
            <div data-role="footer" data-theme="a">
                <h1>' . $footer . '</h1>
            </div>
        </div>
                ';
    }
}

?>

