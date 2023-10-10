<?php
// page start
echo '<div data-role="page" id="team">';

create_header(title: $name_team, login: TRUE);

// content start
echo '<div data-role="content">';

create_section("FEELE Team");

create_list($team['FEELE Team']);


create_textbox(
    title: "",
    content: "For more information about the <strong>FEELE Lab</strong>,
    <a href='https://feele.exeter.ac.uk/' target='_blank'>visit our website</a>."
);

// end content
echo '</div>';

create_footer();

// end page
echo '</div>';


?>