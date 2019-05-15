<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/libs/css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/buttons.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/select.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">-->
        <title>RTC (Reltrab Cliente) - WEB</title>
        <style type="text/css">

            .nodo{

                border-radius: 4px;
                border:2px solid #000000;
                background-color:#FFFFFF;
                z-index: 20;
                text-align: right;
                color:#000000;
                font-family: Arial;
                font-weight: bold;
                padding-top:5px;
            }

            .nodo button{
                width:20px;
                padding:0px;
                margin-right:4px;
            }

            .nodo div{
                height:2px !important;
                text-align: center;
            }

            .nodo:hover{

                border-radius: 4px;
                border:2px solid #000000;
                background-color:#FFFFFF;
                z-index: 20;
                text-align: right;
                color:#000000;
                font-family: Arial;
                font-weight: bold;
                padding-top:5px;

            }

        </style>
    </head>

    <body>





    </body>
    <script>

        var estrutura = {
            nodos: [
                {
                    id: 0,
                    expressao: "Teste1",
                    tipo: "U"
                },
                {
                    id: 1,
                    expressao: "Teste2",
                    tipo: "U"
                },
                {
                    id: 2,
                    expressao: "Teste3",
                    tipo: "U"
                },
                {
                    id: 3,
                    expressao: "Teste4",
                    tipo: "U"
                },
                {
                    id: 4,
                    expressao: "Teste5",
                    tipo: "U"
                }
            ],
            links: [
                [1,2,3],
                [4],
                [4],
                [4],
                [4]
            ]
        };
        
        
        
        function montarDiagrama(estrutura,indice,nivel,y_offset,x){
            
            
            
        }


    </script>
</html>