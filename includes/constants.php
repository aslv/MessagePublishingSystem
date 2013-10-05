<?php
//define(D, DIRECTORY_SEPARATOR);
$heading = 'Система за публикуване на съобщенията';
$dateFormat = 'd.m.Y';

$db_host = 'localhost';
/*
$db_user_user = 'user';
$db_user_pass = 'pass';
$db_admin_user = 'admin';
$db_admin_pass = 'admin';
*/
$db_user = 'user';
$db_pass = 'pass';
$db = 'messages_users_storage';

function db_connect($db_host, $db_user, $db_pass, $db)
{
    $connection = mysqli_connect($db_host, $db_user, $db_pass, $db) or die(error_connection());
    mysqli_set_charset($connection, 'utf8') or die(error('Възникна грешка при настройването на базата данни!'));
    return $connection;
}
function error($msg)
{
    return '<div class="error">' . $msg . '</div>';
}
function error_connection()
{
    return error('Възникна грешка при свързването с базата данни!');
}
function error_query()
{
    return error('Възникна грешка при обработването на заявката!');
}
/*
$query=<<<Q
  insert into categories values
  (null, 'Singers', 1),
  (null, 'Bands', 1),
  (null, 'Companies', 1);
Q;
*/
?>