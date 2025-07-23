<?php include 'webpagehead.php';


        $db_host      = "localhost";
        $db_user      = "root";
        $db_pass      = "";
        $db_database  = "dssnp - portal";
        

        try {
            $pdo = new PDO("mysql:host=$db_host;dbname=$db_database", $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
        
        // MySQLi connection (optional, only if needed)
        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
        if (!$conn) {
            die("MySQLi connection failed: " . mysqli_connect_error());
        }





 /*       $id = $_GET['id'];
$result = $pdo->prepare("SELECT * FROM gallery WHERE id = :post_id");
$result->bindParam(':post_id', $id);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC); // Fetch the row
if ($row) {*/
                               
?>
<style>

</STYLE>
    


<!DOCTYPE html>
<html lang="en">
<title>Home | Sto. Niño</title>
<style>
@media (max-width: 375px){
  body, html{
    overflow-x: hidden;
  }
}
</style>
<body>
    <div class="h-background" style="background-image: url('images/h-img1.svg');">
        <div class="color-overlay d-flex justify-content-center align-items-center text-center">
            <h1>
                <p>Roman Catholic Diocese of Cubao</p>Diocesan Shrine of Sto. Niño Parish<br><span>"Where Hope Finds
                    Home"</span>
            </h1>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-12 my-5" style="text-align: center;">
                <span class="s-style">Welcome to Sto. Niño Parish Church !</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 py-5">
                <div class="clearfix">
                    <img src="images/h-img3.svg" style="max-width: 40%;"
                        class="col-md-6 float-md-end mb-3 ms-md-3" alt="...">
                    <p>
                        The Sto. Niño Parish Shrine in Bago Bantay, Quezon City, stands as a testament to the
                        community's unwavering faith and collective effort.
                    </p>
                    <p>Beginning with a simple wooden chapel dedicated to the Mother of Perpetual Help, the parish
                        evolved through dedication and resilience, overcoming challenges such as natural disasters.
                    </p>
                    <p>
                        It was canonically erected in 1967, symbolizing hope and spiritual growth in a region once
                        marked by poverty and hardship. The shrine, now a significant religious landmark, reflects the
                        community's enduring devotion to the Santo Niño, celebrated with a rich history of faith,
                        perseverance, and unity.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <?php
        // Assuming you have a configuration file where your database connection is established

        if (!isset($_GET["page"])) {
            $_GET["page"] = 1;
        }

        $tbl_name = "gallery"; // your table name
        $adjacents = 3;

        $query = "SELECT COUNT(*) as num FROM $tbl_name";
        $total_pages = mysqli_fetch_array(mysqli_query($conn, $query));
        $total_pages = $total_pages['num'];

        $targetpage = "pagination.php"; // your file name
        $limit = 16;
        $page = $_GET['page'] ?? 1;
        $start = ($page - 1) * $limit;

        $query = "SELECT * FROM $tbl_name ORDER BY id DESC LIMIT $start, $limit";
        $result = mysqli_query($conn, $query);

    ?>
    <div class="container" style="height: 20vh;">
        <div class="row">
            <div class="col-12 announce">
                <img src="images/wedding-bells.png">
                Marriage Banns
            </div>
        </div>
    </div>
    <div class="carousel-container" >
        <div id="carouselExampleRide" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        
            <div class="carousel-inner">
                <?php 
                // Reset the pointer of the result set
                mysqli_data_seek($result, 0); 
                $active = "active"; // Variable to mark the first item as active
                while ($row = mysqli_fetch_assoc($result)): ?>

                    <div class="carousel-item <?php echo $active; ?>">
                        <img src="uploads/marriage/<?php echo $row['File']; ?>" class="d-block mx-auto" alt="<?php echo $row['File']; ?>" style="max-height: 400px; object-fit: cover;">

                    </div>
                <?php 
                $active = ""; // Remove active class after the first iteration
                endwhile; ?> 
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
                <i class="bi bi-caret-left-fill" style="color:black; font-size:50px;"></i>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
                <i class="bi bi-caret-right-fill" style="color:black; font-size:50px;"></i>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="container" style="height: 100vh;">
        <div class="row">
            <div class="col-12 announce">
                <img src="images/icon-ann.png">
                Announcements
            </div>
            <div class="col-md-9 posts-archive">
                <?php
                include "socom/functions/dbcon.php";

                // Fetch announcements
                $sql = "SELECT * FROM announcement";
                $result = $conn->query($sql);
                ?>
            
                               
                <?php               
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {						
	            ?>

                <article class="post">
                    <div class="row">
                        <div class="col-md-4 col-sm-4"> 
                            <a href="announcements.php?id=<?php echo $row['ID'];?>">
                                <img src="uploads/announcement/<?php echo $row['File']; ?>" class="card-img-top" alt="" class="img-thumbnail img-responsive">
                            </a>
                        </div>
                        
                        <div class="col-md-8 col-sm-8 A-title">
                            <h3>
                                <a href="announcements.php?id=<?php echo $row['ID'];?>">
                                    <?php echo $row['Title']; ?>
                                </a>
                            </h3>
                            <span class="post-meta meta-data"> 
                                <span>
                                    Posted on <?php echo $row['Date']; ?>
                                </span>
                            </span>
                            <?php echo strip_tags(substr($row['Description'],0,180)) ;?>...
			        	    <p>
                                <a href="announcements.php?id=<?php echo $row['ID'];?>" class="btn btn-primary">
                                    Continue reading 
                                    <i class="fa fa-long-arrow-right">
                                    </i>
                                </a>
                            </p>
                        </div>
                    </div>
                </article>
                    <?php
			        }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?> 
			</div>
        </div>
        <!--<div class="row">
            <div class="col-12 events mt-5">
                <img src="images/icon-events.png">
                 Events
            </div>
            <div class="col-md-9 posts-archive">
            <?php
                include "socom/functions/dbcon.php";

                // Fetch announcements
                $sql = "SELECT * FROM event";
                $result = $conn->query($sql);
            ?>
            
                               
                <?php               
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {						
	            ?>

                    <article class="post">
                        <div class="row">
                            <div class="col-md-4 col-sm-4"> 
                                <a href="announcements.php?id=<?php echo $row['ID'];?>">
                                    <img src="uploads/event/<?php echo $row['File']; ?>" class="card-img-top" alt="" class="img-thumbnail img-responsive">
                                </a>
                            </div>
                            
                            <div class="col-md-8 col-sm-8">
                                <h3>
                                    <a href="announcements.php?id=<?php echo $row['ID'];?>">
                                        <?php echo $row['Title']; ?>
                                    </a>
                                </h3>
                                <span class="post-meta meta-data"> 
                                    <span>

                                        Posted on <?php echo $row['Date'];?>
                                    </span>
                                </span>
                                <?php echo strip_tags(substr($row['Description'],0,180)) ;?>...
			            	    <p>
                                    <a href="Events.php?id=<?php echo $row['ID'];?>" class="btn btn-primary">
                                        Continue reading 
                                        <i class="fa fa-long-arrow-right">
                                        </i>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </article>
                    <?php
			        }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?> 
                     
        </div>-->
<?php
    include "socom/functions/dbcon.php";

    // Fetch announcements
    $sql = "SELECT * FROM event";
    $result = $conn->query($sql);
?>

<div class="row">
    <div class="col-12 events mt-5">
        <img src="images/icon-events.png">
        Past Events
    </div>
    <div class="col-md-9 posts-archive">
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
                    <article class="post">
                        <div class="row">
                            <div class="col-md-4 col-sm-4"> 
                                <a href="Events.php?id=<?php echo $row['ID'];?>">
                                    <img src="uploads/event/<?php echo $row['File']; ?>" class="card-img-top" alt="" class="img-thumbnail img-responsive">
                                </a>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <h3>
                                    <a href="Events.php?id=<?php echo $row['ID'];?>">
                                        <?php echo $row['Title'] ?>
                                    </a>
                                </h3>
                                <span class="post-meta meta-data"> 
                                    <span>
                                        Posted on <?php echo $row['Date'];?>
                                    </span>
                                </span>
                                <?php echo strip_tags(substr($row['Description'],0,180)) ;?>...
			            	    <p>
                                    <a href="Events.php?id=<?php echo $row['ID'];?>" class="btn btn-primary">
                                        Continue reading 
                                        <i class="fa fa-long-arrow-right">
                                        </i>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </article>
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
<?php
    include "socom/functions/dbcon.php";

    // Fetch announcements
    $sql = "SELECT * FROM event";
    $result = $conn->query($sql);
?>
<div class="row">
    <div class="col-12 events mt-5">
        <img src="images/icon-events.png">
        Upcoming Events
    </div>
    <div class="col-md-9 posts-archive">
        <?php
        // Fetch announcements again to reset the pointer
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {						
                // Get the event date
                $event_date = date('Y-m-d', strtotime($row['EventsDate']));
                // Get the current date
                $current_date = date('Y-m-d');
                // Compare event date with current date
                if ($event_date > $current_date){ 
                    // Display upcoming events                      
                    ?>
                    <article class="post">
                        <div class="row">
                            <div class="col-md-4 col-sm-4"> 
                                <a href="Events.php?id=<?php echo $row['ID'];?>">
                                    <img src="uploads/event/<?php echo $row['File']; ?>" class="card-img-top" alt="" class="img-thumbnail img-responsive">
                                </a>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <h3>
                                    <a href="Events.php?id=<?php echo $row['ID'];?>">
                                        <?php echo $row['Title'] ?>
                                    </a>
                                </h3>
                                <span class="post-meta meta-data"> 
                                    <span>
                                        Posted on <?php echo $row['Date'];?>
                                    </span>
                                </span>
                                <?php echo strip_tags(substr($row['Description'],0,180)) ;?>...
			            	    <p>
                                    <a href="Events.php?id=<?php echo $row['ID'];?>" class="btn btn-primary">
                                        Continue reading 
                                        <i class="fa fa-long-arrow-right">
                                        </i>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </article> 
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


    
                    
</body>

</html>