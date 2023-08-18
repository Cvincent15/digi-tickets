<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;

$factory = (new Factory)
    ->withServiceAccount('ctmeu-d5575-firebase-adminsdk-b64w9-c70e931f61.json')
    ->withDatabaseUri('https://ctmeu-d5575-default-rtdb.asia-southeast1.firebasedatabase.app/');

    $database = $factory->createDatabase();
    $auth = $factory->createAuth();

?>