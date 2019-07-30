<?php

namespace Bejzerkop;

use Postmark\PostmarkClient;
use Postmark\Models\PostmarkAttachment;

class Bejzerkop
{
    public $serverList;
    public $emailList;
    private $dumpFile = 'export.sql.gz';
    private $fromEmail = 'database@degordian.com';

    public function __construct()
    {
        $this->serverList = parse_ini_file('./servers.ini', true);
        $this->emailList = parse_ini_file('./emails.ini');
    }

    /**
     * @param $serverName
     * @return array
     */
    public function databaseList($serverName)
    {
        $databaseList = [];
        if ($dbConn = $this->serverConnect($serverName)) {
            $databases = $dbConn->query('SHOW DATABASES');
            while ($row = mysqli_fetch_row($databases)) {
                if (($row[0]!="information_schema") && ($row[0]!="mysql")) {
                    $databaseList[] = $row[0];
                }
            }
        }
        return $databaseList;
    }

    /**
     * @param $serverName
     * @return bool|mysqli
     */
    private function serverConnect($serverName, $database = null)
    {
        $host = $this->serverList[$serverName]['DB_HOST'];
        $port = $this->serverList[$serverName]['DB_PORT'];
        $username = $this->serverList[$serverName]['DB_USERNAME'];
        $password = $this->serverList[$serverName]['DB_PASSWORD'];

        // Create connection
        $conn = new \mysqli($host, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            return false;
        }
        return $conn;
    }

    /**
     * @param $sourceServer
     * @param $sourceDatabase
     * @param $destinationServer
     * @param $destinationDatabase
     * @param $siteUrl
     * @throws Exception
     * @return true
     */
    public function databaseCopy($sourceServer, $sourceDatabase, $destinationServer, $destinationDatabase, $siteUrl)
    {
        unlink($this->dumpFile);
        $this->dumpDatabase($sourceServer, $sourceDatabase);
        $this->importDatabase($destinationServer, $destinationDatabase);
        if ($siteUrl) {
            $this->changeSiteURL($destinationServer, $destinationDatabase, $siteUrl);
        }

        unlink($this->dumpFile);

        return true;
    }


    /**
     * @param $serverName
     * @param $databaseName
     * @param $siteUrl
     */
    public function changeSiteURL($serverName, $databaseName, $siteUrl)
    {
        $database = $this->serverConnect($serverName, $databaseName);
        $database->query('UPDATE wp_options 
                                SET option_value = "' . $siteUrl . '" 
                                WHERE option_name = "siteurl"
                                OR option_name = "home" ');
        $database->close();
    }

    /**
     * @param $serverName
     * @param $databaseName
     * @return bool
     * @throws Exception
     */
    public function dumpDatabase($serverName, $databaseName)
    {
        $database = $this->serverConnect($serverName, $databaseName);
        $dump = new MySQLDump($database);
        $dump->save($this->dumpFile);
        $database->close();
        return true;
    }

    /**
     * @param $serverName
     * @param $databaseName
     * @return bool
     * @throws Exception
     */
    public function importDatabase($serverName, $databaseName)
    {
        $database = $this->serverConnect($serverName, $databaseName);
        // Drop tables
        $this->dropAllTables($database);
        // Import dump to database
        $dbImport = new MySQLImport($database);
        $dbImport->load($this->dumpFile);
        // Close database
        $database->close();
        return true;
    }

    /**
     * @param $database
     */
    public function dropAllTables($database)
    {
        $database->query('SET foreign_key_checks = 0');
        if ($result = $database->query("SHOW TABLES")) {
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $database->query('DROP TABLE IF EXISTS '.$row[0]);
            }
        }
        $database->query('SET foreign_key_checks = 1');
    }

    /**
     * @param $serverName
     * @param $databaseName
     * @param $emailAddress
     * @return mixed
     * @throws Exception
     */
    public function sendDatabaseToEmail($serverName, $databaseName, $emailAddress)
    {
        $client = new PostmarkClient("f8393b4f-2e0b-48f1-9d83-a9f282997188");

        $attachment = PostmarkAttachment::fromFile($this->dumpFile,
            $this->dumpFile, 'application/zip', null);

        //$attachment = PostmarkAttachment::fromRawData("attachment content", "hello.txt", "text/plain");

        // Send an email:
        $sendResult = $client->sendEmail(
            "notification@mediatoolkit.com",
            $emailAddress,
            "BAZA $databaseName",
            "You are the lucky winner of a Database Dump file :)",
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            [$attachment]
        );
        return $sendResult;
    }
}
