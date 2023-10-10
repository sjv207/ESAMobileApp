<?php
////////////////////////////////////
// ACTUAL CODE STARTS HERE, FIRST SOME FUNCTION DEFINITIONS
////////////////////////////////////


// get id from cookie (used to remember visitor)
function manage_cookie()
{
    global $esa_id;
    if (isset($_COOKIE['esa_id'])) {
        $esa_id = $_COOKIE['esa_id'];
        update_cookie();
    } else {
        $esa_id = uniqid("esa");
        update_cookie();
    }
}

// update cookie if needed
function update_cookie()
{
    global $esa_id;
    //    $done=setcookie("esa_id", $esa_id, time()+60*60*24*30*3);

    $done = setcookie("esa_id", $esa_id, [
        'expires' => time() + 60 * 60 * 24 * 30 * 3,
        'path' => '/',
        'secure' => true,
        'samesite' => 'Strict',
    ]);
}


function read_date_arrays()
{
    global $date_arrays;
    $date_arrays = array();

    $query = "SELECT * FROM `date_arrays` ORDER BY `date_arrays`.`id_date_arrays` ASC  ";
    $result = send_mysql_query_no_param($query);

    while ($line = $result->fetch(PDO::FETCH_ASSOC)) {
        $name = $line['day'];
        $date_arrays[$line['id_day']] = $name;
    }
}

function read_participants_notalk()
{
    global $participants_notalk;
    $participants_notalk = array();



    $query = "SELECT * FROM `participants_notalk` ORDER BY `participants_notalk`.`id_participants_notalk` ASC   ";
    $result = send_mysql_query_no_param($query);

    $i = 0;

    while ($line = $result->fetch(PDO::FETCH_ASSOC)) {



        $name = array(
            'fname' => $line['fname'],
            'lname' => $line['lname']
        );

        $i = $i + 1;



        $participants_notalk[$i] = $name;


    }
}

function read_joint_events()
{
    global $joint_events;
    $joint_events = array();



    $query = "SELECT * FROM `joint_event` ORDER BY `joint_event`.`id_joint_event` ASC   ";
    $result = send_mysql_query_no_param($query);



    while ($line = $result->fetch(PDO::FETCH_ASSOC)) {




        $event = array(


            'sid' => trim($line['sid']),
            // same internal identifier
            'sortid' => trim($line['sid']),
            // sort identifier: events will be sorted by this id, can be different to above
//        'day'=>$line['day'], // day of event, will be used for sectioning
            'timeslot' => $line['timeslot'],
            // time of event, will be used for sectioning
            'room' => $line['room'],
            // room / localtion
            'event_name' => $line['event_name'],
            // event name, to be shown in main list
            'event_title' => $line['event_title'],
            // title of talk, if this is a plenary talk
            'event_summary' => $line['event_summary'],
            // abstract of talk or description of event
            'event_presenter_fname' => $line['event_presenter_fname'],
            // if plenary, then first name of presenter
            'event_presenter_lname' => $line['event_presenter_lname'] // if plenary, then last name of presenter

        );

        $joint_events[$line['sid']] = $event;
    }
}

// read papers from the program txt file
function read_program()
{
    global $sessions, $sessions_sorted;
    $sessions = array();
    $sessions_sorted = array();

    $query = "SELECT * FROM `program` ORDER BY `program`.`id_program` ASC  ";
    $result = send_mysql_query_no_param($query);


    while ($line = $result->fetch(PDO::FETCH_ASSOC)) {

        $sid = trim($line['id_session']);
        $sortid = trim($line['id_session']);


        $paper = array(
            'presenter_fname' => trim($line['presenter_fname']),
            'presenter_lname' => trim($line['presenter_lname']),
            'presenter_email' => trim($line['presenter_email']),
            'university' => trim($line['university']),
            'title' => trim($line['title']),
            'abstract' => trim($line['abstract']),
            'other_authors' => trim($line['other_authors'])
        );


        if (!isset($sessions[$sid])) {
            $session = array(
                'sid' => $sid,
                'sortid' => $sortid,
                'day'=>trim($line['day']),
                'timeslot' => trim($line['timeslot']),
                'room' => trim($line['room']),
                'name' => trim($line['name']),
                'papers' => array()
            );
            $sessions[$sid] = $session;
        }


        $sessions[$sid]['papers'][] = $paper;
        $sessions_sorted[$sid] = $sortid;


    }



    asort($sessions_sorted);
    error_log(json_encode($sessions_sorted));
    error_log(json_encode($sessions));


}


