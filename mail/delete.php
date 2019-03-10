<?php
header("Access-Control-Allow-Origin: *");
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

if(isset($_POST['delete'])) {

    $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/google-service-account.json');

    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();

    $auth = $firebase->getAuth();

    $uid = $_POST['delete'];

    $auth->deleteUser($uid);
}
