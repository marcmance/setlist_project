<?php
	require_once('/connection2.php');
	class Model {
		protected $mysqli;
		protected $fields_array;
		protected $fields_var;
		protected $table_name;
		protected $join_array; //when join function gets called
		protected $where_array;
		protected $order_statement;
		
		public function __construct() {
			$this->mysqli = new mysqli(HOST_DB, USERNAME_DB, PASSWORD_DB, NAME_DB);
			$this->table_name = strtolower(get_class($this));
			//$this->makeProperties();
			$this->join_array = array();
			$this->where_array = array();
		}
		
		public function __destruct(){
			$this->mysqli->close();
		}
		
		//defunct i believe
		public function makeProperties() {
			if(isset($this->fields_array)) {
				foreach($this->fields_array as $k) {
					$this->{$k} = "";
				}
			}
		}
		
		public function findAll($select_fields = null) {
			if($select_fields == null) {
				$select_fields = $this->fields_array;
			}
			
			//check to see if joins exists, if so add to the query
			$join_statement = "";
			$fields = "";
			if(!empty($this->join_array)) {
				$new_join_array = $this->_join();
				$join_statement = $new_join_array[0];
				$fields = implode(",",array_map(array($this, 'appendTableName'),$select_fields));
				$fields .= ",". $new_join_array[1];
			}
			else {
				$fields = implode(",",$select_fields);
			}
			
			//check to see if where is populated
			$params = null;
			$where_statement = "";
			if(!empty($this->where_array)) {
				$new_where_array = $this->_where();
				$params = $new_where_array[0];
				$where_statement = $new_where_array[1];
			}

			$query = "SELECT ".$fields ." FROM ". $this->table_name . " " . $join_statement . " " . $where_statement . " " . $this->order_statement;
			//echo $query;
			return $this->query($query, $params);
		}

		/**
		 * Find a single record.
		 *
		 * @param string  $param The value to search by
		 * @param string $find_by_column The column to search by
		 * @param array $select_fields The fields to select
		 *
		 * @return query result
		 */
		public function find($param, $find_by_column = null, $select_fields = null) {
			//if no input, select *
			if($select_fields == null) {
				$select_fields = $this->fields_array;
			}

			//default to primary key id
			if($find_by_column == null || $find_by_column == $this->table_name . "_id") {
				$param = intval($param); 
				$find_by_column = $this->table_name . "_id";
			}

			$join_statement = "";
			$fields = "";
			if(!empty($this->join_array)) {
				$new_join_array = $this->_join();
				$join_statement = $new_join_array[0];
				$fields = implode(",",array_map(array($this, 'appendTableName'),$select_fields));
				$fields .= ",". $new_join_array[1];
			}
			else {
				$fields = implode(",",$select_fields);
			}
			
			$query = "SELECT ".$fields ." FROM ". $this->table_name . " " . $join_statement . " WHERE " . $find_by_column . " = ? LIMIT 1";
			$params = array($param);
			return $this->query($query, $params);
		}
		
		public function join($table, $select_fields = null) {
			if($select_fields != null) {
				foreach($select_fields as $k => $v) {
					//remove primary key to avoide dups
					if($v == $table . "_id") {
						unset($select_fields[$k]);
					}
					else {
						$select_fields[$k] = $table.".".$v;
					}
				}
			}
			$this->join_array[$table] = $select_fields;
			return $this;
		}
		
		public function where($field, $param, $operator = "=") {
			if(in_array($field, $this->fields_array)) {
				//error check operator
				if($operator != "=" && $operator != "!=" && $operator != "<" && $operator != ">") {
					$operator = "=";
				}
				$arr = array($param,$operator);
				$this->where_array[$field] = $arr;
			}
			return $this;
		}

		public function _where() {
			//new_where_array [0] = Array of params for "Bind Params"
			//new_where_array[1] = Where query
			$new_where_array = array(array(),"WHERE ");
			if(!empty($this->where_array)) {
				foreach($this->where_array as $field => $param) {
					array_push($new_where_array[0], $param[0]);
					if($field != end(array_keys($this->where_array))) {
						$new_where_array[1] .= $this->table_name . "." . $field ." ". $param[1] ."  ? AND ";
					}
					else {
						$new_where_array[1] .= $this->table_name . "." . $field ." ". $param[1] ." ?";
					}
				}
			}
			$this->where_array = array(); //reset join
			
			return $new_where_array;
		}

		public function order($field, $order) {
			if(in_array($field, $this->fields_array)) {
				$this->order_statement = "ORDER BY " . $field;
				if($order) {
					$this->order_statement .= " ASC";
				}
				else {
					$this->order_statement .= " DESC";
				}
			}
			return $this;
		}
		
		public function query($query, $params = null) {	
			//echo "<br><b>" . $query . "</b><br/>";	
			if ($stmt = $this->mysqli->prepare($query)) {
				if($params != null) {
					call_user_func_array(array($stmt,'bind_param'),$this->bind_params($params));
				}
				$stmt->execute();
				$stmt->store_result();
				$results = $this->bind_results($stmt);
				$stmt->close();
				return $results;
			}
			else {
				echo $query;
				echo "<br/>";
				echo $this->mysqli->error;
			}
		}

		public function rawQuery($query) {

	
		}
		
		protected function appendTableName($field) {
			return $this->table_name . "." . $field;
		}
		
		protected function _join() {
			$new_join_array = array("","");
			if(!empty($this->join_array)) {
				$c = 1;
				foreach($this->join_array as $table => $select_fields) {
					if(!empty($select_fields)) {
						$new_join_array[1].= implode(",",$select_fields);
						if($c != count($this->join_array)) {
							$new_join_array[1].= ",";
						}						
					}
					$new_join_array[0] .= "JOIN " . $table . " ON " . $table . "." . $table ."_id = " . $this->table_name . "." . $table . "_id ";
					$c++;
				}
			}
			$this->join_array = array(); //reset join
			return $new_join_array;
		}		
		
		//dynamic function bind params
		protected function bind_params($params) {
			$binded_params = array('');                       
			foreach($params as $p) {  
				if(is_int($p)) {
					$binded_params[0] .= 'i';              //integer
				} elseif (is_float($p)) {
					$binded_params[0] .= 'd';              //double
				} elseif (is_string($p)) {
					$binded_params[0] .= 's';              //string
				} else {
					$binded_params[0] .= 'b';              //blob and unknown
				}
				array_push($binded_params, $p);
			}
			
			$refs = array();
			foreach ($binded_params as $key => $value) {
				$refs[$key] = & $binded_params[$key];
			}
			return $refs;
		}
		
		//dynamic function bind all fields
		protected function bind_results($stmt) {
			$fields_var = array();
			$results = null;
			
			$meta = $stmt->result_metadata();
			while ($field = $meta->fetch_field()) {
				$field_name = $field->name;
				$$field_name = null;
				$fields_var[$field_name] = &$$field_name;
			}
			call_user_func_array(array($stmt,'bind_result'),$fields_var);
			$results = array();
			
			if($stmt->num_rows == 1) {
				$stmt->fetch();
				$results['singleRecord'] = true;
				foreach($fields_var as $k => $v) {
					$results[$k] = $v;
					$this->{$k} = $v;
				}
			}
			else if($stmt->num_rows > 1) {
				$i = 0;
				while($stmt->fetch()) {
					$results[$i] = array();
					foreach($fields_var as $k => $v) {
						$results[$i][$k] = $v;
					}
					$i++;
				}
			}
			return $results;
		}
	}

?>