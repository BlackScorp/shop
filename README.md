# Disclaimer

Der nachfolgende Code ist nur für den Lernzweck gedacht und entspricht nicht dem Industriestandard. Wenn ihr einen Shop betreiben wollt, verwendet
einen fertigen Shop wie etwa https://www.shopware.com/de/ oder https://woocommerce.com/

Einige Episoden enthalten Bugs die beim Programmieren nicht direkt aufgefallen sind. Ein bekannter Bug ist die Handhabung der zufälligen UserId mit
random_int(). Ersetzt diese userId mit einem festen Wert statt mit der random_int() Funktion. In späteren Episoden wird dies sowieso gelöscht und es
wird keinen Gastzugang geben. Weitere bekannte Bugs können noch in der Wiki Seite aufgelistet werden.

https://github.com/BlackScorp/shop/wiki

# About

Hier siehst du den Code zu dem Projekt "Online Shop Tutorial". Der Code dient dazu, um die Grundlagen von PHP zu lernen. Er ist mit Absicht komplett
mit Funktionen aufgebaut. Das Ziel ist es aufzuzeigen wie ein PHP-Projekt strukturiert und aufgebaut ist. Dabei sollten schon einige grundlegenden
Prinzipien gezeigt werden.

Die Komplette Playlist findet man hier

https://www.youtube.com/watch?v=feU2eayQ8Ek&list=PLz858EFEcxiElOUr7b3Pql1CMHuVRYkTh

Ab Episode 33 kann man sich den Stand des Quellcodes in Form einer Zip-Datei herunterladen. Die Liste einzelner Episoden findest du hier

https://github.com/BlackScorp/shop/tags

# Installation

Die Installation soll so einfach wie möglich gehalten werden. Einfach den kompletten Ordner herunterladen, in den htdocs Ordner entpacken und die
install.sql in HeidiSQL oder PHPMyAdmin ausführen. Dann die *.example.php Dateien in den config Ordner kopieren und das .example aus den Dateinamen
entfernen und die definierten Werte ausfüllen.

Hier im Video ist es genauer gezeigt : https://www.youtube.com/watch?v=kCZf74EhLrE

# Hilfe

Hilfe und Support kriegst du aus Discord unter folgendem Link: https://discord.com/invite/2XkVqdJ  
Lies dir bitte dort die Nachricht im #willkommen Chat durch damit dir schnell geholfen werden kann

# Architektur

Alle Anfragen gehen an die index.php, welche wiederum eine routes.php einbindet und in dieser wird definiert, welche Aktion bei welcher URL ausgeführt
werden soll. Die Dateien mit dem richtigen Code stehen dann in dem /actions Ordner. Diese Actions werden nach dem EVA Prinzip von oben nach unten
abgearbeitet.

Ganz oben die Eingabe, dort werden alle Variablen zusammengesucht, danach kommt die Verarbeitung der Variablen und ganz zum Schluss wird ein Template
ausgegeben. Die Templates befinden sich im /templates Ordner und haben nur HTML Code mit den Variablen aus den jeweiligen Actions.

# Entwicklung

Welche Features kommen in das Projekt? Hier ist eine Liste der Features die ich noch einbauen will
https://github.com/BlackScorp/shop/projects

Ansonsten schau in den issues tab rein.
