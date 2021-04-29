# Analyse générale du projet
Un cie de vols privés propose des trajets VIP vers des capitales européennes.
Une application avec :
- un système de login avec deux types d'utilisateurs (USER, ADMIN)
- un espace privé qui affiche les vols et propose des actions pour :
  - créer un nouveau vol
  - modifier un vol
  - voir un vol
  - supprimer un vol

L'application à ce stade permet de gérer les vols de la journée courante.

## Analyse fonctionnelle
- A faire.
- Compréhensible voire dicté pour le client.
- Peut donner lieu à un Use Case UML.

## Couche métier
- dégager les types de données
- Ici : 
    1. Vol || Trajet
    2. Capitale
    3. User
## Modélisation base de données
- un diagrammme de classe UML basé sur l'analyse fonctionnelle.
- Nous ici, on va créer un diagramme MySQLWB.
 ![Diagram](/diagram.png)

# Configuration de l'application 
1. database 
   ```bash
   symfony console doctrine:database:create
   # faire la connexion avec la base de données
    DATABASE_URL="postgresql://postgres:root@127.0.0.1:5432/db_capital_airways"
   ```
2. les entités Flight et City et leur relation
   ```bash
   symfony console make:entity Flight #(propriétés flightnumber, schedule, price, reduction)
   symfony console make:entity City #(name)
   ```
 > Ne pas faire User
3. Les fixtures 
   - Créer un tableau d'objets du type City
   - créer un ou 2 vols
    > numéro de vol statique exp: AH2349
__NB__ Eviter le copier/coller de code.