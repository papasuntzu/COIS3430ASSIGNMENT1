<?php
if (isset($_POST['submit'])) {
    $file = $_FILES['file']['tmp_name'];
    $search = isset($_POST['search']) ? $_POST['search'] : '';

    if (is_uploaded_file($file)) {
        $fileread = fopen($file, 'r');
        $lines = array();
        $matched = array();
        $unmatchedCount = 0;

        // Read file and storing
        while (!feof($fileread)) {
            $line = trim(fgets($fileread));
            if ($line !== "") {
                $lines[] = $line; 
            }
        }
        fclose($fileread);

        // if no search
        if (empty($search)) {
            foreach ($lines as $line) {
                echo "<span><strong>Original String: $line</strong></span>";
                $wordCount = str_word_count($line);
                echo "<div>Number of words: $wordCount</div>";

                // Count letter 'a'
                $aCount = substr_count(strtolower($line), 'a');
                echo "<div>Number of 'a's: $aCount</div>";

                // Count punctuation
                $punct_count = 0;
                for ($i = 0; $i < strlen($line); $i++) {
                    $ascii = ord($line[$i]);
                    if (($ascii >= 33 && $ascii <= 47) || ($ascii >= 58 && $ascii <= 64) ||
                        ($ascii >= 91 && $ascii <= 96) || ($ascii >= 123 && $ascii <= 126)) {
                        $punct_count++;
                    }
                }
                echo "<div>Punctuation count: $punct_count</div>";

                // Sort words in descending order
                $words = explode(' ', $line);
                usort($words, function ($a, $b) {
                    return strtolower($b) <=> strtolower($a);
                });
                echo "<div>Words in descending order: " . implode(' ', $words) . "</div>";

                // Middle third of the string
                $length = strlen($line);
                $third = floor($length / 3);
                $middleStart = $third;
                echo "<div>Middle third: " . substr($line, $middleStart, $third) . "</div>";
            }
        } else {
            // If a search term is provided, output only matching lines
            foreach ($lines as $line) {
                if (stripos($line, $search) !== false) {
                    // Highlight the search term
                    $highlighted = str_ireplace($search, "<span class='highlight'>$search</span>", $line);
                    echo "<div>Search Result: $highlighted</div>";
                    $matched[] = $line;
                } else {
                    $unmatchedCount++;
                }
            }

            // Output the count of lines without the search term
            echo "<div>Number of lines without the search term '<strong>$search</strong>': $unmatchedCount</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Search</title>
    <link rel="stylesheet" href="./styles/part1.css">
    <style>
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form class="formcontainer" action="part1.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="searchlabel">Search: </label>
            <input type="text" name="search" id="searchlabel"><br>
        </div>
        <div>
            <label for="filelabel">Upload File: </label>
            <input type="file" name="file" id="filelabel">
        </div>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
