<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Database Type
| -------------------------------------------------------------------------
| If set to TRUE, Ion Auth will use MongoDB as its database backend.
|
| If you use MongoDB there are two external dependencies that have to be
| integrated with your project:
|   CodeIgniter MongoDB Active Record Library - http://github.com/alexbilbie/codeigniter-mongodb-library/tree/v2
|   CodeIgniter MongoDB Session Library - http://github.com/sepehr/ci-mongodb-session
*/
$config['use_mongodb'] = FALSE;

/*
| -------------------------------------------------------------------------
| MongoDB Collection.
| -------------------------------------------------------------------------
| Setup the mongodb docs using the following command:
| $ mongorestore sql/mongo
|
*/
$config['collections']['users']          = 'users';
$config['collections']['groups']         = 'groups';
$config['collections']['login_attempts'] = 'login_attempts';

/*
| -------------------------------------------------------------------------
| Tables.
| -------------------------------------------------------------------------
| Database table names.
*/
$config['tables']['users']                          = 'users';
$config['tables']['groups']                         = 'groups';
$config['tables']['users_groups']                   = 'users_groups';
$config['tables']['login_attempts']                 = 'login_attempts';

$config['tables']['shop_info']                      = 'shop_info';
$config['tables']['users_shop_info']                = 'users_shop_info';
$config['tables']['product_info']                   = 'product_info';
$config['tables']['suppliers']                      = 'suppliers';
$config['tables']['customers']                      = 'customers';
$config['tables']['purchase_order']                 = 'purchase_order';
$config['tables']['product_purchase_order']         = 'product_purchase_order';
$config['tables']['stock_info']                     = 'stock_info';
$config['tables']['sale_order']                     = 'sale_order';
$config['tables']['product_sale_order']             = 'product_sale_order';
$config['tables']['product_sale_price']             = 'product_sale_price';
$config['tables']['expense_type']                   = 'expense_type';
$config['tables']['expense_info']                   = 'expense_info';
$config['tables']['users_shop_info']                = 'users_shop_info';
$config['tables']['institution']                    = 'institution';
$config['tables']['profession']                     = 'profession';
$config['tables']['supplier_payment_info']          = 'supplier_payment_info';
$config['tables']['supplier_returned_payment_info'] = 'supplier_returned_payment_info';
$config['tables']['supplier_transaction_info']      = 'supplier_transaction_info';
$config['tables']['customer_payment_info']          = 'customer_payment_info';
$config['tables']['customer_returned_payment_info'] = 'customer_returned_payment_info';
$config['tables']['customer_transaction_info']      = 'customer_transaction_info';
$config['tables']['sms_configuration_shop']         = 'sms_configuration_shop';
$config['tables']['attendance']                     = 'attendance';
$config['tables']['operators']                      = 'operators';
$config['tables']['shop_type']                      = 'shop_type';
$config['tables']['product_unit_category']          = 'product_unit_category';
$config['tables']['message_category']               = 'message_category';
$config['tables']['message_info']                   = 'message_info';
$config['tables']['supplier_message']               = 'supplier_message';
$config['tables']['shop_type']                      = 'shop_type';
$config['tables']['custom_message']                 = 'custom_message';
$config['tables']['phone_directory']                = 'phone_directory';
$config['tables']['phone_upload_list']              = 'phone_upload_list';
$config['tables']['queue_table']                    = 'queue_table';
$config['tables']['test_queue']                    = 'test_queue';


/*
 | Users table column and Group table column you want to join WITH.
 |
 | Joins from users.id
 | Joins from groups.id
 */
$config['join']['users']  = 'user_id';
$config['join']['groups'] = 'group_id';

$config['account_status']['active_id']      = '1';
$config['account_status']['inactive_id']    = '2';
$config['account_status']['suspended_id']   = '3';
$config['account_status']['deactivated_id'] = '4';
$config['account_status']['blocked_id']     = '5';

$config['user_group']['admin_id']           = '1';
$config['user_group']['manager_id']         = '2';
$config['user_group']['salesman_id']        = '3';
$config['user_group']['supplier_id']        = '4';
$config['user_group']['customer_id']        = '5';

$config['shop_identity_column']             = 'name';
$config['product_identity_column']          = 'name';
$config['customer_identity_column']         = 'card_no';

$config['expense_type']['all']              = '0';
$config['expense_type']['shop']             = '1';
$config['expense_type']['supplier']         = '2';
$config['expense_type']['user']             = '3';
$config['expense_type']['other']            = '4';

$config['payment_type']['cash_id']                          = '1';
$config['payment_type']['check_id']                         = '2';

$config['payment_category']['sale_payment_id']              = '1';
$config['payment_category']['due_collect_id']               = '2';

$config['queue_list_phone_number_identity_column']          = 'phone_number';

