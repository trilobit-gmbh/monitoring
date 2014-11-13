[![Latest Version on Packagist](http://img.shields.io/packagist/v/cliffparnitzky/monitoring.svg?style=flat)](https://packagist.org/packages/cliffparnitzky/monitoring)
[![Installations via composer per month](http://img.shields.io/packagist/dm/cliffparnitzky/monitoring.svg?style=flat)](https://packagist.org/packages/cliffparnitzky/monitoring)
[![Installations via composer total](http://img.shields.io/packagist/dt/cliffparnitzky/monitoring.svg?style=flat)](https://packagist.org/packages/cliffparnitzky/monitoring)

Contao Extension: Monitoring
============================

<img align="right" width="200" height="200" src="https://raw.githubusercontent.com/ContaoMonitoring/documentation/master/logo/ContaoMonitoring_Logo_200x200.png">

Monitoring extension for checking availability of websites.


Installation
------------

The extension is not published in contao extension repository.
Install it manually or via [composer](https://packagist.org/packages/cliffparnitzky/monitoring).


Tracker
-------

https://github.com/ContaoMonitoring/monitoring/issues


Compatibility
-------------

- min. version: Contao 3.0.x
- max. version: Contao 3.3.x


Dependency
----------

- This extension is dependent on the following extensions: [[MultiColumnWizard]](https://contao.org/en/extension-list/view/MultiColumnWizard.html)


Example for additional info fields
----------------------------------

Add this to your `system/config/localconfig.php`:

    $GLOBALS['TL_CONFIG']['monitoringAdditionalInfoFields'] = 'a:15:{i:0;a:2:{s:8:"category";s:9:"actuality";s:4:"name";s:18:"Extensions aktuell";}i:1;a:2:{s:8:"category";s:9:"actuality";s:4:"name";s:14:"System aktuell";}i:2;a:2:{s:8:"category";s:7:"contact";s:4:"name";s:14:"Kontakt Person";}i:3;a:2:{s:8:"category";s:7:"contact";s:4:"name";s:24:"Kontakt Person - Telefon";}i:4;a:2:{s:8:"category";s:7:"contact";s:4:"name";s:23:"Kontakt Person - E-Mail";}i:5;a:2:{s:8:"category";s:6:"contao";s:4:"name";s:39:"Paketmanager &#40;ER oder Composer&#41;";}i:6;a:2:{s:8:"category";s:6:"contao";s:4:"name";s:35:"Composer Stastic Client installiert";}i:7;a:2:{s:8:"category";s:6:"contao";s:4:"name";s:16:"CCA Patch Nummer";}i:8;a:2:{s:8:"category";s:11:"maintenance";s:4:"name";s:21:"Integrity-Check aktiv";}i:9;a:2:{s:8:"category";s:11:"maintenance";s:4:"name";s:22:"Datenbank Backup aktiv";}i:10;a:2:{s:8:"category";s:11:"maintenance";s:4:"name";s:28:"Durch echten CRON getriggert";}i:11;a:2:{s:8:"category";s:6:"system";s:4:"name";s:6:"Hoster";}i:12;a:2:{s:8:"category";s:6:"system";s:4:"name";s:14:"Apache Version";}i:13;a:2:{s:8:"category";s:6:"system";s:4:"name";s:11:"PHP Version";}i:14;a:2:{s:8:"category";s:6:"system";s:4:"name";s:13:"MySQL Version";}}';