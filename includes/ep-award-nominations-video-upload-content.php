<p>Here, you can really shine. Upload a short 30 to 90 second video of you, your business, or your products and services. This video counts towards at least 10% of the judges total, depending on the category of your nomination.</p>

<p>Note: Your video will be put on display the night of the awards ceremony, so put your best foot forward.</p><p>The file upload size is limited to 250MB.</p>

<form name="upload_form" id="upload_form" method="POST" enctype="multipart/form-data">
<input type="file" name="images[]" id="images" accept="image/*" multiple>
<?php wp_nonce_field('image_upload', 'image_upload_nonce');?>
<input type="submit" value="upload">
</form>
<span id="status"></span>
<ul id="images_wrap">
<!-- Images will be added here -->
</ul>
