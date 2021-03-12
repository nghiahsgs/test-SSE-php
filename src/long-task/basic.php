<?php
// Set necessary headers
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require __DIR__ . '/../vendor/autoload.php';

$progress = 0;
while ($progress < 100) {
    $progress += rand(10, 20);

    if ($progress > 100) {
        $progress = 100;
        break;
    }

    sendMessage($progress, 'long-task', time());

    sleep(rand(1, 5));
}

sendMessage($i * 10, 'long-task', 'ENDED');

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
