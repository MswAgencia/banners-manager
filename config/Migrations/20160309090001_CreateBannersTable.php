<?php

use Migrations\AbstractMigration;

class CreateBannersTable extends AbstractMigration {

  public $autoId = false;

  public function change()
  {
    $table = $this->table('bm_banners');

    $table->addColumn('id', 'integer', [
        'autoIncrement' => true,
        'limit' => 11
    ]);

    $table->addPrimaryKey('id');

    $table->addColumn('name', 'string');

    $table->addColumn('text', 'string');

    $table->addColumn('link', 'string');

    $table->addColumn('image', 'string');

    $table->addColumn('description', 'text');

    $table->addColumn('sort_order', 'integer');

    $table->addColumn('position_id', 'integer');

    $table->addColumn('active', 'boolean');

    $table->create();
  }
}
