<?php

// Reosurces
include('./fpdf/fpdf.php');
include('./system.php');

// Start session
session_start();

class PDF extends FPDF
{   
   // Get user data for pdf
   function getUserPdfData($db) {      
      $user_id = $_SESSION["user_id"];
      $query = "SELECT * FROM user_display WHERE user_id = :userId";

      $statement = $db->prepare($query);
      $statement->bindParam("userId", $user_id);
      $statement->execute();

      return $statement->fetch();
   }
   
   // Page header
   function Header()
   {
      // Arial bold 15
      $this->SetFont('Arial', 'B', 15);

      // Move the title cell
      $this->Cell(0.1);

      // Title
      $this->Cell(70, 10, 'My Achievement', 1, 0, 'C');

      // Line break
      $this->Ln(20);
   }

   // Better table
   function ImprovedTable($header, $data)
   {
      // Column widths
      $width = 46;
      $totalColumn = 0;

      // Header
      for ($i = 0; $i < count($header); $i++):
         $this->Cell($width, 7, $header[$i], 1, 0, 'C');
         $totalColumn++;         
      endfor;
      $this->Ln();

      // Data
      foreach ($data as $i => $row):
         $this->Cell($width, 12, $row, 'LR', 0, "C");
      endforeach;
      $this->Ln();

      // Closing line
      $this->Cell($width * $totalColumn, 0, '', 'T');
   }
}

// Get connection
$db = $auth->connectDb();

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

// Get material
$profileDatas = $pdf->getUserPdfData($db);

$headers = ["User", "Average", "Score", "Grade"];
$datas = ["Kowzki", "78%", "82pts", "Legend"];

if ($data = $profileDatas) {
   $datas = [$data["username"], $data["rate"] . "%", $data["score"] . "pts", $data["grade"]];
}

$pdf->ImprovedTable($headers, $datas);

$pdf->Ln(10);
$pdf->Cell(70, 10, '+ Created by Group 11', 0, 0, 'L');
$pdf->Ln(8);
$pdf->Cell(70, 10, 'This valuation according to user experience that calculated', 0, 0, 'L');
$pdf->Ln(8);
$pdf->Cell(70, 10, 'with possible operation from the system.', 0, 0, 'L');

$pdf->Output();