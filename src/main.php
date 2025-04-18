<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
use App\Service\FakeData\ArrayGeneratorFactory;

$CONF_INIT_FILE = __DIR__.'/../conf/json_template.yaml';

$conf = Yaml::parseFile($CONF_INIT_FILE);
$fileName = $conf['template']['name'];
$quantity = $conf['template']['quantity'];
$templatesRepertory = $conf['init']['repertory'];

$arrayGenerator = ArrayGeneratorFactory::create();

$filePath = __DIR__."/../$templatesRepertory/$fileName.yaml";
$template = Yaml::parseFile($filePath);


$faked = $arrayGenerator->createFromTemplate($template, $quantity);

echo '<pre>'.json_encode($faked).'</pre>';
