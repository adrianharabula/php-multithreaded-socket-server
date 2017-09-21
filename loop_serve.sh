#!/bin/bash

# Run with
# bash loop_serve.sh IP PORT socketserver.log >> respawn_loop.log &

# Or add the following line to crontab
# @reboot cd /path/to/socketserver && bash loop_serve.sh 0.0.0.0 13001 socketserver.log >> logs/respawn_loop.log &

until php server.php $1 $2 >> logs/socketserver_loop/$3; do
    SERVER_STATUS=$?
    echo "[`date`] Server crashed with exit code $SERVER_STATUS. Respawning.."
    sleep 1;
done
