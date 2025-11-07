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
 * Interface untuk Queue
 */
interface QueueInterface extends CollectionInterface {
    public function enqueue($element): void;
    public function dequeue();
    public function peek();
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
 * Queue Implementation (FIFO - First In First Out)
 * Element pertama yang masuk adalah yang pertama keluar
 */
class Queue implements QueueInterface, IteratorInterface {
    private array $elements = [];
    private int $position = 0;
    
    /**
     * Menambahkan element ke belakang queue (enqueue)
     */
    public function enqueue($element): void {
        array_push($this->elements, $element);
    }
    
    /**
     * Menghapus dan mengembalikan element dari depan queue (dequeue)
     */
    public function dequeue() {
        if ($this->isEmpty()) {
            throw new UnderflowException("Queue is empty");
        }
        return array_shift($this->elements);
    }
    
    /**
     * Melihat element terdepan tanpa menghapus (peek)
     */
    public function peek() {
        if ($this->isEmpty()) {
            throw new UnderflowException("Queue is empty");
        }
        return $this->elements[0];
    }
    
    /**
     * Menambahkan element (alias untuk enqueue)
     */
    public function add($element): bool {
        $this->enqueue($element);
        return true;
    }
    
    /**
     * Menghapus element tertentu dari queue
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
     * Mengecek apakah element ada di queue
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
     * Mengecek apakah queue kosong
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

echo "=== DEMO QUEUE (FIFO) ===\n\n";

$queue = new Queue();

// Enqueue elements
echo "1. Enqueue (tambah ke belakang):\n";
$queue->enqueue("Pelanggan 1");
$queue->enqueue("Pelanggan 2");
$queue->enqueue("Pelanggan 3");
$queue->enqueue("Pelanggan 4");
echo "   Queue: [" . implode(", ", $queue->toArray()) . "]\n";
echo "   Size: " . $queue->size() . "\n\n";

// Peek
echo "2. Peek (lihat element terdepan):\n";
echo "   Front: " . $queue->peek() . "\n\n";

// Dequeue
echo "3. Dequeue (ambil & hapus dari depan):\n";
echo "   Served: " . $queue->dequeue() . "\n";
echo "   Queue: [" . implode(", ", $queue->toArray()) . "]\n\n";

// Dequeue lagi
echo "4. Dequeue lagi:\n";
echo "   Served: " . $queue->dequeue() . "\n";
echo "   Queue: [" . implode(", ", $queue->toArray()) . "]\n\n";

// Tambah lagi
echo "5. Enqueue pelanggan baru:\n";
$queue->enqueue("Pelanggan 5");
echo "   Queue: [" . implode(", ", $queue->toArray()) . "]\n\n";

// Iterator
echo "6. Iterasi Queue (dari depan ke belakang):\n";
$queue->reset();
$no = 1;
while ($queue->hasNext()) {
    echo "   Posisi " . $no++ . ": " . $queue->next() . "\n";
}

echo "\n7. Analogi Queue:\n";
echo "   - Seperti antrian di kasir\n";
echo "   - Yang datang pertama, dilayani pertama\n";
echo "   - Digunakan untuk: Print Queue, Task Scheduling, dll\n";

?>