<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Api
 *
 * @author user
 */
class Api {

    var $img;
    var $button;
    var $yesterday;

    function __construct() {
        $yesterday = date("d-m-Y");
        $img[] = '<img class="aligncenter size-full wp-image-7421" src="https://www.arotrade.com/wp-content/uploads/2018/12/USDJPY-' . $yesterday . '.png" alt="USDJPY-' . $yesterday . '" width="1640" height="867" />​';
        $img[] = '<img class="aligncenter size-full wp-image-7422" src="https://www.arotrade.com/wp-content/uploads/2018/12/EURUSD-' . $yesterday . '" alt="EURUSD-' . $yesterday . '" width="1654" height="866" />​';
        $img[] = '<img class="aligncenter size-full wp-image-7423" src="https://www.arotrade.com/wp-content/uploads/2018/12/GBPUSD-' . $yesterday . '.png" alt="GBPUSD-' . $yesterday . '" width="1653" height="861" />​';
        $img[] = '<img class="aligncenter size-full wp-image-7424" src="https://www.arotrade.com/wp-content/uploads/2018/12/Gold-' . $yesterday . '.png" alt="Gold-' . $yesterday . '" width="1654" height="861" />​';

        $button[] = '<div class="pad-space center-align">[ts_is_trader_guest]<a href="/open-account/" class="btn middle-news invert">Trade USDJPY</a>[/ts_is_trader_guest][ts_is_trader_with_deposit]<a href="//trade.arotrade.com/cfd-tab/33" class="btn middle-news invert">Trade USDJPY</a>[/ts_is_trader_with_deposit][ts_is_trader_without_deposit]<a href="//trade.arotrade.com/deposit-funds/" class="btn middle-news invert">Trade USDJPY</a>[/ts_is_trader_without_deposit]</div>';
        $button[] = '<div class="pad-space center-align">[ts_is_trader_guest]<a href="/open-account/" class="btn middle-news invert">Trade EURUSD</a>[/ts_is_trader_guest][ts_is_trader_with_deposit]<a href="//trade.arotrade.com/cfd-tab/17" class="btn middle-news invert">Trade EURUSD</a>[/ts_is_trader_with_deposit][ts_is_trader_without_deposit]<a href="//trade.arotrade.com/deposit-funds/" class="btn middle-news invert">Trade EURUSD</a>[/ts_is_trader_without_deposit]</div>';
        $button[] = '<div class="pad-space center-align">[ts_is_trader_guest]<a href="/open-account/" class="btn middle-news invert">Trade GBPUSD</a>[/ts_is_trader_guest][ts_is_trader_with_deposit]<a href="//trade.arotrade.com/cfd-tab/8" class="btn middle-news invert">Trade GBPUSD</a>[/ts_is_trader_with_deposit][ts_is_trader_without_deposit]<a href="//trade.arotrade.com/deposit-funds/" class="btn middle-news invert">Trade GBPUSD</a>[/ts_is_trader_without_deposit]</div>';
        $button[] = '<div class="pad-space center-align">[ts_is_trader_guest]<a href="/open-account/" class="btn middle-news invert">Trade Gold</a>[/ts_is_trader_guest][ts_is_trader_with_deposit]<a href="//trade.arotrade.com/cfd-tab/53" class="btn middle-news invert">Trade Gold</a>[/ts_is_trader_with_deposit][ts_is_trader_without_deposit]<a href="//trade.arotrade.com/deposit-funds/" class="btn middle-news invert">Trade Gold</a>[/ts_is_trader_without_deposit]<a href="/trader-tools/technical-analysis/" class="btn middle-news">Back</a></div>';
    }

    function get_tables($html) {
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
                    $new_table .= '<tr>
		';
                    $i;
                    foreach ($tr as $td) {
                        if ($i == 0) {
                            $new_table .= '<th scope="row">' . $td . '</th>
			';
                        } elseif ($i == 4) {
                            $new_table .= '<td><strong>' . $td . '</strong></td>
			';
                        } else {
                            $new_table .= '<td>' . $td . '</td>
			';
                        }
                        $i++;
                    }
                    unset($i);
                    $new_table .= '</tr>
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

    function get_done_html($html) {

        $table_libtaly = get_tables($html);
        $i = 0;
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
        $my_all_taxt = text_preparation($html);
        foreach ($insert_puth as $value) {
            $my_all_taxt = str_replace_once("<h2>table</h2>", $value, $my_all_taxt);
        }
        return $my_all_taxt;
    }

    function text_preparation($html) {
        $string = (string) $html;
        $print = preg_replace('/\<table [\d\D]+\<\/table\>/Ui', '<span>table</span>', $string);

        $html = str_get_html($print);
        $html = $html->find('body', 0);
        foreach ($html->find('span') as $element) {
            $p_string .= '<p>' . $element->innertext . '</p>';
        }

        $p_string = str_replace('<p><o:p>&nbsp;</o:p></p>', '', $p_string);
        $p_string = str_replace('<p><o:p></o:p></p>', '', $p_string);
        $p_string = str_replace('<o:p></o:p>', '', $p_string);
        $p_string = $print = preg_replace('/\<b [\d\D]+\<\/b\>/Ui', '', $p_string);
        $p_string = str_replace('<p>&nbsp;</p>', '', $p_string);
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

    function str_replace_once($search, $replace, $text) {
        $pos = strpos($text, $search);
        return $pos !== false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
    }

}
