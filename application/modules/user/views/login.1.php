<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo base_url(); ?>" />
    <title><?php echo $appTitle ?></title>

    <!-- Bootstrap -->
    <link href="assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="assets/css/custom.min.css" rel="stylesheet">
    <style type="text/css">
        #main_cont {
            background: rgba(52,73,94,.88);
            background-image: url(../img/bg-login.jpeg);
        /*    padding: 40px 20px;*/
            width: auto;
            margin: 0 auto;
            border-radius: 6px;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .main-cover{
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #bbd2d7;
            padding: 12% 30px;
            
            border-radius: 6px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.4);
            
        }
        .login-mobile{
            background-image: url(../img/bg-login.jpeg);
            background-position: center;
        }
        .login-mobile .main-cover{
            padding: 120px 30px 170px;
            border-radius: 0px;
        }
        .form-box {
        width: 360px; /* CUSTOM */
        }
        .form-group {
        margin-bottom: 10px; /* CUSTOM */
        }

        .login-box{
            padding: 0 20px;
        }
        
        .brand-img img {
            width: 130px;
            margin-bottom: 25px;
            margin-left: -25px;
        }

        .brand-header {
            font-weight:bolder;
            color: #000;
            font-size: 35px;
            font-family: "Lato";
            text-shadow: 2px 2px #fff;
            margin-bottom: -10px;
        }

        .brand-motto {
            font-size: 30px;
            font-family: "Lato";
            color: #fff;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .brand-description {
            color: #fff;
            font-family: "Lato";
            line-height: 1.8;
            font-size: 13px;
        }

        .vertical-divider {
            width: 2px;
            height: 20em;
            position: absolute;
            right: 30px;
            background: #fff;
        }

        .login-intro {
            font-size: 24px;
            color: #01086a;
            margin-bottom: 20px;
        }

        label.login-label {
            color: #01086a;
            font-weight: 400;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control.login-form{
            margin-bottom: 16px;
        }

        .login-bottom{
            margin-top: 24px;
        }

        .btn-login{
            padding: 8px 20px;
        }


        .login-link{
            margin-top: 8px;
            color: #01086a;
            transition: all 0.3s ease;
        }

        .login-link:hover{
            color: #628AFC;
        }

        .login-message {
            background: white;
            padding: 8px 15px;
            font-size: 13px;
            border-left: 8px solid #EB5757;
            color: #EB5757;
            margin-bottom: 8px;
        }


    </style>

    </head>

    <body>
        <div class="hidden-xs" id="main_cont">
            <div class="main-cover">
                <div class="col-md-10 col-md-offset-1">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="brand-img">
                                    <img src="<?php echo site_url('assets/images/brand-ico.png'); ?>" alt="">
                                </span>
                            </div>
                            <div class="col-md-6">
                                <div class="brand-header"><?php echo $appTitle ?></div>
                                <div class="brand-motto">CV. Syariah Solution</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4" id="divlogin">
                        <div id="divinfo"></div>
                        <form onsubmit="return User.login()">
                            <div class="form-group row">
                                <div class="col-md-12 has-feedback">
                                    <input type="text" name="username" class="form-control has-feedback-left" placeholder="User Name">
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="form-group row">    
                                <div class="col-md-12 has-feedback">
                                    <input type="password" name="password" class="form-control has-feedback-left" placeholder="Password">
                                    <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>    
                            <div class="form-group row">
                                <div class="checkbox col-md-offset-2 col-md-10">
                                    <label class="">
                                        <input type="checkbox" checked value=""> Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-offset-2 col-md-10">
                                    <button type="submit" class="col-md-5 btn btn-round btn-primary">LOG IN</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top:100px">
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    <script>
        var base_url = '<?php echo base_url(); ?>';
    </script>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/user/user.js"></script>
</html>