function read_annoucements()
{

    global $announcements;

    $query = "SELECT * FROM `announcements` ORDER BY `announcements`.`id_announcements` DESC ";
    $result = send_mysql_query_no_param($query);
    $announcements = array();

    while ($line = $result->fetch(PDO::FETCH_ASSOC)) {
        $cur_ann = array(
            'date' => strtotime($line['date']),
            'title' => $line['title'],
            'text' => $line['text']
        );
        $announcements[] = $cur_ann;

    }
    usort($announcements, 'date_compare');
}


function sane_namecode($text)
{
    $text = str_replace(' ', '', $text);
    $text = str_replace("'", '', $text);
    return $text;
}


// connect to mysql database
function connect_database()
{
    // connect to mysql
    global $db, $mysql_host, $mysql_db, $mysql_username, $mysql_password;
    $dsn = 'mysql:host=' . $mysql_host . ';charset=UTF8;dbname=' . $mysql_db;
    try {
        $db = new PDO($dsn, $mysql_username, $mysql_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    } catch (PDOException $e) {
        // echo 'Host: '.$mysql_host.', db: '.$mysql_db.', username: '.$mysql_username.', passoword: '.$mysql_password;
        die('Connection failed: ' . $e->getMessage());
    }
}

// send a query to the database
function send_mysql_query($query, $pars)
{
    global $db;
    $stmt = $db->prepare($query);
    $stmt->execute($pars);
    return $stmt;
}


// send a query to the database
function send_mysql_query_no_param($query)
{
    global $db;
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt;
}



// get my own program from the database, based on my id (from cookie) or email address
function retrieve_my_list($esa_id, $email = '')
{
    // retrieve my_list
    $my_list = array();
    global $db_esa_id, $db_email;
    if ($email) {
        $pars = array(':email' => $email);
        $query = "SELECT * FROM my_list WHERE email=:email";
    } else {
        $pars = array(':esa_id' => $esa_id);
        $query = "SELECT * FROM my_list WHERE esa_id=:esa_id";
    }
    $result = send_mysql_query($query, $pars);
    while ($line = $result->fetch(PDO::FETCH_ASSOC)) {
        $my_list[] = $line['session_id'];
        $db_esa_id = $line['esa_id'];
        $db_email = $line['email'];
    }
    return $my_list;
}


function read_db_codes()
{
    $db_codes = array();
    global $db_codes;
    $pars = array();
    $query = "SELECT code FROM codes;";
    $result = send_mysql_query($query, $pars);


    while ($line = $result->fetch(PDO::FETCH_ASSOC)) {
        $db_codes[] = $line['code'];
    }
    //    return $allowed_codes;
}

function read_presenter_codes()
{
    global $sessions_sorted, $sessions, $presenter_codes;
    $presenter_codes = array();
    foreach ($sessions_sorted as $sid => $sortid) {
        foreach ($sessions[$sid]['papers'] as $paper) {
            $presenter_codes[] = $paper['presenter_email'];
        }
    }
}

function code_allowed($code)
{
    global $db_codes, $presenter_codes;
    return in_array($code, $db_codes) or in_array($code, $presenter_codes);
}

function date_compare($element1, $element2)
{
    $datetime1 = $element1['date'];
    $datetime2 = $element2['date'];
    return -($datetime1 - $datetime2); // newest on top;
}

function get_token($emailaddr)
{
    $emailcode = "vive_esa_exeter" . $emailaddr;
    $emailcodehash = md5($emailcode);
    $finaltoken = substr($emailcodehash, 0, 6);
    return $finaltoken;
}


function newtoken_allowed($token)
{
    global $conn;
    global $mysql_host, $mysql_username, $mysql_password, $mysql_db;
    global $timelimit;

    $conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // there should be no recent request 
    // check if there is a recent request with the same mail. 

    $sql = "SELECT * FROM codes WHERE code = '" . $token . "' AND date >= DATE_SUB(NOW(), INTERVAL " . $timelimit . " MINUTE)";
    $result = $conn->query($sql);

    return $result->num_rows == 0;
}

function add_request_to_db($token)
{
    global $conn;
    // add the request to db
    $sql = "INSERT INTO codes VALUES (null,'" . $token . "', NOW());";
    $result = $conn->query($sql);
}

function email_valid($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}


// =====================
//  Content functions
// =====================

// create page header

function create_header($title, $back = TRUE, $login = FALSE, $home = FALSE, $logos = FALSE, $custom_back = "")
{
    // important to define required vars here
    global $request_available, $login_available;
    global $logo_esa, $logo_gatelab;
    echo '<div data-role="header" data-theme="a">';

    if ($logos) {
        echo '<img src="' . $logo_gatelab . '" class="ui-btn-left">';
    }

    echo ' <h1>' . $title . '</h1>';

    if ($logos) {
        echo '<img src="' . $logo_esa . '" class="ui-btn-right">';
    }
    if ($back and !$custom_back) {
        echo ' <a href="#" class="ui-btn-left" data-rel="back">Back</a>';
    }
    if ($back and $custom_back) {
        echo ' <a href="' . $custom_back . '" class="ui-btn-left" data-ajax="false">Back</a>';
    }
    if ($home) {
        echo '<a href="#indexPage" class="ui-btn ui-icon-home ui-btn-icon-right ui-btn-icon-notext">Home</a>';
    }

    // login page also handles wrong code and so on.
    if ($login) {
        include("./inc/header_login.php");
    }
    echo ' </div>';

}

function create_footer($text = NULL, $close_before = FALSE, $close_after = FALSE)
{
    // the default is $footer in settings.py
    // close means it closes the divs that are open
    global $footer;

    if ($close_before) {
        echo "</div>";
    }

    echo '<div data-role="footer" data-theme="a"><h1>';
    if (is_null($text)) {
        echo $footer;
    } else {
        echo $text;
    }
    echo '</h1></div>';

    if ($close_before) {
        echo "</div>";
    }
}


function create_textbox($title, $content, $date = NULL)
{

    echo '<div class="ui-body ui-body-a ui-corner-all">';

    if (!empty($title)) {
        echo '<h3 style="margin-bottom: 0;margin-top: 0.2;">' . $title . '</h3>';
    }
    // date format "2022-11-11 12:34:00"
    if (!is_null($date)) {
        echo '<font color="gray">' . date("d M Y H:i", $date) . '</font>';

    }
    echo $content;
    echo '<br>';
    echo '</div>';
    echo '<br>';
}


function create_section($title)
{
    echo '<h3 class="ui-bar ui-bar-a">' . $title . '</h3>';
}

function create_list($array)
{
    echo '<ul data-role="listview" data-theme="a" data-inset="true">';

    foreach ($array as $li) {
        echo '<li>' . $li . '</li>';
    }
    echo '</ul>';

}

function create_image_page($page_id, $page_title, $image_link, $image_caption = "")
{
    echo '<div data-role="page" id="' . $page_id . '" data-cache="false">';
    create_header($page_title);

    echo '  <div data-role="content">';
    echo '    <img src="' . $image_link . '" alt="' . $image_caption . '" style="width: 100%; max-width: 412px; display: block; margin-left: auto; margin-right: auto;">';
    echo '  </div>';
    create_footer();
    echo ' </div>';
}

function alink($href, $email = FALSE, $https = TRUE, $blank = FALSE)
{

    if ($email) {
        $https = FALSE;
    }

    $https_prefix = ($https ? "https://" : "");
    $email_prefix = ($email ? "mailto:" : "");
    $target_tag = ($blank ? 'target="_blank"' : "");

    return '<a href="' . $https_prefix . $email_prefix . $href . '" ' . $target_tag . '>' . $href . '</a>';
}

function esaexetermail()
{
    return alink(href: "esa2023@exeter.ac.uk", email: TRUE);
}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}


