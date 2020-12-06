<?php
$url = parse_url(getenv("mysql://b1140bd4539d94:dd30aefb@eu-cdbr-west-03.cleardb.net/heroku_10c337ec6ca316c?reconnect=true"));

    CONST       _DB_HOST_      = $url["host"],
                _DB_NAME_      = $url["user"],
                _DB_USER_      = $url["pass"],
                _DB_PASSWORD_  = substr($url["path"], 1);
