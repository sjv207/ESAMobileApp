<?php
// Page start
echo '<div data-role="page" id="aboutapp">';

create_header(title: $name_aboutapp, login: TRUE);
// Start content
echo ' <div data-role="content">';

create_textbox(
    title: 'About the app',
    content: '
		
		<p>
		This app was originally developed by Ben Greiner for the
        2017 ESA European Meeting in Vienna. And it was adapted to 
		ESA Bologna and further developed by Ali Seyhun Saral.  
		<br>
		It was then adapted to ESA World Meeting in Lyon by Béatrice Montbroussous
		and Quentin Thevenet.<p>

        <p>It was adapted to the ESA Meeting in Exeter by Scott Vincent.
        We express our gratitude for making the source code available for our 
        event.</p>

        <p>If you experience problems with the app, please send an e-mail 
		to: ' . alink(href: "esa2023@exeter.ac.uk", email: TRUE) . '
		</p>
        '

    
);


create_textbox(
    title: 'About cookies',
    content: '
        <h4>This app uses cookies in order to keep the track of your saved talks anonymously. </h4>

        <p>This Cookies Policy explains what Cookies are and how We use them. you should read this policy so you can understand what type of cookies We use, or the information We collect using Cookies and how that information is used.</p>

        <p>Cookies do not typically contain any information that personally identifies a user, but personal information that we store about you may be linked to the information stored in and obtained from Cookies. For further information on how We use, store and keep your personal data secure, see our Privacy Policy.</p>

        <p>We do not store sensitive personal information, such as mailing addresses, account passwords, etc. in the Cookies We use. Interpretation</p>

        <p>The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural. Definitions</p>

        <p>For the purposes of this Cookies Policy:</p>

        <p> Cookies means small files that are placed on your computer, mobile device or any other device by a website, containing details of your browsing history on that website among its many uses.  Website refers to ESA World Exeter 2023 program website, accessible from https://esa.feele.exeter.ac.uk/  you means the individual accessing or using the Website, or any legal entity on behalf of which such individual is accessing or using the Website, as applicable.</p>

        <p><h4>Type of Cookies We Use</h4></p>

        <p>Cookies can be &quot;Persistent&quot; or &quot;Session&quot; Cookies. Persistent Cookies remain on your personal computer or mobile device when you go offline, while Session Cookies are deleted as soon as you close your web browser.</p>

        <p>We use both session and persistent Cookies for the purposes set out below:</p> 

        <h4>Type Administered Purpose Session Cookies by Us Necessary / Essential Cookies</h4>
        <p>
        These Cookies are essential to provide you with services available through the Website and to enable you to use some of its features. They help to authenticate users and prev ent fraudulent use of user accounts. Without these Cookies, the services that you have asked for cannot be provided, and We only use these Cookies to provide you with those services. Persistent Cookies by Us Cookies Policy / Notice Acceptance Cookies These Cookies identify if users have accepted the use of cookies on the Website. Persistent Cookies by Us Functionality Cookies These Cookies allow us to remember choices you make when you use the Website, such as remembering your login details or language preference. The purpose of these Cookies is to provide you with a more personal experience and to avoid you having to re-enter your preferences every time you use the Website. For more information about the cookies we use and your choices regarding cookies, please visit our Cookies Policy. your Choices Regarding Cookies</p>

        <p>If you prefer to avoid the use of Cookies on the Website, first you must disable the use of Cookies in your browser and then delete the Cookies saved in your browser associated with this website. you may use this option for preventing the use of Cookies at any time.</p>

        <p>If you do not accept Our Cookies, you may experience some inconvenience in your use of the Website and some features may not function properly.</p>

        <p>If you\'d like to delete Cookies or instruct your web browser to delete or refuse Cookies, please visit the help pages of your web browser.</p>

        <p> For the Chrome web browser, please visit this page from Google:  <a href="https://support.google.com/accounts/answer/32050">https://support.google.com/accounts/answer/32050</a> </p>

        <p> For the Internet Explorer web browser, please visit this page from Microsoft:  <a href="http://support.microsoft.com/kb/278835">http://support.microsoft.com/kb/278835</a> </p> 

        <p>  For the Firefox web browser, please visit this page from Mozilla:  <a href="https://support.mozilla.org/en-US/kb/delete-cookies-remove-info-websites-stored">https://support.mozilla.org/en-US/kb/delete-cookies-remove-info-websites-stored</a> </p> 


        <p><h4>More Information About Cookies</h4></p>

        <p>For more information about Cookies, please visit: <a href="https://ec.europa.eu/info/cookies_en">https://ec.europa.eu/info/cookies_en</a> </p> 

                <h4>Contact Us</h4>
        <p>If you have any questions about this Cookies Policy, you can contact us by email: <a href="mailto:esa2023@exeter.ac.uk">FEELE</a></p>
'
);

// end content
echo '</div>';

create_footer();

// end page
echo '</div>';
?>