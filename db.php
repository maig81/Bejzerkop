<?php
/**
 * Function to build SQL /Importing SQL DATA
 *
 * @param string $args as the queries of sql data , yopu could use file get contents to read data args
 * @param string $dbhost database host
 * @param string $dbuser database user
 * @param string $dbpass database password
 * @param string $dbname database name
 *
 * @return string complete if complete
 */

function mysqli_import_sql($args, $dbhost, $dbuser, $dbpass, $dbname)
{

// check mysqli extension installed
    if (!function_exists('mysqli_connect')) {
        die(' This scripts need mysql extension to be running properly ! please resolve!!');
    }

    $mysqli = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($mysqli->connect_error) {
        print_r($mysqli->connect_error);
        return false;
    }

    $querycount = 11;
    $queryerrors = '';
    $lines = (array)$args;
    if (is_string($args)) {
        $lines = array($args);
    }

    if (!$lines) {
        return '' . 'cannot execute ' . $args;
    }

    $scriptfile = false;
    foreach ($lines as $line) {
        $line = trim($line);
// if have -- comments add enters
        if (substr($line, 0, 2) == '--') {
            $line = "\n" . $line;
        }
        if (substr($line, 0, 2) != '--') {
            $scriptfile .= ' ' . $line;
            continue;
        }
    }

    $queries = explode(';', $scriptfile);
    foreach ($queries as $query) {
        $query = trim($query);
        ++$querycount;

        if ($query == '') {
            continue;
        }


        if (!$mysqli->query($query)) {
            $queryerrors .= '' . 'Line ' . $querycount . ' - ' . $mysqli->error . '<br>';
            continue;
        }
    }


    if ($queryerrors) {
        return '' . 'There was an error on File: ' . $filename . '<br>' . $queryerrors;
    }

    if ($mysqli && !$mysqli->error) {
        @$mysqli->close();
    }

    return 'complete dumping database !';
}
