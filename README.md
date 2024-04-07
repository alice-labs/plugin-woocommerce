# Code Documentation

## File Structure
    .
    ├── ...
    ├── myaliceai               # Plugin Root Folder
    │   ├── .github             # Github action directory
    │   │    ├── .              # Github action files
    │   │    └── ...
    │   ├── .wordpress-org      # WordPress.org assets directory
    │   │    ├── .              
    │   │    └── ...
    │   ├── images              # plugin images directory
    │   │    ├── .              
    │   │    └── ...
    │   ├── includes            # plugin includes directory
    │   │    ├── .
    │   │    └── ...
    │   ├── js                  # plugin js directory
    │   │    ├── .
    │   │    └── ...
    │   ├── languages           # plugin languages directory
    │   │    ├── .
    │   │    └── ...
    │   ├── svg                 # plugin svg directory
    │   │    ├── .
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