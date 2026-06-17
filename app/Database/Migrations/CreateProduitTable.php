// 2024-06-01-000001_CreateProduitTable.php
<?php
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