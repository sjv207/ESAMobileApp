<?php
// page start
echo '<div data-role="page" id="contact">';

create_header(title: $name_contact, login: TRUE);

// content start
echo '<div data-role="content">';

create_section("Reach us via e-mail");

create_textbox(
    title: "",
    content: "
    For your inquiries, please email us at: " . esaexetermail()
);

create_section("Emergency");
create_textbox(
    title: "",
    content: "
    To call a doctor/emergency: 112"
);

// end content
echo '</div>';

create_footer();

// end page
echo '</div>';


?>