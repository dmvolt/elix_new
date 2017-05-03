<?php defined('SYSPATH') or die('No direct script access.');

class Valid extends Kohana_Valid {

	public static function check_id($value, $tablename) {
        $id = (int) $value;

        if (!preg_match("/^[a-z_]+$/i", $tablename))
            return FALSE;

        $count = DB::select(array('COUNT("*")', 'total_count'))
                ->from($tablename)
                ->where('id', '=', $id)
                ->execute()
                ->get('total_count');

        if ($count != 1)
            return FALSE;

        return TRUE;
    }

    public static function username_unique($username) {
        $usertemp = DB::query(Database::SELECT, 'SELECT * FROM users WHERE `username` = :username', TRUE)
                ->as_object()
                ->param(':username', $username)
                ->execute();

        if (isset($usertemp[0]->username)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public static function email_unique($email) {
        $usertemp = DB::query(Database::SELECT, 'SELECT * FROM users WHERE `email` = :email', TRUE)
                ->as_object()
                ->param(':email', $email)
                ->execute();

        if (isset($usertemp[0]->email)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	/**
	 * Checks whether a string consists of alphabetical characters, numbers, underscores, slashes, and dashes only.
	 *
	 * @param   string   input string
	 * @param   boolean  trigger UTF-8 compatibility
	 * @return  boolean
	 */
	public static function alpha_dash($str, $utf8 = FALSE)
	{
		if ($utf8 === TRUE)
		{
			$regex = '/^[-\pL\pN_\/]++$/uD';
		}
		else
		{
			$regex = '/^[-a-z0-9_\/]++$/iD';
		}
		return (bool) preg_match($regex, $str);
	}
}