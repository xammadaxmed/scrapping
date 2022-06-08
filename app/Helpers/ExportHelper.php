<?php

namespace App\Helpers;

class ExportHelper
{

    public static function ExcelDownload($data, $columns, $fileName)
    {
        $columns = array_diff($columns, array("status", "id"));
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        array_unshift($data, $columns);
        $sheet->fromArray($data);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=$fileName.xlsx");
        $writer->save("php://output");
    }


    public static function DownloadCSV($data, $columns, $fileName)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$fileName.csv");
        $output = fopen("php://output", "w");
        fputcsv($output, $columns);
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
    }

    public static function DownLoadTextFile($data, $columns, $fileName)
    {
        header('Content-Type: text/plain; charset=utf-8');
        header("Content-Disposition: attachment; filename=$fileName.txt");
        $output = fopen("php://output", "w");

        foreach ($columns as $col) {
            fwrite($output, $col);
            fwrite($output, "\t");
        }

        fwrite($output, "\n");


        foreach ($data as $row) {
            $last = end($row);
            foreach ($row as $item) {
                fwrite($output, $item);
                if ($item != $last)
                    fwrite($output, "\t");
            }
            fwrite($output, "\n");
        }
        fclose($output);
    }
}
