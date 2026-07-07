<?php

class Branch extends BranchBase {

    public $file;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Before validating a record, assign an uploaded file name to the 'filename' column if 'file' is not empty.
     * @return boolean whether the validation should be executed.
     */
    protected function beforeValidate() {
        if (parent::beforeValidate()) {
            if ($this->file) {
                $this->filename = $this->file->name;
            }

            return true;
        } else {
            return false;
        }
    }

}