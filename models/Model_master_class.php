<?php
/**
 * @format
 * esta clase maestra es la encargada de crear los modelos de auerdo ala informacion en la bd
 */

class Model_master_class
{
    protected $db;

    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=localhost;dbname=mydatabase",
            "username",
            "password"
        );
    }

    public function generateModels()
    {
        $tables = $this->db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $fields = $this->db
                ->query("DESCRIBE $table")
                ->fetchAll(PDO::FETCH_COLUMN);

            $modelName = ucfirst($table);
            $modelFile = "models/Model_.$modelName.php";

            $modelContent = "<?php\n\nclass $modelName {\n";
            foreach ($fields as $field) {
                $modelContent .= "\tpublic $$field;\n";
            }
            $modelContent .= "}";

            file_put_contents($modelFile, $modelContent);
        }
    }
}
