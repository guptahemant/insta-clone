# Link Icons module change log

## Link Icons 3.0.3

- Fixed hostname for Wikipedia service configuration

## Link Icons 3.0.2

- Fixed [issue #3185448](https://www.drupal.org/project/link_icons/issues/3185448):
  missing config_export property in LinkIconService entity, by mistermoper

## Link Icons 3.0.1

- Fixed version number of brands configuration database update
- Refactored brands configuration database updates with a helper function
  for reuse
- Added brand service configuration database updates from v3.0.0

## Link Icons 3.0.0

- Branched to Composer-style semantic version numbering
- Replaced CHANGELOG.txt with Markdown formatted CHANGELOG.md
- Fixed HTML formatting in help page
- Added composer.json configuration file
- Replaced README.txt with Markdown formatted README.md, with various updated
  URLs and wording
- Fixed [issue #3127988](https://www.drupal.org/project/link_icons/issues/3127988):
  installation error, patch by akalam
- Added links to issue fixes in CHANGELOG.md
- Fixed [issue #3127987](https://www.drupal.org/project/link_icons/issues/3127987):
  coding standards, patch by shaktik
- Fixed [issue #3127986](https://www.drupal.org/project/link_icons/issues/3127986):
  Drupal 9 readiness core\_version\_requirement, patch by shaktik
- Fixed HTML formatting in install message
- Fixed [issue #3147935](https://www.drupal.org/project/link_icons/issues/3147935):
  automated Drupal 9 compatibility fixes, patch by Project Update Bot
- Fixed [issue #3175394](https://www.drupal.org/project/link_icons/issues/3175394):
  duplicate 'icon' key in Twitter configuration
- Drupal 9 compatibility Url deprecation fixes
- Declaration of protected variables
- Fixed how the services configuration is got before rendering the link
- Fixed return value in service configuration form save()
- Added Drupal 9 readiness core\_version\_requirement to link\_icons\_brands
- Moved brands YML configurations to config/optional so that new service
  configurations will be added instead of attempting to be replaced
- Added new (first/default) text formatting option to use the link URL if
  there is no link title
- Added new text formatting setting to hide the scheme (https://, http://,
  mailto:, tel: etc.) if the URL is used in the text
- Added generic icon formatting for mailto: URLs to use the envelope (or
  envelope-square) icon, as these don't have a hostname to filter on
- Added generic icon formatting for tel: URLs to use the phone (or
  phone-square) icon, as these don't have a hostname to filter on
- Added new brand service configurations, with brands module configuration
  update function, for:
  - Acast
  - Airbnb
  - Audible
  - Blogger
  - Dailymotion
  - eBay
  - iTunes
  - Kickstarter
  - Mixcloud
  - Napster
  - Periscope
  - Skype
  - Slack
- Updated brand service configurations for:
  - Bitbucket
  - Facebook
  - Pinterest
- Added square and circle icons (if available) to preview column in the service
  entities list configuration page

## Link Icons 8.x-2.1

- Added installation thanks and help messages
- Updated README.txt with new FontAwesome styling docs URL
- Fixed [issue #3127768](https://www.drupal.org/project/link_icons/issues/3127768):
  Empty $service ID throws error
- Fixed [issue #3127781](https://www.drupal.org/project/link_icons/issues/3127781):
  Extra comma causes WSOD
- Fixed [issue #3127787](https://www.drupal.org/project/link_icons/issues/3127787):
  Count warning when passing NULL

## Link Icons 8.x-2.0

- Created a services configuration page to allow creation, modification and
  removal of the services that are populated with specific icons, colours,
  classes etc., available at /admin/config/search/link\_icon\_services
- Module help page updated to link to and explain the new services
  configuration page
- Link to the services configuration page added to /admin/modules page
- Added a link\_icons\_brand submodule, containing all the previous brand
  service configurations, so that they can be optionally installed
- Updated Eercast service to Sellcast
- Added Google Drive service configuration
- Updated README.txt with additional installation and configuration
  instructions

## Link Icons 8.x-1.1

- Added CHANGELOG.txt
- Drupal coding standard fixes/comments etc.

