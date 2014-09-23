<?php

/**
 * English Language File for the Users Module (users.en.lang.php)
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * User authentication
 */

$L['users_nameormail'] = 'Username or email';
$L['users_rememberme'] = 'Remember me';
$L['users_lostpass'] = 'Lost your password?';
$L['users_maintenance1'] = 'Site in maintenance mode';
$L['users_maintenance2'] = 'Access for admins and authorized groups only';
$L['users_loggedinas'] = 'You are logged in as';
$L['users_logoutfirst'] = 'If you want to log in with another account you have to log out first.';

/**
 * User registration
 */

$L['users_validemail'] = 'Valid email';
$L['users_validemailhint'] = '(A valid email is required to complete the registration process)';
$L['users_confirmpass'] = 'Confirm password';

$L['aut_contactadmin'] = 'Feel free to contact an administrator if you experience difficulties';
$L['aut_emailalreadyindb'] = 'The email you provided is already in the database';
$L['aut_emailbanned'] = 'This email (or this host) is banned, reason is: ';
$L['aut_emailtooshort'] = 'The email is not valid!';
$L['aut_invalidloginchars'] = 'The login contains invalid characters';
$L['aut_logintitle'] = 'Login form';
$L['aut_mailnoticetitle'] = 'Email transition';
$L['aut_passwordmismatch'] = 'The password fields do not match!';
$L['aut_passwordtooshort'] = 'The password must be at least 4 chars long and must consist of alphanumerical characters and underscore only.';
$L['aut_registersubtitle'] = '';
$L['aut_registertitle'] = 'Register a new member account';
$L['aut_regreqnoticetitle'] = 'New account request';
$L['aut_regrequesttitle'] = 'Registration request';
$L['aut_usernamealreadyindb'] = 'The user name you provided is already in the database';
$L['aut_usernametooshort']= 'The user name must be at least 2 chars long';

/**
 * User registration: messages
 */

$L['aut_regrequest'] = "Hi %1\$s,\n\nYour account is currently inactive, an administrator will need to activate it before you can log in. You will receive another email when this has occured.";

$L['aut_regreqnotice'] = "You are receiving this email because %1\$s requested a new account.\nThis user won't be able to login until you manually set the account as 'active', here:\n%2\$s";

$L['aut_emailreg'] = "Hi %1\$s,\n\nTo use your account you need to activate it with this link:\n%2\$s\n\nTo cancel the recently inactive membership use this link:\n%3\$s";

$L['aut_emailchange'] = "Hi %1\$s,\nTo change your recent email please use this activation link:\n%2\$s";

/**
 * User list
 */

$L['users_usersperpage'] = 'Users per page';
$L['users_usersinthissection'] = 'Users total';

$L['pro_emailandpass'] = 'You can not change both email and password at the same time';
$L['pro_passdiffer'] = 'The 2 password fields do not match';
$L['pro_passtoshort'] = 'The password must be at least 4 chars long and must consist of alphanumerical characters and underscore only.';
$L['pro_subtitle'] = 'Your personal account';
$L['pro_title'] = 'Profile';
$L['pro_wrongpass'] = 'You didn\'t enter your present password, or it\'s wrong';
$L['pro_invalidbirthdate'] = 'The birthdate is invalid.';

$L['useed_accountactivated'] = 'Account activated';
$L['useed_email'] = 'You are receiving this email because an administrator activated your account. You may now login using your username and password.';
$L['useed_subtitle'] = '&nbsp;';
$L['useed_title'] = 'Edit';

$L['use_allbannedusers'] = 'Users banned';
$L['use_allinactiveusers'] = 'Users inactive';
$L['use_allusers'] = 'All users';
$L['use_byfirstletter'] = 'Name starting by';
$L['use_subtitle'] = 'Registered members';
$L['use_title'] = 'Users';

$L['pasrec_title'] = 'Password recovery';
$L['pasrec_email1'] = "Hi %1\$s,\nYou may now reset your password using the link below:\n%2\$s\n\nAttention: if you did not request this password recovery email, please ignore it. IP of the requester is %3\$s, and the date and time of the request is %4\$s.";
$L['pasrec_email2'] = 'Your password has been reset as you requested. Please change it as soon as possible and delete this email. Your new password is';
$L['pasrec_explain1'] = 'Enter your email.';
$L['pasrec_explain2'] = 'You will receive an email with an emergency link. Click it to reset your password.';
$L['pasrec_explain3'] = 'Having confirmed twice your password reset request, you will receive a random password generated by the system.';
$L['pasrec_explain4'] = 'If you cleared the email field in your profile, you will not be able to recover your password. In this case please contact an administrator by email.';
$L['pasrec_mailsent'] = 'Done, please check your mailbox in a few minutes and click the emergency link. After that follow the instructions.';
$L['pasrec_mailsent2'] = 'Password reset complete. Please check your mailbox in few minutes to gather your new password.';
$L['pasrec_request'] = 'Request';
$L['pasrec_youremail'] = 'Your email: ';

/**
 * User details
 */

$L['users_sendpm'] = 'Send a private message';

/**
 * User profile & edit
 */

$L['users_id'] = 'User ID';
$L['users_hideemail'] = 'Always hide email address';
$L['users_pmnotify'] = 'PM notify';
$L['users_pmnotifyhint'] = '(Notify by email when there\'s a new private message)';
$L['users_newpass'] = 'Set a new password';
$L['users_newpasshint1'] = '(Leave empty to keep the current password)';
$L['users_newpasshint2'] = '(Enter your new password twice)';
$L['users_oldpasshint'] = '(To set a new password enter your current one)';
$L['users_lastip'] = 'Last known IP';
$L['users_logcounter'] = 'Log counter';
$L['users_deleteuser'] = 'Delete this user';
$L['users_changeemail'] = 'Change email';

/**
 * Moved from theme.lang
 */

$themelang['usersprofile_Emailpassword'] = 'Your current password';
$themelang['usersprofile_Emailnotes'] = '<p><b>Email transition process (if email transition is available and new email validation is required):</b></p><ol><li>You can\'t use your current email address</li><li>For security reasons you have to enter your current password</li><li>You should re-activate your account via email to prove the new email address is valid</li><li>Your account will be suspended until you use the validation link</li><li>Upon email validation your account will immediately become active again</li><li>Be careful while typing your new email address; you won\'t have a chance to change it later</li><li>Contact an administrator via email if you made a mistake.</li></ol><p><b>If new email validation is not required, the new email address will become effective immediately.</b></p>';

/**
 * Users full name display format
 */
$R['users_full_name'] = '{$firstname} {$lastname}';
