<?php

try
{
    include_once("connection.inc.php");
    include_once("mysql_database.inc.php");

    $db = DBFactory::CreateDatabaseObject("MySqlDatabase");
    $db->Connect($server, $database, $username, $password);

    $db->Begin();
    $db->Execute("
        INSERT INTO person(
            last_name,
            first_name,
            street_address,
            city,
            country,
            zip)
        VALUES(
            'Documento',
            'Mark Jundo',
            'Visita St. Brgy. Sta. Cruz',
            'Makati City',
            'Philippines',
            '1205')");
    $id = $db->GetLastInsertID();
    $db->Commit();
    $dt = $db->Execute("SELECT * FROM person WHERE id = $id");
    $dt->MoveNext();
    echo "Inserted<br>
         $dt->last_name, $dt->first_name<br>
         $dt->street_address, $dt->city, $dt->country $dt->zip";
}
catch (Exception $ex)
{
    $db->Rollback();
    echo "Exception Caught: " . $ex->getMessage() .
         "<p>Trace: " . $ex->getTraceAsString() . "</p>";
}

?>