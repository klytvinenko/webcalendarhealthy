<?php
namespace App;
class Build
{
    static function Form()
    {
        //todo
        return "form";
    }
    static function SelectOptions($array)
    {
        $res = '';
        foreach ($array as $value) {
            $text = isset($value['title']) ? $value['title'] : $value['name'];
            $res .= '<option value="' . $value['id'] . '">' . $text . '</option>';
        }
        return $res;
    }
    static function FormControlSelect($name, $label, string $attrs, array $array)
    {
        $options = '';
        foreach ($array as $value) {
            $text = isset($value['title']) ? $value['title'] : $value['name'];
            $options .= '<option value="' . $value['id'] . '">' . $text . '</option>';
        }
        return '<div class="form-control">
        <label for="' . $name . '">' . $label . '</label>
        <select name="' . $name . '" ' . $attrs . '>
        <option value="">Оберіть...</option>
        ' . $options . '</select>
        </div>';
    }
    static function FormControlSelectSearch($name, $label, string $attrs,string $id)
    {
        return '<div class="form-control">
        <label for="' . $name . '">' . $label . '</label>
        <select id="'.$id.'" name="' . $name . '" ' . $attrs . '></select>
        </div>';
    }
    static function FormControlInput($name, $label, string $inputType, string $attrs)
    {
        if($inputType!="checkbox"&&$inputType!="radiobutton"){
        return '<div class="form-control">
            <label for="' . $name . '">' . $label . '</label>
            <input type="' . $inputType . '" name="' . $name . '" ' . $attrs . '>
        </div>';}
        else{
            
        return '<div class="form-control">
        <br><label for="' . $name . '">
        <input type="' . $inputType . '" name="' . $name . '" ' . $attrs . '>' . $label . '</label>
    </div>';
        }

    }
    static function FormControlеTextarea($name, $label, string $attrs)
    {
        return '<div class="form-control">
            <label for="' . $name . '">' . $label . '</label>
            <textarea name="' . $name . '" ' . $attrs . '></textarea>
        </div>';

    }
    static function List($array, bool $is_number, $id_name = "")
    {
        $res = "";
        foreach ($array as $key => $value) {
            if ($id_name != "")
                $res .= "<li id='" . $id_name . "_" . $key . "'>" . $value . "</li>";
            else
                $res .= "<li>" . $key . "</li>";
        }
        $tag = $is_number ? "ol" : "ul";
        return "<$tag>" . $res . "</$tag>";
    }

}