<?php
class FakeStmt {
    public function bind_param($types, ...$vars) {}
    public function execute() { return true; }
    public function close() {}
    public function get_result() { return false; }
    public function store_result() {}
    public function num_rows() { return 0; }
    public function bind_result(&...$vars) {}
    public function fetch() { return false; }
}

class FakeDB {
    private $data = [];
    private $images = [];

    public function query($query) {
        // echo "Simulating query: $query\n";

        // Simulate the venue update
        if (strpos($query, "UPDATE venues SET") !== false) {
            return true; // Simulate successful update query
        }

        // Simulate updating venue images
        if (strpos($query, "UPDATE venue_images SET is_main = 0 WHERE venue_id =") !== false) {
            return true; // Simulate successful image update
        }

        // Simulate inserting new images (as part of update)
        if (strpos($query, "INSERT INTO venue_images") !== false) {
            $this->images[] = $query; // Store the simulated insert query for images
            return true; // Simulate successful insert
        }

        return false;
    }

    public function real_escape_string($string) {
        return addslashes($string); // Simulate escaping
    }

    public function prepare($query) {
        return new FakeStmt(); // Return fake statement
    }

    public function close() {
        // No operation for fake DB
    }
}
