<?
class ToRssGUI {
	var $data = NULL;

	function JSONFile() {
		$file = json_decode(file_get_contents("../inc/shows.json"),true);
		return $file;
	}

	function SaveJSON($output) {
		// sort output
		uksort($output, 'strcasecmp');

		// outputs array to file
		json_encode($output);
		file_put_contents('../inc/shows.json', json_encode($output));
	}
	
	function GetShows() {
		
		foreach ($this->JSONFile() as $key => $value) {
			$result .= '<option value="' . $key . '" onclick="document.forms[0].submit(); return false">' . $key . '</option>';
		}
		return $result;
	}


	function GetShowData($show) {
		foreach ($this->JSONFile() as $key => $value) {
		    if ($key == $show) {
		        $data = array(
		        		'name' => $key,
						'query' => $value['query'],
						'ignore' => $value['ignore']);
		    }
		}
		return $data;
	}

	function DeleteShow($show) {
		$file = $this->JSONFile();
		
		// Clean showname from form
		$ShowName = $this->replacestring($show);

		// Removes show from file
		unset($file[$ShowName]);

		// lists all values, and create new array
		foreach ($file as $key => $value) {
		        $output[$key] = array(
		        		'query' => $value['query'],
						'ignore' => $value['ignore']);
		}
		$this->SaveJSON($output);		
	}

	function AddShow($values) {
		$file = $this->JSONFile();

		$ShowName = $this->replacestring($values['name']);

		$output[$ShowName] = array(
        		'query' => $values['query'],
				'ignore' => $values['ignore']);
		
		// lists all values, and create new array
		foreach ($file as $key => $value) {
	        $output[$key] = array(
	        		'query' => $value['query'],
					'ignore' => $value['ignore']);
		}

		$this->SaveJSON($output);	
	}

	function EditShow($show) {
		foreach ($this->JSONFile() as $key => $value) {
		    if ($key == $show['name']) {
		    	$this->DeleteShow($show['name']);
		        $this->AddShow($show);
		    }
		}
	}

	function replacestring($data) {
		$result = str_replace("%20", " ", $data);
		return $result;
	}
}
?>