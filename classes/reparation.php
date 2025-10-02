<?php
declare(Strict_types=1);
require_once __DIR__ . '/../config/mysql.php';
require_once __DIR__ . '/../fpdf/fpdf.php';
if(!class_exists('PDF')){
    class PDF extends FPDF {

        function Header() {
            $this->SetFont('Arial','B',14);
            $this->Cell(
                0, 10,
                mb_convert_encoding("FACTURE DE RÉPARATION", 'ISO-8859-1', 'UTF-8'),
                0, 1, 'C'
            );
            $this->Ln(5);
        }

        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(
                0, 10,
                mb_convert_encoding('Page '.$this->PageNo(), 'ISO-8859-1', 'UTF-8'),
                0, 0, 'C'
            );
        }
    }
}


class Reparation{
 public $con;

public function __construct($con){
        $this->con = $con;
    }
    

 public function getReparation($vehiculeId){
   $stmt = $this->con->prepare(" SELECT r.id AS reparation_id, v.immatriculation, r.date_reparation, r.description, r.cout
                                 FROM vehicules v 
                                 JOIN reparations r ON v.id = r.vehicule_id 
                                 WHERE v.id = :id
                                 ORDER BY r.date_reparation DESC");
   $stmt->execute(['id' => $vehiculeId]);
   $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $fetch === false ? null : $fetch;
}


public function getDernierCoutReparation($vehicule_id){
   $stmt = $this->con->prepare("SELECT cout FROM reparations WHERE vehicule_id = :vehicule_id ORDER BY date_reparation DESC LIMIT 1");
   $stmt->execute(['vehicule_id' => $vehicule_id]);
   $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
   return $fetch;
}
public function getSommeCoutReparation($vehicule_id){
    $stmt = $this->con->prepare("SELECT SUM(cout) AS total_coup FROM reparations WHERE vehicule_id = :vehicule_id");
    $stmt->execute(['vehicule_id' => $vehicule_id]);
    $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
    return $fetch;
}
 public function genererFacture($idReparation) {
    require_once __DIR__ . '/../fpdf/fpdf.php';

    // 1. Récupérer les infos de la réparation
    $sql = "SELECT c.nom,c.telephone,c.adresse, v.marque, v.modele, v.immatriculation, 
                   r.cout, r.date_reparation
            FROM reparations r
            JOIN vehicules v ON v.id = r.vehicule_id
            JOIN clients c ON c.id = v.client_id
            WHERE r.id = :id";

    $stmt = $this->con->prepare($sql);
    $stmt->execute(['id' => $idReparation]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        die("Réparation introuvable !");
    }

    // 2. Générer le PDF
   
 

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',12);

    $pdf->Cell(  0, 10,  mb_convert_encoding("Client : ".$data['nom'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Cell(  0, 10,  mb_convert_encoding("Télèphone :  ".$data['telephone'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    $pdf->Cell(  0, 10,  mb_convert_encoding("Adresse :   ".$data['adresse'], 'ISO-8859-1', 'UTF-8'), 0, 1);

    $pdf->Cell(0,10, mb_convert_encoding("Véhicule : ".$data['marque']." ".$data['modele'], 'ISO-8859-1','UTF-8'),0,1);
    $pdf->Cell(0,10, mb_convert_encoding("Immatriculation : ".$data['immatriculation'], 'ISO-8859-1','UTF-8'),0,1);
    $pdf->Cell(0,10, mb_convert_encoding("Date réparation : ".$data['date_reparation'],'ISO-8859-1','UTF-8'),0,1);

    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10, mb_convert_encoding("Montant : ".number_format((float)$data['cout'],0,',',' ')." F CFA",'ISO-8859-1','UTF-8'),0,1);

    // 3. Sortie PDF
    ob_end_clean();
    $pdf->Output();
}

}
?>