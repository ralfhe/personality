Anwendungsfälle
================

## Benutzer

**AF-B-1: Eigenevaluation**

1. Benutzer ruft die Webseite auf und landet auf Startseite
1. Benutzer wählt Möglichkeit der Eigenevaluation
1. Benutzer bekommt die Fragen des Tests zu sehen
1. Benutzer füllt den Test aus
1. Benutzer klickt auf "Weiter"
1. Benutzer füllt weitere notwendige Informationen zu seiner Person aus (z.B. E-Mail, Alter, Geschlecht)
1. Benutzer sendet den Test ab
1. Benutzer gelangt auf die Ergebnisseite mit weiteren Optionen (z.B. PDF-Druck, E-Mail-Versandt, Unique-Link)

**AF-B-2: Gruppenevaluation (Ausfüllen)**

1. Benutzer erhält E-Mail mit eindeutigem Link zum Test
1. Benutzer gelangt über den Link direkt zum Test und sieht die Fragen. Ein Wizard weißt den Benutzer darauf hin, dass zunächst eine Eigenevaluation stattfindet.
1. Benutzer füllt Fragen aus und klickt auf "Weiter"
1. Benutzer sieht nun den Namen der Person welche er im Folgenden bewerten soll, sowie die Fragen. Dieser Schritt wiederholt sich so oft, wie Personen zugewiesen wurden.
1. Benutzer gelangt nach vollständigem Ausfüllen der zugewiesenen Personen auf eine Seite, wo zusätzliche Informationen verlangt werden (z.B. E-Mail, Alter, Geschlecht)
1. Benutzer schickt den Test ab und sieht eine "Thank-You-Page" mit Informationen zum weiteren Verlauf

**AF-B-3: Gruppenevaluation (Ergebnis)**

1. Benutzer erhält E-Mail mit eindeutigem Link zum Ergebnis (evtl. auch direkt mit Ergebnis-PDF im Anhang)
1. Benutzer gelangt über den Link direkt auf die Ergebnisseite mit weiteren Optionen (z.B. PDF-Druck, E-Mail-Versandt)

## Administrator

### Studenten

**AF-A-1: Student anlegen (Manuell)**

1. Administrator wählt im Hauptmenü "Students" und gelangt zur Übersichtsseite
1. Administrator wählt die Operation Benutzer hinzufügen (gekennzeichnet durch ein +) aus und gelangt zur Eingabemaske
1. Administrator gibt benötigte Informationen (Vorname, Nachname, E-Mail) ein und sendet das Formular ab
1. Waren keine Fehler in der Eingabe, wird der neue Student gespeichert und der Administrator gelangt auf die Übersichtsseite zurück. Andernfalls bleibt er auf der Eingabemaske und wird auf die Fehler hingewiesen.

**AF-A-2: Student anlegen (CSV)**

1. Administrator wählt im Hauptmenü "Students" und gelangt zur Übersichtsseite
1. Administrator wählt die Operation Benutzer importieren (gekennzeichnet durch ein Wolke mit Pfeil) aus und gelangt zur Eingabemaske
1. Der Administrator wählt die hochzuladende Datei aus und bestimmt das Zeichen, durch welches die Daten getrennt sind aus und sendet das Formular ab
1. Waren keine Fehler in der Eingabe und das hochgeladene Dokument entspricht den Vorgaben, so werden dem Administrator alle Studenten aus der CSV-Datei aufgelistet.
1. Der Administrator kann nun Benutzer einzeln oder alle gelisteten Benutzer hinzufügen. Benutzer, welche in der CSV gelistet sind, jedoch bereits im System eingetragen sind, werden nicht aufgelistet. Entscheidendes Kriterium ist hierbei die E-Mailadresse
1. Nach Beendigung des Imports gelangt der Administrator wieder auf die Überblicksseite

**AF-A-3: Student editieren**

1. Der Administrator wählt im Hauptmenü "Students" und gelangt zur Übersichtsseite
1. Der Administrator wählt die Operation Benutzer editieren (gekennzeichnet durch einen Bleistift) aus und gelangt zur Eingabemaske
1. Der Administrator führt die gewünschten Änderungen durch und schickt das Formular ab
1. Waren keine Fehler in der Eingabe, werden die Änderungen gespeichert und der Administrator gelangt auf die Übersichtsseite zurück. Andernfalls bleibt er auf der Eingabemaske und wird auf die Fehler hingewiesen.

**AF-A-4: Student löschen**

1. Der Administrator wählt im Hauptmenü "Students" und gelangt zur Übersichtsseite
1. Der Administrator wählt die Operation Benutzer löschen (gekennzeichnet durch einen Mülleiemer) aus
1. Der Administrator bestätigt in der Abfrage, dass er den Benutzer tatsächlich löschen möchte oder bricht die Aktion ab. In beiden Fällen gelangt er wieder zur Übersichtsseite

***
### Gruppen

**AF-A-5: Gruppe anlegen**

1. Der Administrator wählt im Hauptmenü "Groups" und gelangt zur Übersichtsseite
1. Der Administrator wählt die Operation Gruppe anlegen (gekennzeichnet durch ein +) aus und gelangt zur Eingabemaske
1. Der Administrator vergibt einen Gruppennamen und kann gleichzeitigt
 1. bestehende Studenten der Gruppe hinzufügen,
 1. neue Studenten anlegen und der Gruppe hinzufügen,
 1. Studenten aus CSV importieren.
Alle hinzugefügten Studenten, werden gelistet.
1. Ist die Liste vollständig, kann der Administrator die Gruppe anlegen und gelangt zur Übersicht.

**AF-A-6: Gruppe editieren**

1. Der Administrator wählt im Hauptmenü "Groups" und gelangt zur Übersichtsseite
1. Der Administrator wählt die Operation Gruppe editieren (gekennzeichnet durch einen Bleistift) aus und gelangt zur Eingabemaske
1. Der Administrator kann den Namen der Gruppe ändern, sowie Benutzer hinzufügen und entfernen (evtl. auch editiren)

**AF-A-7: Gruppe löschen**

1. Der Administrator wählt im Hauptmenü "Groups" und gelangt zur Übersichtsseite
1. Der Administrator wählt die Operation Gruppe löschen (gekennzeichnet durch einen Mülleimer) aus
1. Der Administrator hat die Option sämtliche Studenten der Gruppe ebenfalls zu löschen, sofern diese nicht auch anderen Gruppen zugeordnet sind
1. Der Administrator kann den Löschvorgang bestätigen oder abbrechen und gelangt anschließend zur Übersicht zurück

***
### Tests

***
### Durchführungen

***
### Einstellungen