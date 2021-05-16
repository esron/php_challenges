<?php

require_once('./Xml2Assoc.php');

$xmlFileName = $argv[1];

echo "Parsing $xmlFileName\n";

$xml2Assoc = new Xml2Assoc();

$array = $xml2Assoc->parseFile($xmlFileName, true);

var_dump($array);

$csvFileName = explode('.', $xmlFileName)[0] . '.csv';

$csvFileHandle = fopen($csvFileName, 'w');

echo "Saving to $csvFileName\n";
