<?php

/**
 * This line is required, it must contain the label for your unique username field (what users login with)
 */
$lang['bitauth_username']		= 'Gebruikersnaam';

/**
 * Password Complexity Labels
 */
$lang['bitauth_pwd_uppercase']		= 'Hoofdletters';
$lang['bitauth_pwd_number']		= 'Getal';
$lang['bitauth_pwd_special']		= 'Speciale tekens';
$lang['bitauth_pwd_spaces']		= 'Spaties';

/**
 * Login Error Messages
 */
$lang['bitauth_login_failed']		= 'Ongeldige wachtwoord';
$lang['bitauth_user_inactive']		= 'U moet dit account te activeren voordat u kunt inloggen.';
$lang['bitauth_user_locked_out']	= 'U bent geblokkeerd voor % s minuten voor te veel mislukte inlogpogingen, Probeer het later opnieuw.';
$lang['bitauth_pwd_expired']		= 'Uw wachtwoord is verlopen.';

/**
 * User Validation Error Messages
 */
$lang['bitauth_unique_username']	= 'De gebruikersnaam moet uniek zijn.';
$lang['bitauth_password_is_valid']	= 'Uw wachtwoord voldoet aan de gevraagde eisen: ';
$lang['bitauth_username_required']	= 'Gebruikersnaam is verplicht.';
$lang['bitauth_password_required']	= 'Wachtwoord is verplicht.';
$lang['bitauth_passwd_complexity']	= 'Wachtwoord voldoet niet aan de eisen';
$lang['bitauth_passwd_min_length']	= 'Wachtwoord moet minstens% d tekens bevatten.';
$lang['bitauth_passwd_max_length']	= 'Wachtwoord mag niet langer zijn dan% d tekens.';

/**
 * Group Validation Error Messages
 */
$lang['bitauth_unique_group']		= 'Het% s veld moet uniek zijn.';
$lang['bitauth_groupname_required']	= 'Groepsnaam is vereist.';

/**
 * General Error Messages
 */
$lang['bitauth_instance_na']		= "BitAuth kon de instantie CodeIgniter krijgen.";
$lang['bitauth_data_error']		= 'Wijzig de naam van het veld:% s';
$lang['bitauth_enable_gmp']		= 'U moet php_gmp activeren.';
$lang['bitauth_user_not_found']		= 'Gebruiker niet gevonden:% d';
$lang['bitauth_activate_failed']	= 'Kan gebruiker niet activeren met deze activeringscode.';
$lang['bitauth_expired_datatype']	= '$user moet een array of een object in Bitauth :: password_expired()';
$lang['bitauth_expiring_datatype']	= '$user moet een array of een object in Bitauth zijn::password_almost_expired()';
$lang['bitauth_add_user_datatype']	= '$data moet een array of een object in Bitauth zijn::add_user()';
$lang['bitauth_add_user_failed']	= 'Het toevoegen van gebruiker mislukt, stel uw beheerder op de hoogte.';
$lang['bitauth_code_not_found']		= 'Activeringscode niet gevonden.';
$lang['bitauth_edit_user_datatype']	= '$data moet een array of een object in Bitauth zijn::update_user()';
$lang['bitauth_edit_user_failed']	= 'Updaten gebruiker mislukt,stel uw beheerder op de hoogte.';
$lang['bitauth_del_user_failed']	= 'Gebruiker niet wissen, stel uw beheerder op de hoogte.';
$lang['bitauth_set_pw_failed']		= 'Niet in staat om het wachtwoord in te stellen, stel uw beheerder op de hoogte.';
$lang['bitauth_no_default_group']	= 'Standaard groep werd ofwel niet genoemd of niet gevonden, stel uw beheerder op de hoogte.';
$lang['bitauth_add_group_datatype']	= '$data moet een array of een object in Bitauth zijn::add_group()';
$lang['bitauth_add_group_failed']	= 'Het toevoegen van de groep is mislukt, stel uw beheerder op de hoogte.';
$lang['bitauth_edit_group_datatype']    = '$data moet een array of een object in Bitauth zijn::update_group()';
$lang['bitauth_edit_group_failed']	= 'Updaten groep kan niet, stel uw beheerder op de hoogte';
$lang['bitauth_del_group_failed']	= 'Het verwijderen van groep kan niet, stel uw beheerder op de hoogte';
$lang['bitauth_lang_not_found']		= 'De gekozen taal is niet gevonden!';
