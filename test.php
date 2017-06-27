#!/usr/local/bin/php -d display_errors=STDOUT
<?php

date_default_timezone_set('America/Los_Angeles');
$params = array();
if (isset($_GET['year']) && isset($_GET['month'])) {
    $params = array(
        'year' => $_GET['year'],
        'month' => $_GET['month'],
    );
}
$params['url']  = 'demo.php';
require_once 'calendar.php';
?>
 
<html>
    <head>
        <title>Invitation Calendar</title>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <link rel="stylesheet" href="calendar.css">
    </head>
    <body>
        <h1>Invitation</h1>

        <div class="container">
            <div>
                <?php
                    $cal = new Calendar($params);
                    $cal->display();
                    /*
                    $cal->showChangeDate();
                    $cal->showWeeks();
                    $cal->showDays($cal->year,$cal->month);
                    */
                ?> 
            </div>   
        </div>
    </body>
</html>