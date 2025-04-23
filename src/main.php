<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Provider\InputProvider;
use App\Service\FakeData\ItemGeneratorFactory;


$templateName  = InputProvider::templateName();
$itemGenerator = ItemGeneratorFactory::create($templateName);


$faked = $itemGenerator->create(InputProvider::quantityToGenerate());

echo '<pre>' . json_encode($faked) . '</pre>';