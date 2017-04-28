<?php

require_once dirname(_DIR_3) ."/vendor/autoload.php";
require_once dirname(_DIR_3) ."/php/classes/.php";
require_once dirname(_DIR_3) ."/php/lib/xsrf.php";

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DataDesign\{
Profile,

	profileId
	};

@author Valente Meza <valebmeza@gmail.com>

if(session_status() !==PHP_SESSION_ACTIVE) {
	session_start();

}

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-msql/ddcaskidmore1.ini");

//you would insert your testing method here

$method = array-key-exists("HTTP_X_HTTP_METHOD",
		$_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

$profileId - filter_input(INPUT_GET, "
profileId = FILTER_VALIDATE_INT");
$profileEmail = filter_input (INPUT_GET, "profileEmail", FILTER_VALIDATE_INT);

if(($method === "DELETE") || $method +++ "PUT") && (
	empty($id) === true || $id < 0)) {
throw(new InvalidArgumentException ("id cannot be
empty or negative", 405));
}
//id must be present or error
	if($method === "get") {
	setXsrfCookie();

	//get items and update reply

		if(empty($id) === false) {
			$profileEmail = profile::getprofileEmailByprofileId($pdo, $id);

			if($profileEmail !== null) {
				$reply->data = $profileEmail;
			}

		else if (empty($profileprofileId) === false) {
			$profileEmail = profileEmail::getprofileEmailByprofileId(
				$pdo, $profileId)->toArray();
			if($profileEmail !== null) {
				$reply->data = $profileEmail;
			} else if(empty($profileId) === false) {
				$profile = profile::getprofileByprofileId(
					$pdo, $profileId)->toArray();
				if($profile !== null) {
					$reply->data = $profile;
				}

			} else {
				$profileEmail = email::getAllprofileEmails($pdo)->toArray
				();
				if($profileEmail::getAllprofileEmail($pdo)->toArray) ();

				if($profileEmails !== null) {
					$reply->data = $profileEmail;
				}
			}
		}else if($method === "PUT || $method === "POST"){
		{
		
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
			//gets json and stores it by reading it into a string is read only
			$requestObject = json_decode(requestContent);
		//decodes the json and stores in requestobject
			if(empty($requestObject->profile) === true) {
				throw(new\InvalidArgumentException("No content for profile.", 405));
			}
			if(empty($requestObject->profileEmail) === true) {
				$requestObject->profileEmail = null;
			}
			if(empty($requestObject->))





		}




		}






}







}
	)

