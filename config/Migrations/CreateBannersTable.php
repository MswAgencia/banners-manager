<?php

use Migrations\AbstractMigration;

class CreateBannersTable extends AbstractMigration {

  public function change()
  {
    $table = $this->table('bm_banners');
    $table->addColumn('id', 'integer', [
        'autoIncrement' => true,
        'limit' => 11
    ])
    ->addPrimaryKey('id')
    ->addColumn('name', 'string')
    ->addColumn('text', 'string')
    ->addColumn('link', 'string')
    ->addColumn('image', 'string')
    ->addColumn('description', 'text')
    ->addColumn('sort_order', 'integer')
    ->addColumn('position_id', 'integer')
    ->addColumn('active', 'boolean')
    ->create();
  }
}
