<?php
require('index.php');

class Film extends Entity{
    function __construct() {
    // mettre un construct
        $title = ["varchar", 255];

        $producer = ["varchar", 255];

        $columns = [$title,$producer];
    }
}