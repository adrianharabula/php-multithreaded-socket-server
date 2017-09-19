#!/bin/bash

# Run with
# bash loop_serve.sh IP PORT logfilename.txt

# Or add the following line to crontab
# @reboot cd ~/web/commmanager/modules/cop_module/socket-server && bash loop_serve.sh 0.0.0.0 13001 socketserverlog.txt >> loop_errors.txt &

until php server.php $1 $2 >> $3; do
    SERVER_STATUS=$?
    echo "[`date`] Server crashed with exit code $SERVER_STATUS. Respawning.."
    sleep 1;
done
