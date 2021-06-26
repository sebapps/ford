<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CurPhew | Ford Connect Hackathon</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/themify-icons/themify-icons.css">
        <link rel="stylesheet" href="css/slick/slick.css">
        <link rel="stylesheet" href="css/slick/slick-theme.css">
        <link rel="stylesheet" href="css/fancybox/jquery.fancybox.min.css">
        <link rel="stylesheet" href="css/aos/aos.css">
        <link href="css/style.css?id=<?php echo date("YmdHis"); ?>" rel="stylesheet">
    </head>
    <body class="body-wrapper" data-spy="scroll" data-target=".privacy-nav">
        <div align="center" style="margin-top:10px">
            <img id="logo" src="images/logo.png" alt="logo">
            <form id="username_form" action="begin.php" method="post">
                <table id="curfew-table" width="50%" style="max-width:450px">
                    <tr>
                        <td>Enter your username</td>
                        <td><input type="text" name="username" id="username"></td>
                    </tr>
                </table>
            </form>
            <button onclick="verify_username();" class="settings-button">Go!</button>
        </div>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/jquery.fancybox.min.js"></script>
        <script src="js/jquery.syotimer.min.js"></script>
        <script src="js/aos.js"></script>
        <script src="js/script.js"></script>
        <script type="text/javascript">
        function verify_username() {
            var username = $("#username").val();
            if(username == "") {
                alert("Please enter your username.");
                return false;
            }
            $("#username_form").submit();
        }
        </script>
    </body>
</html>