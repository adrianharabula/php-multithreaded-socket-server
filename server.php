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

        // $client->send ( "String sent successfully!\r\n" );
        printf( "[%s] [%s] received: %s\n", get_time(), $client->getAddress(), $read );
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

$server = new \Sock\SocketServer(4444, '0.0.0.0');
$server->init();
$server->setConnectionHandler( 'onConnect' );
$server->listen();
