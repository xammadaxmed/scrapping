<?php

namespace App\Helpers;

class ExcelHelper
{

    private  $payload = [];
    private  $raw = [];
    private  $headings;

    public function __construct($filePath)
    {
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filePath);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($filePath);
        foreach ($spreadsheet->getAllSheets() as $sheet) {
            $this->payload = array_merge($this->payload, $sheet->toArray());
        }
        $this->raw = $this->payload;
        $this->headings = array_shift($this->payload);
        $this->formatHeadings();
    }

    private function formatHeadings()
    {
        $strHeadings = implode(',',$this->headings);
        $this->headings = explode(',',strtolower(str_replace(' ','_',$strHeadings)));
    }


    public function body()
    {
        return Convert::cellToAssoc($this->raw);
    }

    public function headings()
    {
        return array_filter($this->headings);
    }

    public static function create($filePath)
    {
        return new ExcelHelper($filePath);
    }
}
