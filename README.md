Multi Threaded Socket Server based on pcntl_fork()
====================
Forked from: https://github.com/lukaszkujawa/php-multithreaded-socket-server  
Code explanation on http://systemsarchitect.net/multi-threaded-socket-server-in-php-with-fork/

Installation
---------------------
> git clone git@github.com:adrianharabula/php-multithreaded-socket-server.git

Run the server
---------------------
```bash
php server.php 0.0.0.0 4444
```

Or, with docker:  
```bash
docker build -t php-socket-multi .
docker run -it --rm -p 4444:4444 --name php-socket-server-multi php-socket-multi
```

Connect to the created server
---------------------
> telnet localhost 4444
