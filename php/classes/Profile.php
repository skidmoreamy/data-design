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
 * accessor method for profile id
 */
public function getprofileId() :?int{return
	($this->profileId);}
 /**
  * mutator method for profileid
  * @param int/null $newprofileId is not positive
  * @throws \RangeException if $newprofileId is not positive
  * @throws \ TypeError if $newprofileId is not an integer
  */
	/**
	 * @param int $profileId
	 **/
	public function setProfileId(int $newprofileId) :
	void{
	if($newprofileId === null) {
		$this->profileId = null;
		return;
	}
	if ($newprofileId <= 0) {
		throw(new \RangeException("profile id is not prositive"));
	}
	$this->profileId = $newprofileId;
	}
	public function getprofileId () : int{
		return($this->profileId));
	}
	public function setprofileId(int$newprofileId) : void {
		if ($newprofileId <= 0){
			throw(new \RangeException("profile id is not positive"));
		}
		$this->profileId = $newprofileId;
	}
	public static function getprofilebyprofileId(\PDO $pdo, int $profileId): \SPLFixedArray {
		if($profileIdId <= 0) {
			throw(new \RangeException("profile id must be positive"));
		}
		$query = "SELECT profileId, shopProfileId, favorite FROM profile WHERE"

	/** inserts this into mySQL
	 */
	 public function insert(\PDO $pdo): void {
			//enforce the profileId is null (i.e., don't insert a profile that already exists)
			if($this->profileId !== null) {
				throw(new\PDOException ("not a new profile"));
			}
		}
			/**
			 * create query template
			 */
			/

			$query = "INSERT INTO profileId(profileActivationToken, profileEmail) VALUES (:profileActivationToken, :profileEmail)";
			$statement = $pdo->prepare($query);
		}

	// bind the member variable to the place holders in the template
		/**  deletes this profile from mySQL.
		 */
	public function delete(PDO $pdo) : void{
		// enforce the profileId is not null
			if($this->profileId === null){
			throw(new \PDOException ("unable to delete a profile that does not exist"));
			}
			//create query template
			$query = "DELETE FROM profile WHERE profileId = :profileId";
			$sttement = $pdo->prepare($query);
			// bind the member variables to the place holder in the template
			$parameters + ["profileId" => $this->profileId];
			$sttement->execute($parameters);
		}


		//updates this into mySQL
		public function update(\PDO $pdo) : void {
	//enforce the profileId is not null (i.e., don't update a profile that hasn't been inserted)
			if (this->profileId === null{
				throw(new \PDOExcetpion("unable to update a profile that does not exist"));
			}
			//create a query table
			$query = "UPDATE profile SET profileId = : profileId, profileActivationToken = : profileActivationToken, 
profileEmail = : profileEmail WHERE profileId = :profileId";
			$statement = $pdo->prepare($query);
			//bind the member variables to the place holders in the template


			//gets the ____ by content

			//gets the profile by profileId
			public static function getProfileByProfileId(PDO $pdo, int $profileId) :?Profile {
				//sanitize the profileid befor searching
				if($profileId <= 0){
					throw(new \PDOException("profile id is not positive"));
				}
			//create query template
				$query = "SELECT profileId, profileEmail FROM profile WHERE profileId =:profileId";
				$statement = $pdo->prepare($query);
				//bind the profile if to the place holder in the template
				$parameter = ["profileId" => $profileId];
				$statement->execute($parameters);
				//grab the profile from mySQL
				try {
					$profile = null;
					$statement->setFetchMode (\PDO::FETCH_ASSOC);
					$ROW = $statement->fetch();
					if($row !== false) {
						$profile = new Profile($row["profileId"], $row["profileId"], $row["profileEmail"]);

					}
			}catch(\Exception $exception)
					//if the row couldn't be converted, rethrow it
					throw(new \PDOException ($exception->getMessage(), 0, $exception));
				}
				return($profile);
				}


				//gets profile by profileEmail
			public static function getprofileByprofileEmail(\PDO $pdo, int $profileId) : \SPLFixedArray {
				//sanitize the profile id before searching
				if($profileId <= 0) {
					throw(new \RangeException("profile id must be positive"));
				}
				//create query table
				$query = "SELECT profileEmail,profileId FROM profile WHERE profileId = :profileId";
				$statement = $pdo->prepare($query);
				//bind the profileId to the place holder in the template
				$parameters = ["profileId" => $profileId];
				$statement->execute($parameters);
				//build and array of emails
				$profileEmail = new \SPLFixedArray($statement->rowCount());
				$statement->setFetchMode()(PDO::FETCH_ASSOC);
				while(($row = $statement->fetch()) != false) {
		try{
					$email = new profileEmail($row["profileEmail"], $row["profileId"]);
					$email[$profileEmail->key()] = $email;
					$profileId->next();
				} catch(\Exception $exception) {
					//if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->fetcMessage(), 0, $exception));
					}
					}
					return($profileEmail);

}
//gets all the emails
public static function getAllemails(\PDO $pdo) :\SPLFixedArray {
		//create query template
	$query = "SELECT profileEmail, profileId FROM profile";
	$statement = $pdo->prepare($query);
	$statement->execute();
	//build and array of emails
	$email = \SPLFoxedArray($statement->rowcount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try{
			$email = new email($row["profileEmail"], $row["profileId"]);

			$emails[$emails->key()] = $email;
			$emails->next();
		} catch()
	}

}









	$query = "INSERT INTO shop (shopContent, shopName) VALUES (:shopContent, : shopName)";
	$statement = $pdo->prepare($query);




	}