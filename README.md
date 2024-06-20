Inokufu Search - Local Services Plugin for the Moodle™ platform
=================================

The Inokufu Search - Local Services Plugin for the Moodle™ platform is part of the set of plugins to integrate Inokufu Search into your Moodle™ platform. 
This set also includes:
- [Inokufu Search - Repository plugin for the Moodle™ platform](https://github.com/inokufu/moodle-repository_inokufu), 
- [Inokufu Search - TinyMCE plugin for the Moodle™ platform](https://github.com/inokufu/moodle-tinymce_inokufu). 
- [Inokufu Search - Atto Plugin for the Moodle™ platform](https://github.com/inokufu/moodle-atto_inokufu). 

This plugin enable users to interact with our [Learning Object API](https://gateway.inokufu.com/) from other plugins of their Moodle™ platform, by centralizing the API endpoints.
This documentation will guide you through the installation and usage of the plugin.

Please find a French version of this documentation [here](./README.fr.md).

## Installation

### Installation from ZIP
1. Download the plugin zip file from this GitHub repository.
2. Log in to your Moodle site as an administrator.
3. Navigate to `Site administration > Plugins > Install plugins`.
4. Upload the zip file you downloaded from this GitHub repository and follow the on-screen instructions.
5. Complete and confirm the forms to finish the plugin installation.

### Installation from sources
1. Establish an SSH connection to your Moodle instance.
2. Clone the source files from this GitHub repository directly into your Moodle source files.
3. Rename the cloned folder to `inokufu`.
4. Move the `inokufu` folder into the `local` directory of your Moodle installation. Ensure that the plugin folder is named `inokufu`.
5. Open the folder in a terminal.
6. Install the Composer dependencies (you will need to [install Composer](https://getcomposer.org/download/) if you don't have it yet).
```sh
composer install
```
7. Log in to your Moodle site as an administrator.
8. Navigate to `Site administration > Notifications` to finalize the plugin installation.

## Configuration
1. After a successful installation, you should be prompted to fulfill the original configuration for the plugin (including you API key). You can still access this menu from `Site administration > Plugins > Local plugins > Inokufu Services`.
2. Save changes, and start using our plugin.

**Note:** An API Key is required in order to use this plugin. To obtain an API Key, please refer to the [Inokufu APIs Gateway](https://gateway.inokufu.com/) section or contact [Inokufu Support](https://support.inokufu.com/).


## Usage
**Note:** This use case is only needed for creating new plugins, the other ones from our `Inokufu Search for Moodle` set are already configured with this.

1. To call this plugin from another one, you'll need to import the `externallib` library from Moodle.
```php
require_once ($CFG->libdir . '/externallib.php'); 
```
2. Then, you can simply call the needed services using the following syntax:
```php
$result = external_api::call_external_function(
    'my_function_name', 
    ['params' => $params],  // We expect $params to be an associative array
    null                    // To use the current context
);
```
You can see all functions available from `Site administration > Server > Web services > External Services` and then by selecting `Functions` on the `local_inokufu` line.

3. The returned format varies from function to function, but Moodle gives you at least some general fields to see if the call was successful or not:
```php
if (isset($result['error']) && !$result['error'] && isset($result['data'])) {
    // No errors, data in in the 'data' key
    return $result['data'];
} else if (isset($result['exception'])) {
    // Error, details are in the 'exception' key
    throw new Exception(json_encode($result['exception']));
} else {
    // Unsupported error
    throw new Exception('Unsupported error' . json_encode($result));
}
```
4. You can now access Inokufu's API data through another plugin.

## Troubleshooting
If you encounter any issues with the plugin, please check the following:
1. Ensure your Moodle site meets the minimum requirements for the plugin.
2. Verify that your API Key is correctly filled in, and valid.
3. Verify that the hostname used in the configuration page is valid (if any doubt, leave the field empty).
5. Check the Moodle log (`Site administration > Reports > Logs`) for any error messages related to the plugin.
6. If none of these steps helped, feel free to contact our [Inokufu Support](https://support.inokufu.com/).

## Support
For additional support or to report a bug, please visit the plugin's GitHub repository and open an `issue`. Be sure to include any relevant details, such as your Moodle version, plugin version, and a detailed description of the issue.