<?php
namespace BannersManager\Model\Entity;

use AppCore\Model\Entity\Entity;

/**
 * Banner Entity.
 */
class Banner extends Entity
{

  /**
   * Fields that can be mass assigned using newEntity() or patchEntity().
   *
   * @var array
   */
  protected $_accessible = [
      'name' => true,
      'image' => true,
      'description' => true,
      'sort_order' => true,
      'active' => true,
      'position_id' => true,
      'text' => true,
      'link' => true,
      'position' => true,
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

  public function getTitle()
  {
    return $this->name;
  }

  public function getImage()
  {
    return $this->image;
  }

  public function getOrder()
  {
    return $this->order;
  }

  public function isActive()
  {
    if($this->active)
      return true;
    else
      return false;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getLink()
  {
    return $this->link;
  }

  public function getPositionId()
  {
    return $this->position_id;
  }
}
