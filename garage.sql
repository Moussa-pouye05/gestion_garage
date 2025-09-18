-- Clients
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    telephone VARCHAR(20),
    email VARCHAR(100)
);

-- Véhicules
CREATE TABLE vehicules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    immatriculation VARCHAR(50) UNIQUE,
    marque VARCHAR(50),
    modele VARCHAR(50),
    annee INT,
    status ENUM('en panne','en reparation','termine') DEFAULT 'en panne',
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

-- Réparations
CREATE TABLE reparations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicule_id INT,
    date_reparation DATE,
    description TEXT,
    cout DECIMAL(10,2),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id) ON DELETE CASCADE
);

-- Utilisateurs (connexion)
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255),
    role ENUM('admin', 'employe') DEFAULT 'employe'
);