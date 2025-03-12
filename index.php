<?php
require 'koneksi.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_transaction'])) {
    $amount = $_POST['amount'];
    $transaction_date = $_POST['transaction_date'];

    $stmt = $conn->prepare("INSERT INTO transactions (amount, transaction_date) VALUES (:amount, :transaction_date)");
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':transaction_date', $transaction_date);

    if ($stmt->execute()) {
        echo "<script>alert('Data transaksi berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: Data gagal ditambahkan');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_account'])) {
    $account_number = $_POST['account_number'];
    $account_holder = $_POST['account_holder'];

    $stmt = $conn->prepare("INSERT INTO accounts (account_number, account_holder) VALUES (:account_number, :account_holder)");
    $stmt->bindParam(':account_number', $account_number);
    $stmt->bindParam(':account_holder', $account_holder);

    if ($stmt->execute()) {
        echo "<script>alert('Data akun berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: Data gagal ditambahkan');</script>";
    }
}

$stmt = $conn->query("SELECT * FROM transactions");
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT * FROM accounts");
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manajemen Transaksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style.css"> 
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <h2>Manajemen <b>Transaksi & Akun</b></h2>
            <div class="btn-group">
                <button class="btn btn-success" data-toggle="modal" data-target="#addTransactionModal">Tambah Transaksi</button>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addAccountModal">Tambah Akun</button>
            </div>
        </div>

        <h4>Daftar Transaksi</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="transactionsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $row) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td>Rp <?= number_format($row['amount'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['transaction_date']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h4>Daftar Akun</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="accountsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nomor Akun</th>
                        <th>Pemilik Akun</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $row) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['account_number']) ?></td>
                            <td><?= htmlspecialchars($row['account_holder']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="addTransactionModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Transaksi</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="transaction_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="add_transaction" class="btn btn-success" value="Simpan">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="addAccountModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Akun</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Akun</label>
                        <input type="text" name="account_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Pemilik Akun</label>
                        <input type="text" name="account_holder" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="add_account" class="btn btn-primary" value="Simpan">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#transactionsTable').DataTable();
    $('#accountsTable').DataTable();
});
</script>
</body>
</html>
