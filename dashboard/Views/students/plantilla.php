<?php
require '../../Config/config.php';
require '../../../vendor/autoload.php'; // Ruta a la autoload de PHPSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;

function calcularEdad($fecha_nacimiento) {
    $fecha_nacimiento = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimiento);
    return $edad->y;
}

$sentencia = $connect->query("SELECT * FROM estudiantes");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

// Obtener fecha y hora actuales y formatear correctamente para nombres de archivo
$fechaHora = date('Y-m-d_H-i-s');

// Agregar la fecha y hora de creación del documento en la primera fila
$sheet->setCellValue('A1', 'Fecha y Hora de Creación: ' . $fechaHora);
$sheet->mergeCells('A1:G1');

// Encabezados
$sheet->setCellValue('A2', 'Cédula');
$sheet->setCellValue('B2', 'Nombre');
$sheet->setCellValue('C2', 'Correo');
$sheet->setCellValue('D2', 'Edad');
$sheet->setCellValue('E2', 'Fecha de Nacimiento');
$sheet->setCellValue('F2', 'Género');
$sheet->setCellValue('G2', 'Número de Teléfono');

// Aplicar estilo de negrita a los encabezados
$spreadsheet->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);

$row = 3; // Cambiar la fila de inicio a 3 porque la 1 y 2 son para fecha/hora y encabezados
foreach ($productos as $producto) {
    $sheet->setCellValue('A' . $row, $producto->cedula_estudiante);
    $sheet->setCellValue('B' . $row, $producto->nombres);
    $sheet->setCellValue('C' . $row, $producto->correo);
    $sheet->setCellValue('D' . $row, calcularEdad($producto->fecha_nac));
    $sheet->setCellValue('E' . $row, $producto->fecha_nac);
    $sheet->setCellValue('F' . $row, $producto->genero == 'M' ? 'Masculino' : 'Femenino');
    $sheet->setCellValue('G' . $row, $producto->telefono);
    $row++;
}

// Agregar el total de alumnos
$totalAlumnos = count($productos);
$sheet->setCellValue('F' . $row, 'Total de Alumnos:');
$sheet->setCellValue('G' . $row, $totalAlumnos);
$spreadsheet->getActiveSheet()->getStyle('F' . $row)->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('G' . $row)->getFont()->setBold(true);

// Generar un identificador único para el archivo
$identificador = uniqid();

// Nombre del archivo con fecha, hora e identificador único
$nombreArchivo = "estudiantes_{$fechaHora}_{$identificador}.xlsx";

// Limpiar el buffer de salida
if (ob_get_contents()) ob_end_clean();
ob_start();

// Establecer encabezados para la descarga del archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
header('Cache-Control: max-age=0');

// Guardar el archivo en el buffer de salida
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
ob_end_flush();

exit;
?>
