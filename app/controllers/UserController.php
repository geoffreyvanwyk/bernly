<?php

class UserController extends BaseController 
{
    /**
     * @summary Adds an authentication route filter to some user routes, redirecting the guest to the login
     * form.
     *
     * @return UserController
     */
    public function __construct()
    {
        $this->beforeFilter( 'auth', array( 'except' => array( 'getIndex', 'getAdd', 'postAdd' ) ) );
    }
    
    /**
     * @summary Responds to HTTP GET /. Displays home page. 
     *
     * @return Response
     */
	public function getIndex()
	{
		return Redirect::to( '/' );
	}

    /**
     * @summary Responds to HTTP GET /user/add. Displays user registration form.
     *
     * @return Response
     */
	public function getAdd()
	{
        $timezones = DateTimeZone::listIdentifiers( DateTimeZone::ALL );
        
		return View::make( 'user.add' )->with( 'timezones', $timezones );
	}
	
    /**
     * @summary Responds to HTTP POST /user/add. Creates new user in database, then displays home page. 
     *
     * @return Response
     */
	public function postAdd()
	{
        $email = Input::get( 'email' );
        $password = Input::get( 'password' );
        $confirm_password = Input::get( 'confirm_password' );
        $timezone = Input::get( 'timezone' );
        
        if ( ! $this->isEmailValid( $email ) ) {
            return Redirect::to( '/user/add' )->with( array(
                'email_class' => 'has-error',
                'email_error' => 'The email you entered is invalid. It should be similar to john@example.com',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        if ( ! $this->isPasswordValid( $password ) ) {
            return Redirect::to( '/user/add' )->with( array(
                'password_class' => 'has-error',
                'password_error' => 'Password should be at least 10 characters long.',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        if ( ! $this->isPasswordConfirmed( $password, $confirm_password ) ) {
            return Redirect::to( '/user/add' )->with( array(
                'confirm_password_class' => 'has-error',
                'confirm_password_error' => 'The passwords do not match.',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        if ( $timezone === 'Please select ...' ) {
            return Redirect::to( '/user/add' )->with( array(
                'timezone_class' => 'has-error',
                'timezone_error' => 'A timezone is required.',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        $user = new User;
        $user->email = $email;
        $user->password = Hash::make( $password );
        $user->timezone = $timezone;
        $user->setRememberToken( 'remember' );
        $user->save();
        
        Auth::login( $user );
        
        return Redirect::to( '/verify' );
	}
	
	/**
	 * @summary Responds to HTTP GET /user/view. Displays the logged-in user's profile.
	 *
	 * @return Response
	 */
	public function getView()
	{
        return View::make( 'user.view' );
	}
	
	/**
	 * @summary Responds to HTTP GET /user/edit-email. Displays email edit form.
	 * 
	 * @return Response
	 */
	public function getEditEmail()
	{
        return View::make( 'user.edit-email' );
	}
	
    /**
     * @summary Responds to HTTP POST /user/edit-email. Updates logged-in user's email address, then
     * displays user's profile with a success message.
     * 
     * @return Response
     */
    public function postEditEmail()
    {
        $email = Input::get( 'email' );
        
        if ( ! $this->isEmailValid( $email ) ) {
            return Redirect::to( '/user/edit-email' )->with( array(
                'email_class' => 'has-error',
                'email_error' => 'The email you entered is invalid. It should be similar to john@example.com',
                'email' => $email
            ));
        }
        
        $user = User::find( Auth::user()->id );
        $user->email = $email;
        $user->verified = false;
        $user->save();
        
        return Redirect::to( '/verify' )->with( 'is_edited_email', true );
    }
    
    /**
     * @summary Responds to HTTP GET /user/edit-password. Displays password edit form.
     * 
     * @return Response
     */
    public function getEditPassword()
    {
        return View::make( 'user.edit-password' );
    }
    
    /**
     * @summary Responds to HTTP POST /user/edit-password. Updates logged-in user's password, then displays
     * user's profile with a success message.
     * 
     * @return Response
     */
    public function postEditPassword()
    {
        $password = Input::get( 'password' );
        $confirm_password = Input::get( 'confirm_password' );
        
        if ( ! $this->isPasswordValid( $password ) ) {
            return Redirect::to( '/user/edit-password' )->with( array(
                'password_class' => 'has-error',
                'password_error' => 'Password should be at least 10 characters long.',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        if ( ! $this->isPasswordConfirmed( $password, $confirm_password ) ) {
            return Redirect::to( '/user/edit-password' )->with( array(
                'confirm_password_class' => 'has-error',
                'confirm_password_error' => 'The passwords do not match.',
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        $user = User::find( Auth::user()->id );
        $user->password = Hash::make( $password );
        $user->save();
        
        return Redirect::to('/user/view')->with( 'is_edited_password', true );
    }
    
    /**
     * @summary Responds to HTTP GET /user/edit-timezone. Displays timezone edit form.
     * 
     * @return Response
     */
    public function getEditTimezone()
    {
        $timezones = DateTimeZone::listIdentifiers( DateTimeZone::ALL );
        return View::make( 'user.edit-timezone' )->with( 'timezones', $timezones );
    }
    
    /**
     * @summary Responds to HTTP POST /user/edit-timezone. Updates logged-in user's timezone, then
     * displays user's profile with a success message.
     * 
     * @return Response
     */
    public function postEditTimezone()
    {
        $timezone = Input::get( 'timezone' );
        
        if ( $timezone === 'Please select ...' ) {
            return Redirect::to( '/user/edit-timezone' )->with( array(
                'timezone_class' => 'has-error',
                'timezone_error' => 'A timezone is required.'
            ));
        }
        
        $user = User::find( Auth::user()->id );
        $user->timezone = $timezone;
        $user->save();
        
        return Redirect::to( '/user/view' )->with( 'is_edited_timezone', true );
    }
    /**
     * @summary Responds to HTTP POST /user/remove. Deletes logged-in user from database. 
     * 
     * @return Response
     */
    public function getRemove()
    {
        $user = User::find( Auth::user()->id );
        $user->delete();
        
        return Redirect::to( '/' );
    }
    
    /**
     * @summary Returns true if $email is valid. 
     *
     * @param string $email An email address.
     *
     * @return boolean
     */
	private function isEmailValid( $email )
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
    private function isPasswordValid( $password )
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
    private function isPasswordConfirmed( $password, $confirm_password )
    {
        return $password === $confirm_password;
    }
    
    /**
     * @summary Responds to HTTP GET /user/links. Displays a list of all logged-in user's links.
     *
     * @return Response
     */
    public function getLinks()
    {
        $user = User::find( Auth::user()->id );
        $urls = $user->urls()->orderBy( 'created_at', 'desc' )->get()->toArray();
        $urls_with_hits = array();
        
        $db_time_zone = new DateTimeZone( 'UTC' );
        $user_timezone = new DateTimeZone( Auth::user()->timezone );
        
        foreach ( $urls as $url ) {
            $created_at = new DateTime( $url['created_at'], $db_time_zone );
            $created_at->setTimeZone( $user_timezone );
            $url['created_at'] = $created_at->format( 'Y-m-d H:i:s' );
            
            $url['hits'] = Url::find( $url['id'] )->urlHits()->count();
            $urls_with_hits[] = $url;
        }
        
        return View::make( 'links' )->with( 'urls', $urls_with_hits );
    }
    
    /**
     * @summary Responds to HTTP GET /user/link/{url_id}. Displays, for a given url_id, a list of click 
     * details: referer, click date.
     *
     * @return Response
     */
    public function getLink( $url_id )
    {
        $url_object = Url::find( $url_id );
        $url_hits = $url_object->urlHits;
        $url = $url_object->toArray();
        
        $db_time_zone = new DateTimeZone( 'UTC' );
        $user_timezone = new DateTimeZone( Auth::user()->timezone );
        
        $created_at = new DateTime( $url['created_at'], $db_time_zone );
        $created_at->setTimeZone( $user_timezone );
        $url['created_at'] = $created_at->format( 'Y-m-d H:i:s' );
        
        $url['hits'] = array();
        foreach ( $url_hits as $url_hit ) {
            $url_hit_created_at = new DateTime( $url_hit['created_at'], $db_time_zone );
            $url_hit_created_at->setTimeZone( $user_timezone );
            $url_hit['created_at'] = $url_hit_created_at->format( 'Y-m-d H:i:s' );
            
            $url['hits'][] = $url_hit;
        }
        
        return View::make( 'clicks' )->with( 'url', $url );
    }
}
