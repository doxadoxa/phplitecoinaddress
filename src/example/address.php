<?php
require "../../vendor/autoload.php";

use doxadoxa\phplitecoinaddress\LitecoinAddressGenerator;

$address = LitecoinAddressGenerator::generate();

echo sprintf("address: %s\n", $address->address());
echo sprintf("private key: %s\n", $address->privateKey(true));
echo sprintf("json: %s\n", $address->toJson());