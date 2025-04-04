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
      href="https://fonts.googleapis.com/css?family=Noto Serif Oriya"
      rel="stylesheet"
    />
  </head>

  <body>

  <?php include('header.php'); ?>
    <main>


      <div
        class="tab-content container justify-content-center w-h-full"
        id="myTabContent"
      >
        <div
          class="tab-pane fade show active flex-center w-h-full"
          id="home"
          role="tabpanel"
          aria-labelledby="home-tab"
        >
          <div class="flex-center flex-center w-h-full">
            <div class="flex-col flex-center pink-box gap">
              <h1>Find your perfect wedding venue</h1>
              <div class="line"></div>
              <button class="btn btn-pink" onclick="changeToSearchTab()">
                Search for a venue
              </button>
            </div>
          </div>
        </div>

        
    </main>
  </body>
</html>
