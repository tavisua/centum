<?php
class ModelExtensionShortcodeFormFeedback extends Model {
	public function saveFeedback($params) {
        return $this->db->query("INSERT INTO " . DB_PREFIX . "feedback SET 
        `name` = '" . $this->db->escape($params['name']) ."', 
        `email`= '" . $this->db->escape($params['email']) ."', 
        `phone`= '" . $this->db->escape($params['phone']) ."',
        `date` = now()");
	}
}