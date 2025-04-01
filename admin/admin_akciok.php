<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal");
    exit();
}

require_once '../db.php';
$query = "UPDATE termek SET akcios_ar = NULL, akcio_kezdete = NULL, akcio_vege = NULL 
          WHERE (akcio_vege IS NOT NULL AND akcio_vege < NOW()) 
          OR (akcio_kezdete IS NULL AND akcio_vege IS NULL)";
$pdo->query($query);
// Termékek lekérdezése
$query = $pdo->query("SELECT id, nev, egysegar, akcios_ar, akcio_kezdete, akcio_vege FROM termek");
$termekek = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
    <title>Akciók kezelése</title>
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Akciók kezelése</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Termék neve</th>
                    <th>Eredeti ár</th>
                    <th>Akciós ár</th>
                    <th>Akció kezdete</th>
                    <th>Akció vége</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($termekek as $termek): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($termek['nev']); ?></td>
                        <td><?php echo number_format($termek['egysegar'], 0, ',', ' ') . ' Ft'; ?></td>
                        <td><?php echo $termek['akcios_ar'] ? number_format($termek['akcios_ar'], 0, ',', ' ') . ' Ft' : '-'; ?></td>
                        <td><?php echo $termek['akcio_kezdete'] ? $termek['akcio_kezdete'] : '-'; ?></td>
                        <td><?php echo $termek['akcio_vege'] ? $termek['akcio_vege'] : '-'; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openModal(<?php echo htmlspecialchars(json_encode($termek)); ?>)">Szerkesztés</button>
                            <button class="btn btn-danger btn-sm" onclick="openDeleteModal(<?php echo $termek['id']; ?>)">Törlés</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Akció szerkesztő modal -->
    <div class="modal fade text-black" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Akció módosítása</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="ment_akciok.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="termek_id" name="termek_id">
                        <div class="mb-3">
                            <label class="form-label">Akciós ár (Ft)</label>
                            <input type="number" id="akcios_ar" name="akcios_ar" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Akció kezdete</label>
                            <input type="datetime-local" id="akcio_kezdete" name="akcio_kezdete" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Akció vége</label>
                            <input type="datetime-local" id="akcio_vege" name="akcio_vege" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Mégse</button>
                        <button type="submit" class="btn btn-success">Mentés</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Törlés megerősítő modal -->
    <div class="modal fade text-black" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Akció törlése</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
        </div>
        <div class="modal-body">
            Biztosan törölni szeretnéd ezt az akciót?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Mégse</button>
            <a id="deleteConfirmBtn" href="#" class="btn btn-danger">Törlés</a>
        </div>
        </div>
    </div>
    </div>


    <script>
        function openModal(termek) {
            document.getElementById('termek_id').value = termek.id;
            document.getElementById('akcios_ar').value = termek.akcios_ar || '';
            document.getElementById('akcio_kezdete').value = termek.akcio_kezdete ? termek.akcio_kezdete.replace(' ', 'T') : '';
            document.getElementById('akcio_vege').value = termek.akcio_vege ? termek.akcio_vege.replace(' ', 'T') : '';
            var modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }

        function openDeleteModal(termekId) {
            let deleteBtn = document.getElementById('deleteConfirmBtn');
            deleteBtn.href = "torol_akciok.php?id=" + termekId;
            let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }       
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>