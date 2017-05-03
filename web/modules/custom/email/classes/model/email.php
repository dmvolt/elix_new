<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Email {

    protected $errors = array();
    protected $tableName = 'email';

    public function edit($Id, $data = array()) {
        $data = Arr::extract($data, array('title', 'body'));
        $vData = $data;
        $validation = Validation::factory($vData);
        $validation->rule('title', 'not_empty');
        $validation->rule('title', 'min_length', array(':value', '3'));
        $validation->rule('title', 'max_length', array(':value', '64'));

        if (!$validation->check()) {
            $this->errors = $validation->errors('catErrors');
            return FALSE;
        }

        $query = DB::query(Database::UPDATE, 'UPDATE ' . $this->tableName . ' SET `title` = :title, `body` = :body WHERE `id` = :id')
                ->parameters(array(
                    ':id' => $Id,
                    ':title' => Security::xss_clean($data['title']),
                    ':body' => $data['body']
                ))
                ->execute();

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Get all emailes
     * @return array
     */
    public function get_all() {
        return DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName)
                        ->execute();
    }

    public function get_content($id) {
        $query = DB::query(Database::SELECT, "SELECT * FROM " . $this->tableName . " WHERE `id` = :id", FALSE)
                ->param(':id', (int) $id)
                ->execute();

        $result = $query->as_array();

        if ($result) {
            return $result[0];
        } else {
            return FALSE;
        }
    }

}