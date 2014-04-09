
<?php echo $this->tag->form(array("Facedetector/detect", "autocomplete" => "off", "enctype" => "multipart/form-data")) ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td colspan="2" align="center">
			<h1>Human Face detector</h1>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" >
			<?php echo $this->getContent(); ?>
			<br />
		</td>
	</tr>
	<tr>
		<td width="40%" align="right">
			<label for="file">Select File</label>
		</td>
		<td width="60%" >
			<?php echo $this->tag->fileField(array("file", "class" => "marginLeft20")) ?>
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td class="toppadding">
			<?php echo $this->tag->submitButton(array("Submit", "class" => "marginLeft20")) ?>
		</td>
	</tr>
</table>
</form>

