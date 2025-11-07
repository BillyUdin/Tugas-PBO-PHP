<?php

/**
 * Interface untuk Map
 */
interface MapInterface {
    public function put($key, $value): void;
    public function get($key);
    public function containsKey($key): bool;
    public function remove($key);
    public function size(): int;
    public function isEmpty(): bool;
    public function keys(): array;
    public function values(): array;
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
 * HashMap Implementation
 * Struktur data key-value pairs dengan akses cepat O(1)
 */
class HashMap implements MapInterface, IteratorInterface {
    private array $map = [];
    private array $keys = [];
    private int $position = 0;
    
    /**
     * Menyimpan key-value pair
     */
    public function put($key, $value): void {
        if (!$this->containsKey($key)) {
            $this->keys[] = $key;
        }
        $this->map[$key] = $value;
    }
    
    /**
     * Mendapatkan value berdasarkan key
     */
    public function get($key) {
        if (!$this->containsKey($key)) {
            throw new OutOfBoundsException("Key not found: " . $key);
        }
        return $this->map[$key];
    }
    
    /**
     * Mengecek apakah key ada
     */
    public function containsKey($key): bool {
        return array_key_exists($key, $this->map);
    }
    
    /**
     * Menghapus key-value pair
     */
    public function remove($key) {
        if (!$this->containsKey($key)) {
            throw new OutOfBoundsException("Key not found: " . $key);
        }
        
        $value = $this->map[$key];
        unset($this->map[$key]);
        
        $index = array_search($key, $this->keys, true);
        if ($index !== false) {
            array_splice($this->keys, $index, 1);
        }
        
        return $value;
    }
    
    /**
     * Mendapatkan jumlah key-value pairs
     */
    public function size(): int {
        return count($this->map);
    }
    
    /**
     * Mengecek apakah map kosong
     */
    public function isEmpty(): bool {
        return empty($this->map);
    }
    
    /**
     * Mendapatkan semua keys
     */
    public function keys(): array {
        return $this->keys;
    }
    
    /**
     * Mendapatkan semua values
     */
    public function values(): array {
        return array_values($this->map);
    }
    
    /**
     * Menghapus semua data
     */
    public function clear(): void {
        $this->map = [];
        $this->keys = [];
    }
    
    /**
     * Konversi ke array asosiatif
     */
    public function toArray(): array {
        return $this->map;
    }
    
    // ===== Iterator Methods =====
    
    public function hasNext(): bool {
        return $this->position < count($this->keys);
    }
    
    public function next() {
        if (!$this->hasNext()) {
            throw new OutOfBoundsException("No more elements");
        }
        
        $key = $this->keys[$this->position++];
        return ['key' => $key, 'value' => $this->map[$key]];
    }
    
    public function reset(): void {
        $this->position = 0;
    }
}

// ===== CONTOH PENGGUNAAN =====

echo "=== DEMO HASHMAP ===\n\n";

$map = new HashMap();

// Put data
echo "1. Menyimpan data mahasiswa:\n";
$map->put("nama", "Budi Santoso");
$map->put("npm", "2024001");
$map->put("jurusan", "Informatika");
$map->put("semester", 5);
$map->put("ipk", 3.75);
echo "   Data tersimpan!\n\n";

// Get data
echo "2. Mengambil data:\n";
echo "   Nama: " . $map->get("nama") . "\n";
echo "   NPM: " . $map->get("npm") . "\n";
echo "   Jurusan: " . $map->get("jurusan") . "\n";
echo "   IPK: " . $map->get("ipk") . "\n\n";

// Keys & Values
echo "3. Menampilkan semua keys:\n";
echo "   Keys: [" . implode(", ", $map->keys()) . "]\n\n";

echo "4. Menampilkan semua values:\n";
echo "   Values: [" . implode(", ", $map->values()) . "]\n\n";

// Contains
echo "5. Cek key:\n";
echo "   Contains 'nama': " . ($map->containsKey("nama") ? "Ya" : "Tidak") . "\n";
echo "   Contains 'alamat': " . ($map->containsKey("alamat") ? "Ya" : "Tidak") . "\n\n";

// Update
echo "6. Update data:\n";
$map->put("semester", 6);
echo "   Semester diupdate ke: " . $map->get("semester") . "\n\n";

// Remove
echo "7. Hapus data 'ipk':\n";
$removed = $map->remove("ipk");
echo "   Removed value: " . $removed . "\n";
echo "   Keys sekarang: [" . implode(", ", $map->keys()) . "]\n\n";

// Iterator
echo "8. Iterasi semua data:\n";
$map->reset();
while ($map->hasNext()) {
    $entry = $map->next();
    echo "   " . $entry['key'] . " => " . $entry['value'] . "\n";
}

echo "\n9. Info HashMap:\n";
echo "   Size: " . $map->size() . "\n";
echo "   Is Empty: " . ($map->isEmpty() ? "Ya" : "Tidak") . "\n";

?>