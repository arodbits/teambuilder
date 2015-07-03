<?php 
echo "<h1>Enter the range to generate the TEAM DISTRIBUTION</h1>";
$this->load->helper('form');
echo form_open('tournament');
echo "<div>";
echo form_label('Enter the min Range', 'minRange');
echo form_input('minRange');
echo "</div>";
echo "<div>";
echo form_label('Enter the max Range', 'maxRange');
echo form_input('maxRange');
echo "</div>";
echo "<div>";
echo form_submit('send', 'Generate Teams!');
echo "</div>";
?>


