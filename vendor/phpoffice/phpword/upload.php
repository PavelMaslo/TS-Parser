<?php

include_once('./api/simple_html_dom.php');
header("Content-type: text/html; charset=UTF-8");
echo '<html>
<header>
<meta http-equiv=\'Content-Type\' content=\'text/html; charset=windows-1251\'>
<style>
   body{
    background-color: #3366CC; /* Цвет фона веб-страницы */
   } 
   h1 {
    background-color: RGB(249, 201, 16); /* Цвет фона под заголовком */
   }
   p { 
   }
  </style>
</header>
<body>';


require_once 'bootstrap.php';

$target_dir = "uploads\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$yesterday = date("d-m-Y");
$file_name = $_FILES["fileToUpload"]["name"];
$name = $_FILES["fileToUpload"]["name"];
$url_new_file = getcwd() . '\\' . $target_dir . $file_name;
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $phpWord = \PhpOffice\PhpWord\IOFactory::load($url_new_file);
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
    $objWriter->save($target_dir . 'TA.html');
} else {
    echo "Sorry, there was an error uploading your file.";
}

$html = file_get_html('http://' . $_SERVER['HTTP_HOST'] . '/uploads/TA.html');

?>
    <p align="center">
    <p align="center">
        <label><strong>Arotrede</strong></label></br>
        <textarea rows="10" cols="150">
                     <?php echo trim(get_done_html($html)) ?>
            </textarea>
    </p>
    <p align="center">
        <label><strong>Opteck</strong></label></br>
        <textarea rows="10" cols="150">
                      <?php echo trim(get_done_html_opteck($html)) ?>
            </textarea>
    </p>
<?php
$i = 1;
$table_libtaly = get_tables($html);
if ($table_libtaly) {
    foreach ($table_libtaly as $table) {

        $table = str_replace('TIME FRAME', 'ПЕРИОД', $table);
        $table = str_replace('PIVOT POINT', 'ОПОРНАЯ ТОЧКА', $table);
        $table = str_replace('DAILY', '1 день', $table);
        $table = str_replace('WEEKLY', '1 неделя', $table);
        $table = str_replace('MONTHLY', '1 месяц', $table);
        ?>
        <p align="center">
            <label><strong>RU Table <?php echo $i ?></strong></label></br>
            <textarea rows="10" cols="150">
        <?php
        echo $table;
        ?>
        </textarea>
        </p>
        <?php
        $i++;
    }
}
?>
    </p>
<?php


echo '</br><a href="/uploads/TAArot.html" download>Arotrade</a></br>';
echo '<a href="/uploads/TAOpteck.html" download>Opteck</a></br>';
echo '</body></html>';
function get_tables($html)
{
    $after_replaced = str_replace('<td>  <p>&nbsp;</p>  </td>', '', (string)$html);
    $html = str_get_html($after_replaced);

    foreach ($html->find('table') as $table) {
        $rowData = array();

        foreach ($table->find('tr') as $row) {
            // initialize array to store the cell data from each row
            $flight = array();

            foreach ($row->find('td') as $cell) {
                // push the cell's text to the array
                $flight[] = $cell->plaintext;
            }
            $rowData[] = $flight;
        }
        $new_table = '<table border="1" cellpadding="1" cellspacing="1" style="width: 100%;">
      <thead>
          <tr>
              <th scope="row">TIME FRAME</th>
              <th scope="col">S3</th>
              <th scope="col">S2</th>
              <th scope="col">S1</th>
              <th scope="col">PIVOT POINT</th>
              <th scope="col">R1</th>
              <th scope="col">R2</th>
              <th scope="col">R3</th>
          </tr>
      </thead>
      <tbody>
  ';

        $numder_road;
        foreach ($rowData as $row => $tr) {
            if ($numder_road >= 1) {
                $new_table .= '    <tr>
  ';
                $i;
                foreach ($tr as $td) {
                    if ($i == 0) {
                        $new_table .= '        <th scope="row">' . $td . '</th>
  ';
                    } elseif ($i == 4) {
                        $new_table .= '        <td><strong>' . $td . '</strong></td>
  ';
                    } else {
                        $new_table .= '        <td>' . $td . '</td>
  ';
                    }
                    $i++;
                }
                unset($i);
                $new_table .= '    </tr>
  ';
            }
            $numder_road++;
        }
        unset($numder_road);
        $new_table .= '</tbody>
  </table>
 ';
        $table_libtaly[] = $new_table;
    }
    return $table_libtaly;
}

