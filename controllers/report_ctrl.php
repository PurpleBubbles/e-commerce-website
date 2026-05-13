<?php
class ReportCtrl {
    public static function displayReport($row): string {
        return <<<HTML
        <div class="report2">
            <h3 class="t-op-nextlvl">{$row['report_id']}</h3>
            <h3 class="t-op-nextlvl">{$row['report_reason']}</h3>
            <h3 class="t-op-nextlvl">{$row['reported_at']}</h3>
            <h3 class="t-op-nextlvl">{$row['resolution']}</h3>
            <h3 class="t-op-nextlvl label-tag">{$row['completed_at']}</h3>
        </div>
        HTML;
    }
}
