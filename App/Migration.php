<?php
namespace App;

use Exception;



enum FieldType: string
{
    case INTEGER = 'INT';              // ціле число
    case TEXT = 'VARCHAR(255)';        // текст обмеженої довжини
    case REAL = 'DOUBLE';              // дійсне число
    case BLOB = 'BLOB';
    case BOOL = 'BOOL';            // булеве значення
    case NULL = 'NULL';                // NULL тип — рідко використовується явно

    case DATE = 'DATE';
    case DATETIME = 'DATETIME';
}

class Migration
{
    private static $tables = [
        "users" => [
            ["login", FieldType::TEXT, true],
            ["email", FieldType::TEXT, true],
            ["password", FieldType::TEXT, true],
            ["sex", FieldType::TEXT],
            ["height", FieldType::INTEGER],
            ["age", FieldType::INTEGER],
            ["date_of_birth", FieldType::TEXT, true],
            ["activity_level", FieldType::TEXT, true],
            ["norms", FieldType::TEXT, true],
        ],
        "products" => [
            ["title", FieldType::TEXT],
            ["kcal", FieldType::REAL],
            ["fat", FieldType::REAL],
            ["carbonation", FieldType::REAL],
            ["protein", FieldType::REAL],
            ["na", FieldType::REAL],
            ["cellulose", FieldType::REAL],
            ["type", FieldType::TEXT],
        ],
        "recipes" => [
            ["user_id", FieldType::INTEGER, true, "users"],
            ["title", FieldType::TEXT, true],
            ["description", FieldType::TEXT],
            ["type", FieldType::TEXT],
        ],
        "weigths" => [
            ["user_id", FieldType::INTEGER, true, "users"],
            ["weigth", FieldType::INTEGER, true],
            ["date_of_update", FieldType::TEXT, true],
        ],
        "workouts" => [
            ["title", FieldType::TEXT, true],
            ["description", FieldType::TEXT],
            ["kcal", FieldType::TEXT],
        ],
        "workouts_user" => [
            ["user_id", FieldType::INTEGER, true, "users"],
            ["workout_id", FieldType::INTEGER, true,"workouts"],
            ["start_datetime", FieldType::DATETIME, true],
            ["end_datetime", FieldType::DATETIME, true],
        ],
        "diets" => [
            ["name", FieldType::TEXT, true],
            ["description", FieldType::TEXT],
        ],
        "allergies" => [
            ["name", FieldType::TEXT, true],
        ],
        "meals" => [
            ["user_id", FieldType::INTEGER, true, "users"],
            ["recipe_id", FieldType::INTEGER, false, "recipes"],
            ["product_id", FieldType::INTEGER, false, "products"],
            ["date", FieldType::TEXT, true],
            ["time", FieldType::TEXT, true],
            ["weigth", FieldType::INTEGER],
        ],
        "users_diets" => [
            ["user_id", FieldType::INTEGER, true, "users"],
            ["diet_id", FieldType::INTEGER, true, "diets", "diets"],
        ],
        "users_allergies" => [
            ["user_id", FieldType::INTEGER, true, "users"],
            ["allergy_id", FieldType::INTEGER, true, "allergies"],
        ],
        "recipe_in_diets" => [
            ["diet_id", FieldType::INTEGER, true, "diets"],
            ["recipe_id", FieldType::INTEGER, true, "recipes"],
        ],
        "products_in_recipes" => [
            ["user_id", FieldType::INTEGER, true, "users"],
            ["recipe_id", FieldType::INTEGER, true, "recipes"],
            ["product_id", FieldType::INTEGER, true, "products"],
            ["weight", FieldType::REAL, true],
        ],
        "product_in_diets" => [
            ["diet_id", FieldType::INTEGER, true, "diets"],
            ["product_id", FieldType::INTEGER, true, "products"],
        ],
        "allergies_on_products" => [
            ["product_id", FieldType::INTEGER, true, "products"],
            ["allergy_id", FieldType::INTEGER, true, "allergies"],
        ],
        "liked_products" => [
            ["user_id", FieldType::INTEGER, true, "users"],
            ["product_id", FieldType::INTEGER, true, "products"],
        ],
        "liked_recipes" => [
            ["user_id", FieldType::INTEGER, true, "users"],
            ["recipe_id", FieldType::INTEGER, true, "recipes"],
        ]
    ];
    private static $insert_data = [
        [
            'table' => 'diets',
            'query' => "INSERT INTO diets (name) VALUES ('Набір ваги'), ('Скинення ваги'), ('Схований діабет'), ('Гастрит'), ('Виразка')",
        ],
        [
            'table' => 'allergies',
            'query' => "INSERT INTO allergies (name) VALUES ('Риба'), ('Горіхи'), ('Молочні продукти'), ('Соя'), ('Яйця'),('Арахіс'),('Глютен')",
        ],
        [
            'table' => 'products',
            'query' => "INSERT INTO products (title,kcal,fat,carbonation,protein,na,cellulose,type) VALUES 
            ('Apple',60,9,20,3,2,3,'product'),
            ('Oil',54,8,5,6,2,13,'ingredient'),
            ('Egg',91,2,35,9,1,2,'ingredient'),
            ('Milk',91,2,34,5,2,3,'product'),
            ('Rice',92,3,7,4,5,12,'ingredient'),
            ('Potato',129,3,45,9,2,13,'ingredient')",
        ],
        [
            'table' => 'product_in_diets',
            'query' => 'INSERT INTO product_in_diets(product_id,diet_id) VALUES 
            (1,1),(2,1),(3,1),
            (3,2),(6,2),
            (1,3),(2,3),(6,3),
            (3,4),(4,4),(5,4),
            (1,5),(2,5)',
        ],
        [
            'table' => 'recipes',
            'query' => "INSERT INTO recipes (user_id,title,description,type) VALUES 
            (1,'Apple pie','Very tasty','maindish'),
            (1,'Egg salad','Very tasty','maindish'),
            (1,'Milk shake','Very tasty','maindish'),
            (1,'Rice porridge','Very tasty','maindish'),
            (1,'Potato salad','Very tasty','maindish'),
            (1,'Oil salad','Very tasty','maindish'),
            (1,'Apple salad','Very tasty','maindish'),
            (1,'Rice salad','Very tasty','maindish'),
            (1,'Potato salad','Very tasty','maindish'),
            (1,'Oil salad','Very tasty','maindish')",
        ],
        [
            'table' => 'recipe_in_diets',
            'query' => 'INSERT INTO recipe_in_diets(recipe_id,diet_id) VALUES 
            (1,1),(1,3),
            (2,1),(2,4),
            (3,2),(3,4),
            (4,3),(4,4),(4,5),
            (5,1),(5,4),
            (6,3),(6,5),
            (7,2),(7,3),
            (8,4),
            (9,1),(9,4),(9,5),
            (10,2),(10,3)
            ',
        ],
        [
            'table' => 'allergies_on_products',
            'query' => 'INSERT INTO allergies_on_products(product_id,allergy_id) VALUES 
            (3,1),(1,1),
            (6,2),(2,2),(4,2),
            (1,3),(2,3),
            (4,4),(3,4),
            (5,5),(3,5)',
        ],
        [
            'table' => 'products_in_recipes',
            'query' => 'INSERT INTO products_in_recipes (user_id,recipe_id,product_id,weight) VALUES 
            (1,1,1,20),(1,1,2,50),(1,1,3,300),
            (1,2,3,200),(1,2,4,100),(1,2,5,50),
            (1,3,4,200),(1,3,5,100),(1,3,6,50),
            (1,4,5,200),(1,4,6,100),(1,4,1,50),
            (1,5,6,200),(1,5,1,100),(1,5,2,50),
            (1,6,1,200),(1,6,2,100),(1,6,3,50),
            (1,7,2,200),(1,7,3,100),(1,7,4,50),
            (1,8,3,200),(1,8,4,100),(1,8,5,50),
            (1,9,4,200),(1,9,5,100),(1,9,6,50),
            (1,10,5,200),(1,10,6,100),(1,10,1,50),
            (1,11,6,200),(1,11,1,100),(1,11,2,50),
            (1,12,1,200),(1,12,2,100),(1,12,3,50)',
        ],
    ];

