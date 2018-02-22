<?php

require __DIR__ . '/vendor/autoload.php';

use YoutubeDl\YoutubeDl;
use YoutubeDl\Exception\CopyrightException;
use YoutubeDl\Exception\NotFoundException;
use YoutubeDl\Exception\PrivateVideoException;
if (isset($_POST['url'])) {
	
	//var_dump($_POST);
	$dl = new YoutubeDl([
	    'continue' => true, // force resume of partially downloaded files. By default, youtube-dl will resume downloads if possible.
	    'format' => 'bestvideo',
	]);
	// For more options go to https://github.com/rg3/youtube-dl#user-content-options

	$dl->setDownloadPath(__DIR__ . '/Downloads');
	// Enable debugging
	/*$dl->debug(function ($type, $buffer) {
	    if (\Symfony\Component\Process\Process::ERR === $type) {
	        echo 'ERR > ' . $buffer;
	    } else {
	        echo 'OUT > ' . $buffer;
	    }
	});*/
	try {
	    $video = $dl->download($_POST['url']);
	    echo $video->getTitle() . PHP_EOL; // Will return Phonebloks
	    $file = $video->getFile(); // \SplFileInfo instance of downloaded file
	    $filePath = $file->getPathName();
	    $encodedFileName = urlencode(basename($filePath));
	    header('Location: download.php?download=' . $encodedFileName);
	} catch (NotFoundException $e) {
	    // Video not found
	} catch (PrivateVideoException $e) {
	    // Video is private
	} catch (CopyrightException $e) {
	    // The YouTube account associated with this video has been terminated due to multiple third-party notifications of copyright infringement
	} catch (\Exception $e) {
	    // Failed to download
	}

	exit;
}
?>
<!DOCTYPE html>
<html>
<body>

<form action="#" method="post">
  URL<br>
  <input type="text" name="url" value="https://www.youtube.com/watch?v=a4_O9fm0uLg">
  <br>
  
  <input type="submit" value="Download">
</form> 


</body>
</html>
