<?php
/// page to request a personal code
/// you need a mail sending provider or a mail server to use this
// uses google captcha. you need to get a key from google and put it in ./inc/settings.php
require_once("./inc/headcontent.php");
require_once("./inc/settings.php");
require_once("./inc/functions.php");

?>

<body>



  <?php

  if (!$request_available) {
    echo 'not available';
    exit;
  }

  echo '<div data-role="page" id="indexPage" data-title="Personal code request">';

  create_header(title: "Request personal code");

  echo '
<div data-role="content">';

  create_textbox(
    title: 'Request personal code',
    content: '
      Please enter below your email address to request your personal code. <br>
      <input type="text" placeholder="enter e-mail address" name="email"><br>
	 <div > <span id="text" class="textFont">Please, add these two numbers:<br /><br />

		4 + 3

	<fieldset >
	        <input name="CaptchaCode" type="text" id="CaptchaCode"  class="textFont"/>
        </fieldset >
        </div>
      <button onclick="  checkCaptcha();  "> Request </button>
  '
  );


  create_footer(close_before: TRUE, close_after: TRUE);
  ?>

  <script>
    var myRedirect = function (redirectUrl, arg, value) {
      var form = $('<form action="' + redirectUrl + '" method="post">' +
        '<input type="hidden" name="' + arg + '" value="' + value + '"></input>' + '</form>');
      $('body').append(form);
      $(form).submit();
    };


    function checkCaptcha() {
      if (document.getElementById('CaptchaCode').value != 7) {
        // Captcha validation failed, show error message
        alert('incorrect');
      } else {

        myRedirect("requestlink.php", "email", document.getElementsByName('email')[0].value);
      }

    }
  </script>