    static function run()
    {
        if (!isset($_SESSION['migration'])) {
            //create tables
            foreach (self::$tables as $key => $data) {
                self::createTable($key, $data);
            }
            //fill tables
            foreach (self::$insert_data as $item) {
                self::fillTable($item['table'], $item['query']);
            }
            $admin_password = md5('secret123');
            $user_password = md5('123456');
            self::fillTable($item['users'], "INSERT INTO users(login,email,password) VALUES ('admin','testuser@test.com','$admin_password'),('user','testuser@test.com','$user_password');");
            $_SESSION['migration'] = true;
        }
    }
    static function reset()
    {
        foreach (Migration::$tables as $key => $data) {
            if (DB::selectOne("$key") != false)
                DB::query("DROP TABLE `$key`;");
        }
        unset($_SESSION['migration']);
    }
    static function getFieldPK()
    {
        return "id INT AUTO_INCREMENT PRIMARY KEY";
    }

    static function getFieldFK($name, $table)
    {
        return "FOREIGN KEY ($name) REFERENCES $table(id)";
    }
    static function getField($name, $type, $notNull = false): string
    {
        $nullStr = $notNull ? "NOT NULL" : "";
        return "$name {$type->value} $nullStr";
    }
    static function createTable($name, $data)
    {
        $rows_str = self::getFieldPK();
        $fks = [];
        foreach ($data as $row) {
            $rows_str .= ", " . self::getField($row[0], $row[1], );
            if (isset($row[3]))
                array_push($fks, [$row[0], $row[3]]);
        }
        foreach ($fks as $fk) {
            $rows_str .= ", " . self::getFieldFK($fk[0], $fk[1]);
        }
        $query = "CREATE TABLE IF NOT EXISTS $name ($rows_str)";
        DB::query($query);
    }
    static function fillTable($table, $query)
    {
        try {
            $db = DB::connect();
            $check_data = DB::selectOne($table);
            if (!empty($check_data))
                return;
            else
                $db->exec($query);

        } catch (Exception $e) {
            Data::MySQLError($e, $query);
        }
    }

}