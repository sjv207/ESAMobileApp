<?php
// page start
echo '<div data-role="page" id="announcements">';

create_header(title: $name_announcements, login: TRUE);

// content start
echo '<div data-role="content">';


foreach ($announcements as $aid => $ann) {
    create_textbox($ann['title'], $ann['text'], $ann['date']);
}

// end page
echo '</div>';
create_footer();

// end page
echo '</div>';

?>