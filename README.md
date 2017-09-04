Muilti Threaded Socket Server based on pcntl_fork()
====================
Examaple created for http://systemsarchitect.net/multi-threaded-socket-server-in-php-with-fork/


Requirements
---------------------
> Docker

Installation
---------------------
> git clone git@github.com:adrianharabula/php-multithreaded-socket-server.git

Build Docker image
---------------------
> docker build -t php-socket-multi .

Run
---------------------
> docker run -it --rm -p 4444:4444 --name php-socket-server-multi php-socket-multi


Connect to the created server
---------------------
> telnet localhost 4444

