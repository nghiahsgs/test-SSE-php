function log(eventName, data) {
    $('#log').append('<li class="list-group-item"><b>' + eventName + '</b>: ' + data + '</li>');
}

function setConnectionStatus(connected) {
    if (connected) {
        $('#connection').removeClass('fa-frown-o text-danger');
        $('#connection').addClass('fa-smile-o text-success');
    } else {
        $('#connection').removeClass('fa-smile-o text-success');
        $('#connection').addClass('fa-frown-o text-danger');
    }
}

$('#clear-status').click(function () {
    $('#log').html('');
});

function onSSEOpen(e, sse) {
    // console.log('OPEN: ', e, sse);
    setConnectionStatus(true);
}

function onSSEError(e, sse) {
    // console.log('ERROR: ', e, sse);
    setConnectionStatus(false);
}

var serverInfoSSE = new EventSource('./src/server-info/libsse.php');
// var serverInfoEvent = 'server-info';
var serverInfoEvent = 'cpu';
serverInfoSSE.addEventListener(serverInfoEvent, function(e) {
    const data = e.data;
    console.log('server send',data);
    log("server send",data)

    // var dataId = e.lastEventId;
    // if (dataId == 'CLOSED') {
    //     // Ngăn client không kết nối lại server
    //     evtSource.close();
    // }
}, false);

serverInfoSSE.addEventListener('open', function(e) {
    console.log("OPEN");
    //chinh icon mat cuoi
    onSSEOpen(e, serverInfoSSE);
}, false);

serverInfoSSE.addEventListener('error', function(e) {
    console.log("ERROR");
    //chinh icon mat khoc
    onSSEError(e, serverInfoSSE);
}, false);

////////// Demo long running task
// $('#start-task').click(function () {
//     var longTaskSSE = new EventSource('./src/long-task/basic.php');
//     var longTaskEvent = 'long-task';
//     var progressEl = $('#long-task-progress');
//     progressEl.parent().removeClass('hide');

//     var button = $(this);
//     button.prop('disabled', true);

//     longTaskSSE.addEventListener(longTaskEvent, function(e) {
//         log(longTaskEvent, e.data);

//         var data = e.data;
//         progressEl.css('width', data + '%')
//             .attr('aria-valuenow', data)
//             .html(data + '%');

//         if (e.lastEventId == 'ENDED') {
//             longTaskSSE.close();
//             progressEl.parent().addClass('hide');
//             button.prop('disabled', false);
//         }
//     }, false);

//     longTaskSSE.addEventListener('open', function(e) {
//         onSSEOpen(e, longTaskSSE);
//     }, false);

//     longTaskSSE.addEventListener('error', function(e) {
//         onSSEError(e, longTaskSSE);
//     }, false);
// });

// $('#start-task').trigger('click');