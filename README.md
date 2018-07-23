<img src="https://github.com/PicVid/picvid-core/raw/master/resource/template/img/picvid-logo.png" height="100"/><br/>

[![Build Status](https://travis-ci.org/PicVid/picvid-core.svg?branch=master)](https://travis-ci.org/PicVid/picvid-core)
[![Maintainability](https://api.codeclimate.com/v1/badges/c8946e69e8da6078c00e/maintainability)](https://codeclimate.com/github/PicVid/picvid-core/maintainability)
[![Coverage Status](https://coveralls.io/repos/github/PicVid/picvid-core/badge.svg?branch=master)](https://coveralls.io/github/PicVid/picvid-core?branch=master)

PicVid ist eine Web-Anwendung zur Verwaltung von Bildern auf dem eigenen Server. Es können Bilder hochgeladen und
in einer Übersicht angezeigt werden. Sollten in einem Bild EXIF-Informationen vorhanden sein, können diese ebenfalls
angezeigt werden.

## Voraussetzungen

- PHP 7.1 oder PHP 7.2
- MySQL oder PostgreSQL

PicVid kann auch über Docker eingerichtet werden. Weitere Informationen findest du in 
[diesem Repository](https://github.com/PicVid/picvid-docker).

## Frameworks / Libraries

- [Animate.css](https://daneden.github.io/animate.css/)
- [Bootstrap 4](https://getbootstrap.com/)
- [Dropzone.js](http://www.dropzonejs.com/)
- [FontAwesome](https://fontawesome.com/)

## Externe Tools
Für die Entwicklung von PicVid werden verschiedene externe Tools eingesetzt um automatisiert verschiedene
Aufgaben auszuführen. Nachfolgend eine Liste aller verwendeten externen Tools:

- [Code Climate](https://codeclimate.com/github/PicVid/picvid-core)
- [Coveralls](https://coveralls.io/github/PicVid/picvid-core)
- [Travis-CI](https://travis-ci.org/PicVid/picvid-core)

## Unterstützung
- Du hast einen Fehler entdeckt? 
- Du vermisst eine Funktion / ein Feature? 
- Du möchtest die Entwicklung von PicVid unterstützen?

Einfach eine E-Mail an <a href="mailto:feedback@picvid.de">feedback@picvid.de</a> oder auf dem 
[Discord-Server](https://discord.gg/s9TuhWM) vorbeischauen. Fehler können auch direkt hier im Repository als 
Issue mitgeteilt werden.

## Dokumentation (Entwicklung)
Während der Entwicklung werden auch verschiedene Tools zur Erstellung von Metriken und Dokumentationen (auf Basis des
Quellcodes) eingesetzt. Die dabei automatisch erstellten Informationen findest du nachfolgend:

- [Website](https://picvid.de)
- [PhpMetrics](https://picvid.de/docs/phpmetrics)
- [phpDox](https://picvid.de/docs/phpdox/api)

### Erstellen der Dokumentation

**PHPUnit**: `"vendor/bin/phpunit" -c phpunit.xml`  
**PhpMetrics**: `"vendor/bin/phpmetrics" --config=phpmetrics.json ./src`  
**phpDox**: `"vendor/bin/phpdox" -f phpdox.xml`  
**PHPLOC**: `"vendor/bin/phploc" --log-xml docs/logs/phploc.xml ./src`  
**PHPCS**: `"vendor/bin/phpcs" --standard=phpcs.xml`