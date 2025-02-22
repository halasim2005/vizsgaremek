if(is_array($OSSZES_RENDELES)){
            $thead_th = "style='border-bottom:none;padding-bottom:20px;padding-top:20px;color:white'";
            $tbody_td = "style='padding-bottom:25px;padding-top:25px'";
            $thead_style = "style='border:none;background-color:rgb(61, 61, 61);border-radius:15px'";

            echo "<h5 class='mb-3 text-start'>Rendelések száma: {$rendelesek_szama} db</h5>";
            echo 
            "
                <table class='table'>
                    <thead {$thead_style}>
                        <tr>
                            <th {$thead_th}>Sorszám</th>
                            <th {$thead_th}>Végösszeg</th>
                            <th {$thead_th}>Dátum</th>
                            <th {$thead_th}>Tételek</th>
                            <th {$thead_th}>Állapot</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            foreach($OSSZES_RENDELES as $elem){
                    $statuszSzoveg = ($elem["statusz"] === "kész") ? "futárnak átadva" :
                        (($elem["statusz"] === "csomagolva") ? "csomagolva" :
                        (($elem["statusz"] === "feldolgozás alatt") ? "feldolgozás alatt" : $elem["statusz"]));

                    $statuszStyle = ($elem["statusz"] === "kész") ? "color:green;font-weight:bold" :
                        (($elem["statusz"] === "csomagolva") ? "color:orange;font-weight:bold" :
                        (($elem["statusz"] === "feldolgozás alatt") ? "color:gray;font-weight:bold" : ""));

                    echo "
                        <tr>
                            <td {$tbody_td}>{$elem["id"]}</td>
                            <td {$tbody_td}>{$elem["vegosszeg"]} Ft</td>
                            <td {$tbody_td}>{$elem["leadas_datum"]}</td>
                            <td {$tbody_td}>{$elem["osszesTetel"]} db</td>
                            <td style='$statuszStyle;padding-bottom:25px;padding-top:25px'>$statuszSzoveg</td>
                        </tr>
                    ";
            }
            echo 
            "
                    </tbody>
                </table>
            ";
        }else{
            echo "<h5 style='font-weight:bold'>Még nincsen aktuális rendelése!</h5>";
        }









        <?php
                foreach ($OSSZES_RENDELES as $rendeles_elem) {
                    if($rendeles_elem['statusz'] == "feldolgozás alatt"){
                        $statuszStyle = "style='color:gray'";
                        $statuszSzoveg= "feldolgozás alatt";
                    }else if($rendeles_elem['statusz'] == "csomagolva"){
                        $statuszStyle = "style='color:orange'";
                        $statuszSzoveg= "csomagolva";
                    }else{
                        $statuszStyle = "style='color:green'";
                        $statuszSzoveg= "futárnak átadva";
                    }

                    echo 
                    "
                        <div class='card border m-2' style='width: 18rem'>
                            <div class='card-body'>
                                <p>Azonosító: <strong>{$rendeles_elem['id']}</strong></p>
                                <p>Dátum: <strong>{$rendeles_elem['leadas_datum']}</strong></p>
                                <p>Végösszeg: <strong>{$rendeles_elem['vegosszeg']} Ft</strong></p>
                                <p>Állapot: <strong {$statuszStyle}'>{$statuszSzoveg}</strong></p>
                            </div>
                        </div>
                    ";
                }
            ?>