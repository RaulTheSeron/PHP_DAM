<?php
require_once('include/CestaCompra.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario']))
    die("Error - debe <a href='login.php'>identificarse</a>.<br />");

// Recuperamos la cesta de la compra
$cesta = CestaCompra::cargar_cesta();

if (isset($_POST['exportar'])) {

    if (!$cesta->esta_vacia()) {

     
        require_once('fpdf/fpdf.php');
        
        //Creacion del objeto FPDF.
        $pdf = new FPDF();
        //se añade una página
        $pdf->AddPage();
        // Formato del texto
        $pdf->SetFont('Arial', 'B', 16);                 
        $pdf->Cell(0, 10, 'Resumen de la compra', 0, 2, 'C');
        
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Nombre Usuario: ' . $_SESSION['usuario']);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 12);

        $moviles = $cesta->get_moviles();

        $pdf->Cell(120, 10, 'PRODUCTO', 0, 0, 'C');
        $pdf->Cell(0, 10, 'IMPORTE', 0, 1, 'C');
        foreach ($moviles as $p => $movil) {
            $pdf->Cell(120, 10, $movil->getnombre(), 1);
            $pdf->Cell(0, 10, $movil->getPrecio(), 1, 1, 'R');
        }
        $pdf->Cell(120, 10, 'TOTAL A PAGAR: ', 0, 0, 'R');
        $pdf->Cell(0, 10, $cesta->get_coste(), 1, 2, 'R');
        
        //Cerramos el archivo y lo envíamos al navegador.
        $pdf->Output('pedido.pdf', 'I');
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Cesta de la Compra</title>
        <link href="catalogo.css" rel="stylesheet" type="text/css">
    </head>

    <body class="pagcesta">

        <div id="contenedor">
            <div id="encabezado">
                <h1>Cesta de la compra</h1>
            </div>
            <div id="productos"> 
                <?php
                $moviles = $cesta->get_moviles();

                foreach ($moviles as $m => $movil) {
                    $codigo = $movil->getcodigo();
                    $nombre = $movil->getnombre();
                    $precio = $movil->getprecio();
                    echo "<p><span class='codigo'>$codigo</span>";
                    echo "<span class='nombre'>$nombre</span>";
                    echo "<span class='precio'>$precio</span></p>";
                }
                ?>
                <hr />
                <p><span class='pagar'>Precio total: <?php print $cesta->get_coste(); ?> €</span></p>
                <form action='comprar.php' method='post'>
                    <p>
                        <span class='pagar'>
                            <input type='submit' name='pagar' value='Pagar'/>
                        </span>
                    </p>
                </form>
                <form action="" method="post">
                    <input type="submit" name="exportar" value="Exportar a pdf"/>
                </form>
            </div>
            <br class="divisor" />
            <div id="pie">
                <form action='logoff.php' method='post'>
                    <input type='submit' name='desconectar' value='Desconectar usuario <?php echo $_SESSION['usuario']; ?>'/>
                </form>        
            </div>
        </div>
    </body>
</html>