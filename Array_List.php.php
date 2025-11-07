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
 * Interface untuk List
 */
interface ListInterface extends CollectionInterface {
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
 * ArrayList Implementation
 * Struktur data berbasis array dinamis dengan akses cepat
 */
class ArrayList implements ListInterface, IteratorInterface {
    private array $elements = [];
    private int $position = 0;
    
    /**
     * Menambahkan element ke list
     */
    public function add($element): bool {
        $this->elements[] = $element;
        return true;
    }
    
    /**
     * Menghapus element dari list
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
     * Mengecek apakah element ada di list
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
     * Mengecek apakah list kosong
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
    
    /**
     * Mendapatkan element pada index tertentu
     */
    public function get(int $index) {
        if ($index < 0 || $index >= $this->size()) {
            throw new OutOfBoundsException("Index out of bounds");
        }
        return $this->elements[$index];
    }
    
    /**
     * Mengubah element pada index tertentu
     */
    public function set(int $index, $element): void {
        if ($index < 0 || $index >= $this->size()) {
            throw new OutOfBoundsException("Index out of bounds");
        }
        $this->elements[$index] = $element;
    }
    
    /**
     * Mencari index dari element
     */
    public function indexOf($element): int {
        $index = array_search($element, $this->elements, true);
        return $index !== false ? $index : -1;
    }
    
    /**
     * Menghapus element pada index tertentu
     */
    public function removeAt(int $index) {
        if ($index < 0 || $index >= $this->size()) {
            throw new OutOfBoundsException("Index out of bounds");
        }
        $element = $this->elements[$index];
        array_splice($this->elements, $index, 1);
        return $element;
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

echo "=== DEMO ARRAYLIST ===\n\n";

$list = new ArrayList();

// Menambahkan data
echo "1. Menambahkan data:\n";
$list->add("Apple");
$list->add("Banana");
$list->add("Cherry");
$list->add("Date");
echo "   ArrayList: [" . implode(", ", $list->toArray()) . "]\n";
echo "   Size: " . $list->size() . "\n\n";

// Mengakses data
echo "2. Mengakses data:\n";
echo "   Index 0: " . $list->get(0) . "\n";
echo "   Index 2: " . $list->get(2) . "\n\n";

// Mencari data
echo "3. Mencari data:\n";
echo "   Index of 'Banana': " . $list->indexOf("Banana") . "\n";
echo "   Contains 'Cherry': " . ($list->contains("Cherry") ? "Yes" : "No") . "\n\n";

// Mengubah data
echo "4. Mengubah data index 1:\n";
$list->set(1, "Blueberry");
echo "   ArrayList: [" . implode(", ", $list->toArray()) . "]\n\n";

// Menghapus data
echo "5. Menghapus data pada index 2:\n";
$removed = $list->removeAt(2);
echo "   Removed: " . $removed . "\n";
echo "   ArrayList: [" . implode(", ", $list->toArray()) . "]\n\n";

// Iterator
echo "6. Iterasi dengan Iterator:\n";
$list->reset();
while ($list->hasNext()) {
    echo "   - " . $list->next() . "\n";
}

?>