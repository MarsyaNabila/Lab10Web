<?php
class Form {
    private $fields = array();
    private $action;
    private $submit = "Submit";
    private $jumField = 0;

    public function __construct($action, $submit) {
        $this->action = $action;
        $this->submit = $submit;
    }

    public function addField($name, $label) {
        $this->fields[$this->jumField]['name'] = $name;
        $this->fields[$this->jumField]['label'] = $label;
        $this->jumField++;
    }

    public function displayForm() {
        echo "<form action='$this->action' method='POST'>";
        echo "<table>";

        for ($i = 0; $i < count($this->fields); $i++) {
            echo "<tr><td>".$this->fields[$i]['label']."</td>";
            echo "<td><input type='text' name='".$this->fields[$i]['name']."'></td></tr>";
        }

        echo "<tr><td colspan='2'>";
        echo "<input type='submit' value='$this->submit'>";
        echo "</td></tr>";

        echo "</table>";
        echo "</form>";
    }
}
?>
