<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Database connection
$host = 'localhost';
$db_name = 'beer';  // Replace with your database name
$username = 'root';         // Replace with your username
$password = '';             // Replace with your password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// Fetch about section content
$query = "SELECT * FROM about_section WHERE id = 1"; // Replace '1' with the desired record ID
$stmt = $pdo->query($query);
$about = $stmt->fetch(PDO::FETCH_ASSOC);

// Define how many results per page
$limit = 4;

// Get the current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $limit;

// Get the total number of products
$totalQuery = "SELECT COUNT(*) FROM alcohol_products";
$totalStmt = $pdo->query($totalQuery);
$total_products = $totalStmt->fetchColumn();

// Calculate the total number of pages
$total_pages = ceil($total_products / $limit);

// Fetch the products for the current page
$query = "SELECT * FROM alcohol_products LIMIT $limit OFFSET $offset";
$stmt = $pdo->query($query);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch testimonials from the database
$sql = "SELECT id, name, position, image, message FROM testimonials";
$result = $pdo->query($sql); // Use $pdo instead of $conn
$testimonials = $result->fetchAll(PDO::FETCH_ASSOC); // Fetch all testimonials

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Liquor Store - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Spectral:ital,wght@0,200;0,300;0,400;0,500;0,700;0,800;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
	<!--To be added to other pages-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
/* Reduce space between content and pagination */
.content-container {
    margin-bottom: 20px; /* Adjust as needed */
}

.pagination {
    margin-top: 10px; /* Adjust the space above pagination */
}

/* Optional: Adjust the pagination button spacing */
.pagination li {
    margin: 0 5px; /* Decrease horizontal space between page buttons */
}

/* Optional: Adjust button padding for better appearance */
.pagination a {
    padding: 5px 10px; /* Adjust the padding for smaller buttons */
}

/* Ensure pagination looks neat and aligned */
.pagination li a {
    display: block;
    text-align: center;
    font-size: 15px;
    width: 70px; /* Make buttons smaller */
}

/* Responsive Styles */
@media (max-width: 1200px) { /* Large devices like tablets */
    .pagination li a {
        font-size: 13px;
        width: 50px; /* Adjust button size for medium screens */
    }

    .content-container {
        margin-bottom: 15px; /* Slightly reduce space for medium screens */
    }
}

@media (max-width: 768px) { /* Tablets */
    .pagination li a {
        font-size: 12px;
        width: 45px; /* Make buttons even smaller */
    }

    .pagination {
        margin-top: 8px; /* Adjust space above pagination */
    }

    .content-container {
        margin-bottom: 10px; /* Further reduce space for small screens */
    }
}

@media (max-width: 576px) { /* Mobile devices */
    .pagination li a {
        font-size: 10px;
        width: 40px; /* Even smaller buttons on mobile */
    }

    .pagination {
        margin-top: 5px; /* Less space on mobile */
    }

    .content-container {
        margin-bottom: 5px; /* Very little space between content and pagination */
    }

    /* Ensure pagination items stack properly on small screens */
    .pagination {
        flex-wrap: wrap; /* Allow pagination items to stack on mobile */
        justify-content: center; /* Center pagination items */
    }
}



</style>

  </head>
  <body>


	<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top" id="ftco-navba">
	    <div class="container">
	      <a class="navbar-brand" href="index.php">Liquor <span>store</span></a>
	</div>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
	          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products</a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">
              	<a class="dropdown-item" href="product.php">Products</a>
                <a class="dropdown-item" href="cart.php">Cart</a>
            
              </div>
            </li>
	          <!--<li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>-->
	          <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
			  <li class="nav-item"><a href="login.php" class="nav-link">Sign up/Login</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    
    <div class="hero-wrap" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-8 ftco-animate d-flex align-items-end">
          	<div class="text w-100 text-center">
	            <h1 class="mb-4">Good <span>Drink</span> for Good <span>Moments</span>.</h1>
	            <p><a href="#" class="btn btn-primary py-2 px-4">Shop Now</a> <a href="#" class="btn btn-white btn-outline-white py-2 px-4">Read more</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-intro">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-md-4 d-flex">
    				<div class="intro d-lg-flex w-100">
    					</div>
    				</div>
    			</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
