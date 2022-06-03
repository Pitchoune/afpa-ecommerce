<?php

/**
 * The SQL server name.
 *
 * @var string
 */
$config['server']['servername'] = 'localhost';

/**
 * The SQL server port.
 *
 * @var string
 */
$config['server']['port'] = 3306;

/**
 * The SQL server username.
 *
 * @var string
 */
$config['server']['username'] = 'root';

/**
 * The SQL server password
 *
 * @var string
 */
$config['server']['password'] = '1234';

/**
 * The SQL database name.
 *
 * @var string
 */
$config['database']['dbname'] = 'ecommerce';

/**
 * The full path to directory
 *
 * On a few systems it may be necessary to input the full path to your script directory
 * to function normally. You can ignore this setting unless the system tells you
 * to fill this in. Do not include a trailing slash!
 * Example Unix:
 *   $config['Misc']['path'] = '/home/users/public_html/script';
 * Example Win32:
 *   $config['Misc']['path'] = 'c:\program files\apache group\apache\htdocs\script';
 *
 * @var string
 */
$config['Misc']['path'] = '';

/**
 * The ID of the employee to not delete. This user won't be able to be deleted at all.
 */
$config['Misc']['superadminid'] = '1';

/**
 * Email address of the super admin.
 */
$config['Misc']['emailaddress'] = 'admin@yrg.ovh';

/**
 * The Strip API private key.
 */
$config['Stripe']['privatekey'] = 'sk_test_51KrojCIKwGeta4eBYr9rnf1wCE8ZPcyFyk04TN5JCd7kj4j8Fevn6JyMIPt7zulB17jJNLTjXUqL5ovjmpxQky2L00j2ZQWbjt';

/**
 * The Strip API public key.
 */
$config['Stripe']['publickey'] = 'pk_test_51KrojCIKwGeta4eBiTqAhx1hJ77yKlzThOWsblV7PyJ3cKF0S2R4c4Zyh6Ifw1yREzmEQktiJcs3BqbcCOFpoSgZ005LmrHNbV';

?>