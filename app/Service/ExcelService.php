<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelService
{
    public function createAdventureExcelFile(string $filename): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'orderNumber',
            'adventureName',
            'date',
            'participantsCount',
            'department',
            'providerName',
            'coordinatorName',
            'estimatedCost',
            'actualCost'
        ];

        $sheet->fromArray($headers, NULL, 'A1');

        $data = [
            ["ORD1001", 'Adventure 1', '2024-08-01 10:00:00', 11, 'Veverky', 'Provider A', 'Coordinator A', 500.00, 450.00],
            ["ORD1002", 'Adventure 2', '2024-08-15 12:00:00', 11, 'Bobři', 'Provider B', 'Coordinator B', 300.00, null],
            ["ORD1003", 'Adventure 3', '2024-09-05 14:00:00', 11, 'Křečci', 'Provider C', 'Coordinator C', 600.00, 600.00],
        ];

        $sheet->fromArray($data, NULL, 'A2');

        $writer = new Xlsx($spreadsheet);
        $writer->save(__DIR__ . '/../../www/files/' . $filename);
    }

}