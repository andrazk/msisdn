#!/bin/bash

rcpid=$RANDOM

data='{"jsonrpc":"2.0","method":"parse","params":["'$1'"],"id":"'$rcpid'"}'

curl --data-binary $data -H 'content-type: application/json;' http://192.168.33.10:8000/index.php
