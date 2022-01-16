# Install Site on local
1. **git clone https://github.com/guptahemant/insta-clone.git**
2. " **composer install** " will download all require files and modules.
3. install and do all site setup through browser.
4. "**drush updb**" will install all recent updates if their are some.
5. "**drush cim** " will import the configuration.
6. look at *Frontend* section for **frontend setup**.

# Install site through existing config
1. drush si --existing-config
 
# Before taking fresh pull
1. In your **feature branch** check all current changes work is been **commited**.
2. do drush config export and add commit it.
3. " **drush cex** " - to export configuration .
4. After that switch to main branch to do next step.

# Taking pull of fresh code 
In your main branch perform "**git pull**".
1. "**git pull**" - allows you to take fresh pull in your directory.
2. change your branch to your **feature branch** and perform :
  1. "**composer install** " - will install all modules and files required.
  2. " **drush updb** " - this command will update your database.
  3. " **drush cim** " - this command will import all the configuaration to the site.
3. look at *Frontend* section for **frontend setup**.

# Before uploading code to github

1. check that your **main branch** contains new code.
2. do configuraton export - "**drush cex**".
3.**commit all** code and changes with the new **configuration exported** to your **feature branch**.
4. **push** all changes to **feature branch**.
5. create a **pull request** and ask fellow teammates to **review the changes**.

# Frontend
1. switch your directory to **web/themes/custom/instagram** and run " **npm install** ".
2. **npm install** - will download all require node modules to perform further task on sites. **eg: gulp , sass**
3. run " **gulp sass** " this command will compile the sass file in the css and will create a **css file** which contains all the css we needed for the site.
    ("Do Not forget to clear the cache if any of the css is missing to load - '**drush cr**' ").
  
# Default content module

1. This modules helps to **import/export** content of our site.
2. To **Export** new content on the site

  **EXPORT NODE** : " **drush dcer node --folder=modules/custom/demo_con/content** "

  **EXPORT MEDIA** : " **drush dcer media --folder=modules/custom/demo_con/content** "

  **EXPORT FILE** : " **drush dcer file --folder=modules/custom/demo_con/content** "

  **EXPORT BLOCK** : "**drush dcer block_content --folder=modules/custom/demo_con/content** "

  **EXPORT MENU** : " **drush dcer menu_link_content --folder=modules/custom/demo_con/content** "

  **EXPORT TAXONOMY** : " **drush dcer taxonomy_term --folder=modules/custom/demo_con/content** "

3. This will add all the needed content in your custom module content folder.

4. To **Import** new content on the site

    1.simply install the **demo_con** module and all the content will be imported.
    
    2.if problem arises with similar key **delete all previous content** from the database table.
