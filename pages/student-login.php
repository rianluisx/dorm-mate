<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DormMate</title>
    <link rel="icon" type="icon" href="../images/🦆 icon _bookmark book_.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

      <nav class="navbar navbar-expand-lg bg-body-primary">
          <div class="container-fluid">
            <a class="navbar-brand" href="../src/index.php"> <img src="../images/🦆 icon _bookmark book_.png" alt=""> DormMate </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="../src/index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="student-login.php">Student</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="admin-login.php">Admin</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../src/index.php">About</a>
                </li>
              </ul>

              <div class="cntcts">
                <a class="cstm-class btn btn-outline-dark my-2 my-sm-0" href="#">Contacts</a>
              </div>
            
            </div>
            
          </div>
      </nav>

      <div class="center-form">
        <div class="login-content">
              <h3>Student Login</h3>
              <p>Welcome back!</p>
              
              <form action="../actions/sign-in.php" method="post">
                  <div class="sign-in">
                      <input type="email" class="form-control" id="email" placeholder="Email" name="student_email">
                      <br>
                      <input type="password" class="form-control" id="password" placeholder="Password" name="student_password">
                  </div>
                  <br>
                  <button type="submit" class="cstm-bton btn btn-dark" id="sign-up"> Sign in </button>
                  <br>
              </form>

              <a href="#sign-up-modal" class="sign-in" id="user-sign-up" data-bs-target="#sign-up-modal" data-bs-toggle="modal">Not registered? Create an account </a>

              <div class="modal fade" id="sign-up-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="sign-up-modal">Sign-up</h5>
                          </div>
                          <div class="modal-body">
                              <form action="../actions/sign-up.php" method="post" class="sign-up"></form>
                                  <div class="input-field">
                                    <input type="email" class="input" id="email" placeholder="Email" name="student_email">
                                  </div>
                                  <div class="input-field">
                                    <input type="password" class="input" id="password" placeholder="Password" name="student_password"> 
                                    <input type="hidden" >
                                  </div>
                                  <button type="submit" class="btn btn-primary" >Sign up</button>
                              <form>
                          </div>
                      </div>
                  </div>
              </div>
        </div>
      </div> 

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    
</body>
</html>