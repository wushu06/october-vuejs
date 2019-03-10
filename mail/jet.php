<?php
require 'vendor/autoload.php';

use \Mailjet\Resources;
$mj = new \Mailjet\Client(getenv('f1457db282ee5f8baacef6800fcda689'),
    getenv('f9f0e836de29e82f9a803deeda995bd5'),true,['version' => 'v3.1']);


$body = [
    'FromEmail' => "pilot@mailjet.com",
    'FromName' => "Mailjet Pilot",
    'Subject' => "Your email flight plan!",
    'Text-part' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
    'Html-part' => "<h3>Dear passenger, welcome to Mailjet!</h3><br/>May the delivery force be with you!",
    'Recipients' => [
        [
            'Email' => "nourwushu@gmail.com"
        ]
    ]
];
$response = $mj->post(Resources::$Email, ['body' => $body]);
if($response->success())
    var_dump($response->getData());
else
    var_dump($response->getStatus());
