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
    public $error = null; // Simulate MySQL error property
    public $insert_id = 1001; // Simulate the insert_id, set to any value for testing

    // Simulate queries
    public function query($query) {
        // echo "Simulating query: $query\n";

        // Simulate INSERT query
        if (strpos($query, "INSERT INTO venues") !== false) {
            // Simulate insert query (set insert_id to simulate auto-increment value)
            return true; // Simulating successful insert
        }

        // Simulate SELECT for active reservations (example)
        if (strpos($query, "SELECT COUNT(*) AS count") !== false) {
            if (strpos($query, "WHERE venue_id = 1") !== false) {
                return new FakeResult(1); // Simulating 1 active reservation for venue ID 1
            } else {
                return new FakeResult(0); // No active reservations for other venues
            }
        }

        // Simulate SELECT image_url for venue images
        if (strpos($query, "SELECT image_url FROM venue_images WHERE venue_id") !== false) {
            if (strpos($query, "WHERE venue_id = 29") !== false) {
                return new FakeResultImage([
                    ['image_url' => 'images/venue_images/29_main_image.jpg'],
                    ['image_url' => 'images/venue_images/29_extra_image1.jpg'],
                ]);
            }
            return new FakeResultImage(); // No images for other venue IDs
        }

        // Simulate UPDATE query
        if (strpos($query, "UPDATE venues SET") !== false) {
            $this->error = null; // Simulate no error
            return true; // Simulate successful query execution
        }

        // Simulate DELETE query (successful)
        if (strpos($query, "DELETE FROM venues WHERE venue_id") !== false) {
            return true; // Simulating successful delete
        }

        return false; // Default failure return
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


class FakeResult {
    private $rowCount;

    public function __construct($rowCount) {
        $this->rowCount = $rowCount;
    }

    public function fetch_assoc() {
        if ($this->rowCount > 0) {
            return ['count' => $this->rowCount]; // Simulate result with count
        }
        return null; // Simulate no result
    }
}

class FakeResultImage {
    private $images;

    public function __construct($images = []) {
        $this->images = $images;
    }

    public function fetch_assoc() {
        // Simulate fetching image URLs
        if (!empty($this->images)) {
            return array_shift($this->images); // Return images one by one
        }
        return null; // No more images
    }
}


?>