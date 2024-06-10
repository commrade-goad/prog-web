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


$template_item = array("kodeitem", "nama", "hargabeli", "hargajual", "stok", "satuan");
$template_item_t = array("text", "text", "number", "number", "number", "text");

if (isset($_POST["del-item"])) {
    $data = new SqlItem();
    $result = $data->gen_object(array("kodeitem"), array("text"));
    $data->make_form($result, "/dashboard/?tview=all", "Remove Item", "done-rm");
} elseif (isset($_POST["add-item"])) {
    $data = new SqlItem();
    $result = $data->gen_object($template_item, $template_item_t);
    $data->make_form($result, "/dashboard/?tview=all", "Add Item", "done-add");
}



if (isset($_POST["done-add"])) {
    $db = connect_db();
    $str = "insert into item (kodeitem, nama, hargabeli, hargajual, stok, satuan) values (";
    for ($i=0; $i < count($template_item); $i++) {
        if ($template_item_t[$i] == "text") {
            $str = $str . "'" . $_POST[$template_item[$i]] . "'" ;
        } else {
            $str = $str . "" . $_POST[$template_item[$i]];
        }

        if ($i != count($template_item) - 1) {
            $str = $str . ",";
        }
    }
    $str = $str . ");";
    $results = $db->query($str);
}
if (isset($_POST["done-rm"])) {
    $db = connect_db();
    $id = $_POST["kodeitem"];
    $str = "delete from item where kodeitem = '$id';";
    $results = $db->query($str);
}

if (isset($_POST["cancel"])) {
    echo "<script>document.getElementById('popout').innerHTML='';</script>";
}
?>
