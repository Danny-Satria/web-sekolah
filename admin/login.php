<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Informasi</title>
    <style>
        
    </style>
</head>
<body style="background-color: #508bfc; overflow-y : hidden;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">Login</h3>
            <form action="proses-login.php" method="POST">

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="typeEmailX-2" >Username</label>
                    <input type="text" id="typeEmailX-2" class="form-control form-control-lg" name="user" />
                </div>
                
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label " for="typePasswordX-2" >Password</label>
                    <input type="password" id="typePasswordX-2" class="form-control form-control-lg" name="pass"/>
                </div>
                
                
                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block px-5 text-light" type="submit" name="submit" style="background-color : #508BFC ">Login</button>
                <p>Kembali ke <a href="../index.php">beranda?</a></p>
            </form>


          </div>
        </div>
      </div>
    </div>
  </div>
<!-- js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
