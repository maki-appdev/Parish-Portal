<?php
include "try.php";
include_once 'header.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="images/logo.png" style="border-radius: 50%;">
    <link rel="stylesheet" href="all.css/index.css">
    <link rel="stylesheet" href="css/announce/bootsnavs.css" >	
    <link rel="stylesheet" href="css/announce/responsive.css">
    <link href="css/event/style.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="css/event/bootstrap.css" />
    <link rel="stylesheet" href="css/announce/style.css">
    
    <title>DSSNP Portal</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
@media (max-width: 375px){
  body, html{
    overflow-x: hidden;
  }
}
a:hover {
    text-decoration: none;
}
.carousel-indicators img{
            width: 70px;
            display: block;
        }
        .carousel-indicators button{
            width: max-content!important;
        }
        .carousel-indicators{
            position: unset;
        }

:root{
	--bg-color: #ffffff;
	--second-color: #f54300;
	--main-color: #7dd87d;
	--text-color: #130849;
	--other-color: #999fb9;
	--big-font: 4.8rem;
	--h2-font: 3.2rem;
	--p-font: 1rem;
}
.about_section{
    background: url(images/bgchurch.png);
	background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
	
}
.marriage_section{
    background: url(images/bgchurch2.png);
    background-size: auto 900px;
    background-position: center;
	
}
.blog_section, .explore_section{
    background-color: #efefef;
}

.about_section .heading_container h1{
	margin: 15px 0px 15px;
	font-size: var(--h2-font);
	line-height: 1.1;
}

.about_section .heading_containert h3{
	color: var(--second-color);
	font-size: 25px;
	font-weight: 600;
}

.explore_section {
  padding-top: 50px;
}

.box1{
	
	background: var(--bg-color);
	box-shadow: 0px 5px 40px rgb(19 8 73 / 13%);
	border-radius: 20px;
	transition: all .40s ease;
}
.box{
	
	background: var(--bg-color);
	border-radius: 20px;
	transition: all .40s ease;
}
.box .img-box{
    border-radius: 20px;
}
.box:hover, .box1:hover{
	transform: scale(1.04) translateY(-5px);
}

