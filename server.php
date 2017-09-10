<?php

/**
 * Check dependencies
 */
if( ! extension_loaded('sockets' ) ) {
    echo "This example requires sockets extension (http://www.php.net/manual/en/sockets.installation.php)\n";
    exit(-1);
}

if( ! extension_loaded('pcntl' ) ) {
    echo "This example requires PCNTL extension (http://www.php.net/manual/en/pcntl.installation.php)\n";
    exit(-1);
}

/**
 * Format time for logging messages
 *
 * @return void
 */
function get_time()
{
    return date(DATE_RFC2822);
}

/**
 * Connection handler
 */
function onConnect( $client ) {
    $pid = pcntl_fork();
    
    if ($pid == -1) {
         die('could not fork');
    } else if ($pid) {
        // parent process
        return;
    }
    
    $read = '';
    printf( "[%s] [%s] Connected at port %d\n", get_time(), $client->getAddress(), $client->getPort() );
    
    while( true ) {
        // read from the client
        $read = $client->read();

        if( $read === null ) {
            printf( "[%s] [%s] Disconnected\n", get_time(), $client->getAddress() );
            return false;
        }

        // trim whitespaces from message
        $read = trim($read);

        printf( "[%s] [%s] received: %s\n", get_time(), $client->getAddress(), $read );
        // $client->send ( "String sent successfully!\r\n" );
        break;

        // switch($read){
        //     case 'date':
        //         $client->send( '[' . date( DATE_RFC822 ) . '] ' . $read . "\r\n"  );
        //         break;
        //     case 'd':
        //         $client->send( '[' . date( DATE_RFC822 ) . '] ' . $read . "\r\n"  );
        //         break;
        //     case 'test':
        //         $client->send ( "OK\r\n" );
        //         break 2;
        //     case '':
        //         break 2;
        //     case 'exit':
        //         break 2;
        //     default:
        //         break 2;
        // }
    }
    $client->close();
    printf( "[%s] [%s] Disconnected\n", get_time(), $client->getAddress() );

    // exit child process
    exit;
}

require "sock/SocketServer.php";

// if no arguments passed to script
if ($argc < 1)
{
    // bind the new server to default ip 0.0.0.0 and port 4444
    $server = new \Sock\SocketServer();
}
// exec script with `php server.php 0.0.0.0 4444`
else if ($argc == 3)
{
    // bind the new server to the specified ip and port
    $server = new \Sock\SocketServer($argv[1], $argv[2]);
}
else
{
    exit("invalid number of arguments passed\n");
}

$server->init();
$server->setConnectionHandler( 'onConnect' );
$server->listen();
