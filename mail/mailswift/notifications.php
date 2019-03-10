<?php
header("Access-Control-Allow-Origin: *");
if(isset($_POST['subject'])) {

    require_once '../vendor/autoload.php';
// Create the Transport

// Create the Mailer using your created Transport

// Usually you want to replace the following static array
// with a dynamic one built retrieving users subject the database


// Create the replacements array

    $replacements[$_POST['email']] = array(
        "{subject}" => $_POST['subject'],
        "{message}" => $_POST['message']
    );

// Create the mail transport configuration

    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
        ->setUsername('nourwushu@gmail.com')
        ->setPassword('Pawudr2004.');

// Create an instance of the plugin and register it
    $plugin = new Swift_Plugins_DecoratorPlugin($replacements);
    $mailer = new Swift_Mailer($transport);
    $mailer->registerPlugin($plugin);

// Create the message
    $message = new Swift_Message;
    $message->setSubject("{subject}");
    $message->setBody("{message}");
    $message->setFrom(['nourwushu@gmail.com' => 'Noureddine Latreche']);

// Send the email

    $message->setTo([$_POST['email'] => $_POST['name']]);
    $mailer->send($message);
}