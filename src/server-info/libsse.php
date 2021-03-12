<?php
// require __DIR__ . '/../vendor/autoload.php';

// use Sse\Events\TimedEvent;
// use Sse\SSE;
// use Linfo\Linfo;

// class SysEvent extends TimedEvent
// {
//     /**
//      * the interval in seconds to get new data
//      */
//     public $period = 2;

//     private $linfo;

//     public function __construct()
//     {
//         $this->linfo = new Linfo;
//     }

//     /**
//      * Get updated data
//      */
//     public function update()
//     {
//         $parser = $this->linfo->getParser();
//         $parser->determineCPUPercentage();

//         $ram = $parser->getRam();

//         return json_encode([
//             'cpu' => $parser->getCPUUsage(),
//             'ram' => round(($ram['total'] - $ram['free']) / $ram['total'] * 100, 2),
//         ]);
//     }
// }

// $sse = new SSE();
// // Close connection after 30s
// $sse->exec_limit = 30;
// $sse->addEventListener('server-info', new SysEvent());
// $sse->start();




//C2 Set necessary headers
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// require __DIR__ . '/vendor/autoload.php';

// $linfo = new \Linfo\Linfo;
// $parser = $linfo->getParser();

// Using while to keep server connection open, so we have only one request.
// If connection is closed browser will reconnect and will send last event Id.
$dem = 0;
while (true) {
    // $parser->determineCPUPercentage();
    // print_r($parser->determineCPUPercentage());
    $dem++;
    $data = "nghia $dem";
    $data = date('r');
    // print_r($data);
    // sendMessage($parser->getCPUUsage(), 'cpu', time());
    sendMessage($data,'cpu',time());

    sleep(3);
    
}

function sendMessage($value, $event = null, $id = null, $retry = null)
{
    if ($retry) {
        echo "retry: $retry\n";
    }

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

