<?php

/**
 * This is Side Effect file
 */

require __DIR__ . '/vendor/autoload.php';

use Gomaji\Demo\TestA\A;
use Gomaji\Demo\TestB\B;


$aClazz = new A();
$bClazz = new B();

$callName =  $aClazz->callMe();
$showName = $bClazz->showMe();

echo $finalName . "\n";
