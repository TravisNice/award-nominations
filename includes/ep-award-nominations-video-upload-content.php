<p>Here, you can really shine. Upload a short 30 to 90 second video of you, your business, or your products and services. This video counts towards at least 10% of the judges total, depending on the category of your nomination.</p>

<p>Note: Your video will be put on display the night of the awards ceremony, so put your best foot forward.</p><p>The file upload size is limited to 250MB.</p>

<form name="upload_form" id="upload_form" method="POST" enctype="multipart/form-data">

<p><input type="file" name="images[]" id="images" accept="video/mp4,video/*"></p>

<?php wp_nonce_field('image_upload', 'image_upload_nonce');?>

<p><input type="submit" value="Upload" style="margin: 16px 16px 16px 0;"></p>

</form>

<p id="status"></p>

<p><ul style="list-style-type:none;" id="images_wrap"><!-- Videos will be added here --></ul></p>

<form name="continue_form" method="POST" id="continue_form">
<p><button name="video-submit" value="next" style="margin: 16px 16px 16px 0;">Save & Next</button><p>
</form>
