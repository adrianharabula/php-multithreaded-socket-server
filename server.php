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
    printf( "[%s] Connected at port %d\n", $client->getAddress(), $client->getPort() );
    
    while( true ) {
        // read from the client
        $read = $client->read();

        if( $read === null ) {
            printf( "[%s] Disconnected\n", $client->getAddress() );
            return false;
        }

        // trim whitespaces from message
        $read = trim($read);

        printf( "[%s] received: %s\n", $client->getAddress(), $read );

        switch($read){
            case 'date':
                $client->send( '[' . date( DATE_RFC822 ) . '] ' . $read . "\r\n"  );
                break;
            case 'd':
                $client->send( '[' . date( DATE_RFC822 ) . '] ' . $read . "\r\n"  );
                break;
            case '':
                break 2;
            case 'exit':
                break 2;
            default:
                break 2;
        }
    }
    $client->close();
    printf( "[%s] Disconnected\n", $client->getAddress() );
    
}

require "sock/SocketServer.php";

$server = new \Sock\SocketServer(4444, '0.0.0.0');
$server->init();
$server->setConnectionHandler( 'onConnect' );
$server->listen();
