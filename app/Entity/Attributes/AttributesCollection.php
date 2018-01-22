<?php

namespace App\Entity\Attributes;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use IteratorAggregate;
use Traversable;


/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AttributesCollection implements ArrayAccess, Arrayable, IteratorAggregate
{
    private $collection;

    public function __construct()
    {
        $this->collection = new Collection();
    }

    public function findAttributeById($attributeId) : ?AAttribute
    {
        foreach ($this->collection as $attribute) {
            $resultAttribute = (new AttributeFinderFactoryMethod(app()))->make($attribute)->find($attribute, $attributeId);
            if ($resultAttribute) {
                return $resultAttribute;
            }
        }
        return null;
    }

    public function isEmpty(){
        return $this->collection->isEmpty();
    }

    public function each($callback, $onlyAttributes = false){
        $this->collection->each(function($item) use ($callback, $onlyAttributes) {
            if($item->getTypeName() == 'table'){
                if(!$onlyAttributes){
                    $callback($item);
                }
                foreach ($item->getValue()->getRows() as $row){
                    foreach ($row->getCells() as $attribute) {
                        $callback($attribute);
                    }
                }
            } else {
                $callback($item);
            }
        });
    }

    public function push(AAttribute $value)
    {
        return $this->collection->push($value);
    }

    public function put($key, AAttribute $value)
    {
        return $this->collection->put($key, $value);
    }

    public function has($key)
    {
        return $this->collection->has($key);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->collection->toArray();
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->collection->offsetExists($offset);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->collection->offsetGet($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->collection->offsetSet($offset, $value);
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->collection->offsetUnset($offset);
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return $this->collection->getIterator();
    }
}