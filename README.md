# TP Automatisation du developpement - Test - Rendu 3
## PINOT Gaëtan
[ https://github.com/gaetanpinot/Automatisation-cours-3-rendu ]


Mini projet pour le rendu numéro 3 du cours d'automatisation du développement sur les tests.

Ce projet contient seulement 3 classes qui intéragissent entre elle :

- `Person` : Classe qui permet de créer une personne
- `Wallet` : Classe qui permet de créer un portefeuille avec une devise spécifique
- `Product` : Classe qui permet de créer un produit avec une catégorie et une liste de prix par devise.

## Technologie utilisées

```sh
docker compose run --rm php composer install
```

## Script

### Run test with [PHPUnit](https://phpunit.de/)

```sh
docker compose run --rm php composer test
```

utilise la configuration disponible dans le fichier `phpunit.xml`

### Run test and coverage

```sh
docker compose run --rm php composer test:coverage
```

édite un rapport au format HTML dans le dossier `coverage`
