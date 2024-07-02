<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url ?>assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url ?>assets/bootstrap/css/estilos-ecommerce-sweets.css?v=" <?php echo time(); ?> />
    <link rel="stylesheet" href="<?= base_url ?>assets/bootstrap/css/shopInfo.css?v=" <?php echo time(); ?> />
    <link rel="stylesheet" href="<?= base_url ?>assets/bootstrap/css/estilos-inicio-sesion.css?v=" <?php echo time(); ?> />
    <script type="text/javascript" src="<?= base_url ?>assets/js/main.js"></script>    
    <!-- Agrega Easy Toast -->
    <script type="text/javascript" src="<?= base_url ?>assets/jquery/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Paypal -->
    <script src="https://www.paypal.com/sdk/js?client-id=AT_hnmio2IdJthKN5CO0BbSx3DwbT5nkQCLS2SSKtiRZtYF7ZcvjYu4yS-RE9gsGpiR5XRWVmljsaPyE&currency=MXN"></script>
    <!-- PARA QUE FUNCIONE LOS SLIDERS Y MÁS-->
    <script type="text/javascript" src="<?= base_url ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- PARA QUE FUNCIONE LOS SLIDERS Y MÁS-->
    <script type="text/javascript" src="<?= base_url ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/fc7ee59db0.js" crossorigin="anonymous"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        // JavaScript to prevent back navigation
        history.pushState(null, null, window.location.href);
        window.addEventListener('popstate', function() {
            history.pushState(null, null, window.location.href);
        });
    </script>
    <title>Sweets</title>
</head>

<body>

    <body>
        <?php if (isset($_SESSION['successful_login'])) : ?>
            <script>
                toastr.success('¡Bienvenido a Sweets! Estamos felices de verte de nuevo.');
            </script>
        <?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'complete') : ?>
            <script>
                toastr.success('¡Cuenta creada exitosamente! Por favor, inicia sesión para continuar.');
            </script>
        <?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'failed') : ?>
            <script>
                toastr.error('Lo sentimos, no se pudo crear tu cuenta. Inténtalo nuevamente.');
            </script>
        <?php elseif (isset($_SESSION['error_login'])) : ?>
            <script>
                toastr.error('Error al iniciar sesión. Verifica tus credenciales e inténtalo de nuevo.');
            </script>
        <?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'duplicated_email') : ?>
            <script>
                toastr.error('El correo ingresado ya se encuentra registrado.');
            </script>
        <?php elseif (isset($_SESSION['errores'])) : ?>
            <?php foreach ($_SESSION['errores'] as $indice => $elemento) : ?>
                <script>
                    toastr.error("<?= $elemento; ?>");
                </script>
            <?php endforeach; ?>

        <?php endif; ?>
        <?php Utils::deleteSession('successful_login'); ?>
        <?php Utils::deleteSession('register'); ?>
        <?php Utils::deleteSession('errores') ?>
        <?php Utils::deleteSession('error_login') ?>
        <header>
            <!-- TITULO PÁGINA -->
            <div class="container">
                <div class="row">
                    <div class="logo col-xs-12 col-sm-4">
                        <a href="#"><img src="<?= base_url ?>assets/img/logo-tienda.png" alt="FarmaciaJesusito Logo" /></a>
                    </div>
                    <!-- FIN TITULO PÁGINA -->
                    <!-- BARRA DE BUSQUEDA -->
                    <div class="barra-busqueda col-xs-12 col-sm-12 col-md-8 mb-2">
                        <form class="d-flex" action="<?= base_url ?>producto/busqueda" method="POST">
                            <input class="mx-2 me-2 mt-4" type="search" name="buscar" placeholder="Buscar productos, marcas, categorías y más" />
                            <button class="btn mt-4">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>


            <?php $categorias = Utils::showCategorias(); ?>
            <!-- MENU -->
            <nav class="menu">
                <div class="container">
                    <div class="row">
                        <!-- Botón de hamburguesa -->
                        <div class="hamburguesa">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <!-- Lista de navegación principal -->
                        <ul class="menu-lista">
                            <li>
                                <a href="<?= base_url ?>producto/index">Inicio</a>
                            </li>
                            <li>
                                <a href="#">Categorías </a>
                                <ul class="submenu">
                                    <?php while ($categoria = $categorias->fetch_object()) : ?>
                                        <li>
                                            <a href="<?= base_url ?>categoria/ver&id=<?= $categoria->id ?>"><?= $categoria->nombre ?></a>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            </li>
                            <li>
                                <a href="<?= base_url ?>sweets/sobreNosotros">Sobre nosotros</a>
                            </li>
                            <li>
                                <a href="<?= base_url ?>sweets/vision">Visión</a>
                            </li>
                            <li>
                                <a href="<?= base_url ?>sweets/objetivos">Objetivos</a>
                            </li>
                            <?php if (!isset($_SESSION['identity'])) : ?>
                            <li>
                                <a href="<?= base_url ?>usuario/iniciarSesionVista">Iniciar Sesión</a>
                            </li>
                            <?php endif; ?>                           
                            <?php if (isset($_SESSION['identity'])) : ?>
                                <li class="registro">
                                    <a href="#"><?= $_SESSION['identity']->usuario ?> <i class="fa-solid fa-square-caret-down"></i></a>
                                    <ul class="submenu">
                                        <?php if (isset($_SESSION['admin'])) : ?>
                                            <li><a class="acciones" href="<?= base_url ?>Categoria/index">Gestionar categorías</a></li>
                                            <li><a class="acciones" href="<?= base_url ?>Producto/gestion">Gestionar productos</a></li>
                                            <li><a class="acciones" href="<?= base_url ?>Pedido/gestion">Gestionar pedidos</a></li>
                                        <?php endif; ?>
                                        <?php if (isset($_SESSION['identity'])) : ?>
                                            <li><a class="acciones" href="<?= base_url ?>Pedido/mis_pedidos">Mis pedidos</a></li>
                                            <li><a class="acciones" href="<?= base_url ?>Usuario/logout">Cerrar sesion</a></li>
                                        <?php else : ?>
                                            <li><a class="acciones" href="<?= base_url ?>Usuario/registro">Registrate aqui</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <!-- Fin de la lista de navegación principal -->
                    </div>
                </div>
            </nav>

        </header>
        <!--BANNER -->
        <?php if (Utils::isAdmin() != true && isset($_GET['controller']) && isset($_GET['action']) && $_GET['controller'] == 'producto' && $_GET['action'] == 'index') : ?>
            <div id="banner" class="mb-3 d-xs"></div>
        <?php endif; ?>
        <!--FIN BANNER-->
        <div class="container">
            <div class="row">
                <section class="main col-md-12 col-xs-12">
                    <!-- Para que ocupe el espacio adecuado -->