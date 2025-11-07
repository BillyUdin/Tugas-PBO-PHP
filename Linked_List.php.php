<?php

/**
 * Node class untuk LinkedList
 */
class Node {
    public $data;
    public ?Node $next;
    public ?Node $prev;
    
    public function __construct($data) {
        $this->data = $data;
        $this->next = null;
        $this->prev = null;
    }
}

/**
 * Interface untuk List
 */
interface ListInterface {
    public function add($element): bool;
    public function remove($element): bool;
    public function contains($element): bool;
    public function size(): int;
    public function isEmpty(): bool;
    public function clear(): void;
    public function toArray(): array;
    public function get(int $index);
    public function set(int $index, $element): void;
    public function indexOf($element): int;
    public function removeAt(int $index);
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
 * LinkedList Implementation
 * Struktur data berbasis node yang saling terhubung
 */
class LinkedList implements ListInterface, IteratorInterface {
    private ?Node $head = null;
    private ?Node $tail = null;
    private int $count = 0;
    private ?Node $current = null;
    
    /**
     * Menambahkan element ke akhir list
     */
    public function add($element): bool {
        $newNode = new Node($element);
        
        if ($this->head === null) {
            $this->head = $newNode;
            $this->tail = $newNode;
        } else {
            $this->tail->next = $newNode;
            $newNode->prev = $this->tail;
            $this->tail = $newNode;
        }
        
        $this->count++;
        return true;
    }
    
    /**
     * Menghapus element dari list
     */
    public function remove($element): bool {
        $current = $this->head;
        
        while ($current !== null) {
            if ($current->data === $element) {
                if ($current->prev !== null) {
                    $current->prev->next = $current->next;
                } else {
                    $this->head = $current->next;
                }
                
                if ($current->next !== null) {
                    $current->next->prev = $current->prev;
                } else {
                    $this->tail = $current->prev;
                }
                
                $this->count--;
                return true;
            }
            $current = $current->next;
        }
        
        return false;
    }
    
    /**
     * Mengecek apakah element ada di list
     */
    public function contains($element): bool {
        $current = $this->head;
        while ($current !== null) {
            if ($current->data === $element) {
                return true;
            }
            $current = $current->next;
        }
        return false;
    }
    
    /**
     * Mendapatkan ukuran list
     */
    public function size(): int {
        return $this->count;
    }
    
    /**
     * Mengecek apakah list kosong
     */
    public function isEmpty(): bool {
        return $this->count === 0;
    }
    
    /**
     * Menghapus semua element
     */
    public function clear(): void {
        $this->head = null;
        $this->tail = null;
        $this->count = 0;
    }
    
    /**
     * Konversi ke array
     */
    public function toArray(): array {
        $array = [];
        $current = $this->head;
        while ($current !== null) {
            $array[] = $current->data;
            $current = $current->next;
        }
        return $array;
    }
    
    /**
     * Mendapatkan element berdasarkan index
     */
    public function get(int $index) {
        if ($index < 0 || $index >= $this->count) {
            throw new OutOfBoundsException("Index out of bounds");
        }
        
        $current = $this->head;
        for ($i = 0; $i < $index; $i++) {
            $current = $current->next;
        }
        
        return $current->data;
    }
    
    /**
     * Mengubah element pada index tertentu
     */
    public function set(int $index, $element): void {
        if ($index < 0 || $index >= $this->count) {
            throw new OutOfBoundsException("Index out of bounds");
        }
        
        $current = $this->head;
        for ($i = 0; $i < $index; $i++) {
            $current = $current->next;
        }
        
        $current->data = $element;
    }
    
    /**
     * Mencari index element
     */
    public function indexOf($element): int {
        $current = $this->head;
        $index = 0;
        
        while ($current !== null) {
            if ($current->data === $element) {
                return $index;
            }
            $current = $current->next;
            $index++;
        }
        
        return -1;
    }
    
    /**
     * Menghapus element pada index tertentu
     */
    public function removeAt(int $index) {
        if ($index < 0 || $index >= $this->count) {
            throw new OutOfBoundsException("Index out of bounds");
        }
        
        $current = $this->head;
        for ($i = 0; $i < $index; $i++) {
            $current = $current->next;
        }
        
        $data = $current->data;
        
        if ($current->prev !== null) {
            $current->prev->next = $current->next;
        } else {
            $this->head = $current->next;
        }
        
        if ($current->next !== null) {
            $current->next->prev = $current->prev;
        } else {
            $this->tail = $current->prev;
        }
        
        $this->count--;
        return $data;
    }
    
    // ===== Iterator Methods =====
    
    public function hasNext(): bool {
        if ($this->current === null) {
            return $this->head !== null;
        }
        return $this->current->next !== null;
    }
    
    public function next() {
        if ($this->current === null) {
            $this->current = $this->head;
        } else {
            $this->current = $this->current->next;
        }
        
        if ($this->current === null) {
            throw new OutOfBoundsException("No more elements");
        }
        
        return $this->current->data;
    }
    
    public function reset(): void {
        $this->current = null;
    }
}

// ===== CONTOH PENGGUNAAN =====

echo "=== DEMO LINKEDLIST ===\n\n";

$list = new LinkedList();

// Menambahkan data
echo "1. Menambahkan data:\n";
$list->add("Jakarta");
$list->add("Bandung");
$list->add("Surabaya");
$list->add("Medan");
echo "   Data: " . implode(" -> ", $list->toArray()) . "\n";
echo "   Size: " . $list->size() . "\n\n";

// Mengakses data
echo "2. Mengakses data:\n";
echo "   Index 0: " . $list->get(0) . "\n";
echo "   Index 2: " . $list->get(2) . "\n\n";

// Mencari data
echo "3. Mencari data:\n";
echo "   Index of 'Bandung': " . $list->indexOf("Bandung") . "\n";
echo "   Contains 'Surabaya': " . ($list->contains("Surabaya") ? "Ya" : "Tidak") . "\n\n";

// Mengubah data
echo "4. Mengubah data index 1:\n";
$list->set(1, "Yogyakarta");
echo "   Data: " . implode(" -> ", $list->toArray()) . "\n\n";

// Menghapus data
echo "5. Menghapus 'Surabaya':\n";
$list->remove("Surabaya");
echo "   Data: " . implode(" -> ", $list->toArray()) . "\n\n";

// Iterator
echo "6. Iterasi dengan Iterator:\n";
$list->reset();
while ($list->hasNext()) {
    echo "   - " . $list->next() . "\n";
}

?>