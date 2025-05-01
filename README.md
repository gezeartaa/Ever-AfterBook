# Ever-AfterBook 🎉  
A venue reservation management system built with PHP and MySQL

**Ever-AfterBook** is a web-based platform designed to manage event venue listings and reservation requests. It allows administrators to create and manage venues with images and capacity data, while users can browse and request bookings. The system also supports image handling and reservation status workflows.

---

## ✨ Features

- 🏛 **Venue Management:** Add, update, and delete venues
- 📷 **Image Uploads:** Support for main and additional venue images
- 📅 **Reservations:** Users can request venue bookings with custom messages
- ✅ **Approval Workflow:** Admins can approve or deny reservation applications
- 🔐 **Admin Controls:** (Optional) Authentication system for admin access
- 🧪 **Testing Suite:** Unit tests and full integration test of venue lifecycle
- 📦 **Mock Testing:** Use of FakeDB to simulate database for safe testing

---

## 🏗 Tech Stack

- **Backend:** PHP (MySQLi + procedural/OOP hybrid)
- **Database:** MySQL
- **Frontend:** HTML/CSS (ready to integrate with Bootstrap or JS)
- **Testing:** PHP-based test scripts with a custom mock database (FakeDB)

---

## 🚀 Getting Started

### Prerequisites

- PHP 7.4+
- MySQL Server
- XAMPP / MAMP / LAMP or another server stack

### Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/yourusername/ever-afterbook.git
   cd ever-afterbook
   ```

2. **Import the database**

   Open your database management tool (e.g., phpMyAdmin) and import the SQL schema located at:

   ```
   /db/schema.sql - coming soon
   ```

3. **Configure the database**

   Update your MySQL credentials in `db_connection.php`:

   ```php
   $conn = new mysqli('localhost', 'username', 'password', 'everafterbook');
   ```

4. **Run locally**

   Start your local server and navigate to:

   ```
   http://localhost/Ever-AfterBook/
   ```

---

## 🧪 Testing

The application includes both unit and integration tests located in the `tests/` directory.

### Run Tests

```bash
php tests/test_add_venue.php
php tests/test_delete_venue.php
php tests/test_update_venue.php
php tests/test_submitReservation.php
php tests/test_reservation_functions.php
php tests/venue_lifecycle_test.php
```

### Mock Database with FakeDB

The test suite includes a `FakeDB` class that simulates database behavior. This prevents real database writes and ensures isolated, safe unit testing. It replicates methods like `query`, `prepare`, `fetch_assoc`, and properties like `insert_id` and `error`.


---

## 📸 Sample Screenshots 

_Comming soon_

---

## 🤝 Contributing

Contributions are welcome! Here’s how you can help:

1. Fork this repository
2. Create a branch (`git checkout -b feature/my-feature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/my-feature`)
5. Open a Pull Request

---

## 📃 License

This project is licensed under the MIT License. Feel free to use and modify it for personal or commercial projects.

---

## 📬 Contact

Questions, suggestions, or bugs?  
Feel free to reach out by opening an issue or contacting the maintainer directly via GitHub.

---
