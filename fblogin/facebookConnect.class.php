<?php
require_once( 'lib/Facebook/FacebookSession.php');
require_once( 'lib/Facebook/FacebookRequest.php' );
require_once( 'lib/Facebook/FacebookResponse.php' );
require_once( 'lib/Facebook/FacebookSDKException.php' );
require_once( 'lib/Facebook/FacebookRequestException.php' );
require_once( 'lib/Facebook/FacebookRedirectLoginHelper.php');
require_once( 'lib/Facebook/FacebookAuthorizationException.php' );
require_once( 'lib/Facebook/GraphObject.php' );
require_once( 'lib/Facebook/GraphUser.php' );
require_once( 'lib/Facebook/GraphLocation.php' );
require_once( 'lib/Facebook/GraphSessionInfo.php' );
require_once( 'lib/Facebook/Entities/AccessToken.php');
require_once( 'lib/Facebook/HttpClients/FacebookCurl.php' );
require_once( 'lib/Facebook/HttpClients/FacebookHttpable.php');
require_once( 'lib/Facebook/HttpClients/FacebookCurlHttpClient.php');

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphLocation;
use Facebook\GraphSessionInfo;
use Facebook\FacebookHttpable;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookCurl;

class FacebookConnect {

    private $appId;
    private $appSecret;

    /**
     * @param $appId Facebook Application ID
     * @param $appSecret Facebook Application secret
     */
    function __construct($appId, $appSecret){
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    /**
     * @param $redirect_url
     * @return string|Facebook\GraphUser Login URL or GraphUser
     */
    function connect($redirect_url){
        FacebookSession::setDefaultApplication($this->appId, $this->appSecret);
        $helper = new FacebookRedirectLoginHelper($redirect_url);
        if(isset($_SESSION) && isset($_SESSION['fb_token'])){
            $session = new FacebookSession($_SESSION['fb_token']);
        }else{
            $session = $helper->getSessionFromRedirect();
        }
        if($session){
            try{
                $_SESSION['fb_token'] = $session->getToken();
                $request = new FacebookRequest($session, 'GET', '/me?fields=id,name,first_name, last_name,email,location');
                $profile = $request->execute()->getGraphObject('Facebook\GraphUser');
                if($profile->getEmail() === null){
                    throw new Exception('L\'email n\'est pas disponible');
                }
                return $profile;
            }catch (Exception $e){
                unset($_SESSION['fb_token']);
                return $helper->getReRequestUrl(['email']);
            }
        }else{
            return $helper->getLoginUrl(['email, user_location']);
        }
    }

}

?>