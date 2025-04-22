<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Service\Configuration;
use App\Service\FakeData\ItemGeneratorFactory;


$templateName  = Configuration::templateName();
$itemGenerator = ItemGeneratorFactory::create($templateName);


$faked = $itemGenerator->create(Configuration::quantityToGenerate());

echo '<pre>' . json_encode($faked) . '</pre>';
