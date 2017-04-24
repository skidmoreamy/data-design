<?php
namespace Edu/Cnm/data-design;
require_once("autoload.php");ValidateDate;
/**
//* Small Cross Section of a Favorited Etsy Shop
 *
 * This action in Etsy is a small portion of exactly what the site offers aside from ecommerce.
 * Favorited using Etsy. This can esily be extened to emulate more features of Etsy.
 *
 * above in 3 is how to autoload and validdate
 *
 * @author amy Skidmore <askidmore1@cnm.edu>
 * @version 1.0
 **/
class Profile implements \JsonSerializable{
	use ValidateDate;
/**
 * id for this Profile;  this is the primary key
 * @var int $profileId
 **/
	private $profileId;
	/**
	* id of the Profile or the foreign key would be inserted here. You have no foreign key on profile.
	* @ var int $...profileId you have no method here
	**/
 /** private $...ProfileId; same insert as above
 	* : ... is your name if you had this foreign key

  * would be the actual textual content of the above item or short description
	* @var string $...Content;
**/
 /**
  * private $...Content; this would be an actual statment, just replace ...
  * date and time associated with above method, in a PHP DATETIME object
  * @var \DateTime $...Date just insert method in ...
 */
 /**
  * private$...Date; just
  * insert method in above...
  **/
	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setProfileHash(string $newProfileHash): void {
		//enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash empty or insecure"));
		}

		//enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		//enforce that the hash is exactly 128 characters.
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("profile hash must be 128 characters"));
		}

		//how to store hash
		$this->profileHash = $newProfileHash;
		$salt = bin2hex(random_bytes(16));
		$hash = hash_pbkdf2("sha512",$password, $salt,262144);
	}
/**
 * accessor metho for profile id
 */
public function getprofileId() :?int{return($this->profileId);}
 /**
  * mutator method for profileid
  * @param int/null $newprofileId is not positive
  * @throws \RangeException if $newprofileId is not positive
  * @throws \ TypeError if $newprofileId is not an integer
  */
	/**
	 * @param int $profileId
	 */
	public function setProfileId(int $profileId) {
		$this->profileId = $profileId;
	}
	
}