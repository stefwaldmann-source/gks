# GKS Haustechnik – Mini CMS

Schlankes PHP/MySQL-Webseiten-Grundsystem für gkshaustechnik.de mit:

- Dunklem, modernem Startseiten-Look (Hero + Leistungskacheln + KPI-Band + Kontaktblöcke).
- **Logo und Teaser-Titelbild im Admin frei änderbar** (`logo_url`, `hero_title_image`).
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

## Logo / Teaser / weitere Infos bearbeiten

Im Adminbereich unter **Startseiten-Teaser & Popup** können jetzt u. a. gepflegt werden:

- `logo_url`
- `hero_title_image`
- `hero_image`
- `teaser_strip_image`
- `about_title`, `about_text`
- KPI-Werte (`stat_1_*` bis `stat_4_*`)

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
