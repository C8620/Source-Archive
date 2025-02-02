<?php
/* oauth.php Azure AD oAuth class
 *
 * Katy Nicholson, last updated 17/11/2021
 *
 * https://github.com/CoasterKaty
 * https://katytech.blog/
 * https://twitter.com/coaster_katy
 *
 */

class modOAuth {

	function errorMessage($message) {
                // Detect 54005 already reedemed error
                if (strpos($message, 'AADSTS54005') !== false) {
                        // Human-readable message in EN, ZH, JA, KR.
                        $message = 'Stale request. You may have refreshed this 
                        page or clicked the back button. Re-visit the homepage 
                        to try again.</br>\n <a href="/">Return to homepage</a>
                        <br />\n
                        过期的请求。您可能刷新了此页面或单击了返回按钮。请重新访问主页以重试。
                        </br>\n <a href="/">返回主页</a><br />\n
                        期限切れのリクエスト。このページを更新したか、戻るボタンをクリックし
                        ました。もう一度ホームページを訪れてやり直してください。</br>\n 
                        <a href="/">ホームページに戻る</a><br />\n
                        만료된 요청입니다. 이 페이지를 새로 고침하거나 뒤로 버튼을 클릭했을
                        수 있습니다. 다시 홈페이지를 방문하여 다시 시도하십시오.</br>\n
                        <a href="/">홈페이지로 돌아가기</a>';
                }

		return	'<!DOCTYPE html>
                        <html lang="en">
                        <head>
                                <meta name="viewport" content="width=device-width, initial-scale=1">
                                <title>Error</title>
                                <link rel="stylesheet" type="text/css" href="style.css" />
                        </head>
                        <body>
                        <div id="fatalError"><div id="fatalErrorInner"><span>Something\'s gone wrong!</span>' . $message . '</div></div>
                        </body>
                        </html>';
	}

	function generateRequest($data) {
	        if (_OAUTH_METHOD == 'certificate') {
                        // Use the certificate specified
                        //https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-certificate-credentials
                        $cert = file_get_contents(_OAUTH_AUTH_CERTFILE);
                        $certKey = openssl_pkey_get_private(file_get_contents(_OAUTH_AUTH_KEYFILE));
                        $certHash = openssl_x509_fingerprint($cert);
                        $certHash = base64_encode(hex2bin($certHash));
                        $caHeader = json_encode(array('alg' => 'RS256', 'typ' => 'JWT', 'x5t' => $certHash));
                        $caPayload = json_encode(array('aud' => 'https://login.microsoftonline.com/' . _OAUTH_TENANTID . '/v2.0',
                                                'exp' => date('U', strtotime('+10 minute')),
                                                'iss' => _OAUTH_CLIENTID,
                                                'jti' => $this->uuid(),
                                                'nbf' => date('U'),
                                                'sub' => _OAUTH_CLIENTID));
                        $caSignature = '';

                        $caData = $this->base64UrlEncode($caHeader) . '.' . $this->base64UrlEncode($caPayload);
                        openssl_sign($caData, $caSignature, $certKey, OPENSSL_ALGO_SHA256);
                        $caSignature = $this->base64UrlEncode($caSignature);
                        $clientAssertion = $caData . '.' . $caSignature;
                        return $data . '&client_assertion=' . $clientAssertion . '&client_assertion_type=urn:ietf:params:oauth:client-assertion-type:jwt-bearer';
                } else {
			// Use the client secret instead
                        return $data . '&client_secret=' . urlencode(_OAUTH_SECRET);
                }

	}

	function postRequest($endpoint, $data) {
		$ch = curl_init('https://login.microsoftonline.com/' . _OAUTH_TENANTID . '/oauth2/v2.0/' . $endpoint);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);
		if ($cError = curl_error($ch)) {
			echo $this->errorMessage($cError);
			exit;
		}
		curl_close($ch);
		return $response;

	}

	function base64UrlEncode($toEncode) {
                return str_replace('=', '', strtr(base64_encode($toEncode), '+/', '-_'));
        }


        function uuid() {
                //uuid function is not my code, but unsure who the original author is. KN
                //uuid version 4
                return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    // 32 bits for "time_low"
                    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                    // 16 bits for "time_mid"
                    mt_rand( 0, 0xffff ),
                    // 16 bits for "time_hi_and_version",
                    // four most significant bits holds version number 4
                    mt_rand( 0, 0x0fff ) | 0x4000,
                    // 16 bits, 8 bits for "clk_seq_hi_res",
                    // 8 bits for "clk_seq_low",
                    // two most significant bits holds zero and one for variant DCE1.1
                    mt_rand( 0, 0x3fff ) | 0x8000,
                    // 48 bits for "node"
                    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
                );
        }

}
?>
