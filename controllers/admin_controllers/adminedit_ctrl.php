<?php

class AdminEditUsersCtrl {
    public static function displayUsers($row): string {
        // get edits from page
        $user_id = htmlspecialchars($row['user_id']);
        $user_name = htmlspecialchars($row['user_name']);
        $user_email = htmlspecialchars($row['user_email']);
        $is_buyer = $row['is_buyer'] ? 'checked' : '';
        $is_seller = $row['is_seller'] ? 'checked' : '';
        $is_admin = $row['is_admin'] ? 'checked' : '';

        return <<<HTML
        <tr>
            <td>{$user_id}</td>
            <td>{$user_name}</td>
            <td>{$user_email}</td>
            <td>
                <form method="POST" action="/admin/admin_edit_users.php">
                    <input type="hidden" name="action" value="update_permissions">
                    <input type="hidden" name="user_id" value="{$user_id}">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_buyer" value="1" {$is_buyer}>
                            <label class="form-check-label">Buyer</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_seller" value="1" {$is_seller}>
                            <label class="form-check-label">Seller</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_admin" value="1" {$is_admin}>
                            <label class="form-check-label">Admin</label>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </div>
                </form>
            </td>
            <td>
                <form method="POST" action="/admin/admin_edit_users.php" onsubmit="return confirm('Delete user {$user_name}? This cannot be undone.')">
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="user_id" value="{$user_id}">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        HTML;
    }
}
