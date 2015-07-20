# Pimcore Swiss Army Knife
## Components
### Classes migration tool
Files:
```
extra/shell/MigrateCheckout.php
extra/shell/MigrateCheckout.php
extra/hooks/post-checkout
extra/hooks/post-merge
install.sh
```
MigrateCommit will export all Pimcore classes and fieldcollections, and put them into their respective folders (extra/classes, extra/fieldcollections) as json files.

MigrateCheckout will remove all classes from Pimcore and recreate them from json files created by MigrateCommit (don't worry, it wouldn't affect your data, nevertheless i would recommend testing this on dev environment. Also - remember to do your backups before deploying your classes to production!) 

install.sh will copy hooks into .git directory, which would automatically run migration scripts on every commit/checkout/merge and add new/changed files to commit.

Hooks are designed to run on the machine that runs Pimcore. If you're using virtual machines for developing, make sure to use git in these machines! If you're not sure, run migration scripts manually.
#### WARNING
Although they're rather simple, I do not guarantee those scripts to work, there may be some bugs which could cause **data loss** (feel free to post issues or fork and create pull requests).

__Always make backups before deploying you application.__

__Always test your solution on test/staging env before deploying.__

### Users migration tool
Files:
```
extra/shell/userExport.php
extra/shell/userImport.php
```
Scripts for exporting/importing users information. Sql file with tables containg user data will be placed in extra/users folder.

### Asset's folders migration tool

Files:
```
extra/shell/FolderExport.php
extra/shell/FolderImport.php
```
Scripts for exporting/importing asset's folder structure. Txt file with folders structure will be placed in extra/folders folder.

# Second and most important warning
Those scripts are meant to be used only on dev environments. Output files may contain sensitive data! If you want to use those scripts on production environment **make sure that folder extra/ and it's conents are unaccessible (use .htaccess or nginx configuration).**
