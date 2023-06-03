<!DOCTYPE html>
<html lang="de">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>400</title>
        <link rel="shortcut icon" type="image/png" href="favicon.ico">
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Bevan&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: rgb(40, 40, 40);
            overflow: hidden;
        }

        p {
            font-family: "Bevan", cursive;
            font-size: 130px;
            margin: 10vh 0 0;
            text-align: center;
            letter-spacing: 5px;
            background-color: black;
            color: transparent;
            text-shadow: 2px 2px 3px rgba(255, 255, 255, 0.1);
            -webkit-background-clip: text;
            -moz-background-clip: text;
            background-clip: text;
        }

        p span {
            font-size: 1.2em;
        }


        code {
            color: #bdbdbd;
            text-align: center;
            display: block;
            font-size: 16px;
            margin: 0 30px 25px;
        }

        code span {
            color: #f0c674;
        }

        code i {
            color: #b5bd68;
        }

        code em {
            color: #b294bb;
            font-style: unset;
        }

        code b {
            color: #81a2be;
            font-weight: 500;
        }


        a {
            color: #8abeb7;
            font-family: monospace;
            font-size: 20px;
            text-decoration: underline;
            margin-top: 10px;
            display: inline-block
        }

        @media screen and (max-width: 880px) {
            p {
                font-size: 14vw;
            }
        }
        </style>
    </head>

    <body>
        <p>HTTP: <span>400</span></p>
        <code><span>Bad Request!</span></code>
        <script>
        function type(n, t) {
            var str = document.getElementsByTagName("code")[n].innerHTML.toString();
            var i = 1;
            document.getElementsByTagName("code")[n].innerHTML = "";

            setTimeout(function() {
                var se = setInterval(function() {
                    i++;
                    document.getElementsByTagName("code")[n].innerHTML =
                        str.slice(0, i) + "|";
                    if (i == str.length) {
                        clearInterval(se);
                        document.getElementsByTagName("code")[n].innerHTML = str;
                    }
                }, 10);
            }, t);
        }
        type(0, 0);
        type(1, 600);
        type(2, 1300);
        </script>
    </body>

</html>