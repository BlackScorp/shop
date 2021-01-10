# Disclaimer
Einige Episoden enthalten bugs die beim Programmieren nicht direkt aufgefallen sind. Ein bekannter bug ist die Handhabung der Zufälligen UserId mit random_int(). 
Ersetzt diesen userId mit einem festen Wert statt der random_int() Funktion, in späteren Episoden wird es sowieso gelöscht und es wird kein Gast Zugang geben.
Weitere bekannte bugs können noch in der Wiki Seite aufgelistet werden.

https://github.com/BlackScorp/shop/wiki

# About
Hier siehst du den Code zu dem Projekt "Online Shop Tutorial". Der Code dient dazu um die Grundlagen von PHP zu lernen. Es ist mit Absicht komplett mit Funktionen aufgebaut. 
Das Ziel ist es aufzuzeigen wie ein PHP Projekt strukturiert und aufgebaut ist. Dabei sollten schon einige Grundlegenden Prinzipien gezeigt werden.

Die Komplette Playlist findet man hier 

https://www.youtube.com/watch?v=feU2eayQ8Ek&list=PLz858EFEcxiElOUr7b3Pql1CMHuVRYkTh

Ab Episode 33 kann sich den Stand des Quellcodes in Form einer Zip Datei herunterladen. Die Liste einzelner Episoden findest du hier

https://github.com/BlackScorp/shop/tags


# Installation
Die installation soll so einfach gehalt werden wie möglich. Einfach den kompletten Ordner herunterladen in den htdocs Ordner entpacken und die install.sql im HeidiSQL oder PHPMyAdmin ausführen
Dann die *.example.php dateien im config ordner kopieren und das .example aus den Dateinamen entfernen und die definierten Werte ausfüllen.

Hier im Video ist es genauer gezeigt : https://www.youtube.com/watch?v=kCZf74EhLrE

# Hilfe
Hilfe und Support kriegst du im Discord unter folgendem Link: https://discord.com/invite/2XkVqdJ  
Lies dir bitte dort die Nachricht in #willkommen Chat durch damit dir schnell geholfen werden kann

# Architektur
Alle Anfragen gehen auf die index.php wiederum bindet eine routes.php und in der Routes php wird definiert welche Aktion bei welcher URL ausgeführt werden soll.
Die Dateien mit dem richtigen Code stehen dann in dem /actions Ordner. Diese Actions werden nach dem EVA Prinzip von Oben nach Unten abgearbeitet.

Ganz Oben die Eingabe, dort werden alle Variablen zusammengesucht, danach kommt die Verarbeitung der Variablen und ganz zum Schluss wird ein Template ausgegeben. 
Die Templates befinden sich im /templates Ordner und haben nur HTML Code mit den Variablen aus den jeweiligen Actions.

# Entwicklung
Welche Features kommen in das Projekt? 
Hier ist eine Liste der Features die ich noch einbauen will
https://github.com/BlackScorp/shop/projects

Ansonsten schau in den issues tab rein.
