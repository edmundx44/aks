// toastr.options = {
// 	"closeButton": true,
// 	"newestOnTop": false,
// 	// "progressBar": true,
// 	"positionClass": "toast-bottom-right",
// 	"preventDuplicates": false,
// 	"onclick": null,
// 	"showDuration": "300",
// 	"hideDuration": "1000",
// 	"timeOut": "5000",
// 	"extendedTimeOut": "1000",
// 	"showEasing": "swing",
// 	"hideEasing": "linear",
// 	"showMethod": "fadeIn",
// 	"hideMethod": "fadeOut"
// }

// const delay = (ms) => {
// 	return new Promise((resolve) => {
// 		setTimeout(() => resolve(), ms);
// 	}, ms);
// };

// $(function() {
// 	logsNotification()

// 	function logsNotification(){
// 		var idToUpdate = '';
// 		var dataRequest =  {
// 			action: 'display-notification'
// 		}
	
// 		AjaxCall(url, dataRequest).done(function(data) {
// 			if(data != false){
// 				let task = delay(3000);
// 				var counter = 0

// 				data.forEach((element,i) => {
// 					task = task

// 					.finally(() => {
// 						switch (element.action) {
// 							case "Created": case "Edited": case "Deleted":
// 								var message = "<span> " + element.employee + "</span> <span> " + element.action + " an offer on</span> " + element.merchant + " " + element.site +".";
// 							break;
// 							case "Stock Update": case "Price Update":
// 									var message = "<span> " + element.employee + " do a</span> <span> " + element.action + " on</span> " + element.merchant + " " + element.site +".";
// 							break;
// 								default: var message = 'Action Not Found';
// 							break;
// 						}

// 						toastr.info(message);
// 						counter = counter + 1;

// 						var dataRequest =  {
// 							action: 'update-notification',
// 							id: element.id
// 						}
// 						AjaxCall(url, dataRequest).done(function(data) {});
// 						if(data.length == counter) logsNotification();
// 					})
// 					.then(() =>  delay(3000))
// 				});
// 			} else {
// 				// console.log(data)
// 				setTimeout( function(){ 
// 					logsNotification()
// 				}, 3000 );
// 			}
// 		});
// 	}
// });