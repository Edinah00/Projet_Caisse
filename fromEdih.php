<?php
// 2024-06-01-000001_CreateProduitTable.php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateProduitTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INTEGER', 'auto_increment' => true],
            'designation'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'prix'            => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'quantite_stock'  => ['type' => 'INTEGER', 'default' => 0],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('produit');
    }
    public function down() { $this->forge->dropTable('produit'); }
}
// Crée les migrations app/Database/Migrations/ :
// php// 2024-06-01-000001_CreateProduitTable.php
// <?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateProduitTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INTEGER', 'auto_increment' => true],
            'designation'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'prix'            => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'quantite_stock'  => ['type' => 'INTEGER', 'default' => 0],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('produit');
    }
    public function down() { $this->forge->dropTable('produit'); }
}
//php// 2024-06-01-000002_CreateCaisseTable.php
class CreateCaisseTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INTEGER', 'auto_increment' => true],
            'numero'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'localisation' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('caisse');
    }
    public function down() { $this->forge->dropTable('caisse'); }
}
//php// 2024-06-01-000003_CreateAchatTable.php
class CreateAchatTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INTEGER', 'auto_increment' => true],
            'caisse_id'  => ['type' => 'INTEGER'],
            'produit_id' => ['type' => 'INTEGER'],
            'quantite'   => ['type' => 'INTEGER'],
            'prix_unit'  => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'statut'     => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'en_cours'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('achat');
    }
    public function down() { $this->forge->dropTable('achat'); }
}
// Travaux à faire 2 — Initialiser CodeIgniter avec SQLite
// Dans app/Config/Database.php, modifie la connexion par défaut :
// php
public array $default = [
    'database' => WRITEPATH . 'caisse.db',
    'DBDriver' => 'SQLite3',
    'DBPrefix' => '',
    'DBDebug'  => true,
    'swapPre'  => '',
    'failover' => [],
    'foreignKeys' => true,
    'dateFormat' => [
        'date'     => 'Y-m-d',
        'datetime' => 'Y-m-d H:i:s',
        'time'     => 'H:i:s',
    ],
];
Ensuite lance les migrations et le seeder :
bashphp spark migrate
php spark db:seed CaisseSeeder