<?php
// a list of all participants, with links to their talks
$allevents = array();
//          foreach ($joint_events as $sid=>$event) {
//              if(isset($event['event_presenter_lname']) && $event['event_presenter_lname']) {
//                  $tpres=array(
//                      'presenter_fname'=>$event['event_presenter_fname'],
//                      'presenter_lname'=>$event['event_presenter_lname']
//                  );
//                  if($event['event_summary']) $tpres['session_id']=$sid;
//                  $key=strtoupper($event['event_presenter_lname'].', '.$event['event_presenter_fname']);
//                  $allevents[$key]=$tpres;
//              }
//          }
foreach ($sessions as $sid => $session) {
    foreach ($session['papers'] as $paper) {
        //                  $key=strtoupper($paper['presenter_lname'].', '.$paper['presenter_fname']);
        $key = $paper['title'];

        //$key=str_replace("Š","S",$key);
        //$key=str_replace("Č","C",$key);

        $allevents[$key] = array(
            'paper_title' => $paper['title'],
            //                      'paper_abstract'=>trim(preg_replace('/\s+/', ' ', $paper['abstract'])),
            'paper_abstract' => strip_tags($paper['abstract']),
            'presenter_fname' => $paper['presenter_fname'],
            'presenter_lname' => $paper['presenter_lname'],
            'session_id' => $sid,
            'session_name' => $session['name'],
            'time_and_place' => $session['day'] . " " . $session['timeslot'] . ": " . $session['room']
        );
    }
}

//          foreach ($participants_notalk as $part) {
//              $key=strtoupper($part['lname'].', '.$part['fname']);
//              $allevents[$key]=array(
//                  'presenter_fname'=>$part['fname'],
//                  'presenter_lname'=>$part['lname'],
//                  'session_id'=>''
//              );
//          }

ksort($allevents);

echo '
    <!-- allevents -->
    <div data-role="page" id="search">';
create_header(title: $name_schedule, login: TRUE);
echo '
        <div data-role="content">
            <ul data-role="listview" data-theme="a" data-inset="true" data-filter="true" data-filter-placeholder="' . $name_search . '">';
foreach ($allevents as $pres) {
    echo '<li class="ui-mini">';
    echo '<a href="#' . $pres['session_id'] . 'exeter" onclick="getTalkLater(\'' . sane_namecode($pres['presenter_fname'] . $pres['presenter_lname']) . '\');">';

    if (strtolower(substr($pres['paper_title'], 0, 6)) == 'aaaaaa') {

    } else {

        echo $pres['paper_title'];
    }
    echo '<br>' . $pres['time_and_place'];
    echo '<br>' . $pres['presenter_fname'] . ' ' . $pres['presenter_lname'];
    echo '<span hidden>' . remove_accents($pres['presenter_lname'] . ', ' . $pres['presenter_fname']) . '</span>';
    echo '<br><font color="#BB2E29">' . $pres['session_name'];
    echo '</font>';
    echo '<br><font color="grey">';
    echo $pres['paper_abstract'];
    echo '</font>';
    echo '</a>';
    echo '</li>';
    //              if ($pres['session_id']) echo '<li class="ui-mini">'."\n";
//              if (!$pres['session_id']) echo '<li class="ui-mini" data-icon="false" >'."\n";
//           if ($pres['session_id']) echo '<a href="#'.$pres['session_id'].'">';
    //             if (!$pres['session_id']) echo '<a href="#">';
    //            echo $pres['presenter_lname'].', '.$pres['presenter_fname'];
    //             if ($pres['session_id']) echo '</a>'; 

    echo '</a>';
    echo '</li>';
}
echo '      </ul>';
//echo '<li> test </li>';
echo '</ul>';

create_footer(close_before: TRUE, close_after: TRUE);

?>