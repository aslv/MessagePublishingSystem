<?php
$heading = 'Система за публикуване на съобщенията';
//$dateFormat = 'd.m.Y';

$db_host = 'localhost';
$db_user = 'user';
$db_pass = 'pass';
$db = 'messages_users_storage';

function db_connect($db_host, $db_user, $db_pass, $db) // a sample of singletone
{
	static $connection = NULL;
	if ($connection)
	{
		return $connection;
	}
    $connection = mysqli_connect($db_host, $db_user, $db_pass, $db) or die(error_connection());
    mysqli_set_charset($connection, 'utf8') or die(error('Възникна грешка при настройването на базата данни!'));
    return $connection;
}
function error($msg) // rather offhand, but we must stop the script if there are invalid data due to prevention
{
	return '<div style="
    margin: 10px;
    padding: 3px;
    overflow: auto;
    border: 2px solid #F00;
    border-radius: 10px;
    text-align: center;
    color: #F00;
    background-color: #FFEAEA;
    ">' . $msg . '</div>
    <input type="button" value="Назад" onclick="history.back(-1)" />';
}
function error_connection()
{
    return error('Възникна грешка при свързването с базата данни!');
}
function error_query()
{
    return error('Възникна грешка при обработването на заявката!');
}
?>