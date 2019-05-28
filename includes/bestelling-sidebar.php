<div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item active bg-light">
            <a class="nav-link" href="bon.php">
                <span>Bon maken</span>
            </a>
        </li>

        <!-- script -->
        <script type="text/javascript">

          //script for handling back-button
          let currentPagina = window.location.href.split('/');
          let currentPaginaBeforeDot = currentPagina[4].split('.');
          var previousPage = '';

          switch (currentPaginaBeforeDot[0]) {
            case 'bestelling-beheren':
              previousPage = 'bestellingen.php';
              break;
            case 'bestelling-toevoegen': {
              previousPage = 'bestelling-beheren.php';
              break;
            }
            default:
              previousPage = 'bestellingen.php';
              break;
          }
        </script>

        <li class="nav-item bg-light">
            <a class="nav-link" onclick="window.location.href = previousPage; return false;">
                <span>Terug</span>
            </a>
        </li>

        <li class="nav-item bg-light">
            <a class="nav-link" href="bestellingen.php">
                <span>Andere tafel</span>
            </a>
        </li>

    </ul>

    <div id="content-wrapper">

        <!-- .container-fluid -->
        <div class="container-fluid">