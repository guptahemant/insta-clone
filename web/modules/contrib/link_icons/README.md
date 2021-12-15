# CONTENTS OF THIS FILE

- Introduction
- Requirements
- Installation
- Configuration
- Troubleshooting
- FAQ
- Maintainers
- Thanks

## INTRODUCTION

The Link Icons module is a field formatter for the Link field to display an
icon for the service being linked to - ex. Facebook, Twitter or LinkedIn, with
various display options available as settings of the formatter. The icons
themselves are provided from the Font Awesome project.

Services/icons currently supported, via the Link Icons Brands sub-module, are:

- 500px
- Acast
- Airbnb
- Amazon
- AngelList
- Apple
- Audible
- Bandcamp
- Behance
- Bitbucket
- Blogger
- Codepen
- Dailymotion
- Delicious
- DeviantArt
- Digg
- Dribbble
- Dropbox
- Drupal
- eBay
- Etsy
- Facebook
- Flickr
- Font Awesome
- Foursquare
- freeCodeCamp
- Grav
- Github
- Google
- Google Chrome
- Google Drive
- Google Play
- Google Plus
- IMDb
- Instagram
- iTunes
- Joomla
- JSFiddle
- Kickstarter
- last.fm
- LinkedIn
- Linode
- Medium
- Meetup
- Mixcloud
- Napster
- Paypal
- Periscope
- Pinterest
- Product Hunt
- Quora
- Ravelry
- Reddit
- Sellcast
- Skype
- Slack
- Slideshare
- Snapchat
- Soundcloud
- Spotify
- Stack Exchange
- Stack Overflow
- Steam
- StumbleUpon
- Telegram
- Tripadvisor
- Tumblr
- Twitch
- Twitter
- Viadeo
- Vimeo
- Vine
- Wikipedia
- WordPress
- WPExplorer
- Xing
- Yahoo
- Yelp
- YouTube

A navy generic globe icon is used if a link URL does not have one of the
hostnames above.

- For a full description of the module, [visit the project page](https://drupal.org/project/link_icons).
- To submit bug reports and feature suggestions, or to track changes,
  [use the issues forum](https://drupal.org/project/issues/link_icons).

## REQUIREMENTS

The link field module, obviously, and the Font Awesome module that adds the FA
project to Drupal allowing the icons to be displayed:

- [Link](https://drupal.org/project/link)
- [Font Awesome](https://drupal.org/project/fontawesome) (at least version 7.x-2.6/8.x-2.x)

Don't forget to add/upgrade to the latest version of Font Awesome in your
sites/all/libraries/fontawesome directory.

## INSTALLATION

Install as you would normally install a contributed drupal module. Further
information is available for:

- [Drupal 7](https://www.drupal.org/docs/7/extend/installing-modules)
- [Drupal 8](https://www.drupal.org/docs/extending-drupal/installing-modules)

Optionally, enable the link\_icons\_brands sub-module, to import service
configurations for many online brands that have Font Awesome icons.

## CONFIGURATION

- Just head to a content type display management tab
  (ex. <http://yoursite.com/admin/structure/types/manage/yourtype/display>) where
  you have a link field/fields. In the format column for the link field that
  you want to use this formatter, select the 'Service icon (with options)'
  format, and save the form to put it into use.
- Click the settings cog/gear button to view and edit the (hopefully)
  self-explanatory options for how the links should be displayed. These exploit
  many of the
  [Font Awesome styling features](https://fontawesome.com/how-to-use/on-the-web/styling).
- To customise the icons further, just theme your pages as usual. With the
  icons rendered as text characters using Font Awesome, you can style them with
  CSS as you wish.
- To customise which hostnames result in which icons being used (including the
  colour, HTML class and more), use the services configuration page (ex.
  <http://yoursite.com/admin/config/search/link_icon_services>) to add, modify
  and remove service configurations. See the module help page for explanations
  of each service configuration field (ex.
  <http://yoursite.com/admin/help/link_icons>).

## TROUBLESHOOTING

- Try clearing all your caches using the performance configuration page should
  you encounter any issues.
- Edit the settings for the problematic field, using the cog/gear button, to
  flush out any invalid settings from previous versions of this module.
- Don't forget to add/upgrade to the latest version of Font Awesome in your
  sites/all/libraries/fontawesome directory.

## FAQ

None, yet?

## MAINTAINERS

- [Dave Nattriss](http://natts.com) [(natts)](https://www.drupal.org/u/natts3)

## THANKS

Thanks to [Honza Pobořil](https://honza.poboril.cz/)
[(Bobík)](https://www.drupal.org/u/bobik) who published [a sandbox project](https://drupal.org/sandbox/bobik/1914102)
which was the starting point for this module.

The icons are from [the Font Awesome project](https://fontawesome.com/), by
[Greg Loucas](https://twitter.com/gregoryLpau) and [Dave Gandy](https://github.com/davegandy).

The font has been made available to Drupal in the fontawesome module by [Rob
Loach](https://robloach.net) [(RobLoach)](https://www.drupal.org/u/robloach)
and [Inder Singh](http://www.indersingh.com/) [(inders)](https://www.drupal.org/u/inders).

