<?php
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VPOV</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="ajax/ajax.js"></script>
</head>

    <body style=" margin-top: 6%;">
    <div id="wrapper">
        <div class="printarea">
            <div class="container-lg">
                <img src="logo.jpg" alt="Trulli" class="logo">
                <p id="success"></p>
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2 class="nadpis">VÝDEJKA-PŘEVODKA-ODPIS-VÝMĚNA </h2>
                            </div>
                            <div style="position: static;" class="wrapper"></div>
                            <br>
                        </div>
                    </div>
                    <div style="margin-top: -1%;margin-left: 85%;">
                        <?php
                                session_start();
                                $_SESSION['uzivatel'] = 'Jan Novák';
                                if($_SESSION["uzivatel"]) {
                                ?>
                        Přihlášen/a: <?php echo $_SESSION["uzivatel"]; ?>
                        <?php
                                } 
                                ?>
                    </div>
                  
                    <!--------------------------------------------------------------------->
                    <style>
                    th {
                        text-align: center;
                    }

                    td {
                        background-color: white;
                        border: 1px solid #ddd;
                    }
                    </style>

               
                        <a onclick="document.location='records.php'" class="btn button"  id="addnew" data-toggle="modal" title="Přidat nový záznam">
                            <span style="font-size: 20px;">
                                <span class="material-icons" style="position: relative;top: 5px;font-size:27px;">
                                    add
                                </span>
                            </span>
                        </a>
                        <div class="animate__animated animate__fadeInUp ">
                       

                        <section>
                            <!-- TABLE CONSTRUCTION-->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <!-- TABLE HEADING -->
                                        <th>#</th>
                                        <th>Vyhotovil</th>
                                        <th>Datum</th>
                                        <th>Kontroloval</th>
                                        <th> Status</th>
                                        <th
                                            style="border: 1px solid transparent; background-color:transparent; border-bottom:2px solid #ddd; ">
                                        </th>
                                    </tr>
                                </thead>
                                <!-- TABLE DATA -->
                                                    <?php
                                    $result = mysqli_query($conn,"SELECT 
                                    id, 
                                    vyhotovil, datum, kontroloval, status, odeb, vydav
                                    FROM
                                    uzivatel
                                    WHERE
                                    EXISTS(
                                    SELECT 
                                            1
                                        FROM
                                            zadanka
                                        WHERE
                                            zadanka.id_uziv 
                                        = uzivatel.id_uziv);");
                                        $i=1;
                                 
                                        while($row = mysqli_fetch_array($result)) {
                                    ?>
                                <tbody>
                                    <tr id="<?php echo $row["id"]; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td class="vyhotovil"><?php echo $row["vyhotovil"]; ?></td>
                                        <td class="datum">
                                            <?php $myinput= $row["datum"]; $sqldate=date('d.m.Y',strtotime($myinput)); echo $sqldate;?>
                                        </td>
                                        <td class="kontroloval"><?php echo $row["kontroloval"]; ?></td>
                                        <td class="status color"><?php echo $row["status"];?></td>
                                        <td><button class="select eye" data-toggle="modal" data-target="#gfgmodal"
                                                style="background-color: transparent; border:transparent;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="20"
                                                    fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                    <path
                                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                </svg></button></td>
                                    </tr>
                                                                    <?php
                                                $i++;
                                                } 
                                                ?>
                                    <script language="javascript">
                                    $(".color:contains('Schváleno')").css("color", "green");
                                    $(".color:contains('Zamítnuto')").css("color", "red");
                                    // $(".color:contains('Čeká na odpověď')").css("color", "yellow");
                                    </script>
                                </tbody>
                            </table>
                        </section>



                        </div>

                    <!--------------------------------------------------------------------------------------------------------------------------------------->
                    <script>
                    $(function() {
                        // ON SELECTING ROW 
                        $(".select").click(function() {
                            //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES 
                            var a =
                                $(this).parents("tr").find(".vyhotovil").text();
                            var c =
                                $(this).parents("tr").find(".datum").text();
                            var d =
                                $(this).parents("tr").find(".kontroloval").text();
                            var e =
                                $(this).parents("tr").find(".status").text();
                            var p = "";
                            // CREATING DATA TO SHOW ON MODEL 
                            p +=
                                "<p id='a' name='vyhotovil' > Vyhotovil: " +
                                a + " </p>";

                            p +=
                                "<p id='c' name='datum'> Datum: " +
                                c + "</p>";
                            p +=
                                "<p id='d' name='kontroloval' > Kontroloval: " +
                                d + " </p>";
                            p +=
                                "<p id='e' name='status' > Status: " +
                                e + " </p>";
                            //CLEARING THE PREFILLED DATA 
                            $("#divGFG").empty();
                            //WRITING THE DATA ON MODEL 
                            $("#divGFG").append(p);
                        });
                    });
                    </script>
                    <!-- CREATING BOOTSTRAP MODEL -->
                    <div class="modal fade" id="gfgmodal" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content" style="margin-top: 29%;">
                                <div class="modal-header">
                                    <!-- MODEL TITLE -->
                                    <h2 class="modal-title" id="gfgmodallabel">
                                        Podrobnosti</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">
                                            ×</span>
                                    </button>
                                </div>
                                <!-- MODEL BODY -->
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <!-- TABLE HEADING -->
                                                <th>#</th>
                                                <th>Název</th>
                                                <th>Množství</th>
                                                <th>Celkem</th>
                                            </tr>
                                        </thead>
                                        <!-- TABLE DATA -->

                                        <?php
				$result = mysqli_query($conn,"SELECT 
                id, 
                nazev, mnozstvi, celkem
                FROM
                zadanka
                WHERE
                EXISTS(
                SELECT 
                        1
                    FROM
                        uzivatel
                    WHERE
                        uzivatel.id_zadost 
                    = zadanka.id_zadost);");
					$i=1;
					while($row = mysqli_fetch_array($result)) {
                ?>
                                        <tbody>
                                            <tr id="<?php echo $row["id"]; ?>">
                                                <td><?php echo $i; ?></td>
                                                <td class="nazev"><?php echo $row["nazev"]; ?></td>
                                                <td class="mnozstvi"><?php echo $row["mnozstvi"]; ?></td>
                                                <td class="celkem"><?php echo $row["celkem"] . ",-" ; ?></td>
                                            </tr>
                                            <?php
				$i++;
				} 
				?>
                                            <div class="GFGclass" id="divGFG">
                                            </div>
                                            <div class="modal-footer">
                                                <!-- The close button in the bottom of the modal -->
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Zavřít</button>
                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>

</html>