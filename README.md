# Roundcube-Plugin-Virtual-User-Mapping
Virtual User mapping multiple user logins for one account
  

Add in your config file:

```php
$config['virtualUserMapping'] = array(
  'REAL DOMAIN 1' => array(
    'REAL ACCOUNT 1' => array(
      'pass' => 'REAL ACCOUNT PASS',
        'users' => array(
          'VIRTUAL USER NAME 1' => 'VIRTUAL USER PASS 1',
          'VIRTUAL USER NAME 2' => 'VIRTUAL USER PASS 2',
            ...
          )
        ),
    'REAL ACCOUNT 2' => array(
      'pass' => 'REAL ACCOUNT 2 PASS',
      'users' => array(
        'VIRTUAL USER NAME 3' => 'VIRTUAL USER PASS 3 '
          ...
        )
      ),
      ...
    )
 );
 ```

Now you can login with "VIRTUAL USER NAME 1#REAL DOMAIN 1".
For example:

```php
$config['virtualUserMapping'] = array(
  'example123.com' => array(
    'sales.web99' => array(
      'pass' => 'imapSecretForRealAccountSales',
        'users' => array(
          'practicant' => 'reallyLongPassword',
          'teamleader' => 'anotherLongPassword',
            ...
          )
    ),
    'support.web99' => array(
      'pass' => 'anotherImapSecret',
      'users' => array(
        'jefe' => 'extremLongPasswordWithALotOfSpecialChars '
          ...
        )
      ),
      ...
    )
 );
 
 With a configuration like this you have following logins:


| User                             | Password             | Mapped to Real Account  |
| -------------------------------- |----------------------| ------------------------|
| practicant#sales@example123.com  | reallyLongPassword   | sales.web99             |
| teamleader#sales@example123.com  | anotherLongPassword  | sales.web99             |
| jefe#support@example123.com      | anotherLongPassword  | support.web99           |


Please note:
The "#" is used as a splitter between the virtual user name and the existing imap account name.

 
