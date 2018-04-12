<?php

namespace App;

use App\Contracts\Models\IAttribute;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model implements IAttribute
{
//    protected $fillable = [
//        'template_id', 'name', 'type_id', 'order', 'table_type_row_id', 'table_type_column_id', 'parent_attribute_id', 'is_locked'
//    ];
    private $data;

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function setId(int $id): IAttribute
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): IAttribute
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setTemplateId(int $templateId): IAttribute
    {
        $this->template_id = $templateId;

        return $this;
    }

    public function getTemplateId(): int
    {
        return $this->template_id;
    }

    public function setTypeId(int $typeId): IAttribute
    {
        $this->type_id = $typeId;

        return $this;
    }

    public function getTypeId(): int
    {
        return $this->type_id;
    }

    public function setLocked(bool $isLocked): IAttribute
    {
        $this->is_locked = $isLocked;

        return $this;
    }

    public function isLocked(): bool
    {
        return $this->is_locked;
    }

    public function setData(array $data): IAttribute
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setOrder(int $order): IAttribute
    {
        $this->order = $order;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setParentAttributeId(int $parentAttributeId): IAttribute
    {
        $this->parent_attribute_id = $parentAttributeId;

        return $this;
    }

    public function getParentAttributeId(): ?int
    {
        return $this->parent_attribute_id;
    }

    public function setTableTypeColumnId(int $tableTypeColumnId): IAttribute
    {
        $this->table_type_column_id = $tableTypeColumnId;

        return $this;
    }

    public function getTableTypeColumnId(): ?int
    {
        return $this->table_type_column_id;
    }

    public function setTableTypeRowId(int $tableTypeRowId): IAttribute
    {
        $this->table_type_row_id = $tableTypeRowId;

        return $this;
    }

    public function getTableTypeRowId(): ?int
    {
        return $this->table_type_row_id;
    }
}
