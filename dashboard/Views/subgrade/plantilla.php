<?php
require '../../Config/config.php';
require '../../Assets/fpdf/fpdf.php';

$id = $_GET['id'];

try {
    $connect = new PDO("mysql:host=".dbhost."; dbname=".dbname, dbuser, dbpass, [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
    $connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch(PDOException $e) {
    echo $e->getMessage();
}

$query = "SELECT c.Cedularepresentante, c.Cedulaestudiante, c.Anio, s.letra as Seccion, c.Fecha, c.Descripcionmotivo,
    r.nombre AS nombre_representante, s.letra ,e.nombres AS nombre_estudiante
    FROM citaciones c
    JOIN representante_legal r ON c.Cedularepresentante = r.cedula_representante_legal
    JOIN estudiantes e ON c.Cedulaestudiante = e.cedula_estudiante
    JOIN seccion s ON s.id_seccion = c.Seccion
    WHERE c.idcitacion = :id";
$stmt = $connect->prepare($query);
$stmt->execute(['id' => $id]);
$citation = $stmt->fetch();

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('LICEO NACIONAL FRANCISCO DE MIRANDA'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('COORDINACION PROTECCION Y DESARROLLO ESTUDIANTIL'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('SAN CRISTÓBAL - ESTADO TÁCHIRA'), 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('CITACIÓN DEL REPRESENTANTE'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

$nombre_representante = utf8_decode($citation->nombre_representante);
$nombre_estudiante = utf8_decode($citation->nombre_estudiante);
$anio = $citation->Anio;
$seccion = $citation->Seccion;
$fecha = $citation->Fecha;
$descripcion = utf8_decode($citation->Descripcionmotivo);

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Concatenar las cadenas de texto y variables en una sola línea
$line = utf8_decode('Ciudadano(a): ' . $nombre_representante . ', Representante legal del estudiante: ' . $nombre_estudiante . ', Cursante del ' . $anio . ' Año, Sección: ' . $seccion . '. Se le agradece asistir el día ' . $fecha . ' a las _____ para tratar asuntos relacionados a la actuación de su representado en esta institución, en cuanto a: ' . $descripcion);

$pdf->MultiCell(0, 10, $line, 0, 'J');

$pdf->Ln(20);
$pdf->Cell(0, 10, '______________________________     ______________________________', 0, 1, 'C');
$pdf->Cell(0, 10, utf8_decode('Estudiante                                           Docente Guía'), 0, 1, 'C');

$pdf->Output();

?>
