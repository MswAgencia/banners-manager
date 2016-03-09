<?php

use Migrations\AbstractMigration;

class CreatePositionsTable extends AbstractMigration {

  public $autoId = false;

  public function change()
  {
    $table = $this->table('bm_positions');

    $table->addColumn('id', 'integer', [
        'autoIncrement' => true,
        'limit' => 11
    ]);

    $table->addPrimaryKey('id');

    $table->addColumn('name', 'string');

    $table->addColumn('type', 'string');

    $table->addColumn('width', 'integer');

    $table->addColumn('height', 'integer');

    $table->addColumn('mode', 'string');

    $table->addColumn('active', 'boolean');

    $table->create();
  }
}
