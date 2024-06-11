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
        $item_key = $template_item[0];
        $item_tbl = $table_name[$i];

        if (isset($_POST["del-$item_tbl"])) {
            $data = new SqlItem();
            $result = $data->gen_object(array($item_key), array($template_item_t[0]));
            $data->make_form($result, $dest, "Remove $item_tbl", $item_rm_handle);
        } elseif (isset($_POST["add-$item_tbl"])) {
            $data = new SqlItem();
            $result = $data->gen_object($template_item, $template_item_t);
            $data->make_form($result, $dest, "Add $item_tbl", $item_add_handle);
        }

        handle_req($item_add_handle, $item_rm_handle, $template_item, $template_item_t, $item_key, $item_tbl);
    }

    if (isset($_POST["cancel"])) {
        echo "<script>document.getElementById('popout').innerHTML='';</script>";
    }
}
?>
