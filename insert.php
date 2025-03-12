<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $transaction_date = $_POST['transaction_date'];

    if (empty($amount) || empty($transaction_date)) {
        echo "<script>alert('Harap isi semua kolom!'); window.history.back();</script>";
        exit();
    }

    try {
        $stmt = $conn->prepare("INSERT INTO transactions (amount, transaction_date) VALUES (:amount, :transaction_date)");
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':transaction_date', $transaction_date);

        if ($stmt->execute()) {
            echo "<script>alert('Transaction added successfully!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Error: Data gagal ditambahkan'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
}
?>
