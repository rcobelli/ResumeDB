<?php

// Support DEBUG cookie
if ($_COOKIE['debug'] == 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
} else {
    error_reporting(0);
}

require_once("vendor/autoload.php");
include_once("classes/Dao.php");
include_once("classes/CertificationDao.php");
include_once("classes/EducationDao.php");
include_once("classes/JobsDao.php");
include_once("classes/LinksDao.php");
include_once("classes/ResumeDao.php");
include_once("classes/ProfileHelper.php");

$ini = parse_ini_file("config.ini", true)["rdb"];

date_default_timezone_set('America/New_York');

try {
    $pdo = new PDO(
        'mysql:host=' . $ini['db_host'] . ';dbname=' . $ini['db_name'] . ';charset=utf8mb4',
        $ini['db_username'],
        $ini['db_password'],
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::ATTR_PERSISTENT => false
        )
    );
} catch (Exception $e) {
    exit($e);
}

$config = array(
    'dbo' => $pdo,
    'appName' => 'Resume DB'
);

// Setup SAML
$samlHelper = new Rybel\backbone\SamlAuthHelper($ini['saml_sp'], 
                            $ini['saml_idp'], 
                            file_get_contents("../certs/idp.cert"), 
                            file_get_contents('../certs/public.crt'), 
                            file_get_contents('../certs/private.pem'),
                            $_COOKIE['debug'] == 'true');
