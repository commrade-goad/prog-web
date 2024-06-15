<?php
// to make array of sql items
class SqlItem {
    public $name;
    public $type;

    function gen_object(array $template_item, array $template_t): array {
        $item = array();
        for ($i=0; $i < count($template_item); $i++) { 
            $stuff = new SqlItem();
            $stuff->name = $template_item[$i];
            $stuff->type = $template_t[$i];
            array_push($item, $stuff);
        }
        return $item;
    }

    function gen_object_with_val(array $template_item, array $template_t, bool $gen_value, string $tname = '', array &$value = [], $val): array {
        $item = array();
        for ($i=0; $i < count($template_item); $i++) { 
            $stuff = new SqlItem();
            $stuff->name = $template_item[$i];
            $stuff->type = $template_t[$i];
            array_push($item, $stuff);
        }
        if ($gen_value) {
            $db = connect_db();
            $str = "select * from $tname where $template_item[0] = ";
            if ($template_t[0] == "text") {
                $str = $str . "'$val'";
            } else {
                $str = $str . "$val";
            }
            $result = $db->query($str);
            while ($row= $result->fetchArray()) {
                for ($i=0; $i < count($template_item); $i++) { 
                    array_push($value, $row[$template_item[$i]]);
                }
            }
        }
        return $item;
    }

    function make_form(array $item, string $dest, string $form_name, string $submit_name, bool $disable_filter = false):void {
        echo "<div class='float-me' id='popup'>";
        echo "<h3>$form_name</h3>";
        echo "<form method='post' action='$dest'>";
        $counter = 0;
        for ($i=0; $i < count($item); $i++) {
            $type = $item[$i]->type;
            $name = $item[$i]->name;
            echo "<div class='form-input'>";
            if ($disable_filter) {
                echo "<label for='$name'>$name: </label><br/>";
                echo "<input type='$type' name='$name'>";
            } else {
                if ($name != "no" && $name != "nogenerate") {
                    echo "<label for='$name'>$name: </label><br/>";
                    echo "<input type='$type' name='$name'>";
                }
            }
            echo "</div>";
        }
        echo "<br/><input class='c-text-bold c-bg-green' type='submit' name='$submit_name' value='Submit'>";
        echo "<br/><input class='c-text-bold c-bg-secondary' type='submit' name='cancel' value='Cancel'><br/>";
        echo "</form>";
        echo "</div>";

    }

    function make_edit_form(array $item, string $dest, string $form_name, string $submit_name, array $value_tbl):void {
        echo "<div class='float-me' id='popup'>";
        echo "<h3>$form_name</h3>";
        echo "<form method='post' action='$dest'>";
        $counter = 0;
        for ($i=0; $i < count($item); $i++) {
            $type = $item[$i]->type;
            $name = $item[$i]->name;
            echo "<div class='form-input'>";
            echo "<label for='$name'>$name: </label><br/>";
            if ($i == 0) {
                echo "<input type='$type' value='$value_tbl[$i]' disabled>";
                echo "<input type='hidden' name='$name' value='$value_tbl[$i]'>";
            } else {
                echo "<input type='$type' name='$name' value='$value_tbl[$i]'>";
            }
            echo "</div>";
        }
        echo "<br/><input class='c-text-bold c-bg-green' type='submit' name='$submit_name' value='Submit'>";
        echo "<br/><input class='c-text-bold c-bg-secondary' type='submit' name='cancel' value='Cancel'><br/>";
        echo "</form>";
        echo "</div>";
    }
};