function get_done_html($html)
{
    $year_mons = date("Y/m");
    $yesterday = date("d-m-Y");
    $img[] = '<img class="aligncenter size-full wp-image-7421" src="/wp-content/uploads/'.$year_mons.'/USDJPY-' . $yesterday . '.png" alt="USDJPY-' . $yesterday . '" width="1640" height="867" />​';
    $img[] = '<img class="aligncenter size-full wp-image-7422" src="/wp-content/uploads/'.$year_mons.'/EURUSD-' . $yesterday . '.png" alt="EURUSD-' . $yesterday . '" width="1654" height="866" />​';
    $img[] = '<img class="aligncenter size-full wp-image-7423" src="/wp-content/uploads/'.$year_mons.'/GBPUSD-' . $yesterday . '.png" alt="GBPUSD-' . $yesterday . '" width="1653" height="861" />​';
    $img[] = '<img class="aligncenter size-full wp-image-7424" src="/wp-content/uploads/'.$year_mons.'/Gold-' . $yesterday . '.png" alt="Gold-' . $yesterday . '" width="1654" height="861" />​';

    $button[] = '<div class="pad-space center-align">[ts_is_trader_guest]<a href="/open-account/" class="btn middle-news invert">Trade USDJPY</a>[/ts_is_trader_guest][ts_is_trader_with_deposit]<a href="//trade.arotrade.com/cfd-tab/33" class="btn middle-news invert">Trade USDJPY</a>[/ts_is_trader_with_deposit][ts_is_trader_without_deposit]<a href="//trade.arotrade.com/deposit-funds/" class="btn middle-news invert">Trade USDJPY</a>[/ts_is_trader_without_deposit]</div>';
    $button[] = '<div class="pad-space center-align">[ts_is_trader_guest]<a href="/open-account/" class="btn middle-news invert">Trade EURUSD</a>[/ts_is_trader_guest][ts_is_trader_with_deposit]<a href="//trade.arotrade.com/cfd-tab/17" class="btn middle-news invert">Trade EURUSD</a>[/ts_is_trader_with_deposit][ts_is_trader_without_deposit]<a href="//trade.arotrade.com/deposit-funds/" class="btn middle-news invert">Trade EURUSD</a>[/ts_is_trader_without_deposit]</div>';
    $button[] = '<div class="pad-space center-align">[ts_is_trader_guest]<a href="/open-account/" class="btn middle-news invert">Trade GBPUSD</a>[/ts_is_trader_guest][ts_is_trader_with_deposit]<a href="//trade.arotrade.com/cfd-tab/8" class="btn middle-news invert">Trade GBPUSD</a>[/ts_is_trader_with_deposit][ts_is_trader_without_deposit]<a href="//trade.arotrade.com/deposit-funds/" class="btn middle-news invert">Trade GBPUSD</a>[/ts_is_trader_without_deposit]</div>';
    $button[] = '<div class="pad-space center-align">[ts_is_trader_guest]<a href="/open-account/" class="btn middle-news invert">Trade Gold</a>[/ts_is_trader_guest][ts_is_trader_with_deposit]<a href="//trade.arotrade.com/cfd-tab/53" class="btn middle-news invert">Trade Gold</a>[/ts_is_trader_with_deposit][ts_is_trader_without_deposit]<a href="//trade.arotrade.com/deposit-funds/" class="btn middle-news invert">Trade Gold</a>[/ts_is_trader_without_deposit]<a href="/trader-tools/technical-analysis/" class="btn middle-news">Back</a></div>';

    $table_libtaly = get_tables($html);
    $i = 0;

    $my_all_taxt = text_preparation($html);
    if ($table_libtaly) {
        foreach ($table_libtaly as $table) {
            $team = '
      ';
            $team .= $img[$i];
            $team .= '
      ';
            $team .= $table;
            $team .= '
      ';
            $team .= $button[$i];
            $team .= '
      ';
            $insert_puth[] = $team;
            $i++;
        }
        foreach ($insert_puth as $value) {
            $my_all_taxt = str_replace_once("<h2>table</h2>", $value, $my_all_taxt);
        }
    }
    return $my_all_taxt;
}


function get_done_html_opteck($html)
{
    $table_libtaly = get_tables($html);
    $my_all_taxt = text_preparation($html);
    if ($table_libtaly) {
        $yesterday = date("d-m-Y");
        $img[] = ' <img src="//assets.opteck.com/attachments/blog/USDJPY-' . $yesterday . '.png" alt="USDJPY-' . $yesterday . '"/>​';
        $img[] = ' <img src="//assets.opteck.com/attachments/blog/EURUSD-' . $yesterday . '.png" alt="EURUSD-' . $yesterday . '" />​';
        $img[] = ' <img src="//assets.opteck.com/attachments/blog/GBPUSD-' . $yesterday . '.png" alt="GBPUSD-' . $yesterday . '" />​';
        $img[] = ' <img src="//assets.opteck.com/attachments/blog/Gold-' . $yesterday . '.png" alt="Gold-' . $yesterday . '" />​';

        $i = 0;
        foreach ($table_libtaly as $table) {
            $team = '
  ';
            $team .= $img[$i];
            $team .= '
            <p>'.htmlspecialchars("&nbsp;", ENT_QUOTES).'</p>
  ';
            $team .= $table;
            $team .= '

            <p>'.htmlspecialchars("&nbsp;", ENT_QUOTES).'</p>
  ';
            $insert_puth[] = $team;
            $i++;
        }

        foreach ($insert_puth as $value) {
            $my_all_taxt = str_replace_once("<h2>table</h2>", $value, $my_all_taxt);
        }
    }
    return $my_all_taxt;
}

function text_preparation($html)
{
    $string = (string)$html;
    $print = preg_replace('/<table>[\d\D]+\<\/table>/Ui', '<p>table</p>', $string);


    $html = str_get_html($print);
    foreach ($html->find('p') as $element) {
        $element->removeAttribute("style");
        $p_string .= '<p>' . $element->innertext . '</p>';
    }

    $p_string = preg_replace('/<span style="(.+?)">(.+?)<\/span>/i', "<span>$2</span>", (string)$p_string);
    $p_string = str_replace('<p>&nbsp;</p>', '', $p_string);
    $p_string = str_replace("<p> </p>", '', $p_string);
    $p_string = str_replace('<p></p>', '', $p_string);

    $html = str_get_html($p_string);

    foreach ($html->find('p') as $element) {
        if ((strlen($element->plaintext)) < 7) {
            $back_to_string .= ('<h2>' . $element->plaintext . '</h2>
  ');
        } else {
            $back_to_string .= $element->outertext;
        }
    }
    return $back_to_string;
}

function str_replace_once($search, $replace, $text)
{
    $pos = strpos($text, $search);
    return $pos !== false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
}

?>