</style>
<body>
    <div class="container-fluid">
        <?php if (isset($_SESSION['name'])) { ?>
            <div class="content-area">
                <span
                    class="text-white position-absolute top-0 start-0">&nbsp&nbsp&nbsp<?php echo date("D, M d,") ?><?php echo date("Y"); ?></span>

                <h1>Diocesan Shrine of Sto. Niño Parish Shrine</h1>
                <img src="images/logo.png" alt="">
                <p>D<span class="text-light">SSNP </span>P<span class="text-light">ORTAL</span></p>
                <h2>A CHRIST-FILLED COMMUNITY STRENGTHENED BY LOVE AND FAITH FOR THE SERVICE OF GOD AND PEOPLE</h2>
            </div>
        <?php } else { ?>
            <div class="content-area">
                <span
                    class="text-white position-absolute top-0 start-0">&nbsp&nbsp&nbsp<?php echo date("D, M d,") ?><?php echo date("Y"); ?></span>

                <h1>Diocesan Shrine of Sto. Niño Parish Shrine</h1>
                <img src="images/logo.png" alt="">
                <p>D<span class="text-light">SSNP </span>P<span class="text-light">ORTAL</span></p>
                <h2>A CHRIST-FILLED COMMUNITY STRENGTHENED BY LOVE AND FAITH FOR THE SERVICE OF GOD AND PEOPLE</h2>
            </div>
            <div class="button-area">
                <a href="register.php"><button type="button" class="btn btn-danger btn-lg mt-5">Register</button></a>
                <a href="login.php"><button type="button" class="btn btn-primary btn-lg mt-5">Login</button></a>
            </div>


        <?php } ?>
    </div>





    <section class="about_section  layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="img-box">
                        <img src="images/h-img3.svg" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="heading_container">
                            <h3>Welcome to</h3>
                            <h2>Sto. Niño Parish Church</h2>
                        </div><br>
                        <p>
                            The Sto. Niño Parish Shrine in Bago Bantay, Quezon City, stands as a testament to the community's unwavering faith and collective effort.
                        </p>
                        <p>
                            Beginning with a simple wooden chapel dedicated to the Mother of Perpetual Help, the parish evolved through dedication and resilience, overcoming challenges such as natural disasters.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


     
    <?php
        include "functions/dbcon.php";
        // Fetch announcements
        $sql = "SELECT * FROM announcement";
        $result = $conn->query($sql);
    ?>

    <section id="explore" class="explore_section">
		<div class="container">
            <div class="heading_container">
                <h2>
                    Announcement
                </h2>
            </div>

			<div class="explore-content">
				<div class="row">

                    <?php               
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {						
	                ?>
					
                    <div class="col-md-4 col-sm-6">
						<div class="box1 single-explore-item">
							<div class="single-explore-img">
								<img src="socomarea/uploads/announcement/<?php echo $row['File']; ?>" >

								<div class="single-explore-img-info">
									<button onclick="window.location.href='socomarea/announcements.php?id=<?php echo $row['ID'];?>'">
                                    <?php echo date('M', strtotime($row['Date'])); ?> 
                                    <?php echo date('d', strtotime($row['Date']));?>, <?php echo date('Y', strtotime($row['Date'])); ?>
                                    </button>
								</div>
							</div>

							<div class="single-explore-txt bg-theme-1">
								<h2>
                                    <a href="socomarea/announcements.php?id=<?php echo $row['ID'];?>"><?php echo $row['Title']; ?></a>
                                </h2>

								<div class="explore-person">
									<div class="row">
                                        <div class="col-sm-12">
                                            <?php 
                                                // Limit the description to a specific number of characters
                                                $description = strip_tags($row['Description']);
                                                $max_length = 180; // Maximum length of characters
                                                                    
                                                if (strlen($description) > $max_length) {
                                                $description = substr($description, 0, strrpos(substr($description, 0, $max_length), ' ')) . '...'; //                                      Trim to last space and add ellipsis
                                                }
                                        
                                                echo $description; 
                                            ?> 
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <?php
			                }
                        } else {
                            echo "0 results";
                        }
                        $conn->close();
                    ?> 
                </div>
			</div>
		</div>
	</section>
    
    
    <?php
        include "functions/dbcon.php";
        // Fetch announcements
        $sql = "SELECT * FROM gallery";
        $result = $conn->query($sql);
    ?>   
    <section class="marriage_section layout_padding">
        <div class="heading_container">
            <h2>
                Marriage Banns
            </h2>
        </div>    
        
        <div class="carousel slide" id="carouselDemo"data-bs-wrap="true" data-bs-ride="carousel"  data-bs-interval="3000">
            <div class="carousel-inner">
                <?php 
                    // Reset the pointer of the result set
                    mysqli_data_seek($result, 0); 
                    $active = "active"; // Variable to mark the first item as active
                    while ($row = mysqli_fetch_assoc($result)): 
                ?>

                <div class="carousel-item <?php echo $active; ?>">
                    <img src="socomarea/uploads/marriage/<?php echo $row['File']; ?>" class="d-block mx-auto" alt="<?php echo $row['File']; ?>"  style="max-height: 400px; object-fit: cover;">
                </div>

                <?php 
                    $active = ""; // Remove active class after the first iteration
                    endwhile; 
                ?>
            </div>

            <div class="carousel-indicators">
                <?php 
                    // Reset the pointer of the result set
                    mysqli_data_seek($result, 0); 
                    $active = "active"; // Variable to mark the first item as active
                    $slide_index = 0; // Initialize a counter to track the slide number

                    while ($row = mysqli_fetch_assoc($result)): 
                ?>
                <button type="button" class="<?php echo $active; ?>" 
                    data-bs-target="#carouselDemo" 
                    data-bs-slide-to="<?php echo $slide_index; ?>">
                    <img src="socomarea/uploads/marriage/<?php echo $row['File']; ?>" />
                </button>
                <?php 
                    $active = ""; // Remove active class after the first iteration
                    $slide_index++; // Increment the slide index for each entry
                    endwhile; 
                ?>
            </div>
        </div>
    </section>

        
    <?php
        include "functions/dbcon.php";

        // Fetch announcements
        $sql = "SELECT * FROM event";
        $result = $conn->query($sql);
    ?>

    <section class="blog_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>
                    Upcoming Event
                </h2>
            </div>

            <div class="row">
                <?php
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {						
                    // Get the event date
                    $event_date = date('Y-m-d', strtotime($row['EventsDate']));
                    // Get the current date
                    $current_date = date('Y-m-d');
                    // Compare event date with current date
                    if ($event_date < $current_date || $event_date > $current_date){ 
                        // Display upcoming events                      
                ?>
                <div class="col-md-4  ">
                    <div class="box">
                        <div class="img-box">
                            <img src="socomarea/uploads/event/<?php echo $row['File']; ?>" alt="" width="600" height="400">
                            <h4 class="blog_date">
                                <?php echo date('d', strtotime($row['EventsDate'])); ?> <br>
                                <?php echo date('M', strtotime($row['EventsDate'])); ?>
                            </h4>
                        </div>
                        <div class="detail-box">
                            <h5>
                                <?php echo $row['Title'] ?>
                            </h5>
                            <p>
                                <?php 
                                    // Limit the description to a specific number of characters
                                    $description = strip_tags($row['Description']);
                                    $max_length = 180; // Maximum length of characters
                                                                        
                                    if (strlen($description) > $max_length) {
                                        $description = substr($description, 0, strrpos(substr($description, 0, $max_length), ' ')) . '...'; //                                      Trim to last space and add ellipsis
                                    }
                                            
                                    echo $description; 
                                ?> 
                            </p><br>
                            <a href="socomarea/Events.php?id=<?php echo $row['ID'];?>">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                        } 
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>



    <?php
    include "functions/dbcon.php";

    // Fetch announcements
    $sql = "SELECT * FROM event";
    $result = $conn->query($sql);
    ?>           

    <section class="blog2_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>
                    Past Event
                </h2>
            </div>

            <div class="row">
                <?php
                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {						
                    // Get the event date
                    $event_date = date('Y-m-d', strtotime($row['EventsDate']));
                    // Get the current date
                    $current_date = date('Y-m-d');
                    // Compare event date with current date
                    if ($event_date <= $current_date){ 
                        // Display upcoming events                      
                ?>
                <div class="col-md-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="socomarea/uploads/event/<?php echo $row['File']; ?>" alt="" width="600" height="370">
                            <h4 class="blog_date">
                                <?php echo date('d', strtotime($row['EventsDate'])); ?> <br>
                                <?php echo date('M', strtotime($row['EventsDate'])); ?><br>
                                <?php echo date('Y', strtotime($row['EventsDate'])); ?>
                            </h4>
                        </div>
                        <div class="detail-box">
                            <h5>
                                <?php echo $row['Title'] ?>
                            </h5>
                            <p>
                                <?php 
                                    // Limit the description to a specific number of characters
                                    $description = strip_tags($row['Description']);
                                    $max_length = 189; // Maximum length of characters
                                                                        
                                    if (strlen($description) > $max_length) {
                                        $description = substr($description, 0, strrpos(substr($description, 0, $max_length), ' ')) . '...'; //                                      Trim to last space and add ellipsis
                                    }
                                            
                                    echo $description; 
                                ?> 
                            </p>
                            <br>
                            <a href="socomarea/Events.php?id=<?php echo $row['ID'];?>">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                        } 
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>








    <!---------------------------- FOOTER ---------------------------------->
    <section id="footer" class="footercontact">
        <div class="footer container">
            <div class="brand">
                <h1><span>D</span>SSNP <span>P</span>ORTAL</h1>
            </div>
            <p>Copyright © 2024 Diocesan Shrine of Sto. Niño Parish</p>
        </div>
    </section>

</body>

</html>