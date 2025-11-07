<?php
//CollectionInterface - Interface dasar untuk semua collection
interface CollectionInterface{
    public function size(): int;
    public function isEmpty(): bool;
    public function clear(): void;
    public function contains($element): bool;
    public function toArray(): array;
}

//ListInterface - Collection berurutan dengan akses index
interface ListInterface extends CollectionInterface{
    public function add($element): void;
    public function get(int $index);
    public function set(int $index, $element): void;
    public function remove(int $index): void;
    public function indexOf($element): int|false;
    public function addFirst($element): void;
    public function addLast($element): void;
}

//QueueInterface
interface QueueInterface extends CollectionInterface{
    public function enqueue($element): void;
    public function dequeue();
    public function peek();
}

//StackInterface
interface StackInterface extends CollectionInterface{
    public function push($element): void;
    public function pop();
    public function peek();
}

//MapInterface - Penyimpanan key-value pairs
interface MapInterface extends CollectionInterface
{
    public function put($key, $value): void;
    public function get($key);
    public function remove($key): bool;
    public function containsKey($key): bool;
    public function containsValue($value): bool;
    public function keys(): array;
    public function values(): array;
}

//IteratorInterface - Interface untuk iterasi custom
interface CustomIteratorInterface
{
    public function hasNext(): bool;
    public function next();
    public function current();
    public function reset(): void;
}

// CollectionIterator - Iterator untuk collection
class CollectionIterator implements CustomIteratorInterface
{
    private array $elements;
    private int $position = 0;
    
    public function __construct(CollectionInterface $collection)
    {
        $this->elements = $collection->toArray();
    }
    
    public function hasNext(): bool
    {
        return $this->position < count($this->elements);
    }
    
    public function next()
    {
        if (!$this->hasNext()) {
            throw new OutOfBoundsException("No more elements");
        }
        return $this->elements[$this->position++];
    }
    
    public function current()
    {
        if ($this->position >= count($this->elements)) {
            throw new OutOfBoundsException("No current element");
        }
        return $this->elements[$this->position];
    }
    
    public function reset(): void
    {
        $this->position = 0;
    }
}
?>