<?php
// Define the application environment taken from the server variable 'CI_ENV', default to 'development' if not set
define('ENVIRONMENT', $_SERVER['CI_ENV'] ?? 'development');

// Set error reporting and display based on the environment
switch (ENVIRONMENT) {
    case 'development': // In development environment, show all errors
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        break;
    case 'testing': // In testing and production environments, do not display errors
    case 'production':
        ini_set('display_errors', '0');
        // Report all errors except those that are explicitly excluded
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        break;
    default: // If the environment is not set correctly, show a server error and exit
        http_response_code(503);
        exit('The application environment is not set correctly.');
}

// Define the paths for system, application, and view folders
$system_path = realpath('system') ?: 'system';
$application_folder = realpath('application') ?: 'application';
$view_folder = realpath($application_folder . DIRECTORY_SEPARATOR . 'views') ?: $application_folder . DIRECTORY_SEPARATOR . 'views';

// Define constants for various paths used in the application
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME)); // The name of the current file
define('BASEPATH', $system_path . DIRECTORY_SEPARATOR); // The path to the system folder
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR); // The path to the front controller (this file)
define('SYSDIR', basename(BASEPATH)); // The name of the system folder
define('APPPATH', $application_folder . DIRECTORY_SEPARATOR); // The path to the application folder
define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR); // The path to the view folder

// Check if the system directory exists and is a directory, if not, show an error and exit
if (!is_dir(BASEPATH)) {
    http_response_code(503);
    exit('Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF);
}

// Include the main CodeIgniter file
require_once BASEPATH . 'core/CodeIgniter.php';
