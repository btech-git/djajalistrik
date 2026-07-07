<?php

class PackingListHeader extends PackingListHeaderBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getMonthlyUserPackingListReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT i.admin_id, MAX(a.name) AS employee_name, COUNT(i.id) AS packing_quantity
                FROM " . PackingListHeader::model()->tableName() . " i
                INNER JOIN " . Admin::model()->tableName() . " a ON a.id = i.admin_id
                WHERE YEAR(i.date) = :year AND MONTH(i.date) = :month AND i.admin_id IS NOT NULL AND i.is_inactive = 0
                GROUP BY i.admin_id
                ORDER BY MAX(a.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}
