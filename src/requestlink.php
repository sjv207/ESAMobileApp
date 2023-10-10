<?php
use PHPMailer\PHPMailer\PHPMailer; //important, on php files with more php stuff move it to the top

// require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
## the page that processes the request for a personal code
require_once("./inc/headcontent.php");
require_once("./inc/settings.php");
require_once("./inc/functions.php");
require './lib/PHPMailer/src/Exception.php';
require './lib/PHPMailer/src/PHPMailer.php';
require './lib/PHPMailer/src/SMTP.php';
?>

<?php

if (!$request_available) {
  echo 'not available';
  exit;
}

$finaltoken = get_token($_POST["email"]);
$finallink = "https://esa.feele.exeter.ac.uk/?p=" . $finaltoken;
require("inc/mailtemplate.php");

?>

<body>
  <?php
  echo '<div data-role="page" id="indexPage" data-title="' . $name_requestcode . '">';

  // if there is no recent request, go.
  if (!email_valid($_POST["email"])) {
    create_header(title: "$name_requestcode", custom_back: "request.php");
    echo '<div data-role="content">';
    create_textbox(
      title: "Invalid email",
      content: 'You have entered an invalid e-mail address.
                Please check the e-mail address you entered: <strong>' . $_POST["email"] . '</strong>'
    );

    create_footer(close_before: TRUE, close_after: TRUE);
    exit;
  }


  // if there is no recent request, go.
  if (!newtoken_allowed($finaltoken)) {
    create_header(title: $name_requestcode, custom_back: "request.php");
    echo '<div data-role="content">';
    create_textbox(
      title: "Too many tokens requested",
      content: "We've already sent an email in the last " . $timelimit . " minutes.
                          Please wait for a while to re-request it again. If you didn't receive
                          your code after requesting please also check your spam folder."
    );
    create_footer(close_before: TRUE, close_after: TRUE);
    exit;
  }
  // capcha check
  
  // If you are experiencing issues with sending mail, set SMTPDebug=2 for 
  // verbose output from both client and server ends
  $mail = new PHPMailer(true);
  try {
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = getenv('ESA_MAIL_HOSTNAME');
    $mail->Port = getenv('ESA_MAIL_PORT');
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = getenv('ESA_MAIL_USERNAME');
    $mail->Password = getenv('ESA_MAIL_PASSWORD');
    $mail->SetFrom(getenv('ESA_MAIL_USERNAME'), 'FromEmail');
    $mail->addAddress($_POST["email"]);
    $mail->Debugoutput = function ($str, $level) {
      echo "debug level $level; message: $str";
    }; //$mail->Debugoutput = 'echo';
    $mail->IsHTML(true);

    $mail->Subject = 'Your personal code for ESA Exeter 2023 App';
    $mail->Body = $mailtemplate;
    $mail->AltBody = $mailtemplate;

    if (!$mail->send()) {
      // echo 'Message could not be sent.';
      // echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      // echo 'Message has been sent';
    }
  } catch (Exception $e) {
    // echo 'Message could not be sent.';
    // echo 'Mailer Error: ' . $mail->ErrorInfo;
  }

  echo '<div data-role="content">';
  create_textbox(title: "Code sent!", content: 'We have sent the personal code to your e-mail address. Please check the e-mail address you have specified: <strong>' . $_POST["email"] . '</strong>');
  create_footer(close_before: TRUE, close_after: TRUE);
  add_request_to_db($finaltoken);

  ?>
</body>

</html>
