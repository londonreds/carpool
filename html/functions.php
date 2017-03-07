<?php

  function create_code () {

    $alphanum = str_split('abcdefghjkmnpqrstuvwxyz23456789');	// leave out 0/O and 1/i/l
    shuffle($alphanum);
    $candidate_code = implode( array_slice($alphanum, 0, 6) );

    return $candidate_code;

  }

  function html_safe ($input) {

		// double encode false means we shouldn't get the problem of
		// &x; becoming &x;x; or similar
		$safe = htmlspecialchars ( $input, ENT_QUOTES, $double_encode = false );

		// bugfix: fix double encoding of ' and " (perhaps because specified ENT_QUOTES?)
		$safe = str_replace("&amp;#039;", "&#039;", $safe);
		$safe = str_replace("&amp;quot;", "&quot;", $safe);
		$safe = str_replace("&amp;amp;", "&amp;", $safe);

		return $safe;

	}

?>
