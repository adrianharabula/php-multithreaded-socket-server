<?php

namespace Sock;

class SocketClient {

    private $connection;
    private $address;
    private $port;

    public function __construct( $connection ) {
        $address = ''; 
        $port = '';
        socket_getsockname($connection, $address, $port);
        $this->address = $address;
        $this->port = $port;
        $this->connection = $connection;
    }
    
    public function send( $message ) {	
        socket_write($this->connection, $message, strlen($message));
    }
    
    public function read($len = 1024) {
        /**
         * Timeout functions if needed
         */
        //socket_set_option($this->connection, SOL_SOCKET, SO_RCVTIMEO, array('sec'=> 60, 'usec'=>0));
        //socket_set_option($this->connection, SOL_SOCKET, SO_SNDTIMEO, array('sec'=> 60, 'usec'=>0));
        if ( ( $buf = @socket_read( $this->connection, $len, PHP_BINARY_READ  ) ) === false ) {
                return null;
        }
        
        return $buf;
    }

    public function getAddress() {
        return $this->address;
    }
    
    public function getPort() {
        return $this->port;
    }
    
    public function close() {
        socket_shutdown( $this->connection );
        socket_close( $this->connection );
    }
}
