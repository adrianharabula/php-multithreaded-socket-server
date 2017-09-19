#!/bin/bash

until php server.php $1 $2 >> $3; do
    SERVER_STATUS=$?
    echo "[`date`] Server crashed with exit code $SERVER_STATUS. Respawning.."
    sleep 1;
done
