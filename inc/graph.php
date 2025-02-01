<?php

/* graph.php Graph API class
 *
 * Katy Nicholson, last updated 01/09/2021
 *
 * https://github.com/CoasterKaty
 * https://katytech.blog/
 * https://twitter.com/coaster_katy
 *
 * Sample class to retrieve data through Graph API once logged in
 */


require_once dirname(__FILE__) . '/auth.php';

class modGraph
{
        var $modAuth;
        function __construct()
        {
                $this->modAuth = new modAuth();
        }
        function getProfile()
        {
                $profile = json_decode($this->sendGetRequest('https://graph.microsoft.com/v1.0/me/'));
                if (isset($profile->displayName)) {
                        $_SESSION['playername'] = $profile->displayName;
                } else {
                        die('Error retrieving profile information: no display name found. Contact the administrator.');
                }
                if (isset($profile->userPrincipalName)) {
                        $_SESSION['userpname'] = $profile->userPrincipalName;
                } else {
                        die('Error retrieving profile information: no user principal name found. Contact the administrator.');
                }
                if (isset($profile->id)) {
                        $_SESSION['uid'] = substr($profile->id, -17);
                } else {
                        die('Error retrieving profile information: no Azure AD ID found. Contact the administrator.');
                }
                return $profile;
        }
        function getPhoto()
        {
                //Photo is a bit different, we need to request the image data which will include content type, size etc, then request the image
                $photoType = json_decode($this->sendGetRequest('https://graph.microsoft.com/v1.0/me/photo/'));
                $photo = $this->sendGetRequest('https://graph.microsoft.com/v1.0/me/photo/%24value');
                return '<img src="data:' . $photoType->{'@odata.mediaContentType'} . ';base64,' . base64_encode($photo) . '" alt="User Photo" />';
        }

        function sendGetRequest($URL, $ContentType = 'application/json')
        {
                $ch = curl_init($URL);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->modAuth->Token, 'Content-Type: ' . $ContentType));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);

                curl_close($ch);
                return $response;
        }
}
?>