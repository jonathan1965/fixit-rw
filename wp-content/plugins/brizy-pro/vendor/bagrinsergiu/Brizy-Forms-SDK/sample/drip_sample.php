
<?php

$composerAutoload = dirname(__DIR__) . '/vendor/autoload.php';
if (!file_exists($composerAutoload)) {
    echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
    exit(1);
}

require $composerAutoload;

//create $dripService service

$fields   = '[{"sourceId":"1", "sourceTitle":"Email", "target":"email"}, {"sourceId":"2", "sourceTitle":"My Name", "target":"_auto_generate"}]';
$fieldMap = new \BrizyForms\FieldMap(json_decode($fields, true));

$data = '[{"name":"2","value":"Anthony","required":false,"type":"text","slug":"name"},{"name":"1","value":"bodnar1212@gmail.com","required":false,"type":"email","slug":"email"}]';
$data = json_decode($data, true);

$dataArray = [];
foreach ($data as $row) {
    $data = new \BrizyForms\Model\Data();
    $data
        ->setName($row['name'])
        ->setValue($row['value']);
    $dataArray[] = $data;
}

$dripService = \BrizyForms\ServiceFactory::getInstance(\BrizyForms\ServiceFactory::DRIP);

$dripService->setAuthenticationData(new \BrizyForms\Model\AuthenticationData([
    'api_key' => '8ffd084187daa1ce8b3af5ef16e5121c',
    'account_id' => '8622359'
]));

var_dump($dripService->authenticate());

var_dump($dripService->getAccount());

//var_dump($dripService->getFields());
//
//$dripService->createMember($fieldMap, null, $dataArray);