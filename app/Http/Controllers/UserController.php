<?php namespace Bernly\Http\Controllers;

use Bernly\Helpers\UrlHelper,
    Bernly\Helpers\UserHelper,
    Bernly\Http\Requests\StoreUser,
    Bernly\Models\Url,
    Bernly\Models\User;

use ReCaptcha\ReCaptcha;
use \Illuminate\Database\QueryException;

class UserController extends Controller
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
     * @summary Responds to HTTP GET /user. Displays home page.
     *
     * @return Response
     */
    public function getIndex()
    {
        return redirect('/');
    }

    /**
     * @summary Responds to HTTP GET /user/add. Displays user registration form.
     *
     * @return Response
     */
    public function getAdd()
    {
        return view('users.store')->withTimezones(\DateTimeZone::listIdentifiers(\DateTimeZone::ALL));
    }

    /**
     * @summary Responds to HTTP POST /user/add. Creates new user in database, then displays home page.
     *
     * @return Response
     */
    public function postAdd(StoreUser $request)
    {
        $email = \Request::input( 'email' );
        $password = \Request::input( 'password' );
        $confirm_password = \Request::input( 'confirm_password' );
        $timezone = \Request::input( 'timezone' );
        $recaptcha_response = \Request::input('g-recaptcha-response');

        $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        $recaptcha_result = $recaptcha->verify($recaptcha_response);

        if (! $recaptcha_result->isSuccess()) {
            return redirect('user/add')->with([
                'recaptcha_class' => 'has-error',
                'recaptcha_error' => 'Please complete the reCAPTCHA.',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password,
                'timezone' => $timezone
            ]);
        }

        $user = new User;
        $user->email = $email;
        $user->password = \Hash::make( $password );
        $user->timezone = $timezone;
        $user->setRememberToken( 'remember' );
        $user->save();

        \Auth::login( $user );

        return redirect('/verify');
    }

    /**
     * @summary Responds to HTTP GET /user/view. Displays the logged-in user's profile.
     *
     * @return Response
     */
    public function getView()
    {
        return view('users.view');
    }

    /**
     * @summary Responds to HTTP GET /user/edit-email. Displays email edit form.
     *
     * @return Response
     */
    public function getEditEmail()
    {
          return view('users.edit-email');
    }

    /**
     * @summary Responds to HTTP POST /user/edit-email. Updates logged-in user's email address, then
     * displays user's profile with a success message.
     *
     * @return Response
     */
    public function postEditEmail(StoreUser $request)
    {
        $email = \Request::input( 'email' );

        $user = User::find( \Auth::user()->id );
        $user->email = $email;
        $user->verified = false;
        $user->save();

        return redirect('/verify')->with('is_edited_email', true);
    }

    /**
     * @summary Responds to HTTP GET /user/edit-password. Displays password edit form.
     *
     * @return Response
     */
    public function getEditPassword()
    {
        return view('users.edit-password');
    }

    /**
     * @summary Responds to HTTP POST /user/edit-password. Updates logged-in user's password, then displays
     * user's profile with a success message.
     *
     * @return Response
     */
    public function postEditPassword(StoreUser $request)
    {
        $password = \Request::input( 'password' );
        $confirm_password = \Request::input( 'confirm_password' );

        $user = User::find( \Auth::user()->id );
        $user->password = \Hash::make( $password );
        $user->save();

        return redirect('/user/view')->with( 'is_edited_password', true );
    }

    /**
     * @summary Responds to HTTP GET /user/edit-timezone. Displays timezone edit form.
     *
     * @return Response
     */
    public function getEditTimezone()
    {
        return view('users.edit-timezone')->withTimezones(\DateTimeZone::listIdentifiers(\DateTimeZone::ALL));
    }

    /**
     * @summary Responds to HTTP POST /user/edit-timezone. Updates logged-in user's timezone, then
     * displays user's profile with a success message.
     *
     * @return Response
     */
    public function postEditTimezone(StoreUser $request)
    {
        $timezone = \Request::input( 'timezone' );

        $user = \Auth::user();
        $user->timezone = $timezone;
        $user->save();

        return redirect('/user/view')->with('is_edited_timezone', true);
    }

    /**
     * @summary Responds to HTTP POST /user/remove. Deletes logged-in user from database.
     *
     * @return Response
     */
    public function getRemove()
    {
        $user = User::find( \Auth::user()->id );
        $user->delete();

        return redirect( '/' );
    }

    /**
     * @summary Responds to HTTP GET /user/links. Displays a list of all logged-in user's links.
     *
     * @return Response
     */
    public function getLinks()
    {
        $urls = \Auth::user()
            ->urls()
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();

        $urls_with_hits = UrlHelper::changeTimeZone($urls);

        return view('links')->withUrls($urls_with_hits);
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

        $db_time_zone = new \DateTimeZone( 'UTC' );
        $user_timezone = new \DateTimeZone( \Auth::user()->timezone );

        $created_at = new \DateTime( $url['created_at'], $db_time_zone );
        $created_at->setTimeZone( $user_timezone );
        $url['created_at'] = $created_at->format( 'Y-m-d H:i:s' );

        $url['hits'] = [];
        foreach ( $url_hits as $url_hit ) {
            $url_hit_created_at = new \DateTime( $url_hit['created_at'], $db_time_zone );
            $url_hit_created_at->setTimeZone( $user_timezone );
            $url_hit['created_at'] = $url_hit_created_at->format( 'Y-m-d H:i:s' );

            $url['hits'][] = $url_hit;
        }

        return view('clicks')->withUrl($url);
    }
}

