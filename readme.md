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

- Compréhensible voire dicté pour le client.
- Peut donner lieu à un Use Case UML.

## Couche métier
- dégager les types de données
- Ici : 
    1. Vol || Trajet
    2. Capitale
    3. User
## Modélisation base de données
- Un diagrammme de classe UML basé sur l'analyse fonctionnelle.
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
   
   - Créer un tableau d'objets du type City dans AppFixtures.php
   - créer un ou 2 vols
    > numéro de vol statique exp: AH2349  
__NB__ Eviter le copier/coller de code.
 ```php
   class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       
        $cities = [ 'Paris', 'Berlin', 'Madrid', 'Londres', 'Vienne', 'Bruxelles', 
        'Sofia', 'Athènes', 'Budapest', 'Rome', 'Dublin', 'Copenhague', 'Amsterdam', 'Varsovie', 'Prague'];
        // Tableau d'objets de type City
        $tabObjCity = [];
        // -- Crée autant d'objet City que de villes dans $cities
        foreach ($cities as $name) {
            $city = new City();
            $city->setName($name);
            $tabObjCity[] = $city;
            $manager->persist($city);
            $manager->flush();
        }
        /* UN VOL */
            $flight = new Flight;
            $flight
                    ->setFlightNumber('AA7777')
                    ->setSchedule(\DateTime::createFromFormat('H:i', '08:00'))
                    ->setPrice(210)
                    ->setReduction(false)
                    ->setDeparture($tabObjCity[0])
                    ->setArrival($tabObjCity[4]);
                $manager->persist(($flight));

        }
    }

 ```
# Modification 
# Entité Flight

- On va rajouter un attribut `seat` qui represente le nombre sièges restant.
  ```bash
  symfony console make:entity Flight
  ```
Nouvelle migration   
```bash
symfony console make:migration
symfony console doctrine:migrations:migrate
SLQSTATE[23000]: Integrity constraint violation : 19 NOT NULL constraint failed: flight.seat
```

### Action 
- Effacer le cache: `symfony console cache:clear`
- refaire la création de la base de données
- refaire de nouvelles migrations (on supprime les anciennes présentes dans la table)
Modification des fixtures  
  - On ajoute l'alimentation via un setter : setSeat()
  - On va créer plusieurs vols (travail de boucle).
  (pour le moment, les numéros de vols et horaires restent les mêmes) 
puis 
```bash
symfony console doctrine:fixtures:load
```
# Automatisation
Le coeur de l'application est générée automatiquement avec :
```bash
symfony console make:crud
```
# Gérer la classe FlightType
- Tous les champs ne sont pas requis ?
- La relation avec City. Même procéder que pour Todolist. Taper dans la doc une recherche du type : `symfony class form entity relation`
  ```php
        $builder
            
            ->add('price', NumberType::class, [
                'label' => 'Prix du vol'
            ])
            ->add('schedule', TimeType::class, [
                'label' => 'Horaires',
                'hours' => range(5,21)
            ])
            ->add('reduction', CheckboxType::class, [
                'label' => 'Réduction de 10% ?'
            ])
            ->add('seat', IntegerType::class, [
                'label' => 'Places disponibles'
            ])
            ->add('departure', EntityType::class, [
                "class"=> City::class,
                "choice_label"=> "name",
                "label"=> "Departure"
            ])
            ->add('arrival', EntityType::class, [
                "class"=> City::class,
                "choice_label"=> "name",
                "label"=> "Arrival"
            ])
  ```
- Ajouter les contraintes
  
## Personnaliser
Ajouter Bootstrap pour les page, le thème formulaire.
   - ajouter style au besoin.

# Créer une classe de service
## Création 
- On crée une classe `App\Services\FlightService.php`
- Ce service va permettre d'attribuer un numéro de vol lors de la création d'un vol.
## Utilisation dans les fixtures

**NB**
- On ne peut pas injecter directement dans la méthode load()
- Passer par un \_\__construct. On ajoute le service.
- On crée pour cela un attribut private.
- Puis dans la méthode load()

```bash
 $flight
      ->setFlightNumber($this->flightService->getFlightNumber())
``` 

