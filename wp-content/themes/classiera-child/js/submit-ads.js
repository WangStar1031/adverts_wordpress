
	jQuery(document).ready(function($) {

		$('#smartwizard').smartWizard({
			transitionEffect: 'fade',
			toolbarButtonPosition: 'right',
			autoAdjustHeight: true,
			useURLhash: true,
			anchorSettings: {
				anchorClickable: true, // Enable/Disable anchor navigation
				enableAllAnchors: true, // Activates all anchors clickable all times
				markDoneStep: true, // add done css
				enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
			},  

			toolbarSettings: {
				toolbarPosition: 'bottom', // none, top, bottom, both
				toolbarButtonPosition: 'right', // left, right
				showNextButton: true, // show/hide a Next button
			}
		});

		$('#checkbox3').click(function() {
			if ($(this).is(':checked')) {
				$('.price-fields').show();
				$('.price-info').hide();
			} else {
				$('.price-fields').hide();
				$('.price-info').show();
			}
		});
		// setTimeout( function(){
			// var width = 255;
			// width = $("#croppic").width();
			// console.log( "width : " + width);
			// $("#croppic").height(width * 343 / 255);

			// var width_double = 510;
			// width_double = $("#croppic-double").width();
			// $("#croppic-double").height( width_double * 343 / 510);
		// }, 1000);

	});
	function customValidate(_this){
		if( _this.is("select")){
			if( $(_this).find("option:selected").length == 0)
				return false;
			if( $(_this).find("option:selected").is("[disabled]"))
				return false;
		} else if( _this.is("input")){
			if( _this.is("[type=text]") || _this.is("[type=password]") || _this.is("[type=number]")){
				if( _this.val() == "")
					return false;
			}
		} else if( _this.is("textarea")){
			if( _this.val() == "")
				return false;
		}
		return true;
	}
	$("input[required]").change(function(){
		if( $(this).val() == ""){
			$(this).addClass("emptyRequire");
		} else{
			$(this).removeClass("emptyRequire");
		}
	});
	$("textarea[required]").change(function(){
		if( $(this).val() == ""){
			$(this).addClass("emptyRequire");
		} else{
			$(this).removeClass("emptyRequire");
		}
	});
	$("select[required]").change(function(){
		if( $(this).find("option:selected").is("[disabled]")){
			$(this).addClass("emptyRequire");
		} else{
			$(this).removeClass("emptyRequire");
		}
	});
	$("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
		var elmForm = $("#step-" + (stepNumber*1+1));
		// only on forward navigation, that makes easy navigation on backwards still do the validation when going next
		if( stepNumber == 5){ // step 6
			var arrCroppedImgs = elmForm.find("#croppic .croppedImg");
			if( arrCroppedImgs.length == 0){
				$("#croppic").addClass("emptyRequire");
				return false;
			}
			var imgCropped = arrCroppedImgs.eq(0);
			$("#croppedImgUrl").val(imgCropped.attr("src"));
			if( $('#ads_type_selected').val().indexOf("standard") == -1){
				var arrDoubleCroppedImgs = elmForm.find("#croppic-double .croppedImg");
				if( arrDoubleCroppedImgs.length == 0){
					$("#croppic-double").addClass("emptyRequire");
					return false;
				}
				$("#croppedImgUrlDouble").val(arrDoubleCroppedImgs.eq(0).attr("src"));
			}
		} else if( stepNumber == 6){

			var arrThumbImgInputs = $("input.classiera-input-file.imgInp");
			var isUploaded = false;
			for( var i = 0; i < arrThumbImgInputs.length; i++){
				var curInput = arrThumbImgInputs.eq(i);
				if( curInput.val() != ""){
					isUploaded = true;
				}
			}
			$("#mydropzone").addClass("emptyRequire");
			return isUploaded;
		} else{
			if(stepDirection === 'forward' && elmForm){
				var arrReqElems = elmForm.find('input,textarea,select').filter('[required]');
				var result = true;
				for( var i = 0; i < arrReqElems.length; i++){
					var curReqElem = arrReqElems.eq(i);
					if( customValidate(curReqElem) == false){
						curReqElem.addClass("emptyRequire");
						result = false;
					}
				}
				return result;
			}
			return true;
		}
	});