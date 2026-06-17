# Projet Caisse Supermarché
# TF 1
## Objectif :environnement et les données de base.
    Créer repo CodeIgniter 4 (Edinah)
    pull depuis main
    Configurer SQLite (Database.php) (Mpiaro)
    Créer les tables : (Mpiaro)
        produit
        caisse
        achat
    Insérer données initiales : (Mpiaro)
        5 produits
        2 caisses
    Créer migrations CI4 (option recommandé) (Mpiaro)
    Créer seeders : Mpiaro
        ProduitSeeder
        CaisseSeeder
    push vers branche mpiaro
    pull request vers main
### TF 2
## Objectif : fonctionnalité :  choisir une caisse et la stocker en session.
    pull depuis main
    Créer page accueil (Edinah)
    Afficher liste caisses (dropdown) (Edinah)
    Bouton "Valider" (Edinah)
    Stocker caisse choisie en session CI4 : (Edinah)
        session()->set('caisse_id')
    Afficher caisse sélectionnée dans menu (Edinah)
    push vers branche edinah
    pull request vers main
### TF 3
## Objectif : Créer systèmeachat avec calcul automatique.
### Partie 1 : Formulaire de saisie
    pull depuis main
        Créer formulaire : (Mpiaro)
            Select produit
            Input quantité
            Bouton valider
        Récupérer produit depuis DB (Mpiaro)
        Calculer montant = prix * quantité (Mpiaro)
    push vers branche mpiaro
    pull request vers main
### Partie 2 : Tableau des achats
    pull depuis main
        Afficher liste des achats en cours :(Edinah)
            Produit
            Prix unitaire
            Quantité
            Montant
        Calculer total général (Edinah)
        Stocker achats en session ou DB(Edinah)
    push vers branche edinah
    pull request vers main
### TF 4
## Objectif : Ajouter contrôle et finalisation des achats.
    pull depuis main
        Ajouter page login (avant choix caisse)(Mpiaro)
        Auth simple (user/password ou session statique)(Mpiaro)
    push vers branche mpiaro
    pull request vers main
    pull depuis main
        Ajouter bouton "Clôturer achat"(Edinah)
        Lier achat à un client (logique métier)(Edinah)
        Empêcher accès sans caisse sélectionnée(Edinah)
        Sécuriser routes avec filters CI4(Edinah)
    push vers branche edinah
    pull request vers main
### Mise au point :
    Mise au point du todo list(Mpiaro)