<!--About us-->
    <section class="ftco-section ftco-no-pb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 img img-3 d-flex justify-content-center align-items-center" 
                 style="background-image: url('<?php echo $about['background_image']; ?>');">
            </div>
            <div class="col-md-6 wrap-about pl-md-5 ftco-animate py-5">
                <div class="heading-section">
                    <span class="subheading"><?php echo $about['subheading']; ?></span>
                    <h2 class="mb-4"><?php echo $about['heading']; ?></h2>
                    <p><?php echo $about['content']; ?></p>
                    <p><?php echo $about['additional_content']; ?></p>
                    <p class="year">
                        <strong class="number" data-number="<?php echo $about['years_of_experience']; ?>">0</strong>
                        <span>Years of Experience In Business</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section><br><br>


		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center pb-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
          	<span class="subheading">Our Delightful offerings</span>
            <h2>Tastefully Yours</h2>
          </div>
        </div>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-3 d-flex">
                <div class="product ftco-animate">
                    <div class="img d-flex align-items-center justify-content-center" style="background-image: url(<?php echo $product['image']; ?>);">
                        <div class="desc">
                        <p class="meta-prod d-flex">
                            <a href="#" class="d-flex align-items-center justify-content-center">
                              <span class="flaticon-shopping-bag"></span>
                          </a>
                          <!--<a href="#" class="d-flex align-items-center justify-content-center">
                              <span class="flaticon-heart"></span>
                          </a>-->
                          <!-- Dynamically pass the product ID and name -->
                          <a href="product-single.php?id=<?php echo $product['id']; ?>&name=<?php echo urlencode($product['name']); ?>" 
                            class="d-flex align-items-center justify-content-center">
                              <span class="flaticon-visibility"></span>
                          </a>
                        </p>


                        </div>
                    </div>
                    <div class="text text-center">
                        <?php if ($product['status'] == 'sale'): ?>
                            <span class="sale">Sale</span>
                        <?php elseif ($product['status'] == 'best_seller'): ?>
                            <span class="seller">Best Seller</span>
                        <?php elseif ($product['status'] == 'new'): ?>
                            <span class="new">New Arrival</span>
                        <?php endif; ?>
                        <span class="category"><?php echo $product['category']; ?></span>
                        <h2><?php echo $product['name']; ?></h2>
                        <p class="mb-0">
                            <?php if ($product['sale_price']): ?>
                                <span class="price price-sale">Ksh.<?php echo $product['sale_price']; ?></span>
                                <span class="price">Ksh.<?php echo $product['price']; ?></span>
                            <?php else: ?>
                                <span class="price">Ksh.<?php echo $product['price']; ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row justify-content-center">
    <div class="pagination d-flex justify-content-center">
    <ul class="pagination">
        <!-- Previous Page Link -->
        <?php if ($page > 1) { ?>
            <li><a href="?page=<?php echo $page - 1; ?>" class="btn btn-primary">Previous</a></li>
        <?php } ?>
        
        <!-- Page Number Links -->
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="<?php echo $i == $page ? 'active' : ''; ?>">
                <a href="?page=<?php echo $i; ?>" class="btn btn-primary">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php } ?>

        <!-- Next Page Link -->
        <?php if ($page < $total_pages) { ?>
            <li><a href="?page=<?php echo $page + 1; ?>" class="btn btn-primary">Next</a></li>
        <?php } ?>
    </ul>
</div>
    </div>
</section>
<!--Testimonial-->
<section class="ftco-section testimony-section img" style="background-image: none;">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
                <span class="subheading">Testimonial</span>
                <h2 class="mb-3">Happy Clients</h2>
            </div>
        </div>
        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel ftco-owl">
                    <?php if (!empty($testimonials)): ?>
                        <?php foreach ($testimonials as $row): ?>
                            <div class="item">
                                <div class="testimony-wrap py-4">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-quote-left"></span>
                                    </div>
                                    <div class="text">
                                        <p class="mb-4"><?php echo htmlspecialchars($row['message']); ?></p>
                                        <div class="d-flex align-items-center">
                                            <div class="user-img" style="background-image: url('<?php echo htmlspecialchars($row['image']); ?>');"></div>
                                            <div class="pl-3">
                                                <p class="name"><?php echo htmlspecialchars($row['name']); ?></p>
                                                <span class="position"><?php echo htmlspecialchars($row['position']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No testimonials found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


    <footer class="ftco-footer">
      <div class="container">
        <div class="row mb-5">
          <div class="col-sm-12 col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2 logo"><a href="#">Liquor <span>Store</span></a></h2>
              <p>Far far away, behind the word mountains, far from the countries.</p>
              <ul class="ftco-footer-social list-unstyled mt-2">
                <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12 col-md">
            <div class="ftco-footer-widget mb-4 ml-md-4">
              <h2 class="ftco-heading-2">My Accounts</h2>
              <ul class="list-unstyled">
               <!-- <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>My Account</a></li>-->
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Register</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Log In</a></li>
                <!--<li><a href="#"><span class="fa fa-chevron-right mr-2"></span>My Order</a></li>-->
              </ul>
            </div>
          </div>
          <div class="col-sm-12 col-md">
            <div class="ftco-footer-widget mb-4 ml-md-4">
              <h2 class="ftco-heading-2">Information</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>About us</a></li>
                <!--<li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Catalog</a></li>-->
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Contact us</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Term &amp; Conditions</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12 col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Quick Link</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Report Spam</a></li>
                <li><a href="#"><span class="fa fa-chevron-right mr-2"></span>Faq's</a></li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12 col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon fa fa-map marker"></span><span class="text">Kabiria </span></li>
	                <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+254 757876862</span></a></li>
	                <li><a href="#"><span class="icon fa fa-paper-plane pr-4"></span><span class="text">riakjms@gmail.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid px-0 py-5 bg-black">
      	<div class="container">
      		<div class="row">
	          <div class="col-md-12">
		
	    <p class="mb-0" style="color: rgba(255,255,255,.5);">
	  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
  </p>
	          </div>
	        </div>
      	</div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>