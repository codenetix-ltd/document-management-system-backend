<?php
namespace App\Builders\ParameterBuilders;
use App\Contracts\Builders\IDocumentParameterCollectionBuilder;
use App\Entity\Document;
use App\Entity\Parameters\BooleanParameter;
use App\Entity\Parameters\CollectionParameter;
use App\Entity\Parameters\FileParameter;
use App\Entity\Parameters\ParametersCollection;
use App\Entity\Parameters\StringParameter;
use App\Entity\Parameters\Table;
use App\Entity\Parameters\TableParameter;
use App\Entity\Parameters\TableRow;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
abstract class BaseParameterCollectionBuilder implements IDocumentParameterCollectionBuilder
{

    protected $parameterBuilders;

    protected $allowedKeys;

    /**
     * BaseParameterCollectionBuilder constructor.
     */
    public function __construct()
    {
        $this->parameterBuilders = new Collection();
        $this->allowedKeys = new Collection();
    }

    protected abstract function defineParameterBuilders();

    protected abstract function defineAllowedParameterKeys();

    public function build(): ParametersCollection
    {
        $this->defineParameterBuilders();
        $this->defineAllowedParameterKeys();

        $parameters = new ParametersCollection();

        foreach ($this->allowedKeys as $key){
            $parameters->push(($this->parameterBuilders->get($key))());
        }

        return $parameters;
    }
}