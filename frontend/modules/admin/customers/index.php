<?php
require_once __DIR__ . '/../includes/bootstrap.php';

require_admin();

$sql = "
    SELECT user_id, full_name, email, role
    FROM users
    WHERE role = 'customer'
    ORDER BY user_id DESC
";

$result = $conn->query($sql);

admin_header('Customers', 'customers');
?>

<style>
    .customers-page {
        color: #1e293b;
    }

    .customers-intro {
        margin-bottom: 22px;
        color: #64748b;
    }

    .customers-card {
        background: #fff;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .06);
        overflow-x: auto;
    }

    .customers-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .customers-search {
        padding: 11px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        width: 280px;
        max-width: 100%;
        outline: none;
    }

    .customers-search:focus {
        border-color: #2563eb;
    }

    .customers-count {
        color: #64748b;
        font-size: 14px;
    }

    .customers-table {
        width: 100%;
        min-width: 550px;
        border-collapse: collapse;
    }

    .customers-table th,
    .customers-table td {
        padding: 15px 12px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .customers-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 12px;
        text-transform: uppercase;
    }

    .customers-table tbody tr:hover {
        background: #f8fafc;
    }

    .customer-name {
        font-weight: 600;
        color: #0f172a;
    }

    .customer-id {
        color: #64748b;
    }

    .customer-email {
        color: #2563eb;
    }

    .customer-role {
        display: inline-block;
        padding: 5px 10px;
        background: #dcfce7;
        color: #166534;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .empty-message {
        text-align: center !important;
        padding: 30px !important;
        color: #64748b;
    }
</style>

<div class="customers-page">

    <p class="customers-intro">
        View registered customers of Ceylon Tea House.
    </p>

    <div class="customers-card">

        <div class="customers-toolbar">
            <input
                type="text"
                id="customerSearch"
                class="customers-search"
                placeholder="Search by name, email or ID..."
            >

            <span class="customers-count">
                Total customers: <?= (int) $result->num_rows ?>
            </span>
        </div>

        <table class="customers-table">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Role</th>
                </tr>
            </thead>

            <tbody id="customersTableBody">
                <?php if ($result->num_rows > 0): ?>

                    <?php while ($customer = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="customer-id">
                                #<?= (int) $customer['user_id'] ?>
                            </td>

                            <td class="customer-name">
                                <?= h($customer['full_name']) ?>
                            </td>

                            <td class="customer-email">
                                <?= h($customer['email']) ?>
                            </td>

                            <td>
                                <span class="customer-role">
                                    <?= h(ucfirst($customer['role'])) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="4" class="empty-message">
                            No registered customers found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <p id="noResults" class="empty-message" style="display:none;">
            No matching customers found.
        </p>

    </div>
</div>

<script>
    const searchInput = document.getElementById('customerSearch');
    const rows = document.querySelectorAll('#customersTableBody tr');
    const noResults = document.getElementById('noResults');

    searchInput.addEventListener('input', function () {
        const search = this.value.toLowerCase().trim();
        let count = 0;

        rows.forEach(function (row) {
            const matches = row.textContent.toLowerCase().includes(search);

            row.style.display = matches ? '' : 'none';

            if (matches) {
                count++;
            }
        });

        noResults.style.display = count === 0 ? 'block' : 'none';
    });
</script>

<?php
$result->free();
admin_footer();
?>