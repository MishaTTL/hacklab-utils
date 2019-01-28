<?php

$wgHooks['ParserFirstCallInit'][] = 'ExampleExtension::onParserSetup';

class ExampleExtension {
	// Register any render callbacks with the parser
	public static function onParserSetup( Parser $parser ) {
		$parser->setHook( 'HacklabMemberDatabase', 'ExampleExtension::renderTagSample' );
		return True;
	}

	// Render <sample>
	public static function renderTagSample( $input, array $args, Parser $parser, PPFrame $frame ) {
		$ret = "";
		$role = $args["role"];
		//mysqli_real_escape_string()

		$servername = "localhost";
		$username = "";
		$password = "";
		$dbname = "memberdb";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = "SELECT name,nickname,joindate,comment,contact,interests FROM wiki_people wp JOIN wiki_people2 wp2 ON wp.id=wp2.id WHERE role='$role' ORDER BY name ASC LIMIT 300";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$td = "<td style='border: 1px solid black; text-align: center; vertical-align: middle;'>";

			$ret .= "<table style='border: 1px solid black'>";
			// output data of each row
			while($row = $result->fetch_assoc()) {
                        	$name = $row["name"];
                	        $nickname = $row["nickname"];
        	                $joindate = $row["joindate"];
	                        $comment = $row["comment"];

				$ret .= "<tr>$td<b>$name<br/>[$nickname]<br/>$joindate</b><br/>$comment</td>"
					."$td" .$row["contact"]. "</td>$td" .$row["interests"]. "</td></tr>";
			}
			$ret .= "</table>";
		} else {
			$ret = "0 results";
		}
		$conn->close();

		return $ret;
	}
}

?>
