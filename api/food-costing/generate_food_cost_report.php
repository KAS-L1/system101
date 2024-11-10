<?php
require_once '../tcpdf/vendor/autoload.php';
require_once '../../app/init.php';

// Retrieve all food costing items from the database
$foodCostingItems = $DB->SELECT("food_costing", "menu_item, ingredients, total_ingredient_cost, selling_price, profit_margin, food_cost_percentage", "ORDER BY id ASC");

// Initialize TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Food Costing Management');
$pdf->SetTitle('Food Costing Report');
$pdf->SetHeaderData('', 0, 'Food Costing Report', 'Generated on ' . date('Y-m-d'));
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 10);  // Use 'dejavusans' for UTF-8 support

// Report title
$pdf->Cell(0, 10, 'Food Costing Report', 0, 1, 'C');

// Food Costing Table
$html = '<h3>Food Costing Items</h3>
         <table border="1" cellpadding="4">
            <thead>
                <tr style="background-color:#198754; color: #fff;">
                    <th>Menu Item</th>
                    <th>Ingredients</th>
                    <th>Total Ingredient Cost</th>
                    <th>Selling Price</th>
                    <th>Profit Margin</th>
                    <th>Food Cost %</th>
                </tr>
            </thead>
            <tbody>';

// Populate table with food costing items data
foreach ($foodCostingItems as $item) {
    // Decode ingredients and cost per ingredient fields
    $ingredientsArray = json_decode($item['ingredients'], true);
    $ingredientsArray = is_array($ingredientsArray) ? $ingredientsArray : []; // Fallback to empty array if null

    // Convert ingredients array to a comma-separated string
    $ingredients = implode(", ", $ingredientsArray);

    $html .= '<tr>
                <td>' . htmlspecialchars($item['menu_item']) . '</td>
                <td>' . htmlspecialchars($ingredients) . '</td>
                <td>₱' . number_format($item['total_ingredient_cost'], 2) . '</td>
                <td>₱' . number_format($item['selling_price'], 2) . '</td>
                <td>₱' . number_format($item['profit_margin'], 2) . '</td>
                <td>' . number_format($item['food_cost_percentage'], 2) . '%</td>
              </tr>';
}

$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('food_costing_report.pdf', 'I'); // 'D' for download; 'I' for in-browser
exit;
