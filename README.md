# Before taking fresh pull
1. check all current changes work is been commited.
2. do drush config export and add commit it.

# Taking pull of fresh code 
1. git pull - allows you to take fresh pull in your directory.
2. change your branch to your feature branch and perform :
1. composer install 
2. drush cim, drush updb
3. change your directory to insta-clone/web/themes/custom/instagram and run " npm install "

# Before uploading code to github

1. check that your main branch contains new code.
2. do configuration import
3. commit all code and changes with the new configuration imported to your feature branch.
4. push all changes to feature branch
5. create a pull request and ask fellow teammates to review the changes.

# Default content module

1. This modules helps to import/export content of our site.
2. To Export new content on the site

  EXPORT NODE : " drush dcer node --folder=modules/custom/demo_con/content "

  EXPORT MEDIA : " drush dcer media --folder=modules/custom/demo_con/content "

  EXPORT FILE : " drush dcer file --folder=modules/custom/demo_con/content "

  EXPORT BLOCK : "drush dcer block_content --folder=modules/custom/demo_con/content "

  EXPORT MENU : " drush dcer menu_link_content --folder=modules/custom/demo_con/content "

  EXPORT TAXONOMY : " drush dcer taxonomy_term --folder=modules/custom/demo_con/content "

3. This will add all the needed content in your custom module content folder.

4. To Import new content on the site

    1.simply install the demo_con module and all the content will be imported.
    
    2.if problem arises with similar key delete all previous content from the database table.
