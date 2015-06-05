<?php
namespace BannersManager\Model\Entity;

use Appcore\Model\Entity\Entity;

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
}
