<?php
namespace BannersManager\Model\Entity;

use BannersManager\Model\Entity\Entity;

class Position extends Entity
{

  /**
   * Fields that can be mass assigned using newEntity() or patchEntity().
   *
   * @var array
   */
  protected $_accessible = [
    'name' => true,
    'active' => true,
    'type' => true,
    'width' => true,
    'height' => true,
    'mode' => true,
    'banners' => true,
  ];

  public function getStatusAsString() {
    switch($this->active) {
      case 0:
        return 'Inativo';
      case 1:
        return 'Ativo';
      default:
        return 'Inválido / Não definido';
    }
  }

  public function getTypeName() {
    switch($this->type) {
      case 'image':
        return 'Imagem';
      case 'text':
        return 'Textual';
      default:
        return 'Inválido / Não definido';
    }
  }

  public function getName()
  {
    return $this->name;
  }

  public function isActive()
  {
    if($this->active)
      return true;
    else
      return false;
  }
}
