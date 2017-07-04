		var test;
		test = document.body.querySelectorAll(".buttonChat");
		
		for (i=0; i< test.length;i++)
		{

		test[i].addEventListener("click", function(e){
				
				this.parentNode.querySelectorAll(".subForm")[0].removeAttribute("hidden");
		});
		}



		function displayAndHide()
		{



		}

		var notification;
		notification = document.querySelectorAll("#notification h2");
		console.log(notification);

		if (notification[0].innerHTML != "")
		{
			document.querySelectorAll("#notification")[0].removeAttribute("hidden");
			
			setTimeout(function(){
				document.querySelectorAll("#notification")[0].setAttribute("hidden","true");
			},3000);
		}