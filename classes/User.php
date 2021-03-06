<?php


/**
 * Class User
 *
 * Model for all users
 */
class User {
	private static $connection;
	
	public $id;
	public $is_admin;
    public $name;
    public $email;
    public $pass;

    /**
     * User constructor.
     * @param $user_arr
     */
	public function User($user_arr) {
        self::checkConnection();
		$this->validateAndSetData($user_arr);
	}

    /**
     * Verify database connection
     */
    public static function checkConnection() {
        global $gb_connection;
        if ($gb_connection) {
            self::$connection = $gb_connection;
        } else {
            die("No valid db connection");
        }
    }

    /**
     * Verify data
     *
     * @param $user_arr
     */
	private function validateAndSetData($user_arr) {
		if(!isset($user_arr['id'])) {
			die("User id required");
		}
		if(!isset($user_arr['name'])) {
			die("Name required");
		}
		if(!isset($user_arr['email'])) {
			die("Email address required");
		}
		if(!isset($user_arr['password'])) {
			die("Password required");
		}
        if(!isset($user_arr['is_admin'])) {
            die("isAdmin required");
        }
		$this->id = $user_arr['id'];
		$this->is_admin = $user_arr['is_admin'];
		$this->name = $user_arr['name'];
		$this->email = $user_arr['email'];
		$this->pass = $user_arr['password'];
	}

    /**
     * Get user by id
     *
     * @param $id
     * @return null|User
     */
    public static function getUserById($id) {
        self::checkConnection();
        settype($id, 'integer');
        $sql = sprintf("SELECT * FROM account WHERE id = %d", $id);
        $results = self::$connection->execute($sql);
        if (count($results) >= 1) {
            return new User($results[0]);
        } else {
            return null;
        }
    }
	
}