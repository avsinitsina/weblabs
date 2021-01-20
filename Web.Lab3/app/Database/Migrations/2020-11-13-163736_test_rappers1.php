<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRappers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'=>'INT',
                'unsigned'=>true,
                'constraint'=>6,
                'auto_increment'=>true
            ],
            'genre' => ['type'=>'ENUM','constraint'=>['freestyle', 'gangsta', 'hardcore', 'nerdcore']],
            'name' => ['type'=>'VARCHAR','constraint'=>200],
            'from' => ['type'=>'DATE'],
            'dead_baddy' => ['type'=>'INT','constraint'=>1],
            'cool_moves_count' => ['type'=>'INT','constraint'=>1],
            'swearing_frequency' => ['type'=>'FLOAT','constraint'=>1],
            'country' => ['type'=>'VARCHAR','constraint'=>200],
            'label' => ['type'=>'VARCHAR','constraint'=>200]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('db_rappers');
    }
    public function down()
    {
        $this->forge->dropTable('db_rappers');
    }
}

