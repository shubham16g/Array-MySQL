# ArrayMySQL

## Overview
ArrayMySQL is a lightweight PHP class that simplifies interactions with MySQL databases using MySQLi. It provides convenient methods for performing CRUD (Create, Read, Update, Delete) operations while using prepared statements for easier implementation.

> **Note:** This is a basic sample project and is not recommended for production use.

## Features
- Easy-to-use methods for inserting, updating, deleting, and selecting records.
- Supports pagination for large datasets.
- Uses prepared statements to prevent SQL injection.
- Error handling with meaningful exception messages.
- Provides utility functions for SQL query execution.

## Installation
Simply include the `ArrayMySQL.php` file in your project and instantiate the class with a valid MySQLi connection.

```php
require_once 'ArrayMySQL.php';

$mysqli = new mysqli("host", "user", "password", "database");
$db = new ArrayMySQL($mysqli);
```

## Usage
### Insert Data
```php
$db->insertSQL('users', ['name' => 'John Doe', 'email' => 'john@example.com']);
```

### Select Data
```php
$users = $db->selectSQL('users', '*', 'WHERE email = ?', ['john@example.com']);
print_r($users);
```

### Update Data
```php
$db->updateSQL('users', ['name' => 'John Smith'], 'WHERE email = ?', ['john@example.com']);
```

### Delete Data
```php
$db->deleteSQL('users', 'WHERE email = ?', ['john@example.com']);
```

### Count Rows
```php
$count = $db->countSQL('users', 'WHERE active = ?', [1]);
echo "Total active users: $count";
```

### Pagination
```php
$usersPage1 = $db->selectPageSQL('users', '*', 'WHERE active = ?', [1], 10, 1);
print_r($usersPage1);
```

## Error Handling
ArrayMySQL throws exceptions when an error occurs. You can catch them as follows:

```php
try {
    $db->insertSQL('users', ['name' => 'John Doe']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## License
This project is licensed under the MIT License.

## Author
Developed by Shubham Gupta

## Changelog
### Version 0.4 Beta (28 April 2021)
- Initial beta release
- CRUD operations implemented
- Error handling added
- Pagination support added


