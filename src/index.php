<?php
// Settings and manual set information are here (except for the annoucements)
require_once("./inc/settings.php");
require_once("./inc/functions.php");

// preliminaries
manage_cookie();

// Program file is a tab separated file with the following fields and no variable name:
# session code
# session code (for sorting)
# date
# timeslot
# room
# category
# name
# surname
# private code (used for personal list)
# institution
# abstract
# (co-authors)

connect_database();
read_participants_notalk();

read_date_arrays();
read_joint_events();
read_program();
read_annoucements(); // ./content/announcements.csv
read_db_codes();
read_presenter_codes();
// can be converted to functions later
require_once("./inc/getmylist.php");
require_once("./inc/handlerequest.php");
require_once("./inc/getmytalks.php");

// contain html openings, jquery, google fonts, links and scripts
include('./inc/headcontent.php');

echo '
<body>

<div data-role="page" id="indexPage" data-title="' . $page_title . '">';

## function to create header
## title: title of the page
## login: show login panel
## back: show back button
## home: show home button
## logos: show logos

create_header(
    title: $main_menu_title,
    login: FALSE, // logins are handled by 'inc/header_login.php'
    back: FALSE,
    home: FALSE,
    logos: TRUE
);

echo '
    <div data-role="content" class="ui-alt-icon">';

echo '
        <ul data-role="listview">
            <li>
            <a href="#announcements"  data-role="button" data-icon="announcement"  data-iconpos="left" onclick="reloadAfterTime(500);">' . $name_announcements . ' <span class="ui-li-count">Last update: ' . date("d M Y H:i", $announcements[0]['date']) . ' </span></a>
            </li>

            <li>
            <a href="#schedule"  data-role="button" data-icon="calendar"  data-iconpos="left">' . $name_schedule . '</a>
            </li>

            <li>
            <a href="#search" data-role="button"  data-icon="search"  data-iconpos="left" >' . $name_search . '</a>
            </li>

            <li>
            <a href="#mylist"  data-role="button" data-icon="bullets"  data-iconpos="left">' . $name_mylist . '<span class="ui-li-count">' . count($my_list) . '</span></a>
            </li>
            ';
// Add my talks 
if (count($mytalks) > 0) {
    echo '
            <li>
            <a href="#mytalks';
    // if (count($mytalks)>1) echo 'mytalks'; else echo $mytalks[0];
    echo '"  data-role="button" data-icon="star"  data-iconpos="left">' . $name_mytalk . '</a>
            </li>';
}

echo '
            <li>
            <a href="#presenters" data-role="button" data-icon="user"  data-iconpos="left">' . $name_presenters . '</a>
            </li>

            <li>
            <a href="#maps" data-role="button" rel="external" data-icon="location" data-iconpos="left" >' . $name_maps . '</a>
            </li>

	    <li>
            <a href="#partners" data-role="button" rel="external" data-icon="user" data-iconpos="left" >' . $name_partners . '</a>
	    </li>

            <li>
            <a href="#contact" data-role="button"  data-icon="mail"  data-iconpos="left" >' . $name_contact . '</a>
            </li>

            <li>
            <a href="#team" data-role="button"  data-icon="user"  data-iconpos="left" >' . $name_team . '</a>
	        </li>

            <li>
            <a href="#aboutapp" data-role="button" data-icon="info"  data-iconpos="left">' . $name_aboutapp . '</a>
            </li>

            <li>
            <a href="https://www.exeter-economics-conferences.org/" target="_blank" data-role="button"  data-icon="action"  data-iconpos="left">' . $name_website . '</a>
            </li>

        </ul>
</div>';

// these are out of content div but it only aligns like this.
// so i'll rather keep it.
include("./inc/addapptophone.php");
// include("./inc/twittershare.php");
include("./inc/whatsappgroup.php");


create_footer($footer);

echo '</div>';

echo '
</body>
</html>
';


//  Pages
require("./pages/contact.php");
require("./pages/team.php");
require("./pages/maps.php");
require("./pages/partners.php");
require("./pages/aboutapp.php");
require("./pages/announcements.php");
require("./pages/sessions.php");
require("./pages/mytalks.php");
require("./pages/search.php");
require("./pages/myprogram.php");
require("./pages/participants.php");
require("./request.php");



?>