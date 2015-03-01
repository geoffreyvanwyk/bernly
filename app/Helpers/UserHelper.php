<?php namespace Bernly\Helpers;

class UserHelper
{
    /**
     * @summary Returns true if $email is valid.
     *
     * @param string $email An email address.
     *
     * @return boolean
     */
    public static function isEmailValid( $email )
    {
        return preg_match(
            "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",
            $email
        );
    }

    /**
     * @summary Returns true if $password is valid.
     *
     * @param string $password
     *
     * @return boolean
     */
    public static function isPasswordValid( $password )
    {
        return strlen( $password ) >= 10;
    }

    /**
     * @summary Returns true if $password and $confirm_password are the same.
     *
     * @param string $password
     * @param string $confirm_password
     *
     * @return boolean
     */
    public static function isPasswordConfirmed( $password, $confirm_password )
    {
        return $password === $confirm_password;
    }

    /**
     * @summary Returns true if the user is logged-in. 
     *
     * @return boolean
     */
    public static function isLoggedIn()
    {
        return Auth::check();
    }
}
