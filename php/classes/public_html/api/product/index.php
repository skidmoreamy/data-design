<?php

require_once dirname(_DIR_3) ."/vendor/autoload.php";
require_once dirname(_DIR_3) ."/php/classes/.php";
require_once dirname(_DIR_3) ."/php/lib/xsrf.php";

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DataDesign\{
Profile,

	//api shop
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

$shopId - filter_input(INPUT_GET, "
shopName = FILTER_VALIDATE_INT");
$shopContent = filter_input (INPUT_GET, "shopContent", FILTER_VALIDATE_INT);

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
					$shop = shop::getshopByshopId($pdo, $id);
					if($shop !== null) {
							$reply->data = $shop;
						}
 		} else if(empty($shopName) === false) {
					$shop = shop::getshopByshopName($pdo, $shopName)->toArray();
					if($shop !== null) {
							$reply->data = $tweet;
						}
 		} else if(empty($shopContent) === false) {
					$shops = shop::getshopByshopContent($pdo, $shopContent)->toArray();
					if($shops !== null) {
							$reply->data = $shops;
						}
 		} else {
					$shops = shop::getAllshops($pdo)->toArray();
					if($shops !== null) {
							$reply->data = $shops;
						}
 		}
 	} else if($method === "PUT" || $method === "POST") {

			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
			$requestObject = json_decode($requestContent);
			// This Line Then decodes the JSON package and stores that result in $requestObject

			//make sure shop content is available (required field)
			if(empty($requestObject->shopContent) === true) {
					throw(new \InvalidArgumentException ("No content for shop.", 405));
 		}

 		//  make sure shopename is available
 		if(empty($requestObject->shopName) === true) {
					throw(new \InvalidArgumentException ("No Shop Name.", 405));
 		}


		//perform the actual put or post
				if($method === "PUT") {

							//enforce that the end user has a XSRF token.
							verifyXsrf();


							// retrieve the shop to update
							$shop = shop::getshopByshopId($pdo, $id);
							if($shop === null) {
									throw(new RuntimeException("shop does not exist", 404));
 			}

 			//enforce the user is signed in and only trying to edit their own tweet
 			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $shop->getshopByshopName()) {
					+				throw(new \InvalidArgumentException("You are not allowed to edit this shop", 403));
 			}

 			// update all attributes
 			$shop->setshopContent($requestObject->shopContent);
 			$shop->update($pdo);


	 // update reply
 			$reply->message = "shop updated OK";

 		} else if($method === "POST") {

							//enforce that the end user has a XSRF token.
							verifyXsrf();

							// enforce the user is signed in
							if(empty($_SESSION["profile"]) === true) {
									throw(new \InvalidArgumentException("you must be logged in to post shop content", 403));
 			}

 			// create new shop and insert into the database
 			$shop = new shop(null, $requestObject->shopName, $requestObject->shopContent, null);
 			$shop->insert($pdo);

 			// update reply
 			$reply->message = "shop created OK";
 		}

 	} else if($method === "DELETE") {

					//enforce that the end user has a XSRF token.
					verifyXsrf();

					// retrieve the shop to be deleted
					$shop = shop::getshopByshopId($pdo, $id);
					if($shop === null) {
							throw(new RuntimeException("Shop does not exist", 404));
 		}

 		//enforce the user is signed in and only trying to edit their own shop
 		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $shop->getshopName()) {
							throw(new \InvalidArgumentException("You are not allowed to delete this shop", 403));
 		}

 		// deletes shop
 		$shop->delete($pdo);
 		// update reply
 		$reply->message = "shop deleted OK";
 	} else {
					throw (new InvalidArgumentException("Invalid HTTP method request"));
 	}
		// update the $reply->status $reply->message
		} catch(\Exception | \TypeError $exception) {
			$reply->status = $exception->getCode();
			$reply->message = $exception->getMessage();
	}

  header("Content-type: application/json");
  if($reply->data === null) {
	  unset($reply->data);
	  unset($reply->data);
  }
  //encode and push to end user
echo json_encode($reply);


<?php

require_once dirname(_DIR_3) ."/vendor/autoload.php";
require_once dirname(_DIR_3) ."/php/classes/.php";
require_once dirname(_DIR_3) ."/php/lib/xsrf.php";

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DataDesign\{
	Profile
};
/**
 * API for profile
 *
 */
//verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-msql/ddcaskidmore1.ini");
	//add test here
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$id = filter_input(INPUT_GET, "id",FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a post by content
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null) {
				$reply->data = $profile;
			}

		} else if(empty($profileEmail) === false) {
			var_dump($profileEmail);
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null) {
				$reply->data = $profile;
			}
		}
	} elseif($method === "PUT") {
		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}
		if(empty($requestObject->newPassword) === true) {
			//enforce that the XSRF token is present in the header
			verifyXsrf();
			//profile email is a required field
			if(empty($requestObject->profileEmail) === true) {
				throw(new \InvalidArgumentException ("No profile email present", 405));
			}
		/**
		 * update the password if requested
		 **/
		//enforce that current password new password and confirm password is present
		if(empty($requestObject->ProfilePassword) === false && empty($requestObject->newPassword) === false && empty($requestContent->ConfirmPassword) === false) {
			//make sure the new password and confirm password exist
			if($requestObject->newProfilePassword !== $requestObject->profileConfirmPassword) {
				throw(new RuntimeException("New passwords do not match", 401));
			}
			//hash the previous password
			$currentPasswordHash = hash_pbkdf2("sha512", $requestObject->currentProfilePassword, $profile->getProfileSalt(), 262144);
			//make sure the hash given by the end user matches what is in the database
			if($currentPasswordHash !== $profile->getProfileHash()) {
				throw(new \RuntimeException("Old password is incorrect", 401));
			}
			// salt and hash the new password and update the profile object
			$newPasswordSalt = bin2hex(random_bytes(16));
			$newPasswordHash = hash_pbkdf2("sha512", $requestObject->newProfilePassword, $newPasswordSalt, 262144);
			$profile->setProfileHash($newPasswordHash);
			$profile->setProfileSalt($newPasswordSalt);
		}
		//preform the actual update to the database and update the message
		$profile->update($pdo);
		$reply->message = "profile password successfully updated";
	} elseif($method === "DELETE") {
		//verify the XSRF Token
		verifyXsrf();
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw (new RuntimeException("Profile does not exist"));
		}
		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}
		//delete the post from the database
		$profile->delete($pdo);
		$reply->message = "Profile Deleted";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP request", 400));
	}

	// catch any exceptions that were thrown and update the status and message state variable fields//

	catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);

<?php

		require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

};
/**
 * Api for the favorite class
 *

 */
//verify the session, start if not active


if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-msql/ddcaskidmore1.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize the search parameters
	$likeProfileId = filter_input(INPUT_GET, "LikeProfileId", FILTER_VALIDATE_INT);
	$likeTweetId = filter_input(INPUT_GET, "likeTweetId", FILTER_VALIDATE_INT);
	if($method === "Get") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a
		if(empty($likeProfileId) === false) {
			$like = Like::getLikeByLikeProfileId($pdo, $likeProfileId)->toArray();
			if($like !== null) {
				$reply->data = $like;
			}
		} else if(empty($likeTweetId) === false) {
			$like = Like::getLikeByLikeTweetId($pdo, $likeTweetId)->toArray();
			if($like !== null) {
				$reply->data = $like;
			}
		} else {
			$like = Like::getLikeByLikeTweetIdAndLikeProfileId($pdo, $likeProfileId, $likeTweetId);
			if($like !== null) {
				$reply->data = $like;
			} else {
				throw (new InvalidArgumentException("Search failed"));
			}
		}
	} elseif($method === "POST" || $method === "DELETE") {
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if($method === "POST") {
			if(empty($requestObject->likeProfileId) === true) {
				throw (new \InvalidArgumentException("No Profile linked to the Like", 405));
			}
			if(empty($requestObject->likeTweetId) === true) {
				throw (new \InvalidArgumentException("No tweet linked to the Like", 405));
			}
			if(empty($requestObject->likeDate) === true) {
				$requestObject->LikeDate = null;
			}
			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in too like posts", 403));
			}
			$like = new Like($requestObject->likeProfileId, $requestObject->likeTweetId, $requestObject->likeDate);
			$like->insert($pdo);
			$reply->message = "liked tweet successful";
		} else if($method === "DELETE") {
			//enforce that the end user has a XSRF token.
			verifyXsrf();
			//make sure that both the tweetId and profileId are present
			if(empty($requestObject->likeProfileId && $requestObject->likeTweetDate) === true) {
				throw (new \InvalidArgumentException("No Profile linked to the Like", 405));
			}
			//grab the like by its composite key
			$like = Like::getLikeByLikeTweetIdAndLikeProfileId($pdo, $likeProfileId, $likeTweetId);
			if($like === null) {
				throw (new RuntimeException("Like does not exist"));
			}
			//enforce the user is signed in and only trying to edit their own like
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $requestObject->LikeProfileId) {
				throw(new \InvalidArgumentException("You are not allowed to delete this tweet", 403));
			}
			//preform the actual delete
			$like->delete($pdo);
			//update the message
			//$reply->message = "Like successfully deleted";
			var_dump($reply->message);
		}
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
	//catch any exception that is thrown and update the status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);