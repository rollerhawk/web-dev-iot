# Mini-IoT-Portal

[![Projektstatus](https://img.shields.io/badge/status-in%20Entwicklung-yellow)](https://github.com/dein-nutzername/mini-iot-portal)

## Projektvision

Das **Mini-IoT-Portal** ist eine webbasierte Anwendung zur Erfassung, Speicherung und Visualisierung von Sensordaten (z. B. Temperatur und Luftfeuchtigkeit). Ziel ist es, ein kompaktes Smart-Home-Dashboard zu simulieren, das typische IoT-Komponenten integriert.

## Inhaltsverzeichnis

1. [Projektübersicht](#projektübersicht)
2. [Mockup](#mockup)
3. [Roadmap](#roadmap)
4. [Funktionsanforderungen](#funktionsanforderungen)
5. [Nicht-funktionale Anforderungen](#nicht-funktionale-anforderungen)
6. [Technologie-Stack](#technologie-stack)
7. [Ausblick & Erweiterungen](#ausblick--erweiterungen)
8. [Nächste Schritte](#nächste-schritte)

## Projektübersicht

* **Manuelle Datenerfassung:** Über ein Webformular werden simulierte Sensordaten (Temperatur, Luftfeuchtigkeit, Sensortyp, Zeitstempel) erfasst.
  
* **Architektur:** CRUD für Datenverwaltung, Dependency Injection für Backend für die erwartbarkeit.

* **Datenhaltung:** MySQL-Datenbank mit Tabelle `sensordaten`:

  ```sql
  CREATE TABLE sensordaten (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    wert FLOAT NOT NULL,
    einheit VARCHAR(10) NOT NULL,
    typ VARCHAR(20) NOT NULL,
    zeitstempel DATETIME NOT NULL
  );
  ```

* **Datenvisualisierung:** Anzeige aller Datensätze in einer sortierbaren HTML-Tabelle.

* **Live-Suche:** AJAX-basierte Echtzeit-Filterung nach Datum und Sensortyp ohne Neuladen.

## Mockup
![image](https://github.com/user-attachments/assets/f4c8d498-bbd4-4398-b491-5efd319c05ef)

## Roadmap
![image](https://github.com/user-attachments/assets/ec260d5a-2bca-4f29-a69c-bc4e1bb09040)

## Funktionsanforderungen (MUSS)

1. **Dateneingabe**

   * Webformular mit Eingabefeldern für Temperatur, Luftfeuchte, Sensortyp und Zeitstempel
   * Client- und serverseitige Validierung (Pflichtfelder, Wertebereich)
   * Datenübertragung via POST

2. **Datenverarbeitung & -speicherung**

   * Speichern der Daten in Tabelle `sensordaten`
   * SensorRepository für die Verwaltung der Daten

3. **Datenanzeige**

   * Sortierbare HTML-Tabelle aller Sensordaten
   * Übersichtseite mit allen Sensoren/Geräten

4. **AJAX-Live-Suche**

   * Echtzeit-Filterung per JavaScript (Fetch API)
   * Aktualisierung der Tabelle ohne Full-Page-Reload

## Nicht-funktionale Anforderungen

* **Usability:** Sensoren als Kärtchen darstellen in der Übersicht (MUSS), responsives Design für Desktop (SOLL) und Mobilgeräte (KANN)
* **Performance:** Antwortzeit < 1 Sekunde bei Filteranfragen (KANN)
* **Sicherheit:** Serverseitige Validierung (MUSS), Prepared Statements (SOLL)
* **Erweiterbarkeit:** Modularer Code für einfache Integration neuer Sensoren und Funktionen (SOLL)

## Technologie-Stack

* **Backend:** PHP (geht Java+Springboot auch?)
* **Frontend:** HTML, CSS, JavaScript
* **Datenbank:** MySQL

## Ausblick & Erweiterungen

* **Automatische Sensoranbindung:** Integration REST
* **Benachrichtigungen:** E-Mail- oder Push-Alerts bei Grenzwertüberschreitungen

## Nächste Schritte

1. Entwicklungsumgebung aufsetzen
2. Datenbankschema importieren
3. Grundfunktionen (Erfassung, Speicherung, Anzeige) implementieren
4. AJAX-Live-Suche integrieren
