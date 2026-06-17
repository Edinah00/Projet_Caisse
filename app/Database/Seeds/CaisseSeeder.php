<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class CaisseSeeder extends Seeder
{
    public function run()
    {   
        // Users
    $users = [
        [
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
        ],
        [
            'username'   => 'caissier1',
            'password'   => password_hash('1234', PASSWORD_DEFAULT),
            'role'       => 'caissier',
            'created_at' => date('Y-m-d H:i:s'),
        ],
        [
            'username'   => 'caissier2',
            'password'   => password_hash('1234', PASSWORD_DEFAULT),
            'role'       => 'caissier',
            'created_at' => date('Y-m-d H:i:s'),
        ],
    ];
    $this->db->table('users')->insertBatch($users);
        // Produits
        $produits = [
            ['designation' => 'Riz 5kg',       'prix' => 12500, 'quantite_stock' => 100],
            ['designation' => 'Huile 1L',       'prix' => 8900,  'quantite_stock' => 50],
            ['designation' => 'Sucre 1kg',      'prix' => 4500,  'quantite_stock' => 80],
            ['designation' => 'Farine 1kg',     'prix' => 3200,  'quantite_stock' => 60],
            ['designation' => 'Savon Lux',      'prix' => 1500,  'quantite_stock' => 200],
        ];
        $this->db->table('produit')->insertBatch($produits);

        // Caisses
        $caisses = [
            ['numero' => 'Caisse 1', 'localisation' => 'Entrée principale'],
            ['numero' => 'Caisse 2', 'localisation' => 'Sortie gauche'],
        ];
        $this->db->table('caisse')->insertBatch($caisses);
    }
}