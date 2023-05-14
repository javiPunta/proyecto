<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Tooplate">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

  <title>Inicio</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/tooplate-main.css">
  <link rel="stylesheet" href="assets/css/owl.css">

</head>
<!--
Tooplate 2113 Earth
https://www.tooplate.com/view/2113-earth
-->

<body>

  <div class="sequence">

    <div class="seq-preloader">
      <svg width="39" height="16" viewBox="0 0 39 16" xmlns="http://www.w3.org/2000/svg" class="seq-preload-indicator">
        <g fill="#F96D38">
          <path class="seq-preload-circle seq-preload-circle-1" d="M3.999 12.012c2.209 0 3.999-1.791 3.999-3.999s-1.79-3.999-3.999-3.999-3.999 1.791-3.999 3.999 1.79 3.999 3.999 3.999z" />
          <path class="seq-preload-circle seq-preload-circle-2" d="M15.996 13.468c3.018 0 5.465-2.447 5.465-5.466 0-3.018-2.447-5.465-5.465-5.465-3.019 0-5.466 2.447-5.466 5.465 0 3.019 2.447 5.466 5.466 5.466z" />
          <path class="seq-preload-circle seq-preload-circle-3" d="M31.322 15.334c4.049 0 7.332-3.282 7.332-7.332 0-4.049-3.282-7.332-7.332-7.332s-7.332 3.283-7.332 7.332c0 4.05 3.283 7.332 7.332 7.332z" />
        </g>
      </svg>
    </div>

  </div>

  <div class="logo">
    <h1>TicketsGame</h1>
    <h2>TG</h2>
  </div>
  <nav>
    <ul>
      <li><a href="#1"><img src="assets/images/icon-1.png" alt=""> <em>Home</em></a></li>
      <li><a href="#2"><img src="assets/images/icon-2.png" alt=""> <em>Sobre nosotros</em></a></li>
      <li><a href="#3"><img src="assets/images/icon-3.png" alt=""> <em>Nuestros Juegos</em></a></li>
      <li><a href="#4"><img src="assets/images/icon-4.png" alt=""> <em>Contacta con nosotros</em></a></li>
    </ul>
  </nav>

  <div class="slides">
    <div class="slide" id="1">
      <div id="slider-wrapper">
        <div id="image-slider">
          <ul>
            <li class="active-img">
              <div class="slide-caption">
                <h6>New Arrival</h6>
                <h2>Beautiful<br>Earth</h2>
              </div>
            </li>
            <li>
              <div class="slide-caption">
                <h6>Latest One</h6>
                <h2>Tech<br>Meeting</h2>
              </div>
            </li>
            <li>
              <div class="slide-caption">
                <h6>Your Update</h6>
                <h2>Smart<br>Devices</h2>
              </div>
            </li>
          </ul>
        </div>
        <div id="thumbnail">
          <ul>
            <li class="active"><img src="assets/images/thumb-01.jpg" alt="Earth" /></li>
            <li><img src="assets/images/thumb-02.jpg" alt="Meeting" /></li>
            <li><img src="assets/images/thumb-03.jpg" alt="Smart" /></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="slide" id="2">
      <div class="content second-content">
        <div id='tabs'>
          <ul>
            <li><a href='#tabs-1'><span class='fa fa-desktop'></span></a></li>
            <li><a href='#tabs-2'><span class='fa fa-users'></span></a></li>
            <li><a href='#tabs-3'><span class='fa fa-mobile'></span></a></li>
          </ul>
          <section class='tabs-content'>
            <article id='tabs-1'>
              <h2>¿Qué ofrecemos?</h2>
              <span>Premios</span>
              <p> <a href="https://www.facebook.com/tooplate/">Facebook page</a> for latest updates. Thank you.</p>
            </article>
            <article id='tabs-2'>
              <h2>¿Qué hacemos?</h2>
              <span>Sueños realidad</span>
              <p></p>
            </article>
            <article id='tabs-3'>
              <h2>¿Quienes somos?</h2>
              <span>Empresa joven</span>
              <p></p>
            </article>
          </section>
        </div>
      </div>
    </div>
    <div class="slide" id="3">
      <div class="content third-content">
        <div class="container-fluid">
          <div class="row">
            <div class="owl-carousel owl-theme">

              <div class="col-md-12">
                <div class="featured-item">

                  <div class="down-content">
                    <div class="container container2">



                      <p>Para poder jugar debes estar registrado en el siguiente enlace:</p>
                      <a href="forms/login.php">Login</a>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              if (session_status() === PHP_SESSION_ACTIVE) {
                session_start();
                $_SESSION['nombre_user'] = $nombre_user;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['correo'] = $correo;
                if (isset($nombre)) {
                  echo "Bienvenido " . $_SESSION['nombre_user'];

                  echo '
                        <div class="col-md-12">
                            <div class="featured-item"> 
                                <a href="dino.php"><img src="assets/images/item-01.png" alt=""></a>
                                <div class="down-content">
                                    <div class="container container2">
                                        <a href="dino.php">
                                            <img src="img/arka/juegod.png" alt="">
                                            Dinosaurio
                                        </a>
                                        <p>El juego consiste en saltar y esquivar objetos mientras
                                            que el T-Rex pixeleado no deja de correr. Los controles
                                            son básicos, ya que solo utilizas el espacio para saltar.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="featured-item">
                                <a href=""><img src="assets/images/item-02.png" alt=""></a>
                                <div class="down-content">
                                    <div class="container container1">
                                        <a href="Juegos/Memoramas/memorama.php">
                                            <img src="img/memo/juegom.png" alt="">
                                            Memorama
                                        </a>
                                        <p>Memoriza la ubicación de las diferentes 
                                            cartas con el fin de voltear sucesivamente las 2 cartas idénticas
                                            que formen pareja, para llevárselas, solamente tienes que hacer click
                                            para voltearla. La partida se terminará cuando
                                            estén todas las parejas encontradas.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="featured-item">
                                <a href=""><img src="assets/images/" alt=""></a>
                                <div class="down-content">
                                    <div class="container container1">
                                        <a href="encuesta/encuesta.html">
                                            Encuesta
                                        </a>
                                        <p>Sirve para saber si optuvo un buen servicio en la tienda,
                                        calificarlos y obtener puntos para aspirar a premios en el ranking.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="featured-item">
                                <a href=""><img src="assets/images/" alt=""></a>
                                <div class="down-content">
                                    <div class="container container1">
                                        <a href="ranking/grafico.html">
                                            Encuesta
                                        </a>
                                        <p>Sirve para saber los puntos obtenidos.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                }
              }
              ?>



            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slide" id="4">
      <div class="content fourth-content">
        <div class="container-fluid">
          <form id="contact" action="" method="post">
            <div class="row">
              <div class="col-md-12">
                <h2>Pon tu tienda en TicketsGame</h2>
              </div>
              <div class="col-md-6">
                <fieldset>
                  <input name="name" type="text" class="form-control" id="name" placeholder="Tu nombre..." required="">
                </fieldset>
              </div>
              <div class="col-md-6">
                <fieldset>
                  <input name="email" type="text" class="form-control" id="email" placeholder="Tu email..." required="">
                </fieldset>
              </div>
              <div class="col-md-12">
                <fieldset>
                  <textarea name="message" rows="6" class="form-control" id="message" placeholder="Tu mensaje..." required=""></textarea>
                </fieldset>
              </div>
              <div class="col-md-12">
                <fieldset>
                  <button type="submit" id="form-submit" class="button">Enviar ahora</button>
                </fieldset>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


  <!-- Additional Scripts -->
  <script src="assets/js/owl.js"></script>
  <script src="assets/js/accordations.js"></script>
  <script src="assets/js/main.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {

      // navigation click actions 
      $('.scroll-link').on('click', function(event) {
        event.preventDefault();
        var sectionID = $(this).attr("data-id");
        scrollToID('#' + sectionID, 750);
      });
      // scroll to top action
      $('.scroll-top').on('click', function(event) {
        event.preventDefault();
        $('html, body').animate({
          scrollTop: 0
        }, 'slow');
      });
      // mobile nav toggle
      $('#nav-toggle').on('click', function(event) {
        event.preventDefault();
        $('#main-nav').toggleClass("open");
      });
    });
    // scroll function
    function scrollToID(id, speed) {
      var offSet = 0;
      var targetOffset = $(id).offset().top - offSet;
      var mainNav = $('#main-nav');
      $('html,body').animate({
        scrollTop: targetOffset
      }, speed);
      if (mainNav.hasClass("open")) {
        mainNav.css("height", "1px").removeClass("in").addClass("collapse");
        mainNav.removeClass("open");
      }
    }
    if (typeof console === "undefined") {
      console = {
        log: function() {}
      };
    }
  </script>

</body>

</html>