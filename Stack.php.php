<?php

/**
 * Interface untuk Collection
 */
interface CollectionInterface {
    public function add($element): bool;
    public function remove($element): bool;
    public function contains($element): bool;
    public function size(): int;
    public function isEmpty(): bool;
    public function clear(): void;
    public function toArray(): array;
}

/**
 * Interface untuk Iterator
 */
interface IteratorInterface {
    public function hasNext(): bool;
    public function next();
    public function reset(): void;
}

/**
 * Stack Implementation (LIFO - Last In First Out)
 * Element terakhir yang masuk adalah yang pertama keluar
 */
class Stack implements CollectionInterface, IteratorInterface {
    private array $elements = [];
    private int $position = 0;
    
    /**
     * Menambahkan element ke top stack (push)
     */
    public function push($element): void {
        array_push($this->elements, $element);
    }
    
    /**
     * Menghapus dan mengembalikan element dari top stack (pop)
     */
    public function pop() {
        if ($this->isEmpty()) {
            throw new UnderflowException("Stack is empty");
        }
        return array_pop($this->elements);
    }
    
    /**
     * Melihat element teratas tanpa menghapus (peek)
     */
    public function peek() {
        if ($this->isEmpty()) {
            throw new UnderflowException("Stack is empty");
        }
        return $this->elements[count($this->elements) - 1];
    }
    
    /**
     * Menambahkan element (alias untuk push)
     */
    public function add($element): bool {
        $this->push($element);
        return true;
    }
    
    /**
     * Menghapus element tertentu dari stack
     */
    public function remove($element): bool {
        $index = array_search($element, $this->elements, true);
        if ($index !== false) {
            array_splice($this->elements, $index, 1);
            return true;
        }
        return false;
    }
    
    /**
     * Mengecek apakah element ada di stack
     */
    public function contains($element): bool {
        return in_array($element, $this->elements, true);
    }
    
    /**
     * Mendapatkan jumlah element
     */
    public function size(): int {
        return count($this->elements);
    }
    
    /**
     * Mengecek apakah stack kosong
     */
    public function isEmpty(): bool {
        return empty($this->elements);
    }
    
    /**
     * Menghapus semua element
     */
    public function clear(): void {
        $this->elements = [];
    }
    
    /**
     * Konversi ke array
     */
    public function toArray(): array {
        return $this->elements;
    }
    
    // ===== Iterator Methods =====
    
    public function hasNext(): bool {
        return $this->position < $this->size();
    }
    
    public function next() {
        if (!$this->hasNext()) {
            throw new OutOfBoundsException("No more elements");
        }
        return $this->elements[$this->position++];
    }
    
    public function reset(): void {
        $this->position = 0;
    }
}

// ===== CONTOH PENGGUNAAN =====

echo "=== DEMO STACK (LIFO) ===\n\n";

$stack = new Stack();

// Push elements
echo "1. Push elements ke Stack:\n";
$stack->push("Piring 1");
$stack->push("Piring 2");
$stack->push("Piring 3");
$stack->push("Piring 4");
echo "   Stack: [" . implode(", ", $stack->toArray()) . "]\n";
echo "   Size: " . $stack->size() . "\n\n";

// Peek
echo "2. Peek (lihat top element):\n";
echo "   Top: " . $stack->peek() . "\n\n";

// Pop
echo "3. Pop (ambil & hapus top element):\n";
echo "   Popped: " . $stack->pop() . "\n";
echo "   Stack: [" . implode(", ", $stack->toArray()) . "]\n\n";

// Pop lagi
echo "4. Pop lagi:\n";
echo "   Popped: " . $stack->pop() . "\n";
echo "   Stack: [" . implode(", ", $stack->toArray()) . "]\n\n";

// Contains
echo "5. Cek element:\n";
echo "   Contains 'Piring 2': " . ($stack->contains("Piring 2") ? "Ya" : "Tidak") . "\n";
echo "   Contains 'Piring 4': " . ($stack->contains("Piring 4") ? "Ya" : "Tidak") . "\n\n";

// Iterator
echo "6. Iterasi Stack (dari bottom ke top):\n";
$stack->reset();
while ($stack->hasNext()) {
    echo "   - " . $stack->next() . "\n";
}

echo "\n7. Analogi Stack:\n";
echo "   - Seperti tumpukan piring\n";
echo "   - Piring terakhir ditaruh, pertama diambil\n";
echo "   - Digunakan untuk: Undo/Redo, Browser History, dll\n";

?>