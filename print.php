<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
extract($_POST);
require_once('../crud/Attendance.class.php');
           
        $projects = new Projects();
        $result = $projects->exec("/*SQL query*/");

             $fileName = "Report.xls";
 
            if ($result) {
                function filterData(&$str) {
                    $str = preg_replace("/\t/", "\\t", $str);
                    $str = preg_replace("/\r?\n/", "\\n", $str);
                    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
                }
            
                // headers for download
                header("Content-Disposition: attachment; filename=\"$fileName\"");
                header("Content-Type: application/vnd.ms-excel");
            
                $flag = false;
                foreach($result as $row) {
                    if(!$flag) {
                        // display column names as first row
                        echo implode("\t", array_keys($row)) . "\n";
                        $flag = true;
                    }
                    // filter data
                    array_walk($row, 'filterData');
                    echo implode("\t", array_values($row)) . "\n";
                    // echo $row;
                }
                // exit;           
            }
// exit;
// header("location:../sittin_table_view.php");
