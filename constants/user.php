<?php
    define('ADMIN', 'admin');
    
    define('MANAGER', 'manager');
    define('MANAGER_LOGIN_URI', 'user/manager_login');
    define('MANAGER_LOGIN_TEMPLATE', 'templates/login_tmpl');
    define('MANAGER_LOGIN_VIEW', 'manager/login');
    define('MANAGER_LOGIN_SUCCESS_URI', 'user/manager_login');
    define('MANAGER_LOGIN_SUCCESS_TEMPLATE', 'templates/manager_tmpl');
    define('MANAGER_LOGIN_SUCCESS_VIEW', 'manager/home');
    
    define('STAFF', 'staff');
    define('STAFF_LOGIN_URI', 'user/staff_login');
    define('STAFF_LOGIN_TEMPLATE', 'templates/login_tmpl');
    define('STAFF_LOGIN_VIEW', 'staff/login');
    define('STAFF_LOGIN_SUCCESS_URI', 'user/staff_login');
    define('STAFF_LOGIN_SUCCESS_TEMPLATE', 'templates/staff_tmpl');
    define('STAFF_LOGIN_SUCCESS_VIEW', 'staff/home');
    
    define('SALESMAN', 'salesman');
    define('CUSTOMER', 'customer');
    define('SUPPLIER', 'supplier');
    
    define('LOGIN_TEMPLATE', 'templates/login_tmpl');
    define('LOGIN_VIEW', 'login');
    define('LOGIN_URI', 'user/login');
    
    define("USER_GROUP_ADMIN",                                      1);
    define("USER_GROUP_MANAGER",                                    2);
    define("USER_GROUP_SALESMAN",                                   3);
    define("USER_GROUP_SUPPLIER",                                   4);
    define("USER_GROUP_CUSTOMER",                                   5);
    define("USER_GROUP_STAFF_ID",                                   6);
    
    define("ACCOUNT_STATUS_ACTIVE",                                   1);
    define("ACCOUNT_STATUS_INACTIVE",                                 2);
    define("ACCOUNT_STATUS_SUSPENDED",                                3);
    define("ACCOUNT_STATUS_DEACTIVATED",                              4);
    define("ACCOUNT_STATUS_BLOCKED",                                  5);
?>