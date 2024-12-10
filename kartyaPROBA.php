<div class="container mt-5">
        <div class="row">
            <?php
            // Adatok megjelenítése kártyákban
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="card shadow">
                        <div id="termekekKartyaKepKozep"><img id="termekekKartyaKep" src="<?= $row['kep'] ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nev']) ?>"></div>
                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($row['nev']) ?></h6>
                            <h6><strong><?= number_format($row['egysegar'], 0, '', ' ') ?> Ft</strong></h6>
                            <!--<button class="btn btn-primary">Kosárba</button>-->
                            <button type="button" id="termekekKartyaGomb" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_<?= $row['termek_id'] ?>">Részletek</button>
                            <button type="button" id="termekekKartyaGomb" class="btn btn-primary">Kosárba</button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade modalTermekek" id="modal_<?= $row['termek_id'] ?>" tabindex="-1" aria-labelledby="modalLabel_<?= $row['termek_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel_<?= $row['termek_id'] ?>"><strong><?= htmlspecialchars($row['nev']) ?></strong></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img id="modalKepekTermekek" src="<?= $row['kep'] ?>" class="img-fluid mb-3" alt="<?= htmlspecialchars($row['nev']) ?>">
                                <p><strong>Kategória:</strong> <?= htmlspecialchars($row['kategoria_nev']) ?></p>
                                <p><strong>Gyártó:</strong> <?= htmlspecialchars($row['gyarto']) ?></p>
                                <p><strong>Leírás:</strong> <?= nl2br(htmlspecialchars($row['leiras'])) ?></p>
                                <p><strong>Elérhető mennyiség:</strong> <?= htmlspecialchars($row['elerheto_mennyiseg']) ?> db</p>
                                <p><strong>Egységár:</strong> <?= number_format($row['egysegar'], 0, '', ' ') ?> Ft</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="modalKartyaGomb">Kosárba</button>
                                <button type="button" id="modalKartyaGomb" data-bs-dismiss="modal">Bezárás</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>
        </div>
    </div>