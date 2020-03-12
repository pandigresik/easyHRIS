<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo base_url(); ?>" />
    <title><?php echo $appTitle ?></title>
    <!-- CODELAB: Add link rel manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- Bootstrap -->
    <link href="assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="assets/css/custom.min.css" rel="stylesheet">

    </head>
    <body class="login">
      <div class="login_wrapper">
        <div class="animate form login_form" id="divlogin">
          <section class="login_content">
            <div id="divinfo"></div>  
            <form onsubmit="return User.login()">
              <h1>Login Form</h1>
              <div>
                <input type="text" name="username" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button type="submit" class="btn btn-default submit">Log in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><?php echo $appTitle ?></h1>
                  <p>©2019 CV. Syariah Solution</p>
                </div>
              </div>
            </form>
          </section>
        </div>
    </div>
    </body>    
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/user/user.js"></script>
</html>


