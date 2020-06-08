<?php
// Un namespace
namespace Core\HTML;

class BootstrapForm extends Form {

    protected function surround($html) {
        return "<div class='form-group'>{$html}</div>";
    }

    /**
     * @param string $name
     * @param $label
     * @param string $type
     * @return string
     */
    public function input($name, $label, $options = array()) {
        if (empty($options["type"])) {
            $options["type"] = "text";
        }

        if (empty($options["class"])) {
            $options["class"] = "form-control";
        } else {
            $options["class"] = "{$options["class"]} form-control";
        }

        $labelHTML = "<label for='{$name}'>{$label} <b style='color: red'>*</b></label>";

        if ($options["type"] === "textarea") {
            $inputHTML = "<textarea rows='4' class='form-control' id='{$name}' name='{$name}'>{$this->getValue($name)}</textarea>";
        } else {
            $inputHTML = "<input ";

//            dd($options, false);
            foreach ($options as $k => $v) {
                $inputHTML .= " {$k}='{$v}' ";
            }

            // input HTML
            $inputHTML .= " name='{$name}' value=\"{$this->getValue($name)}\" id='{$name}' required>";
        }

        return $this->surround($labelHTML . $inputHTML);
    }

    public function submit($value = "Envoyer", $class = "primary") {
        return "<button class='btn btn-{$class}' type='submit'>{$value}</button>";
    }


    /**
     * Display errors
     * @return string
     */
    public function errors() {
        $errHTtml = '';
        if ($this->error) {
            $typeHtml = $this->error["type"] == "success" ? "success" : "danger";
            $errHTtml .= "<div class='alert alert-{$typeHtml}'>{$this->error["msg"]}</div>";
        }
        return $errHTtml;
    }

    /**
     * @param $name
     * @param $label
     * @param $items array -> list of items to show
     * @return string
     */
    public function select($name, $label, $items) {
        $labelHTML = "<label for='{$name}'>{$label} <b style='color: red'>*</b></label>";
        $selectHTML = "<select class='form-control' name='{$name}' id='{$name}' required>";

        foreach ($items as $k => $v) {
            // other attributes for select
            $attrs = "";
            if ($k == $this->getValue($name)) {
                $attrs = "selected";
            }

            $selectHTML .= "<option value='{$k}' {$attrs}>{$v}</option>";
        }

        $selectHTML .= "</select>";

        return $this->surround($labelHTML . $selectHTML);
    }

    public function group($inputs) {
        $inputsHTML = "<div class=\"form-row\">\n";

        foreach ($inputs as $input) {
            $inputsHTML .= "<div class='col'>" . $input . "</div>\n";
        }
        $inputsHTML .= "</div>\n";

        return $inputsHTML;
    }
}