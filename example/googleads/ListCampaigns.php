<?php

namespace Example;

use AtelliTech\AdHub\GoogleAds\GoogleAdsServiceBuilder;
use Dotenv\Dotenv;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
	'clientId' => $_ENV['CLIENT_ID'],
	'clientSecret' => $_ENV['CLIENT_SECRET'],
	'developToken' => $_ENV['DEVELOP_TOKEN'],
	'apiVersion' => $_ENV['API_VERSION'],
	'customerId' => $_ENV['CUSTOMER_ID'],
	'refreshToken' => $_ENV['REFRESH_TOKEN'],
];

$googleAdsServiceBuilder = new GoogleAdsServiceBuilder($config['clientId'], $config['clientSecret'], $config['developToken'], $config['apiVersion']);
$service = $googleAdsServiceBuilder->create([
		'customerId' => $config['customerId'],
		'refreshToken' => $config['refreshToken']
	]);

$customerClientId = $_ENV['CUSTOMER_CLIENT_ID'];
$customerClient = $service->getCustomerClient($customerClientId);
if ($customerClient === false) {
    echo "\nGet Customer Client $customerClientId, Error";
} else {
    echo sprintf("\nCustomer Client: %s, ID: %s", $customerClient->getDescriptiveName(), $customerClient->getId());
}

$rows = $service->listCampaigns($customerClientId);
if ($rows === false) {
    echo "\nList Campaigns, Error";
} else {
    echo "\nList Campaigns:";
    foreach ($rows as $r) {
        echo sprintf("\nCampaign: %s, ID: %s", $r->getCampaign()->getName(), $r->getCampaign()->getId());
    }
}