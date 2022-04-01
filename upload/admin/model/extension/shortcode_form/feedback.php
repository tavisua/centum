<?php
class ModelExtensionShortcodeFormFeedback extends Model {
	public function feedbackList() {
        $sql = "select `feedback_id`, `name`, `email`, `phone`,date_format(`date`, '%d.%m.%Y') as date from " . DB_PREFIX . "feedback";
        return $this->db->query($sql)->rows;
	}

    public function deleteFeedbackTable(){
        $sql = "DROP TABLE IF EXISTS " . DB_PREFIX . "feedback;";
        return $this->db->query($sql);
    }
}