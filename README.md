# Pimcore Swiss Army Knife
## Components
### Classes migration tool
MigrateCommit will export all Pimcore classes and fieldcollections, and put them into their respective folders (data/classes, data/fieldcollections) as json files.

MigrateCheckout will remove all classes from Pimcore and recreate them from json files created by MigrateCommit (don't worry, it wouldn't affect your data, nevertheless i would recommend testing this on dev environment. Also - remember to do your backups before deploying your classes to production!) 

Upon install composer will put nice shortcuts for you. Use:
```
vendor/bin/dump-structure
vendor/bin/restore-structure
```
To dump or restore classes

(not yet implemented) Also you can use
```
vendor/bin/install-hooks
```
to automatically do the dump/restore procedures with ```git commit``` and ```git checkout``` respectively

Hooks are designed to run on the machine that runs Pimcore. If you're using virtual machines for developing, make sure to use git in these machines! If you're not sure, run migration scripts manually.
#### WARNING
Although they're rather simple, I do not guarantee those scripts to work, there may be some bugs which could cause **data loss** (feel free to post issues or fork and create pull requests).

__Always make backups before deploying you application.__

__Always test your solution on test/staging env before deploying.__

### Users migration tool
Files:
```
src/userExport.php
src/userImport.php
```
Scripts for exporting/importing users information. Sql file with tables containg user data will be placed in data/users folder.

### Asset's folders migration tool

Files:
```
src/FolderExport.php
src/FolderImport.php
```
Scripts for exporting/importing asset's folder structure. Txt file with folders structure will be placed in data/folders folder.

# Second and most important warning
Those scripts are meant to be used only on dev environments. Output files may contain sensitive data! If you want to use those scripts on production environment **make sure that folder data/ and it's conents are unaccessible (use .htaccess or nginx configuration).**
