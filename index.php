<!DOCTYPE html>
<html lang="en">
  <head>
    <title>EverAfterBook</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="script.js" defer></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
      defer
    ></script>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap"
      rel="stylesheet"
    />

    <style>
      body {
        background-color: #f9f4f7; /* Soft background color */
        font-family: 'Playfair Display', serif; /* Elegant font */
      }

      .navbar {
        background-color: #e0c7d1; /* Soft pink for the navbar */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border: 0;
      }

      .navbar-brand {
        font-size: 2rem;
        font-weight: bold;
        color: #a97383; /* Subtle pink color */
      }

      .navbar-nav .nav-link {
        color: #a97383;
        font-size: 1.1rem;
        text-transform: uppercase;
      }

      .navbar-nav .nav-link:hover {
        color: #f3a8b0;
      }

     

      .main-content {
  background: url('images/aboutusbg.jpg') no-repeat center center/cover;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.pink-box {
  background-color: rgba(255, 255, 255, 0.8);
  padding: 40px 50px;
  text-align: center;
  border-radius: 15px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  max-width: 600px;
  width: 100%;
}

h1 {
  font-size: 3.5rem;
  color: #f46e6e; /* Soft pinkish-red */
  font-family: 'Playfair Display', serif;
  margin-bottom: 15px;
}

.line {
  width: 50px;
  height: 4px;
  background-color: #f46e6e;
  margin: 15px auto;
}

.search-description {
  font-size: 1.1rem;
  color: #555;
  margin-bottom: 30px;
  font-family: 'Playfair Display', serif;
}

.btn-pink {
  background-color: #f46e6e;
  color: white;
  border: none;
  padding: 15px 35px;
  font-size: 1.3rem;
  text-transform: uppercase;
  border-radius: 50px;
  transition: all 0.3s ease;
}

.btn-pink:hover {
  background-color: #e06d6d;
  transform: scale(1.1);
}

@media (max-width: 768px) {
  .pink-box {
    padding: 30px;
    width: 80%;
  }

  h1 {
    font-size: 2.5rem;
  }

  .btn-pink {
    font-size: 1.1rem;
    padding: 12px 30px;
  }
}


      footer {
        background-color: #a97383; /* Soft pink footer */
        color: white;
        padding: 30px;
        text-align: center;
        font-size: 1rem;
      }

      footer a {
        color: white;
        text-decoration: none;
        font-weight: bold;
      }

      footer a:hover {
        color: #f46e6e;
      }

      /* Venue Showcase (Carousel) */
      .venue-carousel img {
        border-radius: 10px;
        height: 400px;
        object-fit: cover; /* Ensure the images fit within their box */
        width: 100%;
      }

      .carousel-item {
        max-height: 500px; /* Ensure a fixed height for the carousel images */
      }

      .testimonial-section {
        background-color: #f8f4f1;
        padding: 50px 0;
      }

      .testimonial-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
      }

      .testimonial-card img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 15px;
        object-fit: cover;
      }

      .gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Adjust column width */
  gap: 20px;
  padding: 50px 0;
  grid-template-rows: repeat(auto-fill, minmax(200px, 300px)); /* Vary the row heights */
}

.gallery img {
  width: 100%;
  border-radius: 10px;
  height: 100%; /* Let images fill their grid area */
  object-fit: cover;
  transition: transform 0.3s ease-in-out;
}

.gallery img:hover {
  transform: scale(1.05); /* Slight zoom effect on hover */
}


      .contact-form {
        background-color: #f9f4f7;
        padding: 50px 0;
        text-align: center;
      }

      .contact-form input,
      .contact-form textarea {
        width: 80%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
      }

      .contact-form button {
        background-color: #f46e6e;
        color: white;
        padding: 12px 30px;
        font-size: 1.2rem;
        border: none;
        border-radius: 50px;
        cursor: pointer;
      }
    </style>
  </head>

  <body>

    <?php include('header.php'); ?>

    <main>
    <div class="main-content">
  <div class="pink-box">
    <h1>Find Your Perfect Wedding Venue</h1>
    <div class="line"></div>
    <p class="search-description">Explore a curated list of the most stunning wedding venues. Let us help you make your big day even more special!</p>
    <button class="btn btn-pink" onclick="changeToSearchTab()">Search for a venue</button>
  </div>
</div>

      <!-- Venue Showcase (Carousel) -->
      <div class="container mt-5">
        <h2 class="text-center mb-4">Popular Venues</h2>
        <div id="venueCarousel" class="carousel slide venue-carousel" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="images/venue images/eden/eden1.jpg" class="d-block w-100" alt="Venue 1">
            </div>
            <div class="carousel-item">
              <img src="images/venue images/eden/eden2.jpg" class="d-block w-100" alt="Venue 2">
            </div>
            <div class="carousel-item">
              <img src="images/venue images/eden/eden3.jpg" class="d-block w-100" alt="Venue 3">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#venueCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#venueCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>

      <!-- Testimonials Section -->
      <div class="testimonial-section">
        <h2 class="text-center mb-4">What Our Clients Say</h2>
        <div class="container d-flex justify-content-center">
          <div class="testimonial-card mx-3">
            <img src="images/client1.jpg" alt="Client 1">
            <p>"The team at EverAfterBook made our dream wedding a reality. We couldn't be happier with our venue!"</p>
            <p><strong>Jane & John</strong></p>
          </div>
          <div class="testimonial-card mx-3">
            <img src="images/client2.jpg" alt="Client 2">
            <p>"The venue we chose was perfect. Thank you for helping us find such a beautiful location!"</p>
            <p><strong>Alice & Bob</strong></p>
          </div>
        </div>
      </div>

      <!-- Gallery Section -->
      <div class="gallery">
        <img src="images/venue images/winter/winter1.jpg" alt="Gallery Image 1">
        <img src="images/venue images/winter/winter2.jpg" alt="Gallery Image 2">
        <img src="images/venue images/winter/winter3.jpg" alt="Gallery Image 3">
        <img src="images/venue images/winter/winter4.jpg" alt="Gallery Image 4">
      </div>

      <!-- Contact Section -->
      <div class="contact-form">
        <h2>Get in Touch</h2>
        <p>Have a question or need more information? Reach out to us!</p>
        <form>
          <input type="text" placeholder="Your Name" required>
          <input type="email" placeholder="Your Email" required>
          <textarea placeholder="Your Message" required></textarea>
          <button type="submit">Send Message</button>
        </form>
      </div>
    </main>

    <?php include('footer.php'); ?>

  </body>
</html>
