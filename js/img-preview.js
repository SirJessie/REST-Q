$(document).ready(function(){
	const fileDialog = document.querySelector("#imgFile"),
	  img_preview = document.querySelector("#img-preview");

	fileDialog.addEventListener("change", function(){
		const file = this.files[0];
		
		if(file){
			const reader = new FileReader();

			reader.addEventListener("load",function(){
				console.log(this);
				img_preview.setAttribute("src",this.result);
			});
			reader.readAsDataURL(file);
		}
	});
});
