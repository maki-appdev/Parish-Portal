<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="website icon" type="png" href="images/logo.png" style="border-radius: 50%;">
    <title>Contact Us | DSSNP Portal </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
    * {
    box-sizing: border-box;
}
    .contact {
        background: #eee;
    }

    .contact h1 {
        text-align: center;

    }

    .contact span {
        font-size: 20px;

    }

    .contact {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    

    .contact .contact-info {
        display: flex;
        justify-content: center;
    }

    .contact .contact-info>div>div {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }

    .contact .contact-info>div>div img {
        margin-right: 1rem;
    }

    .contact .contact-info>div>div .fa {
        margin-right: 1rem;
        font-size: 30px;
        color: black;
    }

    .contact .contact-info>div>div .fab {
        margin-right: 1rem;
        font-size: 30px;
        color: black;
    }

    .contact .contact-info>div>div>div {
        display: flex;
        flex-direction: column;
    }

    .contact .contact-info>div>div>div span:first-child {
        font-family: "Raleway-bold";
        margin-bottom: 0.25rem;
    }

    .footercontact {
        background-color: white !important;
    }



    #footer .container {
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #footer .brand h1 {
        font-size: 2rem;
        text-transform: uppercase;
        color: black;
    }

    #footer .brand h1 span {
        color: crimson;
    }
    .map iframe{
        max-width: 100%;
    }
    #footer {
        background-color: #eee;
    }

    #footer .footer {
        min-height: 100px;
        flex-direction: column;
        padding-top: 30px;
        padding-bottom: 20px;
        font-family: 'Montserrat', sans-serif;
    }
    #footer p {
        color: black;
        font-size: 1rem;
        font-family: 'Montserrat', sans-serif;
    }
    
</style>

<body>


    <!--  ======================= Header ============================== -->



    <!--  ======================= Contact =============================  -->

    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="project-title pb-5">
                        <h1 class="text-uppercase title-h1 fw-bold" style="color:#C4110C;">Contact US</h1>
                    </div>
                    <div class="contact-info">
                        <div>
                            <div>
                                <div>
                                    <b><span> <i class="bi bi-geo-alt-fill"></i> Address </span></b>
                                    <span> M26G+3FJ, Bukidnon, Bago Bantay, Lungsod Quezon, Kalakhang Maynila</span>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <b><span><i class="bi bi-envelope-at-fill"></i> Gmail </span></b>
                                    <span>stoninoparishshrine@gmail.com</span>
                                </div>
                            </div>
                            <div>
                                <a href="https://www.facebook.com/dssnp" class="text-dark"
                                    style="text-decoration:none;">
                                    <div>
                                        <b><span><i class="bi bi-facebook"></i> Facebook </span></b><br>
                                        <span>Diocesan Shrine of Sto. Niño Parish </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.92495075886!2d121.0235599749252!3d14.66020038583324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b6e4361a1023%3A0x423eca49d5714447!2sDiocesan%20Shrine%20and%20Parish%20of%20Santo%20Ni%C3%B1o%20-%20Bago%20Bantay%2C%20Quezon%20City%20(Diocese%20of%20Cubao)!5e0!3m2!1sen!2sph!4v1714580266722!5m2!1sen!2sph"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
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