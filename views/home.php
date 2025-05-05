<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MachinaSynthLabs - UNEFA</title>
  <link href="../assets/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/home.css" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>

  <!-- Barra de navegación -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-unefa">
    <div class="container d-flex justify-content-center">
      <a class="navbar-brand d-flex align-items-center" href="../index.php">
        <div class="me-3"><img src="../assets/images/logo.png" alt="logo" width="40" height="60"></div>
        <span>Machina<span style=" color: #FFC72C;">Synth</span>Labs</span>
      </a>
    </div>
  </nav>

  <!-- Barra de búsqueda -->
  <div class="search-container text-white">
    <div class="container">
      <div class="search-box">
        <h2 class="text-center mb-4">Encuentra el simulador que necesitas</h2>
        <div class="input-group mb-3">
          <input type="text" class=" search-input" placeholder="Buscar simuladores..." id="search_bar">
          <script src="./../assets/js/search-bar.js"></script>
        </div>
        <div class="text-center">
          <small>Ejemplo: redes, programación, bases de datos</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Contenido principal -->
  <div class="container py-5">
    <?php 
    // Configuración de conexión a Supabase
    $host = 'aws-0-us-east-2.pooler.supabase.com';
    $port = '5432';
    $dbname = 'postgres';
    $user = 'postgres.nihjruyujqysshpsgnpp';
    $password = 'machinalabsxpass';

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Obtenemos las asignaturas únicas
        $consulta_asignaturas = "SELECT DISTINCT asignatura FROM simuladores ORDER BY asignatura";
        $resultado_asignaturas = $pdo->query($consulta_asignaturas);
        
        if ($resultado_asignaturas) {
            while ($asignatura_row = $resultado_asignaturas->fetch(PDO::FETCH_ASSOC)) {
                $asignatura_actual = $asignatura_row['asignatura'];
    ?>
    
    <!-- Sección por asignatura -->
    <h3 class="section-title mb-4"><?php echo htmlspecialchars(ucfirst($asignatura_actual)); ?></h3>
    
    <div class="row g-4 mb-5">
        <?php
                // Obtenemos los simuladores para esta asignatura
                $consulta_simuladores = "SELECT * FROM simuladores WHERE asignatura = :asignatura ORDER BY nombre_del_simulador";
                $stmt = $pdo->prepare($consulta_simuladores);
                $stmt->bindParam(':asignatura', $asignatura_actual, PDO::PARAM_STR);
                $stmt->execute();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['id'];
                    $categoria = $row['categoria'];
                    $nombre_del_simulador = $row['nombre_del_simulador'];
                    $enlace = $row['enlace'];
        ?>
        <!-- Card Individual -->
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column">
                    <i class="bi bi-terminal fs-1 my-4"></i>
                    <span class="badge category-badge mb-3"><?php echo htmlspecialchars(ucfirst($categoria)); ?></span>
                    <h5 class="card-title"><?php echo htmlspecialchars($nombre_del_simulador); ?></h5>
                    <hr>
                    <p class="card-text text-muted mb-4">Simulador interactivo</p>
                    <a href="<?php echo htmlspecialchars($enlace); ?>" target="_blank" class="btn btn-simulator mt-auto ">Ejecutar</a>
                </div>
            </div>
        </div>
        <?php
                } // Cierra while simuladores
        ?>
    </div> <!-- Cierre del row -->
    <?php
            } // Cierra while asignaturas
        } // Cierra if resultado_asignaturas
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
    ?>
</div> <!-- Cierre del container -->
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>