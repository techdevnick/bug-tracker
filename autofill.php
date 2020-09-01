<?php
	//autofill an indicated html <input>
	//autoFillForm('id') with id being the $_POST['id']
	function autoFillForm($post){
		if(isset($_POST[$post])){
			echo 'value="'.$_POST[$post].'"';
		}else{
			echo 'class="required-form-field"';
		}
	}
	
	//autofill an indicated html <select>
	//autoSelectForm('id','valuename') with id being the $_POST['id'] & valuename being the <option value="valuename"
	function autoSelectForm($post,$value){
		if(isset($_POST[$post])){
			if($_POST[$post] == $value){
				echo 'selected';
			}
		}
	}
	
	//same as above but with return instead of echo
	function autoSelectFormReturn($post,$value){
		if(isset($_POST[$post])){
			if($_POST[$post] == $value){
				return 'selected';
			}
		}
	}
	
	//
	function autoFillDescription($post){
		if(isset($_POST[$post])){
			echo $_POST[$post];
		}
	}
?>