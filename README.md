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
* **UML:** //www.plantuml.com/plantuml/dpng/pLPTYjn647xNAOfb7hJZcC6l1cElVqWsaDYiXn18WkbHr-msjBedtQMnXyMGfnmWEKSkaQFu92cfUqki8bd3u0VFWurQNttrrLVLjNeMIGLgQbiKRz557-3iqHai7pw4irgvmncaqvUAr6Eel2DbN2oAogeOeJtTg8Z5RG7y-_UVJt_y3RjWzeeGc9XC1K_Vl7mD2muYvIg49-0QQplu0zWr6ykGZDmshYBZ7LmZlV3EOVTKdZy6fYW-5eNQH0gg8aZPV_0QxI2r9uv23LrIlRcVHnAyUyULC5TJKPcHvnagEOOnMsDjgK9G1uPptInhxusU2oD_qSQqLNJ1N4SsBzkD7mYTlbzDMujn1ErlORISSGxZhldCgHh_Vqg77VOL7wz-NlG4ZXjrgHdLYfs6_CXY6PHrJkFMB7yM5pDV0h4Jdwya9bg1qnqyurVB9JpwzETVIrYknZIr4ousSCHg1G6f2Iv2Vp5--QtlQdywsrdfxV0qTXoN_RkjzIfF0s6zmw1O0ewzlcbgemqTv1qhmRMfiGtb_oAfUlSLpaYoxGZWkg-ViQdqQVHtsOuZeEixTnWhhat0utqToVy5pOwYoCaHDxCHlIffv89Y3ckdZit2i5KLmXNkV3Jam-7oxgoudMorqoM7jXF8P4_JY4vZBwoLHa-9LNiiEnvOr8pTU3_5o1WabFm9Exn2VJbWwft56Xt5yI9bs4_U-dF-94b76iIWj2bI56-7ppYMCB28frWshUVvuVxQuuTUdaWRNrnVb_CYwnJtK-HC1mJ7khvq5n9v5o5hNPJEgnIcAwpGKVbhlmMYSHKArP19slgJiaQhbkSAOsEfxrcEN608FaHu0jC2bB6nb7AdDkYhZcXkJoYjEw3CvjQWrT_0tMCThsMz3Jxvf1eVPBC9GBxz-bIXiJYhPvyeSV2NR-ZRs4N96Fc86zCtAskaoXVUKV3MOkYxDNR_O17uy8WxDnvxFgn9yaf10ocZYOpJ-A7CFME4NC1lNwrXbOO-TYNuFOQzmVTGgQ3Zr9syyU_bXWdfW6vrQ_J72O8ge28S2XeI91IKpwtI25iVwlCfGUI3J4V0tpDno_ZczTkUScn2lgIZmneqywVlVnz8RIn2-lS1N7n_yVEHvanJPuTEDaM8s9TdN7bJs_y0

* **Manuelle Datenerfassung:** Über ein Webformular werden simulierte Sensordaten (Temperatur, Luftfeuchtigkeit, Sensortyp, Zeitstempel) erfasst.
  
* **Patterns:** CRUD (CREATE, READ, UPDATE, DELETE) für Datenverwaltung, Dependency Injection für Backend für die erwartbarkeit.

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
* **Datenübertragung:** Front-End und Back-End MUSS mit die Daten im JSON Format austauschen.
  
* **Datenvisualisierung:** Anzeige aller Datensätze in einer sortierbaren HTML-Tabelle + Übersichtseite ein Kärtschen pro Sensor/Gerät

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

* **Backend:** PHP
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
