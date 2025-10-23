<?php
require_once("iRadovi.php");

class DiplomskiRadovi implements iRadovi {

    public $naziv_rada;
    public $tekst_rada;
    public $link_rada;
    public $oib_tvrtke;

    public $radovi = [];

    public function create() {
        for ($i = 2; $i <= 6; $i++) {
            $url = "https://stup.ferit.hr/index.php/zavrsni-radovi/page/$i/";
            $html = $this->fetchHTML($url);

            if (!$html) {
                echo "<p'>Stranica $url nije dohvaćena ili je prazan sadržaj.</p>";
                continue;
            }

            // loadHTML može proizvesti upozorenja, pa ih suzbijemo s @
            $dom = new DOMDocument();
            @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);

            $xpath = new DOMXPath($dom);

            // Pronađi sve article elemente (ako ih nema, pokušaj pronaći div sa klasom post)
            $articles = $xpath->query('//article');
            if ($articles->length === 0) {
                // fallback: potraži elemente koji sadrže class="post" ili class="type-post"
                $articles = $xpath->query('//*[contains(@class, "post") or contains(@class, "type-post")]');
            }

            foreach ($articles as $article) {
                $rad = new DiplomskiRadovi();

                // 1) naslov i link: h2[@class="entry-title"]/a
                $titleNode = $xpath->query('.//h2[contains(concat(" ", normalize-space(@class), " "), " entry-title ")]//a', $article);
                if ($titleNode->length > 0) {
                    $a = $titleNode->item(0);
                    $rad->naziv_rada = trim($a->nodeValue);
                    $rad->link_rada = trim($a->getAttribute('href'));
                } else {
                    // fallback: bilo koji <a> unutar <h2>
                    $h2a = $xpath->query('.//h2//a', $article);
                    if ($h2a->length > 0) {
                        $a = $h2a->item(0);
                        $rad->naziv_rada = trim($a->nodeValue);
                        $rad->link_rada = trim($a->getAttribute('href'));
                    } else {
                        $rad->naziv_rada = '';
                        $rad->link_rada = '';
                    }
                }

                // 2) OIB iz URL-a slike (ako postoji <img>)
                $imgNode = $xpath->query('.//img', $article);
                $rad->oib_tvrtke = '';
                if ($imgNode->length > 0) {
                    $src = $imgNode->item(0)->getAttribute('src');
                    if (preg_match('/(\d{11})/', $src, $m)) {
                        $rad->oib_tvrtke = $m[1];
                    }
                } else {
                    // fallback: traži bilo gdje u članku
                    $whole = $dom->saveHTML($article);
                    if (preg_match('/(\d{11})/', $whole, $m)) {
                        $rad->oib_tvrtke = $m[1];
                    }
                }

                // 3) dohvat kratkog teksta sa stranice rada (prvi <p>)
                $rad->tekst_rada = '';
                if ($rad->link_rada) {
                    $tekst_html = $this->fetchHTML($rad->link_rada);
                    if ($tekst_html) {
                        $dom2 = new DOMDocument();
                        @$dom2->loadHTML('<?xml encoding="utf-8" ?>' . $tekst_html);
                        $xpath2 = new DOMXPath($dom2);
                        // pokušaj prvo entry-content p
                        $pnode = $xpath2->query('//div[contains(@class, "entry-content")]//p[normalize-space()]');
                        if ($pnode->length == 0) {
                            // fallback: prvi <p> u dokumentu
                            $pnode = $xpath2->query('//p[normalize-space()]');
                        }
                        if ($pnode->length > 0) {
                            $text = trim($pnode->item(0)->nodeValue);
                            // skratiti ako je predugo
                            $rad->tekst_rada = mb_substr($text, 0, 1000);
                        } else {
                            $rad->tekst_rada = '';
                        }
                    }
                }

                $this->radovi[] = $rad;
            }
        }
    }

    public function save($conn) {
        foreach ($this->radovi as $r) {
            if (empty($r->naziv_rada) && empty($r->link_rada) && empty($r->tekst_rada)) {
                continue;
            }
            $stmt = $conn->prepare("INSERT INTO diplomski_radovi (naziv_rada, tekst_rada, link_rada, oib_tvrtke)
                                    VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $r->naziv_rada, $r->tekst_rada, $r->link_rada, $r->oib_tvrtke);
            $stmt->execute();
        }
    }

    public function read($conn) {
        $result = $conn->query("SELECT * FROM diplomski_radovi");
        while ($row = $result->fetch_assoc()) {
            echo "<strong>ID:</strong> {$row['ID']}<br>";
            echo "<strong>Naziv:</strong> {$row['naziv_rada']}<br>";
            echo "<strong>Tekst:</strong> {$row['tekst_rada']}<br>";
            echo "<strong>Link:</strong> <a href='{$row['link_rada']}' target='_blank'>{$row['link_rada']}</a><br>";
            echo "<strong>OIB:</strong> {$row['oib_tvrtke']}<hr>";
        }
    }

    private function fetchHTML($url) {
        if (!$url) return false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            echo "<p style='color:red;'>cURL greška za $url: " . curl_error($ch) . "</p>";
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode >= 400) {
            echo "<p style='color:red;'>HTTP $httpCode za $url</p>";
        }

        curl_close($ch);

        return $output ?: false;
    }
}
?>
