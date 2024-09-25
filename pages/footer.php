<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <!-- footer.php -->
    <div class="row">
      <div class="col-12">
        <div id="globe" class="position-absolute end-0 top-10 mt-sm-3 mt-7 me-lg-7">
          <canvas width="700" height="600" class="w-lg-100 h-lg-100 w-75 h-75 me-lg-0 me-n10 mt-lg-5"></canvas>
        </div>
      </div>
    </div>
    <footer class="footer py-4">
      <div class="container-fluid d-flex flex-column align-items-center">
        <div class="row align-items-center justify-content-center">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-muted">
              © <script>document.write(new Date().getFullYear())</script>, made for <b>UKK</b></i> by
              <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Rainn</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
    </main>
    <!-- Core JS Files -->
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
          damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard -->
    <script src="./assets/js/material-dashboard.min.js?v=3.1.0"></script>

</body>
</html>