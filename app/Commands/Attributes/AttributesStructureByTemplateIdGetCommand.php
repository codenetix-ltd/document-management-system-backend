<?php

namespace App\Commands\Attributes;

use App\Adapters\AttributeCollectionAdapter;
use App\Attribute;
use App\AttributeValue;
use App\Contracts\Commands\ACommand;
use App\Contracts\Entity\IHasAttributes;
use App\Contracts\Exceptions\ICommandException;
use App\Entity\ValueWithDeviations;
use Illuminate\Contracts\Container\Container;

class AttributesStructureByTemplateIdGetCommand extends ACommand
{

    private $context;

    private $templateId;

    private $documentVersionId;

    public function __construct(Container $container, IHasAttributes $context, int $templateId, int $documentVersionId = null)
    {
        parent::__construct($container);

        $this->context = $context;
        $this->templateId = $templateId;
        $this->documentVersionId = $documentVersionId;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $attributeModels = Attribute::whereTemplateId($this->templateId)->whereNull('parent_attribute_id')->orderBy('order', 'ASC')->get();

        $attributes = (new AttributeCollectionAdapter($this->container))->transform($attributeModels);

        if($this->documentVersionId){
            $attributeValueModels = AttributeValue::whereDocumentVersionId($this->documentVersionId)->get();
            $attributes->each(function($item) use ($attributes, $attributeValueModels) {
                $foundAttribute = $attributeValueModels->where('attribute_id', $item->getId())->first();
                if($foundAttribute){
                    if($item->getTypeName() == 'value_with_deviations'){
                        if(!empty($foundAttribute->value)){
                            $v = json_decode($foundAttribute->value, true);
                            $item->setValue(new ValueWithDeviations(str_replace(',', '.', $v['left']), str_replace(',', '.', $v['value']), str_replace(',', '.', $v['right'])));
                        }
                    } else {
                        if(!empty($foundAttribute->value)){
                            $item->setValue(is_numeric(str_replace(',', '.', $foundAttribute->value)) ? str_replace(',', '.', $foundAttribute->value) : $foundAttribute->value);
                        }
                    }
                } else {
                    //TODO
                    if($item->getTypeName() == 'value_with_deviations') {
                        $item->setValue(new ValueWithDeviations());
                    }
                }
            }, true);
        }

        $this->executed = true;
        $this->context->setAttributes($attributes);
    }
}
