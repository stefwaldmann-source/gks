CREATE DATABASE IF NOT EXISTS gks_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gks_cms;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(120) NOT NULL UNIQUE,
    value TEXT NOT NULL
);

CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE,
    intro TEXT,
    content MEDIUMTEXT,
    sort_order INT NOT NULL DEFAULT 0,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE service_boxes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    description TEXT,
    image_url VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0
);

CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(190) NOT NULL,
    short_description TEXT,
    tasks TEXT,
    requirements TEXT,
    benefits TEXT,
    location VARCHAR(150) DEFAULT '',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users(name, email, password_hash) VALUES
('Admin', 'admin@gkshaustechnik.de', '$2y$10$Qh9vPcEx5q2Nr4vpk0L82OZoPA8H95v0.5wmq74wYJv1nVbWcvWnW');

INSERT INTO settings(`key`, value) VALUES
('hero_title', 'Moderne Haustechnik für Ihr Zuhause'),
('hero_subtitle', 'Heizung, Sanitär, Klima und erneuerbare Energien aus einer Hand.'),
('hero_button_text', 'Jetzt beraten lassen'),
('hero_button_url', '/page.php?slug=kontakt'),
('hero_image', 'https://cdn.daa.net/p/moderne_heizung_0dcd1ee11f.jpg'),
('popup_enabled', '1'),
('popup_text', 'Hinweis: Unser Büro ist am 24.12. geschlossen. Notdienst unter 01234-5678.'),
('opening_hours', 'Mo-Fr 08:00-17:00'),
('job_email', 'jobs@gkshaustechnik.de');

INSERT INTO pages(title, slug, intro, content, sort_order, is_published) VALUES
('Sanitär', 'sanitaer', 'Moderne Sanitärlösungen für Neubau und Sanierung.', 'Wir planen und realisieren Bäder, Sanitäranlagen und barrierefreie Lösungen.', 10, 1),
('Heizung', 'heizung', 'Effiziente Heizsysteme für jedes Gebäude.', 'Wärmepumpen, Hybridanlagen und Heizungsmodernisierung inklusive Förderberatung.', 20, 1),
('Lüftung & Klima', 'lueftung-klima', 'Besseres Raumklima mit durchdachter Technik.', 'Klimaanlagen, Wohnraumlüftung und Service aus einer Hand.', 30, 1),
('Solar', 'solar', 'Nachhaltige Energie vom eigenen Dach.', 'Photovoltaik, Solarthermie und Speichersysteme.', 40, 1),
('Kontakt', 'kontakt', 'Wir freuen uns auf Ihr Projekt.', 'Telefon: 01234-5678\nE-Mail: info@gkshaustechnik.de', 100, 1),
('Datenschutz', 'datenschutz', 'Datenschutzhinweise', 'Diese Seite ist im CMS editierbar und dient als DSGVO-Seite.', 110, 1),
('Impressum', 'impressum', 'Impressum', 'Diese Seite ist im CMS editierbar und dient als Impressum.', 120, 1);

INSERT INTO service_boxes(title, description, image_url, sort_order) VALUES
('Sanitär', 'Neubau, Sanierung und barrierefreie Bäder.', 'https://www.daschner-gmbh.de/media/de/marke_hersteller_produkte/villeroy-boch-bad-wellness/news/bad-trends-2025/vb_classic_contemporary_modernluxury_bad_mit_bade-_und_duschwanne.jpg', 10),
('Heizung', 'Wärmepumpen, Gas- und Hybridanlagen.', 'https://files.vdzev.de/intelligent-heizen/heizsystem/waermepumpe/illustrationen/wasser-waermepumpe.png', 20),
('Lüftung & Klima', 'Wohnraumlüftung und Klimaanlagen.', 'https://www.bosch-homecomfort.com/de/media/country_pool/bilder/referenzen/modernisierung_in_samerberg/bild2_1600x640original.jpg', 30),
('Solar', 'PV und Solarthermie für mehr Unabhängigkeit.', 'https://gebaeudeklima-schweiz.ch/images/content/Fachthemen/Info_Solar_A4_de_GKS1.jpg', 40);

INSERT INTO jobs(title, short_description, tasks, requirements, benefits, location, is_active) VALUES
('Anlagenmechaniker SHK (m/w/d)', 'Verstärke unser Montageteam im Bereich Heizung/Sanitär.', 'Installation und Inbetriebnahme\nKundendienst', 'Abgeschlossene Ausbildung\nTeamfähigkeit', 'Unbefristet\nFirmenfahrzeug\nWeiterbildung', 'Region', 1),
('Kundendiensttechniker Heizung (m/w/d)', 'Service und Wartung moderner Heiztechnik.', 'Wartungen\nStörungsbehebung', 'Erfahrung in Heiztechnik\nFührerschein Klasse B', 'Leistungsprämie\nModernes Werkzeug', 'Region', 1);
