<?php
// Output program schedule pages and subpages

// let's sort the sessions and create schedule structure based on days, timeslots, and rooms
ksort($sessions);
$schedule = array();
foreach ($sessions_sorted as $sid => $sortid) {
    $schedule[$sessions[$sid]['day']][$sessions[$sid]['timeslot']][$sessions[$sid]['room']] = $sid;
}

// output page with list of days
echo '
    <!-- schedule -->
    <div data-role="page" id="schedule">';
create_header(title: $name_schedule, login: TRUE);

echo '<div data-role="content">';

echo '<ul data-role="listview" data-theme="a" data-inset="true">';
foreach ($schedule as $k => $d) {
    echo '<li><a href="#' . $k . '">' . $k . '</a></li>';
}
echo '</ul>';

create_footer(close_before: TRUE, close_after: TRUE);



// for each day, output a page with list of timeslots
foreach ($schedule as $day => $slots) {
    echo '
    <!-- day ' . $day . ' -->
    <div data-role="page" id="' . $day . '">';
    create_header(title: $day, login: TRUE, home: TRUE);


    echo '<div data-role="content">
            <ul data-role="listview" data-theme="a" data-inset="true">';
    foreach ($slots as $slot => $rooms) {
        echo '<li><a href="#' . $day . $slot . '">' . $slot . '</a></li>';
    }
    echo '      </ul>';

    create_footer(close_before: TRUE, close_after: TRUE);

}

// for each day and timeslots, output a page with list of rooms (sessions)
foreach ($schedule as $day => $slots) {
    foreach ($slots as $slot => $rooms) {
        echo '
    <!-- day ' . $day . ' slot ' . $slot . ' -->
    <div data-role="page" id="' . $day . $slot . '">';

        create_header(title: $day . '<br>' . $slot, login: TRUE, home: TRUE);

        echo '
        <div data-role="content">
            <ul data-role="listview" data-theme="a" data-inset="true">';
        foreach ($rooms as $room => $session) {
            $thismytalk = false;
            $thislist = array();
            foreach ($sessions[$session]['papers'] as $paper) {


                if (strtolower(substr($paper['title'], 0, 6)) == 'aaaaaa') {
                    $thislist[] = $paper['presenter_fname'] . ' ' . $paper['presenter_lname'] . '';
                } else {

                    if (strtolower(substr($paper['title'], 0, 11)) == 'cancelled: ') {
                        $thislist[] = '<i style="color: #AAAAAA;">CANCELLED: ' . $paper['presenter_fname'] . ' ' . $paper['presenter_lname'] . ': ' . substr($paper['title'], 10) . '</i>';
                    } else {
                        $thislist[] = $paper['presenter_fname'] . ' ' . $paper['presenter_lname'] . ': <i>' . $paper['title'] . '</i>';
                    }
                }
                if ($email && $paper['presenter_email'] == $email)
                    $thismytalk = true;
            }
            echo '<li><a href="#' . $session . '" class="ui-mini"';
            //if (isset($mytalks)) {
            if (in_array($session, $mytalks))
                echo ' style="background: ' . $mytalk_highlight_color . ';"';
            //}
            if (in_array($session, $my_list))
                echo ' style="background: ' . $mylist_highlight_color . ';"';
            echo '>';
            echo $room . ' - ' . $sessions[$session]['name'];
            echo '<br>';

            echo '<font color="grey">' . implode('<br>', $thislist) . '</font>';
            echo '</a></li>';
        }
        echo '      </ul>';

        create_footer(close_before: TRUE, close_after: TRUE);
    }
}

// for each session, output a page with its talks and abstracts
foreach ($sessions as $sid => $s) {
    echo '
    <div data-role="page" id="' . $sid . '">';

    create_header(title: $s['day'] . '<br> ' . $s['timeslot'], login: TRUE, home: TRUE);

    echo '
        <div data-role="content">
            <h3 class="ui-bar ui-bar-a">' . $s['room'] . ' - ' . $s['name'] . '</h3>';

    if (in_array($sid, $my_list)) {
        echo '<form id="form-' . $sid . '" method="post" data-ajax="false">
            <INPUT type=hidden name="p" value="' . $email . '">
              <INPUT type=hidden name="s" value="' . $sid . '">
            <INPUT type=hidden name="delfromlist" value="true">
            <input data-icon="check" type="submit" id="submit-s' . $sid . '" value="' . $name_remove_from_my_list . '">
          </form>';
    } else if (in_array($sid, $mytalks)) {
        echo '<a href="#" data-role="button"  data-icon="star"  data-iconpos="left" >' . $name_mytalk . '</a>';
    } else {
        echo '<form id="form-' . $sid . '" method="post" data-ajax="false">
            <INPUT type=hidden name="p" value="' . $email . '">
              <INPUT type=hidden name="s" value="' . $sid . '">
            <INPUT type=hidden name="addtolist" value="true">
            <input data-icon="star" type="submit" id="submit-s' . $sid . '" value="' . $name_add_to_my_list . '">
          </form>';
    }


    echo '
            <ul data-role="listview" data-theme="a" data-inset="true">
            ';
    foreach ($s['papers'] as $p) {

        if (strtolower(substr($p['title'], 0, 6)) == 'aaaaaa') {

            echo '<li style="white-space:normal;" id="' . sane_namecode($p['presenter_fname'] . $p['presenter_lname']) . '">';
            echo '     <strong>Presenter:</strong><br>' . $p['presenter_fname'] . ' ' . $p['presenter_lname'] . ', ' . $p['university'] . '<br>';
            echo '</li>';


        } else {


            if (strtolower(substr($p['title'], 0, 11)) == 'cancelled: ') {
                echo '<li style="white-space:normal; background: #AAAAAA;">';
                echo '<strong>CANCELLED:</strong><br>
                  Presenter: ' . $p['presenter_fname'] . ' ' . $p['presenter_lname'] . ', ' . $p['university'] . ', Title: ' . substr($p['title'], 10);
                echo '</li>';
            } else {
                echo '<li style="white-space:normal;" id="' . sane_namecode($p['presenter_fname'] . $p['presenter_lname']) . '">';
                echo '  
                <strong>Presenter:</strong><br>' . $p['presenter_fname'] . ' ' . $p['presenter_lname'] . ', ' . $p['university'] . '<br>
                <strong>Title:</strong><br>' . $p['title'];
                echo '<br><strong>(Co-)Authors:</strong><br>' . $p['other_authors'];
                if (trim($p['abstract'])) {
                    echo '<br><strong>Abstract:</strong><br>' . $p['abstract'];
                }
            }
            echo '</li>';
        }

    }
    echo '  </ul>';

    create_footer(close_before: TRUE, close_after: TRUE);
}
?>