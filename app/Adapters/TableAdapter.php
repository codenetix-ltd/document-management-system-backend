<?php
namespace App\Adapters;

use App\Attribute;
use App\Contracts\Adapters\ITableAdapter;
use App\Contracts\Repositories\IAttributeRepository;
use App\Entity\Attributes\ATable;
use App\Entity\Attributes\AttributeFactoryMethod;
use App\Entity\Attributes\Table;
use App\Entity\Attributes\TableColumn;
use App\Entity\Attributes\TableRow;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class TableAdapter implements ITableAdapter
{
    protected $container;
    protected $repository;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->repository = $container->make(IAttributeRepository::class);
    }

    public function transform(Attribute $attribute, Collection $childAttributes, Collection $columns, Collection $rows): ATable
    {
        $table = new Table($attribute->id, $attribute->name);
        foreach ($columns as $column){
            $table->addColumn(new TableColumn($column->id, $column->name, $column->type_id, $column->type->machine_name));
        }

        foreach ($rows as $row){
            $tableRow = new TableRow($row->id, $row->name);
            foreach ($childAttributes->where('table_type_row_id', $row->id) as $childAttribute){
                $parts = explode('/', $childAttribute->name);
                array_shift($parts);
                //TODO: dirty thing
                $childAttribute->name = trim(implode(' / ', $parts));

                $tableRow->addCell((new AttributeFactoryMethod($this->container))->make($childAttribute));
            }
            $table->addRow($tableRow);
        }

        return $table;
    }
}