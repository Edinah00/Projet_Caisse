<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
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