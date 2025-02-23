<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Employe;
use App\Models\Service;
use App\Models\SuperieurHierarchique;
use App\Models\GestionnaireRh;
use App\Models\Directeur;

class InitialDatabaseSeeder extends Seeder
{
/**
* Run the database seeds.
*/
public function run(): void
{
//
// Création du Directeur
$directeur = Employe::create([
'nom' => 'BAYILI',
'prenom' => 'Gilbert',
'email' => 'ouedraogoarmand41@gmail.com',
'fonction' => 'Directeur',
'role' => 'directeur',
'password' => Hash::make('password123')
]);
// Création du directeur en utilisant le nom de l'employé
Directeur::create([
    'employe_id' => $directeur->id,
    'nom' => $directeur->nom,// Utilisez le nom de l'employé
    'prenom' => $directeur->prenom, // Utilisez le prenom de l'employé
]);
// Création du Gestionnaire RH
$grh = Employe::create([
'nom' => 'Tapsoba',
'prenom' => 'Arsene',
'email' => 'arseneghislaintaps@gmail.com',
'fonction' => 'Gestionnaire RH',
'role' => 'grh',
'password' => Hash::make('password123')
]);
GestionnaireRh::create([
    'employe_id' => $grh->id,
    'nom' => $grh->nom, // Utilisez le nom de l'employé
    'prenom' => $grh->prenom, // Utilisez le prenom de l'employé
]);

// Création des Chefs de Service et assignation des services
$chef_admin = Employe::create([
'nom' => 'Kobende',
'prenom' => 'Evrard',
'email' => 'kobendeevrard8@gmail.com',
'fonction' => 'Chef Administration',
'role' => 'chef_service',
'password' => Hash::make('password123')
]);

$chef_vie_scolaire = Employe::create([
'nom' => 'Traore',
'prenom' => 'Latifa',
'email' => 'kobendeevrard1234@gmail.com',
'fonction' => 'Chef Vie Scolaire',
'role' => 'chef_service',
'password' => Hash::make('password123')
]);

$chef_bibliotheque = Employe::create([
'nom' => 'Dao',
'prenom' => 'Oumar',
'email' => 'hamidoubande86@gmail.com',
'fonction' => 'Chef Bibliothèque',
'role' => 'chef_service',
'password' => Hash::make('password123')
]);

// Création des services avec chef_service_id
$admin = Service::create([
'nom' => 'Administration',
'chef_service_id' => $chef_admin->id
]);

$vie_scolaire = Service::create([
'nom' => 'Vie Scolaire',
'chef_service_id' => $chef_vie_scolaire->id
]);

$bibliotheque = Service::create([
'nom' => 'Bibliothèque',
'chef_service_id' => $chef_bibliotheque->id
]);

// Associer les chefs aux services dans la table SuperieurHierarchique
SuperieurHierarchique::create([
'employe_id' => $chef_admin->id,
'service_id' => $admin->id,
'nom' => $chef_admin->nom,
'prenom' => $chef_admin->prenom

]);

SuperieurHierarchique::create([
'employe_id' => $chef_vie_scolaire->id,
'service_id' => $vie_scolaire->id,
'nom' => $chef_vie_scolaire->nom,
'prenom' => $chef_vie_scolaire->prenom
]);

SuperieurHierarchique::create([
'employe_id' => $chef_bibliotheque->id,
'service_id' => $bibliotheque->id,
'nom' => $chef_bibliotheque->nom,
'prenom' => $chef_bibliotheque->prenom
]);

}
}