/*
 | -------------------------------------------------------------------------
 | Hash Method (sha1 or bcrypt)
 | -------------------------------------------------------------------------
 | Bcrypt is available in PHP 5.3+
 |
 | IMPORTANT: Based on the recommendation by many professionals, it is highly recommended to use
 | bcrypt instead of sha1.
 |
 | NOTE: If you use bcrypt you will need to increase your password column character limit to (80)
 |
 | Below there is "default_rounds" setting.  This defines how strong the encryption will be,
 | but remember the more rounds you set the longer it will take to hash (CPU usage) So adjust
 | this based on your server hardware.
 |
 | If you are using Bcrypt the Admin password field also needs to be changed in order login as admin:
 | $2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36
 |
 | Becareful how high you set max_rounds, I would do your own testing on how long it takes
 | to encrypt with x rounds.
 */
$config['hash_method']    = 'sha1';	// IMPORTANT: Make sure this is set to either sha1 or bcrypt
$config['default_rounds'] = 8;		// This does not apply if random_rounds is set to true
$config['random_rounds']  = FALSE;
$config['min_rounds']     = 5;
$config['max_rounds']     = 9;

/*
 | -------------------------------------------------------------------------
 | Authentication options.
 | -------------------------------------------------------------------------
 | maximum_login_attempts: This maximum is not enforced by the library, but is
 | used by $this->ion_auth->is_max_login_attempts_exceeded().
 | The controller should check this function and act
 | appropriately. If this variable set to 0, there is no maximum.
 */
$config['site_title']                 = "Apurbobrand.com";       // Site Title, example.com
$config['admin_email']                = "info@apurbobrand.com"; // Admin Email, admin@example.com
$config['default_group']              = 'members';           // Default group, use name
$config['admin_group']                = 'admin';             // Default administrators group, use name
$config['customer_group']             = 'customer';             // Default administrators group, use name
$config['salesman_group']             = 'salesman';             // Default administrators group, use name
$config['identity']                   = 'username';             // A database column which is used to login with
$config['min_password_length']        = 8;                   // Minimum Required Length of Password
$config['max_password_length']        = 20;                  // Maximum Allowed Length of Password
$config['email_activation']           = FALSE;               // Email Activation for registration
$config['manual_activation']          = FALSE;               // Manual Activation for registration
$config['remember_users']             = TRUE;                // Allow users to be remembered and enable auto-login
$config['user_expire']                = 86500;               // How long to remember the user (seconds). Set to zero for no expiration
$config['user_extend_on_login']       = FALSE;               // Extend the users cookies everytime they auto-login
$config['track_login_attempts']       = FALSE;               // Track the number of failed login attempts for each user or ip.
$config['maximum_login_attempts']     = 3;                   // The maximum number of failed login attempts.
$config['lockout_time']               = 600;                 // The number of seconds to lockout an account due to exceeded attempts
$config['forgot_password_expiration'] = 0;                   // The number of miliseconds after which a forgot password request will expire. If set to 0, forgot password requests will not expire.
$config['sms_sender_server_url']      = "http://dev2-64.xpressfiler.com/SendMSG";       

$config['send_admin_email']                = FALSE;
$config['admin_email_templates']      = 'manager/email/';
$config['admin_email_registration_success'] = 'registration_success.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Email options.
 | -------------------------------------------------------------------------
 | email_config:
 | 	  'file' = Use the default CI config or use from a config file
 | 	  array  = Manually set your email config settings
 */
$config['use_ci_email'] = FALSE; // Send Email using the builtin CI email class, if false it will return the code and the identity
$config['email_config'] = array(
	'mailtype' => 'html',
);

/*
 | -------------------------------------------------------------------------
 | Email templates.
 | -------------------------------------------------------------------------
 | Folder where email templates are stored.
 | Default: auth/
 */
$config['email_templates'] = 'auth/email/';

/*
 | -------------------------------------------------------------------------
 | Activate Account Email Template
 | -------------------------------------------------------------------------
 | Default: activate.tpl.php
 */
$config['email_activate'] = 'activate.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Forgot Password Email Template
 | -------------------------------------------------------------------------
 | Default: forgot_password.tpl.php
 */
$config['email_forgot_password'] = 'forgot_password.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Forgot Password Complete Email Template
 | -------------------------------------------------------------------------
 | Default: new_password.tpl.php
 */
$config['email_forgot_password_complete'] = 'new_password.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Salt options
 | -------------------------------------------------------------------------
 | salt_length Default: 10
 |
 | store_salt: Should the salt be stored in the database?
 | This will change your password encryption algorithm,
 | default password, 'password', changes to
 | fbaa5e216d163a02ae630ab1a43372635dd374c0 with default salt.
 */
$config['salt_length'] = 10;
$config['store_salt']  = FALSE;

/*
 | -------------------------------------------------------------------------
 | Message Delimiters.
 | -------------------------------------------------------------------------
 */
$config['message_start_delimiter'] = '<div style="color:blue">'; 	// Message start delimiter
$config['message_end_delimiter']   = '</div>'; 	// Message end delimiter
$config['error_start_delimiter']   = '<div style="color:red">';		// Error mesage start delimiter
$config['error_end_delimiter']     = '</div>';	// Error mesage end delimiter

/* End of file ion_auth.php */
/* Location: ./application/config/ion_auth.php */