function handle_req(string $add_handle, string $rm_handle, string $edit_handle, array $template, array $template_t, string $key, string $table_name) {
    if (isset($_POST[$add_handle])) {
        $db = connect_db();
        $str = "insert into $table_name (";
        for ($i=0; $i < count($template); $i++) { 
            if ($template[$i] == "no" || $template[$i] == "nogenerate") {
                continue;
            }
            $str = $str . $template[$i];
            if ($i != count($template) - 1) {
                $str = $str . ",";
            }
        }
        $str = $str . ") values (";
        for ($i=0; $i < count($template); $i++) {
            if ($template[$i] == "no" || $template[$i] == "nogenerate") {
                continue;
            }
            if ($template_t[$i] == "text" || $template_t[$i] == "date") {
                $str = $str . "'" . $_POST[$template[$i]] . "'" ;
            } else {
                $str = $str . "" . $_POST[$template[$i]];
            }

            if ($i != count($template) - 1) {
                $str = $str . ",";
            }
        }
        $str = $str . ");";
        $results = $db->query($str);
        if ($table_name == "djual") {
            $sec_query = "insert into hjual (nojual, tanggal, kodepelanggan, total, keterangan) values ('" . $_POST["nojual"] . "', DATE()";
            $sec_query = $sec_query . ", '-', " . $_POST["qty"] * $_POST["hargajual"] . ", '-')";
            $db->query($sec_query);
            $third_query = "insert into dbayarjual (nojual, tanggal, totalbayar, keterangan, koderekening) values ('" . $_POST["nojual"] . "', DATE()";
            $third_query = $third_query . ", " . $_POST["qty"] * $_POST["hargajual"] . ", '-', '-')";
            $db->query($third_query);
        }
        if ($table_name == "dbeli") {
            $sec_query = "insert into hbeli (nobeli, noref, tanggal, kodepemasok, total, keterangan) values ('" . $_POST["nobeli"] . "', '-', DATE()";
            $sec_query = $sec_query . ", '-', " . $_POST["qty"] * $_POST["hargabeli"] . ", '-')";
            $db->query($sec_query);
            $third_query = "insert into dbayarjual (nobeli, tanggal, totalbayar, keterangan, koderekening) values ('" . $_POST["nobeli"] . "', DATE()";
            $third_query = $third_query . ", " . $_POST["qty"] * $_POST["hargajual"] . ", '-', '-')";
            $db->query($third_query);
        }
        unset($_POST[$add_handle]);
    }
    if (isset($_POST[$rm_handle])) {
        $db = connect_db();
        $id = $_POST[$key];
        $str = "delete from $table_name where $key = '$id';";
        $results = $db->query($str);
        unset($_POST[$rm_handle]);
    }
    if (isset($_POST[$edit_handle])) {
        $db = connect_db();
        $str = "update $table_name set ";
        for ($i=1; $i < count($template); $i++) {
            $str = $str . $template[$i] . '=';
            if ($template_t[$i] == "text" || $template_t[$i] == "date") {
                $str = $str . "'" . $_POST[$template[$i]] . "'" ;
            } else {
                $str = $str . "" . $_POST[$template[$i]];
            }
            if ($i != count($template) - 1) {
                $str = $str . ",";
            }
        }
        if ($template_t[0] == "text") {
            $str = $str . " where $template[0] = '$_POST[$key]'";
        } else {
            $str = $str . " where $template[0] = $_POST[$key]";
        }
        $results = $db->query($str);
        unset($_POST[$edit_handle]);
    }
}

/// FORM
if (isset($_SESSION["displayed"])) {
    $dest = $_SESSION["location"];
    $table_name = $_SESSION["table"];
    $template = $_SESSION["template"];
    $template_t = $_SESSION["template_t"];

    for ($i=0; $i < count($template); $i++) { 
        $template_item = $template[$i];
        $template_item_t = $template_t[$i];
        $item_add_handle = "done-add-$table_name[$i]";
        $item_rm_handle = "done-rm-$table_name[$i]";
        $item_edit_handle = "done-edit-$table_name[$i]";
        $item_key = $template_item[0];
        $item_tbl = $table_name[$i];

        if (isset($_POST["del-$item_tbl"])) {
            $data = new SqlItem();
            $result = $data->gen_object(array($item_key), array($template_item_t[0]), false);
            $data->make_form($result, $dest, "Remove $item_tbl", $item_rm_handle, true);
        } elseif (isset($_POST["add-$item_tbl"])) {
            $data = new SqlItem();
            $result = $data->gen_object($template_item, $template_item_t, false);
            $data->make_form($result, $dest, "Add $item_tbl", $item_add_handle);
        } elseif (isset($_POST["edit-$item_tbl"])) {
            $val = $_POST["edit-$item_tbl"];
            $value_arr = array();
            $data = new SqlItem();
            $result = $data->gen_object_with_val($template_item, $template_item_t, true, $item_tbl, $value_arr, $val);
            $data->make_edit_form($result, $dest, "Edit $item_tbl", $item_edit_handle, $value_arr);
        }

        handle_req($item_add_handle, $item_rm_handle, $item_edit_handle, $template_item, $template_item_t, $item_key, $item_tbl);
    }

    if (isset($_POST["cancel"])) {
        echo "<script>document.getElementById('popout').innerHTML='';</script>";
    }
}
?>
