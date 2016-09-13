<?php

/**
 * Class Project
 *
 * Model for all project
 */
class Project {
    private static $connection;

    public $id;
    public $title;
    public $description;
    public $goal;
    public $start_date;
    public $duration;
    public $owner_id;

    /**
     * Project constructor.
     *
     * @param null $db_connection
     */
    public function Project($project_arr) {
        $this->validateAndSetData($project_arr);
    }

    public function validateAndSetData($project_arr) {
        if (!isset($project_arr['id'])) {
            die("id filed required");
        }
        if (!isset($project_arr['title'])) {
            die("title filed required");
        }
        if (!isset($project_arr['description'])) {
            die("description filed required");
        }
        if (!isset($project_arr['goal'])) {
            die("goal filed required");
        }
        if (!isset($project_arr['start_date'])) {
            die("start_date filed required");
        }
        if (!isset($project_arr['duration'])) {
            die("duration filed required");
        }
        if (!isset($project_arr['owner_id'])) {
            die("owner_id filed required");
        }
        $this->id = $project_arr['id'];
        $this->title = $project_arr['title'];
        $this->description = $project_arr['description'];
        $this->goal = $project_arr['goal'];
        $this->start_date = new DateTime($project_arr['start_date']);
        $this->duration = $project_arr['duration'];
        $this->owner_id = $project_arr['owner_id'];
    }

    /**
     * Get the project blonging categories
     *
     */
    public function getCategories() {
        $sql = sprintf("SELECT * FROM category c WHERE EXISTS (SELECT * FROM project_category pc WHERE pc.project_id = %d AND pc.category_id = c.id)", $this->id);
        $categories = array();
        $results = self::$connection->execute($sql);
        foreach ($results as $category_arr) {
            array_push($categories, new Category($category_arr));
        }
        return $categories;
    }

    /**
     * Get owner of this project
     */
    public function getOwner() {

    }

    /**
     * Check global connection
     */
    public static function checkConnection() {
        global $gb_connection;
        if ($gb_connection) {
            self::$connection = $gb_connection;
        } else {
            die("No valid db connection");
        }
    }

    /**
     * Get all data from the database
     *
     * @return array
     */
    public static function getAll() {
        self::checkConnection();
        $sql = "SELECT * FROM project;";
        if(isset($_GET['_category'])) {
            $category_id = $_GET['_category'];
            settype($category_id, 'integer');
            $sql = sprintf("SELECT * FROM project WHERE id IN (SELECT project_id FROM project_category WHERE category_id = %d)", $category_id);
        }
        $results = self::$connection->execute($sql);
        $projects = array();
        foreach ($results as $project_arr) {
            array_push($projects, new Project($project_arr));
        }
        return $projects;
    }

    /**
     * Get a specific project by id
     */
    public static function getProjectById($id) {
        self::checkConnection();
        settype($id, 'integer');
        $sql = sprintf("SELECT * FROM project WHERE id = %d", $id);
        $results = self::$connection->execute($sql);
        if (count($results)) {
            return new Project($results[0]);
        } else {
            return null;
        }
    }

}