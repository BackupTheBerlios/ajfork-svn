Default release should contain:

	Default category (id = 0)	- undeletable ("general"?)
	Default template (id = 0)	- undeletable 
	
	
New name: "Allegori"


Features

	Config:
		Txp:
			Comments disabled after set time
			Preview
				Box where you can define some css rules?
				
			
	{latestcommentby}
			
	Photoblogging capability
			(exif support)
			
			
			
			
			

$image = exif_thumbnail("image.jpg", $width, $height, $type);
if ($image!==false) {
   header('Content-type: ' .image_type_to_mime_type($type));
   echo $image;
   }
   
   
	$exifdata = exif_read_data("image.jpg", "IFD0, EXIF");
	
	$img_data = array(
	
	"Make" => $exifdata[Make],
	"Model" => $exifdata[Model],
	"Exposure" => $exifdata[ExposureTime],
	"ISO" => $exifdata[ISOSpeedRatings],
	"Flash" => $exifdata[Flash],
	"Aperture" => $exifdata[COMPUTED][ApertureFNumber],
	"Blackorwhite" => $exifdata[COMPUTED][IsColor],
	"Height" => $exifdata[COMPUTED][Height],
	"Width" => $exifdata[COMPUTED][Width],
	"Size" => formatsize($exifdata[FileSize]),
	);
	
	foreach ($img_data as $d => $i) {
		echo "$d: $i<br />";
		}