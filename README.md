# Code Documentation

## File Structure
    .
    ├── ...
    ├── myaliceai               # Plugin Root Folder
    │   ├── .github             # Github action directory
    │   │    ├── .              # Github action files
    │   │    └── ...
    │   ├── .wordpress-org      # WordPress.org assets directory
    │   │    ├── .              # WordPress.org asset files
    │   │    └── ...
    │   ├── images              # plugin images directory
    │   │    ├── .              # plugin image files
    │   │    └── ...
    │   ├── includes            # plugin includes directory
    │   │    ├── index.php                                      # index file \\ Silence is golden.
    │   │    ├── myalice-activation-deactivation-register.php   # plugin activation and deactivation hook
    │   │    ├── myalice-dashboard-inline-styles.php            # all the CSS is written in this file
    │   │    ├── myalice-dashboard-templates-and-scripts.php    # admin template components like modal
    │   │    ├── myalice-enqueue-scripts.php                    # enque front-end script
    │   │    ├── myalice-helper-functions.php                   # all the helper function is written here
    │   │    ├── myalice-hooks.php                              # all hooks in one file
    │   │    ├── myalice-hooks-callback.php                     # all hooks callback in one file
    │   │    ├── myaliceai-dashboard.php                        # myalice dashboard page template and functionality
    │   │    └── ...
    │   ├── js                  # plugin js directory
    │   │    ├── .              # plugin js files
    │   │    └── ...
    │   ├── languages           # plugin languages directory
    │   │    ├── .
    │   │    └── ...
    │   ├── svg                 # plugin svg directory
    │   │    ├── .              # plugin svg files
    │   │    └── ...
    │   ├── .distignore         # distignore file for WPCLI
    │   ├── .gitattributes      # gitattributes file for github
    │   ├── .gitignore          # gitignore file to ignore the file from git
    │   ├── index.php           # index file \\ Silence is golden.
    │   ├── myaliceai.php       # main plugin file
    │   ├── README.md           # readme file for github
    │   ├── readme.txt          # readme file for WordPress.org
    │   └── uninstall.php       # uninstall file is automatically trigger when the plugin is deleted 
    └── ...