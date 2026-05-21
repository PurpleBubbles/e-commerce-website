<?php
class ReportCtrl {
    public static function displayReport($row): string {
        $status = "Unresolved";
        if($row['completed_at'] !== NULL){
            $status = "Resolved";
        }
        return <<<HTML
        
        <tr>
            <th scope="col">{$row['report_id']}</th>
            <th scope="col">{$row['report_reason']}</th>
            <th scope="col">{$row['reported_at']}</th>
            <th scope="col">{$row['resolution']}</th>
            <th scope="col">$status</th>
        </tr>
        
        HTML;
    }
}
