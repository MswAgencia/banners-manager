<?php

use Migrations\AbstractMigration;

class CreatePositionsTable extends AbstractMigration {

  public function change()
  {
    $table = $this->table('bm_positions');
    $table->addColumn('id', 'integer', [
        'autoIncrement' => true,
        'limit' => 11
    ])
    ->addPrimaryKey('id')
    ->addColumn('name', 'string')
    ->addColumn('type', 'string')
    ->addColumn('width', 'integer')
    ->addColumn('height', 'integer')
    ->addColumn('mode', 'string')
    ->addColumn('active', 'boolean')
    ->create();
  }
}
