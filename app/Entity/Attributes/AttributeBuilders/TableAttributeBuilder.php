<?php
namespace App\Entity\Attributes\AttributeBuilders;

use App\Attribute;
use App\Contracts\Adapters\ITableAdapter;
use App\Entity\Attributes\AAttribute;
use App\Entity\Attributes\TableAttribute;
use App\TableTypeColumn;
use App\TableTypeRow;
use Illuminate\Contracts\Container\Container;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class TableAttributeBuilder implements IAttributeBuilder
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function build($attribute) : AAttribute
    {
        $childAttributes = Attribute::whereParentAttributeId($attribute->id)->with('type')->get();
        $columns = TableTypeColumn::whereParentAttributeId($attribute->id)->get();
        $rows = TableTypeRow::whereParentAttributeId($attribute->id)->get();

        $tableAdapter = $this->container->make(ITableAdapter::class);

        $entity = new TableAttribute($attribute->id, $attribute->name, $attribute->type_id, $attribute->type->name, $attribute->is_locked);
        $entity->setValue($tableAdapter->transform($attribute, $childAttributes, $columns, $rows));

        return $entity;
    }
}