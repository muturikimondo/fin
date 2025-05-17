<?php
session_start();
require_once '../includes/db.php';

// Access Control: Only allow logged-in users with role 'co'
if (!isset($_SESSION['user']) || strtolower($_SESSION['user']['role']) !== 'co') {
    header("Location: ../auth/login.php");
    exit;
}

include '../templates/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h3 class="text-<?php echo $brand_colors['primary']; ?> mb-4">
                <i class="bi bi-hourglass-split me-2"></i>Pending User Registrations
            </h3>
            <div id="feedback" class="mb-3"></div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-white" style="background-color: <?php echo $brand_colors['primary']; ?>;">
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Requested At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pendingUsersBody">
                        <?php
                        $result = $conn->query("SELECT id, username, email, role, photo, created_at FROM users WHERE status = 'pending'");
                        if ($result && $result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                $photoPath = !empty($row['photo']) && file_exists("../uploads/" . $row['photo'])
                                    ? "uploads/" . htmlspecialchars($row['photo'])
                                    : "../uploads/icons/user.png";

                                echo "<tr id='user-row-{$row['id']}'>
                                        <td>{$i}</td>
                                        <td><img src='{$photoPath}' width='50' height='50' class='rounded-circle'></td>
                                        <td>" . htmlspecialchars($row['username']) . "</td>
                                        <td>" . htmlspecialchars($row['email']) . "</td>
                                        <td>" . htmlspecialchars($row['role']) . "</td>
                                        <td>" . date('d M Y H:i', strtotime($row['created_at'])) . "</td>
                                        <td>
                                            <button class='btn btn-success btn-sm approve-btn' data-id='{$row['id']}'>
                                                <i class='bi bi-check2-circle'></i> Approve
                                            </button>
                                            <button class='btn btn-danger btn-sm reject-btn' data-id='{$row['id']}'>
                                                <i class='bi bi-x-circle'></i> Reject
                                            </button>
                                        </td>
                                      </tr>";
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center text-muted'>No pending user registrations.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="footer bg-<?php echo $brand_colors['dark']; ?> text-white text-center p-3">
    <p><?php echo $site_tagline; ?></p>
    <a href="<?php echo $cta_button_link; ?>" class="btn btn-<?php echo $brand_colors['accent']; ?>" target="_blank">
        <?php echo $cta_button_text; ?>
    </a>
</div>

<?php include '../templates/footer.php'; ?>
<script type="module" src="../js/admin/pending_users.js"></script>
