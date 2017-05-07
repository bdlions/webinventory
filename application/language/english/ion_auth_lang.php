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
$lang['shop_create_successful']                     = 'Shop created successfully.';
$lang['account_creation_shop_assignment_error']     = 'Error while storing shop info of a user';
$lang['shop_creation_duplicate_shop']               = 'Shop Already Used or Invalid.';
$lang['shop_update_duplicate_shop']                 = 'Shop Already Used or Invalid.';
$lang['shop_update_successful']                     = 'Shop is updated successfully.';

// Email Subjects
$lang['email_forgotten_password_subject']    = 'Forgotten Password Verification';
$lang['email_new_password_subject']          = 'New Password';
$lang['email_activation_subject']            = 'Account Activation';
$lang['email_registration_success_subject']            = 'Account Registered';

// Product
$lang['product_size_creation_successful']                           = 'Product Size Successfully Created.';
$lang['product_size_creation_unsuccessful']                         = 'Unable to Create Product Size.';
$lang['product_size_creation_duplicate_product_size']               = 'Product Size Already Used or Invalid.';
$lang['product_size_update_successful']                             = 'Product Size is Updated Successfully.';
$lang['product_size_update_duplicate_size']                         = 'Product Size Already Used or Invalid.';
$lang['product_size_delete_fail_size_exists']                       = 'Failed to delete product size. Product size is used.';
$lang['product_size_delete_fail']                                   = 'Failed to delete product size.';
$lang['product_size_delete_successful']                             = 'Product Size is deleted successfully.';

$lang['product_category1_creation_successful']                      = 'Sub Lot No Successfully Created.';
$lang['product_category1_creation_unsuccessful']                    = 'Unable to Create Sub Lot No.';
$lang['product_category1_creation_duplicate_product_category1']     = 'Sub Lot No Already Used or Invalid.';
$lang['product_category1_update_successful']                        = 'Sub Lot No is Updated Successfully.';
$lang['product_category1_update_duplicate_size']                    = 'Sub Lot No Already Used or Invalid.';
$lang['product_category1_delete_fail_category1_exists']             = 'Failed to delete Sub Lot No. Sub Lot No is used.';
$lang['product_category1_delete_fail']                              = 'Failed to delete Sub Lot No.';
$lang['product_category1_delete_successful']                        = 'Sub Lot No is deleted successfully.';

$lang['product_creation_successful'] 	  	   = 'Product Successfully Created.';
$lang['product_creation_unsuccessful'] 	 	   = 'Unable to Create Product.';
$lang['product_creation_duplicate_product_name']   = 'Product Name Already Used or Invalid.';
$lang['product_creation_duplicate_product_serial_no']   = 'Product Serial No Already Used or Invalid.';
$lang['product_update_duplicate_product_name']     = 'Product Name Already Used or Invalid.';
$lang['product_update_duplicate_product_serial_no']     = 'Product Serial No Already Used or Invalid.';
$lang['product_creation_duplicate_product_code']   = 'Product Code Already Used or Invalid.';
$lang['product_update_successful'] 	  	   = 'Product is Updated Successfully.';

//customer
$lang['customer_creation_duplicate_card_no']       = 'Card No Already Used or Invalid.';
$lang['customer_update_duplicate_card_no']         = 'Card No Already Used or Invalid.';

//purchase
$lang['add_purchase_order_duplicate_purchase_order_no']       = 'Order # already used or invalid.';

//Expense
$lang['add_expense_invalid_shop']           = 'Shop Id is invalid.';
$lang['add_expense_invalid_supplier']       = 'Supplier is invalid.';
$lang['add_expense_invalid_user']           = 'User is invalid.';
$lang['add_expense_success']                = 'Expense is added successfully.';
$lang['delete_expense_successful']          = 'Expense is removed successfully.';
$lang['delete_expense_unsuccessful']        = 'Error while deleting expense.';

//SMS
$lang['add_shop_sms_configuration']                         = 'SMS configuration is added successfully';
$lang['update_shop_sms_configuration']                      = 'SMS configuration is updated successfully.';
$lang['operator_create_successful']                         = 'Operator is created successfully.';
$lang['operator_creation_duplicate_operator']               = 'Operator Already Created or Invalid.';

//Attendance
$lang['store_attendance_successful']                         = 'Attendance successfully stored.';

//Institution
$lang['create_institution_successful']                         = 'Institution is created successfully.';
$lang['create_institution_unsuccessful']                       = 'Error while creating institution.';

//Profession
$lang['create_profession_successful']                         = 'Profession is created successfully.';
$lang['create_profession_unsuccessful']                       = 'Error while creating profession.';

//Message Category
$lang['create_message_category_successful']                   = 'Message category is created successfully.';
$lang['create_message_category_unsuccessful']                 = 'Error while creating message category .';
$lang['message_category_update_successful']                   = 'Message category is updated successfully.';

$lang['create_message_successful']                            = 'Message is created successfully.';
$lang['create_message_unsuccessful']                          = 'Error while creating message .';
$lang['message_update_successful']                            ='Message is updated successfully.';

$lang['create_supplier_message_successful']                   = 'Supplier Message is created successfully.';
$lang['create_supplier_message_unsuccessful']                 = 'Error while creating supplier message .';
$lang['message_supplier_update_successful']                   = 'Supplier Message is updated successfully.';

$lang['duplicate_phoneno']                   = 'Phone no Duplicate';

//Notebook massage
$lang['delete_notebook_message_fail']                         = 'Fail to delete message.';
$lang['delete_notebook_message_successful']                   = 'Message deleted successfully';

//Due collect
$lang['delete_due_collect_fail']                              = 'Fail to delete due collect.';
$lang['delete_due_collect_successful']                        = 'Due collect deleted successfully';