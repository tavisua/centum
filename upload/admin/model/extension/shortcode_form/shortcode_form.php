<?php
class ModelExtensionShortcodeFormShortcodeForm extends Model {
	public function createFeedbackTable() {
        $sql = "create table " . DB_PREFIX . "feedback
            (
                feedback_id int auto_increment,
                name        varchar(255)           not null,
                email       varchar(50) default '' null,
                phone       varchar(25)            null,
                date        datetime               null,
                constraint " . DB_PREFIX . "feedback_pk
                    primary key (feedback_id)
            );";
        $this->db->query($sql);
	}

    public function deleteFeedbackTable(){
        $sql = "DROP TABLE IF EXISTS " . DB_PREFIX . "feedback;";
        return $this->db->query($sql);
    }
}