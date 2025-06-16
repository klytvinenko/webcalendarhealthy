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
    static function FormMessageNotValid($name)
    {
        return isset($_SESSION['message'][$name]) ? '<p class="valid-message"> ' . $_SESSION['message'][$name] . ' </p>' : '';
    }

    static function FormClearMessages()
    {
        unset($_SESSION['message']);
        unset($_SESSION['not_valid']);
        unset($_SESSION['old_values']);
    }
    static function FormControlSelect($name, $label, string $attrs, array $array, string $firstOption = "Оберіть...")
    {
        $old_value = isset($_SESSION['old_values'][$name]) ? 'value="' . $_SESSION['old_values'][$name] . '"' : null;
        $options = '';
        $is_multiple = str_contains($attrs, 'multiple');
        foreach ($array as $value) {
            $text = isset($value['title']) ? $value['title'] : $value['name'];
            // $selected=$old_value==$value['id']?'selected':'';
            $selected = '';
            if (!is_null($old_value)) {
                if ($is_multiple)
                    in_array($value['id'], (array) $old_value) ? ' selected' : '';
                else
                    $value["id"] == $old_value ? ' selected' : '';
            }
            if (isset($value['checked'])) {
                if ($value['checked'])
                    $selected = 'selected';
            }
            $options .= '<option value="' . $value['id'] . '"  ' . $selected . '>' . $text . '</option>';
        }
        return '<div class="form-control">
        <label for="' . $name . '">' . $label . '</label>
        <select name="' . $name . '" ' . $attrs . '>
        <option value="">' . $firstOption . '</option>
        ' . $options . '</select>
        </div>';
    }
    static function FormControlSelectSearch(string $id, string $label, string $route, string $attrs = "")
    {
        return '<div class="form-control">
        <label for="' . $id . '">' . $label . '</label>
        <input type="text" id="' . $id . '" oninput="SearchSelect(\'' . $route . '\',this)" ' . $attrs . ' placeholder="Пошук..">
        <ul class="dropdown hidden" id="select_search_dropdown"></ul>
        <p id="select_search_valid_message" class="valid-message hidden">Не обрано продукту!</p>
    </div>';
    }
    static function FormControlInput($name, $label, string $inputType, string $attrs)
    {
        $old_value = isset($_SESSION['old_values'][$name]) ? 'value="' . $_SESSION['old_values'][$name] . '"' : '';
        if ($inputType != "checkbox" && $inputType != "radiobutton") {
            return '<div class="form-control"><label for="' . $name . '">' . $label . '</label><input type="' . $inputType . '" name="' . $name . '" ' . $attrs . ' ' . $old_value . '></div>';
        } else {
            return '<div class="form-control"><br><label for="' . $name . '"><input type="' . $inputType . '" name="' . $name . '" ' . $attrs . ' ' . $old_value . '>' . $label . '</label></div>';
        }

    }
    static function FormControlTextarea($name, $label, string $attrs, $value = "")
    {
        return '<div class="form-control">
            <label for="' . $name . '">' . $label . '</label>
            <textarea name="' . $name . '" ' . $attrs . '>' . $value . '</textarea>
        </div>';

    }
    static function Pagination($item_on_page, $table, $link)
    {
        $res = '';
        $page = $_GET['page'] ?? 1;
        // unset($_SESSION['tables_lengths']);
        $items_length = DB::selectByQuery('SELECT count(id) as count_ FROM '.$table.';')[0]['count_'];
        // if ($items_length == 0) {
        //     $items_length = DB::selectByQuery('SELECT count(id) as count_ FROM '.$table.';')[0]['count_'];
        //     $_SESSION['tables_lengths'][$table] = $items_length;
        // }
        $last_page = round($items_length / $item_on_page) ;
        $last_page = ($items_length % $item_on_page)!=0?$last_page:$last_page-1;
        $link .= '?page=';
        $n = $page;
        if ($last_page >= 5) {
            if ($n == 1 || $n == 2)
                $pages = [1, 2, 3, 4, 5];
            else if ($n == $last_page)
                $pages = [$n - 4, $n - 3, $n - 2, $n - 1, $n];
            else if ($n == ($last_page - 1))
                $pages = [$n - 3, $n - 2, $n - 1, $n, $n + 1];
            else {
                $pages = [$n - 2, $n - 1, $n, $n + 1, $n + 2];
            }

            $links = [
                $link . '1',
                $link . $pages[0],
                $link . $pages[1],
                $link . $pages[2],
                $link . $pages[3],
                $link . $pages[4],
                $link . $last_page
            ];

            $classes = [
                $page == 1 ? 'disabled' : '',
                $page == 1 ? 'active' : '',
                $page == 2 ? 'active' : '',
                $pages == [$n - 2, $n - 1, $n, $n + 1, $n + 2] ? 'active' : '',
                $page == ($last_page - 1) ? 'active' : '',
                $page == $last_page ? 'active' : '',
                $page == $last_page ? 'disabled' : ''
            ];

            $central_links = '';
            for ($i = 0; $i < 5; $i++) {
                $central_links .= '<a href="' . $links[$i + 1] . '" class="' . $classes[$i + 1] . '">' . $pages[$i] . '</a>';
            }

            $res = '<div class="text-center w-full"><div class="pagination"><a href="' . $links[0] . '" class="' . $classes[0] . '">&laquo;</a>' . $central_links . '<a href="' . $links[6] . '" class="' . $classes[6] . '">&raquo;</a></div></div>';

        } else if ($last_page == 4) {
            $pages = [1, 2, 3,4];
        

            $links = [
                $link . '1',
                $link . $pages[0],
                $link . $pages[1],
                $link . $pages[2],
                $link . $pages[3],
                $link . $last_page
            ];
    
            $classes = [
                $page == 1 ? 'disabled' : '',
                $page == 1 ? 'active' : '',
                $page == 2 ? 'active' : '',
                $page == 3 ? 'active' : '',
                $page == 4 ? 'active' : '',
                $page == $last_page ? 'disabled' : ''
            ];
    
            $central_links = '';
            for ($i = 0; $i < 4; $i++) {
                $central_links .= '<a href="' . $links[$i + 1] . '" class="' . $classes[$i + 1] . '">' . $pages[$i] . '</a>';
            }
    
            $res = '<div class="text-center w-full"><div class="pagination"><a href="' . $links[0] . '" class="' . $classes[0] . '">&laquo;</a>' . $central_links . '<a href="' . $links[5] . '" class="' . $classes[5] . '">&raquo;</a></div></div>';
    
        } else if ($last_page == 3) {
            
            $pages = [1, 2, 3];
        

        $links = [
            $link . '1',
            $link . $pages[0],
            $link . $pages[1],
            $link . $pages[2],
            $link . $last_page
        ];

        $classes = [
            $page == 1 ? 'disabled' : '',
            $page == 1 ? 'active' : '',
            $page == 2 ? 'active' : '',
            $page == 3 ? 'active' : '',
            $page == $last_page ? 'disabled' : ''
        ];

        $central_links = '';
        for ($i = 0; $i < 3; $i++) {
            $central_links .= '<a href="' . $links[$i + 1] . '" class="' . $classes[$i + 1] . '">' . $pages[$i] . '</a>';
        }

        $res = '<div class="text-center w-full"><div class="pagination"><a href="' . $links[0] . '" class="' . $classes[0] . '">&laquo;</a>' . $central_links . '<a href="' . $links[4] . '" class="' . $classes[4] . '">&raquo;</a></div></div>';

        } else if ($last_page == 2) {
                $pages = [1, 2];

            $links = [
                $link . '1',
                $link . $pages[0],
                $link . $pages[1],
                $link . $last_page
            ];

            $classes = [
                $page == 1 ? 'disabled' : '',
                $page == 1 ? 'active' : '',
                $page == 2 ? 'active' : '',
                $page == $last_page ? 'disabled' : ''
            ];

            $central_links = '';
            for ($i = 0; $i < 2; $i++) {
                $central_links .= '<a href="' . $links[$i + 1] . '" class="' . $classes[$i + 1] . '">' . $pages[$i] . '</a>';
            }

            $res = '<div class="text-center w-full"><div class="pagination"><a href="' . $links[0] . '" class="' . $classes[0] . '">&laquo;</a>' . $central_links . '<a href="' . $links[3] . '" class="' . $classes[3] . '">&raquo;</a></div></div>';

        } else if ($last_page == 1) {
                $pages = [1];

            $links = [
                $link . '1',
                $link . $pages[0],
                $link . $last_page
            ];

            $classes = [
                $page == 1 ? 'disabled' : '',
                $page == 1 ? 'active' : '',
                $page == $last_page ? 'disabled' : ''
            ];

            $central_links = '<a href="' . $links[1] . '" class="' . $classes[1] . '">' . $pages[0] . '</a>';
            

            $res = '<div class="text-center w-full"><div class="pagination"><a href="' . $links[0] . '" class="' . $classes[0] . '">&laquo;</a>' . $central_links . '<a href="' . $links[2] . '" class="' . $classes[2] . '">&raquo;</a></div></div>';

        }


        return $res;


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
    public static function Button($title = "Зберегти"): string
    {
        return '<div class="row j-c-end w-full"><button class="button button-save" type="submit">' . $title . '</button></div>';
    }
    public static function ButtonAPI($afterFunction = "")
    {
        return '<div class="row j-c-end w-full"><button class="button button-save" type="button" onclick="Ajax.Post(this,' . $afterFunction . ')">Зберегти</button></div>';
    }

}