<?php

$dest = $_SESSION["location"];
$table_name = array("item", "pemasok", "pelanggan", "rekening", "hjual", "djual", "hbeli", "dbeli", "dbayarjual", "dbayarbeli");

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

    function make_form(array $item, string $dest, string $form_name, string $submit_name):void {
        echo "<div class='float-me' id='popup'>";
        echo "<h3>$form_name</h3>";
        echo "<form method='post' action='$dest'>";
        $counter = 0;
        for ($i=0; $i < count($item); $i++) {
            $type = $item[$i]->type;
            $name = $item[$i]->name;
            echo "<div class='form-input'>";
            echo "<label for='$name'>$name: </label><br/>";
            echo "<input type='$type' name='$name'>";
            echo "</div>";
        }
        echo "<br/><input class='c-text-bold c-bg-green' type='submit' name='$submit_name' value='Submit'>";
        echo "<br/><input class='c-text-bold c-bg-secondary' type='submit' name='cancel' value='Cancel'><br/>";
        echo "</form>";
        echo "</div>";

    }
};

function handle_req(string $add_handle, string $rm_handle, array $template, array $template_t, string $key, string $table_name) {
    if (isset($_POST[$add_handle])) {
        $db = connect_db();
        $str = "insert into $table_name (";
        for ($i=0; $i < count($template); $i++) { 
            $str = $str . $template[$i];
            if ($i != count($template) - 1) {
                $str = $str . ",";
            }
        }
        $str = $str . ") values (";
        for ($i=0; $i < count($template); $i++) {
            if ($template_t[$i] == "text") {
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
        unset($_POST[$add_handle]);
    }
    if (isset($_POST[$rm_handle])) {
        $db = connect_db();
        $id = $_POST[$key];
        $str = "delete from $table_name where $key = '$id';";
        $results = $db->query($str);
        unset($_POST[$rm_handle]);
    }
}

/// ITEM FORM

$template_item = array("kodeitem", "nama", "hargabeli", "hargajual", "stok", "satuan");
$template_item_t = array("text", "text", "number", "number", "number", "text");
$item_add_handle = "done-add-item";
$item_rm_handle = "done-rm-item";
$item_key = $template_item[0];
$item_tbl = $table_name[0];

if (isset($_POST["del-item"])) {
    $data = new SqlItem();
    $result = $data->gen_object(array($item_key), array("text"));
    $data->make_form($result, $dest, "Remove Item", $item_rm_handle);
} elseif (isset($_POST["add-item"])) {
    $data = new SqlItem();
    $result = $data->gen_object($template_item, $template_item_t);
    $data->make_form($result, $dest, "Add Item", $item_add_handle);
}

handle_req($item_add_handle, $item_rm_handle, $template_item, $template_item_t, $item_key, $item_tbl);

/// PEMASOK FORM

$template_pemasok= array("kodepemasok", "namapemasok", "alamat", "kota", "telepon", "email");
$template_pemasok_t= array("text", "text", "text", "text", "text", "text");
$pemasok_add_handle = "done-add-pemasok";
$pemasok_rm_handle = "done-rm-pemasok";
$pemasok_key = $template_pemasok[0];
$pemasok_tbl = $table_name[1];

if (isset($_POST["del-pemasok"])) {
    $data = new SqlItem();
    $result = $data->gen_object(array($pemasok_key), array("text"));
    $data->make_form($result, $dest, "Remove pemasok", $pemasok_rm_handle);
} elseif (isset($_POST["add-pemasok"])) {
    $data = new SqlItem();
    $result = $data->gen_object($template_pemasok, $template_pemasok_t);
    $data->make_form($result, $dest, "Add Pemasok", $pemasok_add_handle);
}

handle_req($pemasok_add_handle, $pemasok_rm_handle, $template_pemasok, $template_pemasok_t, $pemasok_key, $pemasok_tbl);

///////////////////////////////////

if (isset($_POST["cancel"])) {
    echo "<script>document.getElementById('popout').innerHTML='';</script>";
}
?>
