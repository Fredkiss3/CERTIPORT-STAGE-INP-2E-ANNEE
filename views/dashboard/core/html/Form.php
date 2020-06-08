<?php

namespace Core\HTML;


/**
 * Class Form
 * Permet de générer un formulaire rapidement et simplement
 */
class Form {

    /**
     * @var array Données utilisées par le formulaire
     */
    protected $data = array();

    protected $error = array();

    /**
     * @var string Tag pour entourer nos 'champs'
     */
    public $surround = "p";

    /**
     * Form constructor.
     * @param array $data Données utilisées par le formulaire
     */
    public function __construct($data = array(), $errors = array()) {
        $this->data = $data;
        $this->error = $errors;
    }

    /**
     * @param $html string le code html à entourer
     * @return string
     */
    protected function surround($html) {
        return "<{$this->surround}>{$html}<{$this->surround}>";
    }

    /**
     * @param $index string l'index de la valeur à récupérer
     * @return mixed|null
     */
    protected function getValue($index) {
        if (is_object($this->data)) {
            return $this->data->$index;
        }
        return (isset($this->data[$index])) ? $this->data[$index] : "";
    }

    /**
     * @param $name string le 'name' de l'input
     * @param $type string le 'type' de l'input
     * @return string
     */
    public function input($name, $label, $type = "text") {
        if ($type === "textarea") {
            $inputHTML = "<textarea id='{$name}' name='{$name}'>{$this->getValue($name)}</textarea>";
        } else {
            $inputHTML = $this->surround("<input type='{$type}' name='{$name}' value='{$this->getValue($name)}' required>");
        }
        return $inputHTML;
    }

    /**
     * @return string
     */
    public function submit() {
        return $this->surround("<button type='submit'>Envoyer</button>");
    }

    public function select($name, $label, $items) {
        $selectHTML = "<select name='{$name}' id='{$name}'>";

        foreach ($items as $k => $v) {
            $selectHTML .= "<option value='{$k}'>{$v}<option>";
        }

        $selectHTML .= "</select>";

        return $this->surround($selectHTML);
    }

}