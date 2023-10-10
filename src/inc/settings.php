<?php
// some site settings
$login_available = TRUE;
$request_available = TRUE;

$mysql_host = getenv('ESA_MYSQL_HOST');
$mysql_db = getenv('ESA_MYSQL_DB');
$mysql_username = getenv('ESA_MYSQL_USERNAME');
$mysql_password = getenv('ESA_MYSQL_PASSWORD');

// Values for emails
$mail_username = getenv('ESA_MAIL_USERNAME');
$mail_password = getenv('ESA_MAIL_PASSWORD');

// echo 'LOADING: Host: '.$mysql_host.', db: '.$mysql_db.', username: '.$mysql_username.', passoword: '.$mysql_password.'<br>';

// google captcha 
$recaptcha_public = "public_key_for_recaptcha";
$recaptcha_key = "private_key_for_recaptcha";

//
$sendgrid_key = "sendgrid_key";

$timelimit = 5; // minutes
$program_txt_file = './content/program.txt';
$announcements_file = './content/announcements.csv';

$page_title = 'ESA Exeter 2023 Program';
$main_menu_title = '';
$footer = '2023 ESA Exeter Meeting, Exeter';
$name_schedule = 'Parallel & Invited sessions';
$name_contact = 'Contact & Emergency';
$name_team = 'FEELE team';
$name_mylist = 'My Program & Joint Events';
$name_mytalk = 'My Talk';
$name_add_to_my_list = 'Add to my program';
$name_remove_from_my_list = 'Remove from my program';
$name_search_presenters = 'Search participants';
$name_search = 'Find talks';
$name_presenters = 'Participants';
$name_partners = 'Partners';
$name_maps = 'Maps';
$name_website = 'Conference Website';
$name_aboutapp = 'About this app';
$name_announcements = 'Announcements';
$name_requestcode = 'Request personal code';

$logo_esa = 'images/logos/logo_esa_tiny.png';
$logo_gatelab = 'images/logos/uoe-dark-tiny.png';

$mylist_highlight_color = '#d7f0f7';
$event_highlight_color = '#f7f6dc';
$mytalk_highlight_color = '#ffdf6b';


////////////////////////////////////
// INFORMATION NOT CONTAINED IN THE PROGRAM TXT TABLE
////////////////////////////////////

// Contact details, can have different sections
$contact = array(
    'notused_anymore' =>
    array(
        'For your inquiries, please email us at:',
        '<a href="mailto:esa2023@exeter.ac.uk">esa2023@exeter.ac.uk</a>.',
    )
);
$team = array(
    'FEELE Team' =>
    array(
        'Miguel Fonseca',
        'Luke Lindsay',
        'Brit Grosskopf',
        'Scott Vincent',
        'Surajeet Chakravarty',
        'Todd R Kaplan',
        'Gabriel Katz',
        'Simone Meraglia',
        'Pradeep Kumar',
        'Kim Peters',
        'Loukas Balafoutas',
        'Cecilia Chen',
        'Daniel Derbyshire',
        'Helena Fornwagner',
        'Oliver Hauser',
        'Edwin Ip',
        'Hannes Titeca',
        'Pauline Vorjohann',
        'Joerg Weber',    )
);

?>
