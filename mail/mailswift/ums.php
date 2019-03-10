<?php
header("Access-Control-Allow-Origin: *");
if(isset($_POST['from'])) {
    require_once '../vendor/autoload.php';

// Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
        ->setUsername('nourwushu@gmail.com')
        ->setPassword('Pawudr2004.');

// Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);
    $messageText = 'New account has been created for you';
    $messageText .= $_POST['msg'];

// Create a message
    $message = (new Swift_Message($_POST['from']))
        ->setFrom(['nourwushu@gmail.com' => 'Noureddine Latreche'])
        ->setTo([$_POST['email'] => $_POST['name']])
                // Set the body
        ->setBody(
            '<html>' .
            ' <body>' .
            '<table>'.
            '<tbody>'.
            ' <tr><td height="120"><img src="http://via.placeholder.com/100x100" alt="logo" /><td></tr>' .
            '  <tr><td>'.$messageText.'<td></tr>' .
            '  <tr><td><br> <a href="#">Login</a><td></tr>' .
            '</tbody>'.
            '</table>'.
            ' </body>' .
            '</html>',
            'text/html' // Mark the content-type as HTML
        );

// Send the message
    return $result = $mailer->send($message);


}