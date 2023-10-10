<?php
// a list of all participants, with links to their talks
$presenters = array();
foreach ($joint_events as $sid => $event) {
    if (isset($event['event_presenter_lname']) && $event['event_presenter_lname']) {
        $tpres = array(
            'presenter_fname' => $event['event_presenter_fname'],
            'presenter_lname' => $event['event_presenter_lname']
        );
        if ($event['event_summary'])
            $tpres['session_id'] = $sid;
        $key = strtoupper($event['event_presenter_lname'] . ', ' . $event['event_presenter_fname']);
        $presenters[$key] = $tpres;
    }
}
foreach ($sessions as $sid => $session) {
    foreach ($session['papers'] as $paper) {
        $key = strtoupper($paper['presenter_lname'] . ', ' . $paper['presenter_fname']);
        $key = str_replace("Š", "S", $key);
        $key = str_replace("Č", "C", $key);
        $key = remove_accents($key);

        $presenters[$key] = array(
            'presenter_fname' => $paper['presenter_fname'],
            'presenter_lname' => $paper['presenter_lname'],
            'session_id' => $sid
        );
    }
}

foreach ($participants_notalk as $part) {
    $key = strtoupper($part['lname'] . ', ' . $part['fname']);
    $presenters[$key] = array(
        'presenter_fname' => $part['fname'],
        'presenter_lname' => $part['lname'],
        'session_id' => ''
    );
}

ksort($presenters);

echo '
    <!-- presenters -->
    <div data-role="page" id="presenters">';
create_header(title: $name_presenters, login: TRUE);

echo '
        <div data-role="content">
            <ul data-role="listview" data-theme="a" data-inset="true" data-filter="true" data-filter-placeholder="' . $name_search_presenters . '" data-autodividers="true">';
foreach ($presenters as $pres) {
#              if ($pres['session_id']) echo '<li class="ui-mini">'."\n";
#              if (!$pres['session_id']) echo '<li class="ui-mini" data-icon="false" >'."\n";

    if (isset($pres['session_id'])) {
        echo '<li class="ui-mini">' . "\n";
        echo '<a href="#' . $pres['session_id'] . '" onclick="getTalkLater(\'' . sane_namecode($pres['presenter_fname'] . $pres['presenter_lname']) . '\');">';
    } else {
        echo '<li class="ui-mini" data-icon="false" >' . "\n";
        echo '<a href="#">';
    }

    echo $pres['presenter_lname'] . ', ' . $pres['presenter_fname'];
    echo '<span hidden>' . remove_accents($pres['presenter_lname'] . ', ' . $pres['presenter_fname']) . '</span>';
    //              if ($pres['session_id']) echo '</a>'; 
    echo '</a>';
    echo '</li>';
}
echo '      </ul>';

create_footer(close_before: TRUE, close_after: TRUE);
?>