<?php
class ReportCtrl {
    public static function displayReport($row): string {
        $report_id  = (int)$row['report_id'];
        $reason     = htmlspecialchars($row['report_reason']);
        $date       = htmlspecialchars($row['reported_at']);
        $resolution = htmlspecialchars($row['resolution'] ?? '');
        $resolved = $resolution !== '';

        $status_badge = $resolved
            ? '<span class="badge bg-success">Resolved</span>'
            : '<span class="badge bg-danger">Unresolved</span>';

        return <<<HTML
        <tr>
            <td>{$report_id}</td>
            <td>{$reason}</td>
            <td>{$date}</td>
            <td>
                <form method="POST" action="/admin/admin_reports.php" class="d-flex gap-2 align-items-center">
                    <input type="hidden" name="report_id" value="{$report_id}">
                    <input type="text" name="resolution" class="form-control form-control-sm"
                        placeholder="Enter resolution..." value="{$resolution}" style="min-width:200px">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </form>
            </td>
            <td>{$status_badge}</td>
        </tr>
        HTML;
    }
}
