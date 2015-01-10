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
