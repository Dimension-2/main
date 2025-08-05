<?php
require_once __DIR__ . '/../config.php';

$requests = $conn->query("SELECT * FROM preorder_requests ORDER BY submitted_at DESC");
while ($row = $requests->fetch_assoc()):
?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['first_name'].' '.$row['last_name']) ?></td>
    <td><?= htmlspecialchars($row['company_name']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['help_option']) ?></td>
    <td><?= date('M j, Y g:i a', strtotime($row['submitted_at'])) ?></td>
    <td>
        <button class="btn btn-sm btn-primary view-details" 
                data-id="<?= $row['id'] ?>"
                data-bs-toggle="modal" 
                data-bs-target="#detailsModal">
            View
        </button>
    </td>
</tr>
<?php endwhile; ?>