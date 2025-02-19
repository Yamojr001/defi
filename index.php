<?php

// importing config 

include 'includes/config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize user input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO contact (Name, email, Message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    
    if ($stmt->execute()) {
        echo "<script>alert('Message Sent Successfully!');window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Defi Scam Recovery</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        .hero {
            height: 100vh;
            background: url('https://source.unsplash.com/1600x900/?nature,landscape') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .hero h1 {
            font-size: 4rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 2rem 0;
        }

        .footer a {
            color: #ffc107;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Loading screen styles */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #030366;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .typing {
            font-size: 2rem;
            color: #fff;
            font-family: 'Courier New', Courier, monospace;
            border-right: 2px solid #fff; /* Typing cursor effect */
            padding-right: 5px;
            visibility: hidden; /* Hide initially */
        }

        /* Slide out effect */
        @keyframes slideOut {
            0% {
                transform: translateY(0);
                opacity: 1;
            }
            100% {
                transform: translateY(-100px);
                opacity: 0;
            }
        }

        .slide-out {
            animation: slideOut 1s forwards;
        }

        /* Main content section (hidden initially) */
        #main-content {
            display: none;
        }
        /* #home{
            background-image: url(image1.jpg);
        } */
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div id="loading-screen">
        <h1 id="typing-text" class="typing"> Defi Scam Recovery </h1>
    </div>

    <!-- Navbar -->
    <?php include'includes/navuser1.php' ?>


        <!-- Main content -->
    <div id="main-content">
        <!-- Hero Section -->
        <section id="home" class="hero mt-0 pt-0">
            <div class="text-center pt-0">
                <div class="container mt-0 pt-0" style="max-width: 80%; align-self: auto;">
                    <img src="images/defi.png" alt="" class="img-fluid"> <!-- Added img-fluid class -->
                </div>
                <a href="#services" class="btn btn-lg container my-4" style="width: 70%; background-color: #030366; color: #fff;">Services</a>
                <a href="signup.php" class="btn btn-lg container my-4" style="width: 70%; background-color: #030366; color: #fff;">Create Account</a>
                <a href="login.php" class="btn btn-lg container my-4" style="width: 70%; background-color: #030366; color: #fff;">Login</a>
            </div>
        </section>


        <!-- About Section -->
        <section id="about" class="p-3" style="background-color: #c2c4b7;">
            <div class="container py-5 px-2 bg-light">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="text-center">About Us</h2>
                        <p>As a seasoned cyber security expert, I specialize in scam recovery, helping individuals and organizations reclaim stolen assets and restore their digital security. With a deep understanding of online threats and scams, I provide expert guidance on risk mitigation, incident response, and asset recovery.</p>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
        </section>

        <!-- Other sections... -->
        <section id="" class="bg-light py-5">
            <div class="container text-center">
                <div class="row g-4 mt-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow" style="background-color: #030366; color: #fff;">
                            <div class="card-body">
                                <h5 class="card-title">Recognized Globally</h5>
                                <p class="card-text">Decryptrecovery is renowned throughout the world for our commitment and never-ending desire to make the internet safer.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow" style="background-color: #030366; color: #fff;">
                            <div class="card-body">
                                <h5 class="card-title">Experienced Agents and professionals</h5>
                                <p class="card-text">We are confident in being able to provide you with a solution thanks to the assistance of competent and highly skilled individuals from many disciplines.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow" style="background-color: #030366; color: #fff;">
                            <div class="card-body">
                                <h5 class="card-title">97% client statisfaction</h5>
                                <p class="card-text">Our major aim is to offer practical solutions to our clients. We will do all possible to ensure that our clients and partners are happy.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        
        <!-- Services Section -->
        <section id="services" class="bg-light py-5">
            <div class="container text-center">
                <h2>Our Services</h2>
                <p class="lead">We offer a wide range of services to meet your needs</p>
                <div class="row g-4 mt-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Scam Recovery</h5>
                                <p class="card-text">Recoveering your lost fund after being Scammed By Scammers .</p>
                                <a href="#home" class="btn btn-lg" style="background-color: #030366; color: #fff;">Use the Service</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">E-Commerce</h5>
                                <p class="card-text">Building online stores that drive sales and offer a seamless shopping experience.</p>
                                <a href="#home" class="btn btn-lg" style="background-color: #030366; color: #fff;">Use the Service</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
                          <!-- info section -->
        <section id="info" class="py-5" style="background-color: #c2c4b7;">
            <div class="container text-center">
                <h2>Cyber Safety Protect yourself from hackers</h2>
                
                <div class="row g-4 mt-4 " >
                    <div class="col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Check Website Url</h5>
                                <p class="card-text">One simple yet effective practice is to check the website URL before interacting with it. By understanding how to verify and validate URLs, you can protect yourself from phishing attacks, scams, and other online threats.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Check Emails Before Opening Them</h5>
                                <p class="card-text">Try adopting the practice of checking emails before opening them, you can significantly reduce the risk of falling victim to these malicious attacks.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">​Remember To Log Off</h5>
                                <p class="card-text">Logging off from your accounts is a fundamental practice that should not be overlooked. It plays a crucial role in protecting your online privacy, preventing unauthorized access, and mitigating potential risks.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Choose Strong Passwords</h5>
                                <p class="card-text">
                                    Choose Strong Passwords
                                    it's crucial to prioritize the strength and security of our passwords. Weak passwords make it easier for cybercriminals to gain unauthorized access to our sensitive information, leading to identity theft, financial loss, and other detrimental consequences.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Shop on Trusted Websites
                                    </h5>
                                <p class="card-text">Shopping on trusted websites not only offers a seamless and enjoyable experience but also safeguards your sensitive information from potential risks</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Update Your Antivirus</h5>
                                <p class="card-text">Updating your antivirus keeps you protected against the latest threats and contributes to a safer online environment. Stay proactive and prioritize regular antivirus updates to strengthen your overall digital defense.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Portfolio Section -->
        <section id="aboutScams" class="py-5">
            <div class="container text-center">
                <h2>About Scams</h2>
                <p class="lead font-monospace">
                    A scam is a fraudulent or deceptive scheme, typically designed to obtain money, personal information, or other benefits from unsuspecting individuals. Scams often involve misleading or false promises, and can be perpetrated through various channels
                </p>
                <div class="col-md-4 d-block m-auto">
                        <div class="card border-0 shadow d-block m-auto">
                            <div class="card-body">
                                <h3 class="card-title">Types of Scam</h3>
                            </div>
                        </div>
                    </div>
                <div class="row g-4 mt-4">
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Investment Scam</h5>
                                <p class="card-text">An investment scam is a type of scam where a scammer promises unusually high returns on an investment opportunity, but the investment is either fake or non-existent.
                                    .</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Crypto Scam</h5>
                                <p class="card-text">A cryptocurrency scam is a type of scam that involves fraudulent activities related to cryptocurrencies, such as Bitcoin or Ethereum..</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Romance Scam</h5>
                                <p class="card-text">A romance scam is a type of online scam where a scammer creates a fake online profile, usually on dating websites or social media platforms, and builds a romantic relationship with the victim. The scammer's goal is to gain the victim's trust and eventually ask for money or personal information.
                                    .</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        
       
        <section id="aboutid" class="py-5">
            <div class="container text-center">
                <h2>Defi recovery, we prioritize the utmost security and confidentiality in every aspect of our services</h2>
                
                <div class="row g-4 mt-4">
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="text-left">State-of-the-Art Technology</h5>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text" style="flex: 1; font-size: smaller;">Our cutting-edge technology infrastructure ensures the highest level of protection for our clients. We utilize advanced encryption protocols, multi-factor authentication, and secure servers to safeguard sensitive data from unauthorized access.</p>
                                    <h2 class="" style="font-size: 5rem; color: #c2c4b7;">01</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="text-left">Trusted Expertise</h5>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text" style="flex: 1; font-size: smaller;">Our cutting-edge technology infrastructure ensures the highest level of protection for our clients. We utilize advanced encryption protocols, multi-factor authentication, and secure servers to safeguard sensitive data from unauthorized access.</p>
                                    <h2 class="" style="font-size: 5rem; color: #c2c4b7;">02</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h5 class="text-left">24/7 Technical Support</h5>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text" style="flex: 1; font-size: smaller;">We are committed to providing exceptional support to our clients throughout their recovery journey. We understand the emotional and financial toll that falling victim to a crypto scam can have, and we are here to guide you every step of the way.
                                        <h2 class="" style="font-size: 5rem; color: #c2c4b7;">03</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Contact Section -->
        <section id="contact" class="bg-light py-5" style="background-color: #c2c4b7;">
            <div class="container">
                <h2 class="text-center">Contact Us</h2>
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <textarea class="form-control" name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <div class="mt-3 text-center">
                        <button type="submit" class="btn " style="background-color: #030366; color: #fff;">Send Message</button>
                    </div>
                  </form>
                  
            </div>
        </section>
    
        <!-- Footer -->

    </div>

    <!-- Footer -->
    <?php include'includes/footer.php' ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Typing Effect and Slide Transition -->
    <script>
        window.addEventListener('load', function() {
            const text = "Defi Scam Recovery";
            const typingTextElement = document.getElementById("typing-text");
            let i = 0;
            const typingSpeed = 150; // Typing speed (ms)

            // Start typing the text
            typingTextElement.style.visibility = 'visible'; // Make the text visible
            function typeText() {
                typingTextElement.textContent += text[i];
                i++;
                if (i < text.length) {
                    setTimeout(typeText, typingSpeed);
                }
            }

            // Call the typing effect function
            typeText();

            // After the typing effect, hide loading screen and show main content after 3 seconds
            setTimeout(function() {
                typingTextElement.classList.add("slide-out"); // Apply the slide-out animation
                setTimeout(function() {
                    document.getElementById("loading-screen").style.display = 'none'; // Hide the loading screen
                    document.getElementById("main-content").style.display = 'block'; // Show the main content
                }, 1000); // Wait for 1 second (the duration of the slide-out effect)
            }, text.length * typingSpeed + 3000); // Wait for typing effect to finish + 3 seconds
        });
    </script>
</body>
</html>
