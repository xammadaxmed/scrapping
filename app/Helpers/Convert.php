<?php

namespace App\Helpers;

class Convert
{
    public static function arrToStr(array $arr, $delimeter = ",")
    {
        return  implode($delimeter, $arr);
    }

    public static function strToArr(string $str, $delimeter = ",")
    {
        return  explode($delimeter, $str);
    }

    public static function cellToAssoc($sheetData)
    {
        $arrHeader = array_shift($sheetData);
        $arrBody = $sheetData;
        $arrReturn = [];
        foreach ($arrBody as $key => $value) {
            $arr = [];
            foreach ($value as $k => $val) {
                $assocKey = self::indexToAssoc($arrHeader, $k);
                $arr[$assocKey] = $val;
            }

            $arrReturn[] = $arr;
        }

        return $arrReturn;
    }

    private static function indexToAssoc($arrHeader, $index)
    {
        return strtolower(str_replace(' ', '_', $arrHeader[$index]));
    }

    public static function toMappedColumns(array $data, array $columns)
    {
        $arrData = [];
        foreach ($data as $dt) {
            $arrMappedData = [];
            foreach ($columns as $column) {
                if (!empty($dt[$column])) {
                    $arrMappedData[$column] = (!is_array($dt[$column])) ? trim($dt[$column]) : $dt[$column];
                    if (is_array($arrMappedData[$column]))
                        $arrMappedData[$column] = json_encode($arrMappedData[$column]);
                } else
                    $arrMappedData[$column] = "";
            }
            $arrData[] = $arrMappedData;
        }
        return $arrData;
    }

    public static function urlToLink($url, $text)
    {
        $reg_pattern = "/(((http|https|ftp|ftps)\:\/\/)|(www\.))[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/";
        return preg_replace($reg_pattern, '<a href="$0" target="_blank" rel="noopener noreferrer">' . $text . '</a>', $url);
    }

    public static function urlToDomain($strUrl)
    {
        if (strpos($strUrl, "http") === false) {
            $strUrl = "https://" . $strUrl;
        }
        $arrUrl = parse_url($strUrl);
        $strUrl = $arrUrl['host'];
        $strUrl = str_replace(['https://','http://','www.'],'',$strUrl);
        return $strUrl;
    }

    public static function intArrtoString(array $arr)
    {
        $arrReturn = [];
        foreach($arr as $key=>$ar)
            $arrReturn[$key] = (string)$ar;
        return $arrReturn;
    }
}
