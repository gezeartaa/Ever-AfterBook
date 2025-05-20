<!DOCTYPE html>
<html lang="en">
  <head>
    <title>EverAfterBook</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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

    </style>
  </head>

  <body>

    <?php include('header.php'); ?>

    <main>
    <div class="main-content">
  <div class="pink-box">
    <h1 class="title-text">Find Your Perfect Wedding Venue</h1>
    <!-- <div class="line"></div> -->
     <hr class="divider">
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
              <img src="uploads/1744163559_starrymain.png" class="d-block w-100" alt="Venue 1">
            </div>
            <div class="carousel-item">
              <img src="uploads/1744375447_edenmain.jpg" class="d-block w-100" alt="Venue 2">
            </div>
            <div class="carousel-item">
              <img src="uploads/1744375469_wintermain.jpg" class="d-block w-100" alt="Venue 3">
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
       <h2 class="text-center mb-4">Gallery</h2>
      <div class="gallery">
        <img src="uploads/1744163558_starry1.jpg" alt="Gallery Image 1">
        <img src="uploads/1744375447_edenmain.jpg" alt="Gallery Image 2">
        <img src="uploads/1744375469_winter1.jpg" alt="Gallery Image 3">
        <img src="uploads/1744375447_eden4.jpg" alt="Gallery Image 4">
        <img src="uploads/1744375447_eden1.jpg" alt="Gallery Image 4">
        <img src="uploads/1744375929_ranchmain.jpg" alt="Gallery Image 4">
        <img src="images/venue images/1745935667_b1.jpg" alt="Gallery Image 4">
        <img src="images/venue images/1745935667_b.jpg" alt="Gallery Image 4">
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
