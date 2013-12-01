
 <?php
	include('inc/Class.php');
	$ToRssGUI = new ToRssGUI();

		
	// Settings for adding shows or default		
	$settings = array('header' => 'Add',
					  'type' => 'add',
					  'delete' => '');
	
	// Settings for edit shows
	if($_GET['shows']) {
		$data = $ToRssGUI->GetShowData($_GET['shows']);
		$settings = array('header' => 'Edit',
						  'type' => 'edit',
						  'delete' => ' | <a id="white" href="?q=del&show='.$data['name'].'"><span>Delete -</span></a>');
	}

	//CSS Style
//	echo '
//		<style type="text/css">
  //  		.wrap { display:block; border: 1px solid #000; height:365px; width:600px;}
    //		.EditShows { margin: -380px 0 0 100px; width:450px;}
    //		.DisplayShows { margin: 0 0 0 -450px; width:150px; border-right: 1px solid #000;}
    //		.menu { border: 1px solid #000; width: 600px; border-bottom: 0;}
    //		a { text-decoration: none;}
    //	</style>
	//	';

	// Stores values from form
	$values = array('name' => $_GET['Name'], 
					'query' => $_GET['Query'], 
					'ignore' => $_GET['Ignore']);
		
	// Adding shows
	if($_GET['q'] == 'add' && $_GET['Name']) {
		$ToRssGUI->AddShow($values);
	}

	// Edit shows
	if($_GET['q'] == 'edit') {
		$ToRssGUI->EditShow($values);
	}

	// Deleting show		
	if($_GET['q'] == 'del') {
		$ToRssGUI->DeleteShow($_GET['show']);
	}



	echo '<center><h4><a href="index.php">ToRss GUI</a></h4><p>
		<div class="menu">
			<a id="white" href="?q=add"><span>Add +</span></a> 
		</div>
		<div class="wrap">';

	// Gets all shows and display them in dropdown
	echo '
		<form method="get">
			<div class="DisplayShows">
				Shows : <br>
				<select name="shows" size="20">';

				// Get Shows fron JSON file
				echo $ToRssGUI->GetShows();
			
		echo '
				</select><br>
			</div>
		</form>';

		//Displays edit/add options

			echo '
				<form name="options" method="get">
					<div class="EditShows">
						<h4>'.$settings['header'].'</h4>
						<input type="hidden" name="q" value="'.$settings['type'].'">
						Name : <input type="text" name="Name" value="' . $data['name'] . '" size="40"><br>
						Query : <input type="text" name="Query" value="' . $data['query'] . '" size="40"><br>
						Ignore : <input type="text" name="Ignore" value="' . $data['ignore'] . '" size="40"><br>
						<a id="white" href="#" onclick="document.options.submit(); return false"><span>Save</span></a>
						'. $settings['delete'] .'
					</div>
				</form>';
		

	echo '</div></center>';

?>