function remove_accents($string)
{
    if (!preg_match('/[\x80-\xff]/', $string))
        return $string;

    $chars = array(
        // Decompositions for Latin-1 Supplement
        chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
        chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
        chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
        chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
        chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
        chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
        chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
        chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
        chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
        chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
        chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
        chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
        chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
        chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
        chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
        chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
        chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
        chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
        chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
        chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
        chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
        chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
        chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
        chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
        chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
        chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
        chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
        chr(195) . chr(191) => 'y',
        // Decompositions for Latin Extended-A
        chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
        chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
        chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
        chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
        chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
        chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
        chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
        chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
        chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
        chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
        chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
        chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
        chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
        chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
        chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
        chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
        chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
        chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
        chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
        chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
        chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
        chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
        chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
        chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
        chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
        chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
        chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
        chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
        chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
        chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
        chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
        chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
        chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
        chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
        chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
        chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
        chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
        chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
        chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
        chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
        chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
        chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
        chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
        chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
        chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
        chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
        chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
        chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
        chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
        chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
        chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
        chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
        chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
        chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
        chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
        chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
        chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
        chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
        chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
        chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
        chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
        chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
        chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
        chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's'
    );

    $string = strtr($string, $chars);

    return $string;
}



////////////////////////////////////
// FUNCTION DONE, NOW LET'S DO SOME STUFF
////////////////////////////////////
?>