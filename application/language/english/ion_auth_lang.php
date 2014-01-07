<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Account Successfully Created';
$lang['account_creation_unsuccessful'] 	 	 = 'Unable to Create Account';
$lang['account_creation_duplicate_email'] 	 = 'Email Already Used or Invalid';
$lang['account_creation_duplicate_username'] = 'Username Already Used or Invalid';

// Password
$lang['password_change_successful'] 	 	 = 'Password Successfully Changed';
$lang['password_change_unsuccessful'] 	  	 = 'Unable to Change Password';
$lang['forgot_password_successful'] 	 	 = 'Password Reset Email Sent';
$lang['forgot_password_unsuccessful'] 	 	 = 'Unable to Reset Password';

// Activation
$lang['activate_successful'] 		  	     = 'Account Activated';
$lang['activate_unsuccessful'] 		 	     = 'Unable to Activate Account';
$lang['deactivate_successful'] 		  	     = 'Account De-Activated';
$lang['deactivate_unsuccessful'] 	  	     = 'Unable to De-Activate Account';
$lang['activation_email_successful'] 	  	 = 'Activation Email Sent';
$lang['activation_email_unsuccessful']   	 = 'Unable to Send Activation Email';

// Login / Logout
$lang['login_successful'] 		  	         = 'Logged In Successfully';
$lang['login_unsuccessful'] 		  	     = 'Incorrect Login';
$lang['login_unsuccessful_not_active'] 		 = 'Account is inactive';
$lang['login_timeout']                       = 'Temporarily Locked Out.  Try again later.';
$lang['logout_successful'] 		 	         = 'Logged Out Successfully';

// Account Changes
$lang['update_successful'] 		 	         = 'Account Information Successfully Updated';
$lang['update_unsuccessful'] 		 	     = 'Unable to Update Account Information';
$lang['delete_successful']               = 'User Deleted';
$lang['delete_unsuccessful']           = 'Unable to Delete User';

// Groups
$lang['group_creation_successful']  = 'Group created Successfully';
$lang['group_already_exists']       = 'Group name already taken';
$lang['group_update_successful']    = 'Group details updated';
$lang['group_delete_successful']    = 'Group deleted';
$lang['group_delete_unsuccessful'] 	= 'Unable to delete group';
$lang['group_name_required'] 		= 'Group name is a required field';

// Shop
$lang['account_creation_shop_assignment_error']  = 'Error while storing shop info of a user';

// Email Subjects
$lang['email_forgotten_password_subject']    = 'Forgotten Password Verification';
$lang['email_new_password_subject']          = 'New Password';
$lang['email_activation_subject']            = 'Account Activation';

// Product
$lang['product_creation_successful'] 	  	   = 'Product Successfully Created.';
$lang['product_creation_unsuccessful'] 	 	   = 'Unable to Create Product.';
$lang['product_creation_duplicate_product_name']   = 'Product Name Already Used or Invalid.';
$lang['product_creation_duplicate_product_code']   = 'Product Code Already Used or Invalid.';

//customer
$lang['customer_creation_duplicate_card_no']       = 'Card No Already Used or Invalid.';

//purchase
$lang['add_purchase_order_duplicate_purchase_order_no']       = 'Order # already used or invalid.';

//Expense
$lang['add_expense_invalid_shop']       = 'Shop Id is invalid.';
$lang['add_expense_invalid_user']       = 'User Id is invalid.';
$lang['add_expense_success']       = 'Expense is added successfully.';