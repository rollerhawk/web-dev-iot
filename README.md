# Mini-IoT-Portal

[![Projektstatus](https://img.shields.io/badge/status-in%20Entwicklung-yellow)](https://github.com/dein-nutzername/mini-iot-portal)

## Projektvision

Das **Mini-IoT-Portal** ist eine webbasierte Anwendung zur Erfassung, Speicherung und Visualisierung von Sensordaten (z. B. Temperatur und Luftfeuchtigkeit). Ziel ist es, ein kompaktes Smart-Home-Dashboard zu simulieren, das typische IoT-Komponenten integriert und Studierenden einen praxisnahen Einblick in den gesamten Webentwicklungsprozess bietet.

## Inhaltsverzeichnis

1. [Projektübersicht](#projektübersicht)
2. [Funktionsanforderungen](#funktionsanforderungen)
3. [Nicht-funktionale Anforderungen](#nicht-funktionale-anforderungen)
4. [Technologie-Stack](#technologie-stack)
5. [Ausblick & Erweiterungen](#ausblick--erweiterungen)
6. [Nächste Schritte](#nächste-schritte)
7. [Lizenz](#lizenz)

## Projektübersicht

* **Manuelle Datenerfassung:** Über ein Webformular werden simulierte Sensordaten (Temperatur, Luftfeuchtigkeit, Sensortyp, Zeitstempel) erfasst.

* **Datenhaltung:** MySQL-Datenbank mit Tabelle `sensordaten`:

  ```sql
  CREATE TABLE sensordaten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    wert FLOAT NOT NULL,
    einheit VARCHAR(10) NOT NULL,
    typ VARCHAR(20) NOT NULL,
    zeitstempel DATETIME NOT NULL
  );
  ```

* **Datenvisualisierung:** Anzeige aller Datensätze in einer sortierbaren HTML-Tabelle.

* **Live-Suche:** AJAX-basierte Echtzeit-Filterung nach Datum und Sensortyp ohne Neuladen.

* **Open Source:** Entwicklung mit frei verfügbaren Technologien (PHP, JavaScript, SQL).

## Funktionsanforderungen

1. **Dateneingabe**

   * Webformular mit Eingabefeldern für Temperatur, Luftfeuchte, Sensortyp und Zeitstempel
   * Client- und serverseitige Validierung (Pflichtfelder, Wertebereich)
   * Datenübertragung via POST

2. **Datenverarbeitung & -speicherung**

   * Verwendung von Prepared Statements für sichere SQL-Abfragen
   * Speichern der Daten in Tabelle `sensordaten`

3. **Datenanzeige**

   * Sortierbare und paginierte HTML-Tabelle aller Sensordaten

4. **AJAX-Live-Suche**

   * Echtzeit-Filterung per JavaScript (Fetch API)
   * Aktualisierung der Tabelle ohne Full-Page-Reload

## Nicht-funktionale Anforderungen

* **Usability:** Intuitive Oberfläche, responsives Design für Desktop und Mobilgeräte
* **Performance:** Antwortzeit < 1 Sekunde bei Filteranfragen, skalierbar für bis zu 500 Einträge
* **Sicherheit:** Serverseitige Validierung, Prepared Statements, HTTPS-Unterstützung
* **Datenschutz:** Verarbeitung nur technischer, anonymisierter Daten
* **Erweiterbarkeit:** Modularer Code für einfache Integration neuer Sensoren und Funktionen

## Technologie-Stack

* **Backend:** PHP 7.4+
* **Frontend:** HTML5, CSS3, JavaScript (Fetch API)
* **Datenbank:** MySQL 5.7+
* **Tools:** Composer, optional npm/Yarn für Frontend-Dependencies

## Ausblick & Erweiterungen

* **Automatische Sensoranbindung:** Integration per MQTT oder REST
* **Visualisierung:** Chart.js oder Recharts für Diagramme und Trends
* **Benachrichtigungen:** E-Mail- oder Push-Alerts bei Grenzwertüberschreitungen
* **Authentifizierung:** Nutzerverwaltung und personalisierte Dashboards

## Nächste Schritte

1. Entwicklungsumgebung aufsetzen
2. Datenbankschema importieren
3. Grundfunktionen (Erfassung, Speicherung, Anzeige) implementieren
4. AJAX-Live-Suche integrieren
5. Prototyp dem Professor präsentieren
