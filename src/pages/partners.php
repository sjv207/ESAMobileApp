<?php
// parterns page
echo '<div data-role="page" id="partners" data-cache="false">';

create_header(title: $name_partners, login: TRUE);

// partners content
echo '<div data-role="content">';

create_section('We are grateful to the partners of the 2023 ESA Exeter meeting for their generous support:');

echo '
<ul data-role="listview" data-inset="true">
<li class="ui-mini">

      <table>
        <tr>
          <th style="text-align:center"><img src="./images/logos/partners2.png"height="400"/></th>
        </tr>
      </table>

      </li>
</ul>';

// end maps exeter content, end maps exeter page
create_footer(close_before: TRUE, close_after: TRUE);

?>