<?php

if ($_SERVER["HTTP_HOST"] == "localhost" or $_SERVER["HTTP_HOST"] == "127.0.0.1" or
    $_SERVER["HTTP_HOST"] == "res.test") {
    return array(
        "db_name" => "mydb",
        "db_user" => "root",
        "db_password" => "",
        "db_host" => "localhost",
    );
} else {
    return array(
        "db_name" => "moodle",
        "db_user" => "inpadmin55",
        "db_password" => "AAAdHHbLYXecunW9",
        "db_host" => "localhost",
    );
}