# GKS Haustechnik – Mini CMS

Schlankes PHP/MySQL-Webseiten-Grundsystem für gkshaustechnik.de mit:

- Dunklem, modernem Onepage-Start-Look im Stil des gelieferten Layouts (Hero + klare Kachelstruktur).
- CMS-Seiten (z. B. Sanitär, Heizung, Notdienst, Impressum, Datenschutz) vollständig im Admin pflegbar.
- Jobs-Modul mit eigener Übersicht und Detailseite.
- Adminbereich für Inhalte, Jobs, Startseiteninhalte und Hinweise.

## Setup

1. MySQL-Datenbank anlegen und `sql/schema.sql` importieren.
2. `config/config.php` mit Datenbankwerten prüfen oder per Umgebungsvariablen setzen (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`).
3. Webroot auf `public/` setzen.

### Admin Login (Seed)

- E-Mail: `admin@gkshaustechnik.de`
- Passwort: `admin123`

## Download / ZIP-Paket erstellen

Upload-fertiges Paket erstellen:

```bash
./scripts/create-release-zip.sh
```

Ausgabe:

- `dist/gks-mini-cms-YYYYMMDD-HHMMSS.zip`

## Struktur

- `public/` Frontend
- `admin/` Login + Verwaltung
- `includes/` DB + Hilfsfunktionen
- `sql/` Datenbankschema + Seed
- `uploads/` Medienablage
- `scripts/create-release-zip.sh` ZIP-Builder
