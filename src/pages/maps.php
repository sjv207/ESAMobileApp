<?php
// maps page
echo '<div data-role="page" id="maps" data-cache="false">';

create_header(title: $name_maps, login: TRUE);

// maps content
echo '<div data-role="content">';

create_section('Conference Venue');

echo '
    <ul data-role="listview" data-inset="true">
      <li class="ui-mini"><a href="#maps-general">General Map<br><font color="grey">
      <table>
      <thead>
          <tr>
            <th>Building One (84), Streatham Court (31), XFi (30)</th>
          </tr>
        </thead>
      </table></font></a></li>
    </ul>';

create_section('Welcome Reception: Exeter Castle');
echo '
    <ul data-role="listview" data-inset="true">
      <li class="ui-mini"><a href="#maps-exetercastle">Exeter Castle<br><font color="grey"> 
      </font></a></li>
	</ul>';

create_section('Conference Dinner: Exeter Cathedral');
echo '
    <ul data-role="listview" data-inset="true">
      <li class="ui-mini"><a href="#maps-exetercathedral">Exeter Cathedral<br><font color="grey"> 
      </font></a></li>
  </ul>';

// end maps content, end maps page
create_footer(close_before: TRUE, close_after: TRUE);

// header and footer included
create_image_page(
  page_id: "maps-general",
  page_title: "General map",
  image_link: "./images/maps/exeter_campus_map.gif",
  image_caption: "Conference venue",
);


// page Exeter castle
// header and footer included
create_image_page(
  page_id: "maps-exetercastle",
  page_title: "Exeter Castle",
  image_link: "./images/maps/exeter-castle.png",
  image_caption: "Welcome Reception - Exeter Castle",
);

// page Exeter castle
// header and footer included
create_image_page(
  page_id: "maps-exetercathedral",
  page_title: "Exeter Castle",
  image_link: "./images/maps/exeter-cathedral.png",
  image_caption: "Welcome Reception - Exeter Castle",
);

// page start maps exeter
echo '<div data-role="page" id="maps-events" data-cache="false">';

create_header("Exeter Maps");
// content start maps Exeter
echo '<div data-role="content" >';

// echo '
// <ul data-role="listview" data-inset="true">
// <li data-icon="action" class="ui-mini"><a href="https://goo.gl/maps/RGBEYW3oHErxa6p8A" target="_blank"> Conference venue: <br> University Lyon 2<br><font color="grey"> 18 Quai Claude Bernard</font> <span class="ui-li-count"> Opens in Google Maps</span>
// <li data-icon="action" class="ui-mini"><a href="https://goo.gl/maps/PSVg7T1eezrNqdHy6" target="_blank"> Conference venue: <br> University Lyon 3-IUT<br><font color="grey">88 rue Pasteur</font> <span class="ui-li-count"> Opens in Google Maps</span></a></li>
// <li data-icon="action" class="ui-mini"><a href="https://goo.gl/maps/6cqTKKgBmzJDAmdR8" target="_blank"> Lunches: <br> CROUS restaurant<br><font color="grey"> 94 rue Pasteur</font> <span class="ui-li-count"> Opens in Google Maps</span></a></li>
// <li data-icon="action" class="ui-mini"><a href="https://goo.gl/maps/RGBEYW3oHErxa6p8A" target="_blank"> Welcome reception: <br> University Lyon 2 - Hirsch Palace <br><font color="grey">18 Quai Claude Bernard </font> <span class="ui-li-count"> Opens in Google Maps</span></a></li>
// <li data-icon="action" class="ui-mini"><a href="https://goo.gl/maps/gE23AEj8kxBuSBr36" target="_blank"> A glass on the riverbanks<br><font color="grey"> 15 Quai du Général Sarrail </font> <span class="ui-li-count"> Opens in Google Maps</span></a></li>
// <li data-icon="action" class="ui-mini"><a href="https://goo.gl/maps/x4zQV4ERwwVRruj47" target="_blank"> Conference dinner: <br> Grand Réfectoire in Grand Hôtel Dieu <br><font color="grey">3 cour Saint-Henri </font> <span class="ui-li-count"> Opens in Google Maps</span></a></li>
// <li>';

// google maps map
echo '
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d40412.128384902724!2d-3.5135475!3d50.7244282!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486c52c4d4498da7%3A0xa976e3256bdfad1e!2sExeter!5e0!3m2!1sen!2suk!4v1693302221205!5m2!1sen!2suk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
';

// end maps exeter content, end maps exeter page
create_footer(close_before: TRUE, close_after: TRUE);

?>