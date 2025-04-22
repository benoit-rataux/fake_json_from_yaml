<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Service\FakeData\ItemGeneratorFactory;
use Symfony\Component\Yaml\Yaml;

$CONF_INIT_FILE = __DIR__ . '/../conf/json_template.yaml';

$conf               = Yaml::parseFile($CONF_INIT_FILE);
$templateName       = $conf['template']['name'];
$quantity           = $conf['template']['quantity'];
$templatesRepertory = $conf['init']['repertory'];

$itemGenerator = ItemGeneratorFactory::create($templateName);

$filePath = __DIR__ . "/../$templatesRepertory/$templateName.yaml";
$template = Yaml::parseFile($filePath);


$faked = $itemGenerator->create($template, $quantity);

echo '<pre>' . json_encode($faked) . '</pre>';
