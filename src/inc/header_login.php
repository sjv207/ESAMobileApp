<?php

echo '<div>';
#            if (isset($_GET['p']) & !code_allowed($_GET['p'])) {   // modif janv2023, cause warning
if (isset($_GET['p']))
    if (!code_allowed($_GET['p'])) {
        echo '</div>
                </div>

                <div data-role="content" class="ui-alt-icon">
                <ul data-role="listview">
                <li>
                <font color="red">
                Invalid code. 
                </font>
                <br>
                Please check the code again or continue without the code.
                </li>
                <li>
               <a href="/"  data-role="button" data-ajax="false"> Go back to the app. </a>
                </li> ';

        if ($request_available) {
            echo '<li>
                <a href="request.php" data-role="button" data-ajax="false"> Request a personal code / personal link </a>
                 </li> ';
        }

        echo '
                </ul> </div>';

        echo ' <div data-role="footer" data-theme="a"><h1>' . $footer . '</h1></div>
                </div>';
        exit();
    }


if (!isset($_GET['p'])) {
    if ($login_available) {
        echo '
                <div data-role="collapsible" class="ui-alt-icon" data-mini="true" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
                    <h4>You are not logged-in.</h4>';
        echo '<font size="2" color="grey"> It is not necessary to log in to use the app. However when you are logged-in, you can access to your saved talks in multiple devices. 
                Moreover, if you are a presenter, you will be able to reach your talk easily.</font><br><br>';

        echo '
                    Enter your private code to log in. <font color="grey">Alternatively you can click on your private link to log-in. </font>
                    
                    <!-- this is necessary for recognition of relevant input because inputs in all pages are rendered -->
                    <form>
                    <table style="width:50%">
                    <tr>
                        <td>
                            <input type="text" name="p"  placeholder="Enter your private code"maxlength="6" size="6"> 
                        </td>
                        <td>
                        <button class="loginbutton">Enter</button>
                        </td>
                    </tr>
                    </table>';
        if ($request_available) {
            echo '<a href="request.php" data-ajax="false"> Don\'t know your code? Request it. </a>';
        }
        echo '
                    </form>

                </div>
                ';
    }
} else {
    echo '<span style="margin-left: 1em";> Logged in with the code: <strong>' . $_GET['p'] . '</strong> </span>';
    //echo code_allowed($_GET['p']);
}
echo '</div>';

?>