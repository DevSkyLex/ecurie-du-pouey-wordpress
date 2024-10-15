<a name="readme-top"></a>

<div align="center">
  <a target="_blank" href="https://elevage-du-pouey.valentin-fortin.pro">
    <img src="https://elevage-du-pouey.valentin-fortin.pro/wp-content/login-logo.png?v=1729023634" width="40%" alt="Logo">
  </a>
  <h3 align="center"></h3>
  
  <p align="center">
    Site vitrine "Élevage du Pouey" - 2024
    <br/>
    <a href="#installation">Installation</a>
    -
    <a href="#fonctionnalities">Fonctionnalités</a>
    -
    <a href="#technologies">Technologies</a>
  </p>
</div>

# Présentation

Bienvenue sur le projet **Élevage du Pouey**, un site vitrine dédié à la présentation de l'élevage et de l'activité de l'écurie. Ce site met en lumière les chevaux et les services de qualité proposés par l'Élevage du Pouey, situé au cœur de la nature. À travers une interface simple et élégante, les visiteurs peuvent découvrir les activités de l'écurie, les chevaux disponibles, ainsi que les prestations proposées.

Ce guide vous accompagne dans l'installation et la configuration de ce site WordPress sur votre environnement local ou serveur distant.

> [!NOTE]  
> Ce projet a été réalisé dans le cadre d'une semaine YMMERSION en première année de Mastère chez YNOV.

# Installation du projet

<p align="right">(<a href="#readme-top">Retour en haut</a>)</p>

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre serveur local ou distant :

- **Serveur web** : Apache ou Nginx
- **PHP** : Version 8.3 ou supérieur (Recommandé 8.3.11)
- **Base de données** : MySQL 8 (Recommandé 8.0.16)
- **Git** : Pour cloner le dépôt du projet
- **Accès FTP/SSH** : Si vous travaillez sur un serveur distant

<p align="right">(<a href="#readme-top">Retour en haut</a>)</p>

## Installation

### Cloner le dépôt

Clonez le dépôt GIT dans le répertoire de votre serveur local ou de votre hébergement distant :

```bash
git clone https://github.com/DevSkyLex/ecurie-du-pouey-wordpress.git
```

Accédez au dossier contenant le clone du dépôt GIT :

```bash
cd ecurie-du-pouey-wordpress
```

### Configurer les variables d'environnement

Copiez le fichier d'exemple des variables d'environnement (`.env.example`) et renommez-le en `.env`. Ce fichier contient toutes les configurations nécessaires pour votre environnement.

```bash
cp .env.example .env
```

Modifiez ensuite les variables d'environnement :

```bash
# Nom de la base de données
DB_NAME=nom_base_de_donnees

# Nom d'utilisateur de la base de données
DB_USER=nom_utilisateur

# Mot de passe de l'utilisateur de la base de données
DB_PASSWORD=mot_de_passe

# Hôte de la base de données (localhost si en local)
DB_HOST=localhost

# Charset de la base de données (recommandé : utf8)
DB_CHARSET=utf8

# Collation à utiliser (laisser vide pour la configuration par défaut)
DB_COLLATE=""
```

### Importer le dump de la base de données

Un dump de la base de données est fourni avec le projet. Pour l'importer :

1. Créez une nouvelle base de données **MySQL** sur votre serveur local ou distant. Vous pouvez le faire via un outil comme **phpMyAdmin** ou en ligne de commande :

```bash
mysql -u root -p -e "CREATE DATABASE <nom_base_de_donnees>;"
```

2. Importez le fichier de **dump SQL** dans votre base de données nouvellement créée. Le fichier de dump doit se trouver dans le projet, généralement sous `database/dump.sql` :

```bash
mysql -u <utilisateur> -p <nom_base_de_donnees> < database/dump.sql
```

### Finaliser la configuration

Utilisez les identifiants de connexion fournis pour accéder à l'administration WordPress et finaliser la configuration du site.





