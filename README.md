<img src="https://i.imgur.com/0Ew9b1K.png" height="100"/><br/>

[![Build Status](https://travis-ci.org/PicVid/picvid-core.svg?branch=master)](https://travis-ci.org/PicVid/picvid-core)
[![Maintainability](https://api.codeclimate.com/v1/badges/c8946e69e8da6078c00e/maintainability)](https://codeclimate.com/github/PicVid/picvid-core/maintainability)
[![Coverage Status](https://coveralls.io/repos/github/PicVid/picvid-core/badge.svg?branch=master)](https://coveralls.io/github/PicVid/picvid-core?branch=master)

PicVid ist eine Web-Anwendung zur Verwaltung von Bildern und Videos auf dem eigenen Server. Die ursprüngliche Version 
vom September 2012 wurde in einem Schulprojekt zur Ausbildung (Fachinformatiker für Anwendungsentwicklung) entwickelt. 
In dieser Version war das Sharing von Bildern und Videos über verschiedene Shortcodes möglich. Auch die Verwaltung der 
Web-Anwendung selbst konnte über einen Backend-Bereich vorgenommen werden.

## Ausblick
Dieses Projekt befindet sich aktuell in der Überarbeitung. In einer neuen Version soll der Funktionsumfang nur auf 
Bilder beschränkt werden. Diese sollen über PicVid wieder hochgeladen und verwaltet werden können.

## Voraussetzungen

- PHP 7.1 oder PHP 7.2
- MySQL oder PostgreSQL

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
Quelltextes) eingesetzt. Die dabei automatisch erstellten Informationen finden Sie nachfolgend:

- [Website](https://picvid.de)
- [PhpMetrics](https://picvid.de/docs/phpmetrics)
- [phpDox](https://picvid.de/docs/phpdox/api)

### Erstellen der Dokumentation

**PHPUnit**: `"vendor/bin/phpunit" -c phpunit.xml`  
**PhpMetrics**: `"vendor/bin/phpmetrics" --config=phpmetrics.json ./src`  
**phpDox**: `"vendor/bin/phpdox" -f phpdox.xml`  
**PHPLOC**: `"vendor/bin/phploc" --log-xml docs/logs/phploc.xml ./src`  
**PHPCS**: `"vendor/bin/phpcs" --standard=phpcs.xml`