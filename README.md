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


# Plugin Deploy to WordPress.org
We are using the 10up Plugin Deploy action to automate the deployment from GitHub to the WordPress Plugin SVN repository. The quick deployment procedure is given below:
* you have to list down the file's location in the .distignore file if you want to exclude it from the plugin zip file.
* commit your changes and create a tag then push it to git.
* the deployment process will start after pushing any tag and you can check it from the action tab of Git Hub.
* for more details please check the official doc [here](https://github.com/10up/action-wordpress-plugin-deploy?tab=readme-ov-file#wordpressorg-plugin-deploy)