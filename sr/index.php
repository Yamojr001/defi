<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FAQ Section</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      .loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
      }
      .carousel-item img {
        display: none;
        height: 400px; 
        object-fit: cover; 
      }
      .carousel-item img.loaded {
        display: block;
      }
      .navbar-toggler {
        border-color: rgba(255, 255, 255, .1);
      }
      .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf-8,%3csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
      }
    </style>
  </head>
  <body>
    <div class="loading">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

   <?php include'../includes/navusersr.php'; ?>

    <div id="carouselExampleDark" class="carousel carousel-dark slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="3000">
          <img src="../images/download.jpg" class="d-block w-100" alt="..." onload="this.classList.add('loaded'); hideLoader();">
          <div class="carousel-caption d-block d-md-block" style="color: #030366;">
            <h2 class="t" style="font-family: 'Times New Roman', Times, serif; font-size: xx-large; color:#030366 ; font-weight: bolder;">Fighting Scams, Restoring Trust: Your Partner in Recovery</h2>
            <p>Your Trusted Partner in Recovering from Fraud. We specialize in helping victims rebuild their lives and reclaim their financial security. Trust us to be your antidote to fraud.</p>
            <a href="form.php" class="btn" style="background-color: #030366; color: #ffffff;">Open Case</a>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <img src="../images/download.jpg" class="d-block w-100" alt="..." onload="this.classList.add('loaded'); hideLoader();">
          <div class="carousel-caption d-block d-md-block">
            <h2 style="font-family: 'Times New Roman', Times, serif; font-size: xx-large; color:#030366 ; font-weight: bolder;">97% client satisfaction</h2>
            <p>Our major aim is to offer practical solutions to our clients. We will do all possible to ensure that our clients and partners are happy.</p>
            <a href="../comments.php" class="btn" style="background-color: #030366; color: #ffffff;">View comments</a>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <img src="../images/download.jpg" class="d-block w-100" alt="..." onload="this.classList.add('loaded'); hideLoader();">
          <div class="carousel-caption d-block d-md-block">
            <h2 style="font-family: 'Times New Roman', Times, serif; font-size: xx-large; color:#030366 ; font-weight: bolder;">Experienced Agents and Professionals</h2>
            <p>We are confident in being able to provide you with a solution thanks to the assistance of competent and highly skilled individuals from many disciplines.</p>
            <a href="../trial/index.html" class="btn" style="background-color: #030366; color: #ffffff;">Chat Admin</a>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <div class="container-fluid">
      <div class="container">
        <h2 class="card-title text-center font-monospace m-3 py-3" style="color: #030366; background-color: aliceblue; border-radius: 7px; box-shadow: #ffffff;"> FAQS</h2>
        
        <div class="card-title text-center font-monospace m-3 py-3" style="color: #030366; background-color: aliceblue; border-radius: 7px; box-shadow: #ffffff; display: flex;">
          <div class="p-3" style="font-size: larger;">+</div>
          <p style="font-size: smaller;">How successful are Decryptrecovery at recovering stolen funds?</p>
        </div>
        <div class="card-title text-center font-monospace m-3 py-3" style="color: #030366; background-color: aliceblue; border-radius: 7px; box-shadow: #ffffff; display: flex;">
          <div class="p-3" style="font-size: larger;">+</div>
          <p style="font-size: smaller;">How long does the recovery process normally take?</p>
        </div>
        <div class="card-title text-center font-monospace m-3 py-3" style="color: #030366; background-color: aliceblue; border-radius: 7px; box-shadow: #ffffff; display: flex;">
          <div class="p-3" style="font-size: larger;">+</div>
          <p style="font-size: smaller;">How successful are Defi Recovery at recovering stolen funds?</p>
        </div>
        <div class="card-title text-center font-monospace m-3 py-3" style="color: #030366; background-color: aliceblue; border-radius: 7px; box-shadow: #ffffff; display: flex;">
          <div class="p-3" style="font-size: larger;">+</div>
          <p style="font-size: smaller;">How can I get started with Defi Recovery for scam recovery?</p>
        </div>
        <div class="card-title text-center font-monospace m-3 py-3" style="color: #030366; background-color: aliceblue; border-radius: 7px; box-shadow: #ffffff; display: flex;">
          <div class="p-3" style="font-size: larger;">+</div>
          <p style="font-size: smaller;">Is my information kept confidential during the process?</p>
        </div>
        <div class="card-title text-center font-monospace m-3 py-3" style="color: #030366; background-color: aliceblue; border-radius: 7px; box-shadow: #ffffff; display: flex;">
          <div class="p-3" style="font-size: larger;">+</div>
          <p style="font-size: smaller;">What happens when the scammers are identified and held accountable?</p>
        </div>
        <div class="card-title text-center font-monospace m-3 py-3" style="color: #030366; background-color: aliceblue; border-radius: 7px; box-shadow: #ffffff; display: flex;">
          <div class="p-3" style="font-size: larger;">+</div>
          <p style="font-size: smaller;">What fees are involved in engaging Defi Recovery services?</p>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      function hideLoader() {
        document.querySelector('.loading').style.display = 'none';
      }

      // Autoplay functionality
      const carouselElement = document.querySelector('#carouselExampleDark');
      const carousel = new bootstrap.Carousel(carouselElement, {
        interval: 3000,
        ride: 'carousel'
      });

      // Define the answers corresponding to each question
      const answers = [
      "",
        "Defirecovery has a high success rate, helping many clients recover their stolen funds effectively.",
        "The recovery process typically takes between 2 to 6 weeks, depending on the complexity of the case.",
        "Defi Recovery has a proven track record in successfully recovering stolen funds for our clients.",
        "To get started, simply contact us through our website and fill out the initial consultation form.",
        "Yes, we prioritize client confidentiality and ensure all information is kept secure and private.",
        "Once scammers are identified, we work with law enforcement to ensure accountability and justice.",
        "Our fees vary depending on the service provided; we offer transparent pricing and no hidden costs."
      ];

      // Select all FAQ items and add click event listeners
      document.querySelectorAll('.card-title').forEach((faq, index) => {
        const questionElement = faq.querySelector('p');
        const answerElement = document.createElement('p');
        answerElement.style.fontSize = 'smaller';
        answerElement.style.backgroundColor = '#f0f8f1';
        answerElement.style.border = '1px solid #030366';
        answerElement.style.borderRadius = '5px';
        answerElement.style.padding = '5px';
        answerElement.innerText = answers[index];
        answerElement.style.display = 'none'; 
        faq.appendChild(answerElement);

        faq.addEventListener('click', () => {
          if (answerElement.style.display === 'none') {
            answerElement.style.display = 'block'; 
            questionElement.innerText = questionElement.innerText.replace('+', '−'); 
          } else {
            answerElement.style.display = 'none'; 
            questionElement.innerText = questionElement.innerText.replace('−', '+'); 
          }
        });
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>