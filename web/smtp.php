<?php

/**
 * 邮件发送程序
 */


include_once  __DIR__ . "/../vendor/autoload.php";

main();
exit;

function main()
{
    $content = $_POST['content'];
    $subject = $_POST['subject'];
    $tos = $_POST['tos']; //使用逗号分隔的多个邮件地址

    smtp($subject, $content, $tos);
}


function smtp($subject, $content, $tos)
{
    $mail = new PHPMailer;

    $config = array();
    include_once __DIR__ . "/../config.php";

    $config = $config['smtp'];

    $mail->SMTPDebug = 3;                                // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $config['host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $config['username'];                 // SMTP username
    $mail->Password = $config['password'];                           // SMTP password
    if ($config['ssl']){
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    }
    if (!empty($config['port'])){
        $mail->Port = $config['port'];                                    // TCP port to connect to
    }

    if (!empty($config['from'])) {
        $mail->setFrom($config['from']);
    }else{
        $mail->setFrom($config['username']);
    }

    $tosArray = explode(";", $tos);
    foreach ($tosArray as $to) {
        $mail->addAddress($to);
    }

    $mail->isHTML(false);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $content;

    if (!$mail->send()) {
        echo 'send error';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'send ok';
    }
}

function test(){
    //curl -X POST $url -d "content=xxx&tos=xx@xxx.com&subject=xxx"
}