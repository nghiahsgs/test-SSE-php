<?php
// Set necessary headers
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require __DIR__ . '/../vendor/autoload.php';

$linfo = new \Linfo\Linfo;
$parser = $linfo->getParser();

// Using while to keep server connection open, so we have only one request.
// If connection is closed browser will reconnect and will send last event Id.
while (true) {
    $parser->determineCPUPercentage();
    $ram = $parser->getRam();

    $data = json_encode([
        'cpu' => $parser->getCPUUsage(),
        'ram' => round(($ram['total'] - $ram['free']) / $ram['total'] * 100, 2),
    ]);
    sendMessage($data, 'server-info', time());

    sleep(1);
}

function sendMessage($value, $event = null, $id = null)
{
    if ($id) {
        echo "id: $id\n";
    }

    if ($event) {
        echo "event: $event\n";
    }

    echo "data: $value\n\n";

    ob_flush();
    flush();
}
