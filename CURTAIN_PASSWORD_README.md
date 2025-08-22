# Curtain Password for Adminer

This implementation adds a "curtain password" protection layer to the Adminer database management tool.

## Features

- **Password Protection**: Requires authentication before accessing Adminer
- **Session Management**: Uses PHP sessions to maintain login state
- **Modern UI**: Clean, responsive login form with gradient background
- **Easy Configuration**: Simple password configuration via a single variable
- **Logout Options**: Provides both Adminer logout and "Exit Curtain" functionality
- **Minimal Changes**: Preserves all original Adminer functionality

## Default Configuration

- **Default Password**: `admin123`
- **Session Variable**: `$_SESSION['curtain_authenticated']`

## How to Change the Password

Edit the `$CURTAIN_PASSWORD` variable at the top of `index.php`:

```php
// Configuration - Change this password to secure your Adminer installation
$CURTAIN_PASSWORD = 'your_new_password_here';
```

## Usage

1. Navigate to your Adminer installation
2. Enter the curtain password when prompted
3. Access Adminer normally after authentication
4. Use "Exit Curtain" link in the footer to logout completely

## Security Notes

- The password is stored in plain text in the PHP file
- Consider using a strong, unique password
- Ensure your web server is configured securely
- The session timeout depends on your PHP session configuration

## Implementation Details

The curtain password is implemented as a wrapper around the existing Adminer code:

1. Session check at the beginning of the file
2. Login form display for unauthenticated users
3. Password verification and session management
4. Integration with Adminer's existing logout functionality

This approach ensures minimal impact on the original Adminer codebase while providing effective access control.