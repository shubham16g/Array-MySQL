<?php
class ArrayMySQL {
	
	// private $conn;
	private const COLON = "'";
	
	public function __construct(mysqli $db) {
		$db->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, TRUE);
		$this->db = $db;
	}

	public function isConnected(){
		if ($this->db->isConnected()) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteSQL($table, $extras) {
		$query = `DELETE FROM $table $extras`;
		return $this->staticSQL($query);
	}

	public function updateSQL($table, $newArr, $extras)	{
		$str = "";
		foreach ($newArr as $key => $value) {
			$value = $this->escapeColonSQL($value);
			$str = "$str $key = $value,";
		}
		$str = substr($str, 0, -1);

		$query = "UPDATE $table SET $str $extras";
		return $this->staticSQL($query);
	}

	public function insertSQL($table, $valueArr) {
		$columns = "";
		$values = "";
		foreach ($valueArr as $key => $value) {
			// $key = $this->escapeColonSQL($key);
			$value = $this->escapeColonSQL($value);
			$columns = "$columns$key, ";
			$values = "$values$value, ";
		}
		$columns = substr($columns, 0,-2);
		$values = substr($values, 0,-2);
		$query = "INSERT INTO $table ($columns) VALUES ($values)";
		return $this->staticSQL($query);
		
	}

	public function selectSQL($table, $columns, $extras){
		return $this->arraySQL("SELECT $columns FROM $table $extras");
	}

	public function selectPageSQL($table, $columns, $extras, $itemPerPage, $page){
		$offset = ($page - 1) * $itemPerPage;
		return $this->arraySQL("SELECT $columns FROM $table $extras LIMIT $offset, $itemPerPage");
	}

	public function getPagesCount($table, $extras, $itemPerPage){
        $total_rows = $this->countSQL($table, $extras);
        $total_pages = ceil($total_rows / $itemPerPage);
        return (int) $total_pages;
    }

    public function countSQL($table, $extras) {
    	$result_pages = $this->db->query("SELECT count(*) FROM $table $extras");
    	return (int) $result_pages->fetch_array()[0];
    }

	public function staticSQL($query){
		if ($this->runSQL($query)) {
			return true;
		}
		else{
			return false;
		}
	}

	public function arraySQL($query){
		$res = $this->runSQL($query);
		if (!$res) {
			return null;
		}
		$arr = array();
		while ($row = $res->fetch_assoc()) {
			$arr[] = $row;
		}

		// todo
		// mysqli_free_result($res);
		return $arr;
	}

	public function escapeSQL($value){
		return $this->db->real_escape_string($value);	
	}

	private function escapeColonSQL($value) {
		$RR = self::COLON;
		return "$RR" . $this->escapeSQL($value) . "$RR";
	}

	private function runSQL($query){
		$res = $this->db->query($query);
		return $res;
	}

	public function close()
	{
		$this->db->close();
	}
}	
?>