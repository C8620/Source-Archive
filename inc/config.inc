<?php
// MySQL connection details
define('_MYSQL_HOST', '');
define('_MYSQL_USER', '');
define('_MYSQL_DB', '');
define('_MYSQL_PASS', '');

// URLs to be used
define('_URL', ''); // No end slash
define('_CDN_URL', ''); // No end slash

// i18n settings
define('_I18N_DEFAULT_LANG', 'zh');

// Geetest/Turnstile split settings
define('_TURNSTILE_EXCLUDE', array('AA', 'BB'));

// GeeTest4 Settings
define('_GEETEST_VERIFYID', '');
define('_GEETEST_SITEKEY', '');
define('_GEETEST_PERIOD', 10086);
define('_GEETEST_DOMAIN', ''); // Only domain
define('_GEETEST_DEBUG', true);

// Turnstile settings
define('_TURNSTILE_SITEKEY', '');
define('_TURNSTILE_SECRET', '');
define('_TURNSTILE_DOMOIN', ''); // Only domain
define('_TURNSTILE_PERIOD', 8620);

// Proxy settings
define('_TURNSTILE_PROXY_SECRET', '');
define('_TURNSTILE_PROXY_ENDPOINT', ''); // With end slash
define('_IPDATA_PROXY_ENDPOINT', ''); // With end slash

// System settings
define('_GRACE_PERIOD', 0); // Grace period in pages
define('_WHITELIST_ENABLED', false); // Allow access only to accounts
define('_SOFTWARE_VERSION', 'V5.1.0 OSS (20250201)');
define('_DATA_VERSION', '');
define('_WRITE_LOGS', true);

// Geolocation settings
define('_DISALLOWED_TYPES', array('example'));
define('_ALLOWED_REGIONS', array('AA', 'BB'));

// Voice feature configuration
define('_VOICE_ONLOGON', true);
define('_VOICE_KILLSWITCH', false);
define('_VOICE_GA_ENABLED', false);
define('_VOICE_LB_ENABLED', true);
define('_VOICE_ACCESS_SECRET', '');
define('_VOICE_ACCESS_ENDPOINT', ''); // With end slash
define('_VOICE_ONLOGON_LIST', array('Voice_tag_1', 'Voice_tag_2'));


// oAuth details
// TENANTID: Your tenant's ID if you set up the app reg as single tenant, otherwise 'common'
//Scope needs to include the services you wish to access - at a minimum you'll need openid and offline_access for logging on to work. Add in user.read if you want to query user profile via Graph. Separate with %20.
define('_OAUTH_TENANTID', '');
define('_OAUTH_CLIENTID', '');
define('_OAUTH_LOGOUT', 'https://login.microsoftonline.com/common/wsfederation?wa=wsignout1.0');
define('_OAUTH_SCOPE', 'openid%20offline_access%20profile%20user.read');

// Define either the client secret, or the client certificate details
// method = 'certificate' or 'secret'
define('_OAUTH_METHOD', 'secret');

// Secret ID: 4f07607f-05fc-409a-9589-db7f1957066c
define('_OAUTH_SECRET', '');
define('_OAUTH_AUTH_CERTFILE', '/path/to/certificate.crt');
define('_OAUTH_AUTH_KEYFILE', '/path/to/privatekey.pem');

// on Windows, the certificate paths should be in the form c:/path/to/cert.crt

?>

