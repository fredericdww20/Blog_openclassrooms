# Blog Openclassrooms

## Description

Ce projet est un blog réalisé dans le cadre de la formation de développeur d'application Php/Symfony dispensée par Openclassrooms. Il s'agit d'une application web permettant de créer, afficher, éditer et supprimer des articles de blog, ainsi que de laisser des commentaires sur les articles.

## Fonctionnalités

- Création d'un compte utilisateur avec authentification.
- Création, affichage, édition et suppression d'articles de blog.
- Ajout de commentaires sur les articles.
- Gestion des utilisateurs avec des rôles (administrateur, utilisateur).

## Prérequis

Avant de pouvoir exécuter le projet, assurez-vous d'avoir les éléments suivants installés :

- PHP 8.1 ou une version ultérieure
- Twig
- Composer
- MySQL ou un autre système de gestion de base de données

## Installation

1. Clonez ce dépôt sur votre machine locale :

```bash
git clone https://github.com/votre-utilisateur/blog_openclassrooms.git
```

2. Accédez au répertoire du projet :

```bash
cd blog_openclassrooms
```

3. Installez les dépendances du projet via Composer :

```bash
composer install
```

4. Configurez les paramètres de connexion à la base de données dans le fichier `config.php` disponible à la racine du projet.

5. Créez la base de données avec le fichier de migration pofr8259_blogopen.sql à importer dans votre base de données.

6. Lancez le serveur web :

```bash
cd public
php -S localhost:8000
```

7. Accédez à l'application dans votre navigateur à l'adresse suivante :

```
http://localhost:8000
```

## Contribution

Les contributions à ce projet sont les bienvenues. Voici comment vous pouvez contribuer :

1. Forkez le dépôt.
2. Créez une nouvelle branche.
3. Apportez vos modifications et validez-les.
4. Envoyez votre branche vers votre dépôt forké.
5. Soumettez une demande d'extraction

Veuillez-vous assurer de suivre les bonnes pratiques de développement et de respecter les normes de codage en vigueur.

## Auteur

Ce projet a été réalisé par Portemer Frederic, dans le cadre de la formation Openclassrooms.

## License

Ce projet est sous license [MIT](LICENSE).
