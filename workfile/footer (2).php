 <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="http://www.themekita.com">
                    ThemeKita
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Help </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Licenses </a>
                </li>
              </ul>
            </nav>
            <div class="copyright">
              2024, made with <i class="fa fa-heart heart text-danger"></i> by
              <a href="#">DIGITAL IT LTD</a>
            </div>
          </div>
        </footer>
      </div>


    </div>
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	
    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>
	

	
<?php if(isset($IncludeDashbordScript )) { ?>	
	
    <script>
    
    //Chart

var ctx = document.getElementById('statisticsChart').getContext('2d');

var statisticsChart = new Chart(ctx, {
	type: 'line',
	data: {
		labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		datasets: [ {
			label: "Canceled Orders",
			borderColor: '#f3545d',
			pointBackgroundColor: 'rgba(243, 84, 93, 0.6)',
			pointRadius: 0,
			backgroundColor: 'rgba(243, 84, 93, 0.4)',
			legendColor: '#f3545d',
			fill: true,
			borderWidth: 2,
			data: [<?php
			$year = 2024;
            for ($month = 1; $month <= 12; $month++) {
                if($month == 12) {$cv = '';}else {$cv = ',';}
            echo $data = ord_count('ByDate',0,$month,$year,'Canceled').$cv; 
            }
			?>]
		}, {
			label: "All Orders",
			borderColor: '#fdaf4b',
			pointBackgroundColor: 'rgba(253, 175, 75, 0.6)',
			pointRadius: 0,
			backgroundColor: 'rgba(253, 175, 75, 0.4)',
			legendColor: '#fdaf4b',
			fill: true,
			borderWidth: 2,
			data: [<?php
			$year = date('Y');
            for ($month = 1; $month <= 12; $month++) {
                if($month == 12) {$cv = '';}else {$cv = ',';}
            echo $data = ord_count('ByDate',0,$month,$year,'0').$cv; 
            }
			?>]
		}, {
			label: "Completed Orders",
			borderColor: '#177dff',
			pointBackgroundColor: 'rgba(23, 125, 255, 0.6)',
			pointRadius: 0,
			backgroundColor: 'rgba(23, 125, 255, 0.4)',
			legendColor: '#177dff',
			fill: true,
			borderWidth: 2,
			data: [<?php
			$year = date('Y');
            for ($month = 1; $month <= 12; $month++) {
                if($month == 12) {$cv = '';}else {$cv = ',';}
            echo $data = ord_count('ByDate',0,$month,$year,'Completed').$cv; 
            }
			?>]
		}]
	},
	options : {
		responsive: true, 
		maintainAspectRatio: false,
		legend: {
			display: false
		},
		tooltips: {
			bodySpacing: 4,
			mode:"nearest",
			intersect: 0,
			position:"nearest",
			xPadding:10,
			yPadding:10,
			caretPadding:10
		},
		layout:{
			padding:{left:5,right:5,top:15,bottom:15}
		},
		scales: { 
			yAxes: [{
				ticks: {
					fontStyle: "500",
					beginAtZero: false,
					maxTicksLimit: 5,
					padding: 10
				},
				gridLines: {
					drawTicks: false,
					display: false
				}
			}],
			xAxes: [{
				gridLines: {
					zeroLineColor: "transparent"
				},
				ticks: {
					padding: 10,
					fontStyle: "500"
				}
			}]
		}, 
		legendCallback: function(chart) { 
			var text = []; 
			text.push('<ul class="' + chart.id + '-legend html-legend">'); 
			for (var i = 0; i < chart.data.datasets.length; i++) { 
				text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor + '"></span>'); 
				if (chart.data.datasets[i].label) { 
					text.push(chart.data.datasets[i].label); 
				} 
				text.push('</li>'); 
			} 
			text.push('</ul>'); 
			return text.join(''); 
		}  
	}
});
    
    var dailySalesChart = document.getElementById('dailySalesChart').getContext('2d');

var myDailySalesChart = new Chart(dailySalesChart, {
type: 'bar',  // Change from 'line' to 'bar'
data: {
    labels: [<?php
    for ($days = 1; $days <= 31; $days++) {
        
            if($days == 31) {$cv = '';}else {$cv = ',';}
        echo $days.$cv;    
        }?>] ,  // Labels updated to represent the days in a month
    datasets: [{
        label: "Orders",
        fill: true,
        backgroundColor: "rgba(255,255,255,0.2)",  // Adjust background color as needed
        borderColor: "#fff",
        borderCapStyle: "butt",
        borderDash: [],
        borderDashOffset: 0,
        pointBorderColor: "#fff",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "#fff",
        pointHoverBorderColor: "#fff",
        pointHoverBorderWidth: 1,
        pointRadius: 1,
        pointHitRadius: 5,
        data: [<?php
    for ($days = 1; $days <= 31; $days++) {
            if($days == 31) {$cvx = '';}else {$cvx = ',';} 
        echo $data = ord_count('ByDate',$days,10,2024,'Completed').$cvx; 
        }?>] 
               // Data for 31 days
    }]
},
	options : {
		maintainAspectRatio:!1, legend: {
			display: !1
		}
		, animation: {
			easing: "easeInOutBack"
		}
		, scales: {
			yAxes:[ {
				display:!1, ticks: {
					fontColor: "rgba(0,0,0,0.5)", fontStyle: "bold", beginAtZero: !0, maxTicksLimit: 10, padding: 0
				}
				, gridLines: {
					drawTicks: !1, display: !1
				}
			}
			], xAxes:[ {
				display:!1, gridLines: {
					zeroLineColor: "transparent"
				}
				, ticks: {
					padding: -20, fontColor: "rgba(255,255,255,0.2)", fontStyle: "bold"
				}
			}
			]
		}
	}
});
    
    </script>
 <?php } ?>   
    
    
    <script>
    
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
	  
	  
	  //Notify
/* $.notify({
	icon: 'icon-bell',
	title: 'eBazar',
	message: 'A Premium bazar',
}, {
    type: 'secondary',
    allow_dismiss: true,
    newest_on_top: false,
    placement: {
        from: "top",
        align: "right"
    },
    offset: 2,
    spacing: 2,
    z_index: 100000,
    delay: 1,
    timer: 2555,
    mouse_over: true,
    animate: {
        enter: 'animated fadeInDown',
        exit: 'animated fadeOutUp'
    }
});*/
function gen_js_notify(em,from = "bottom",align= "right",timex=700,Settime = 10,type="secondary",icon="icon-bell",title='eBazar'){
setTimeout(function() { 
$.notify({
	icon: icon,
	title: title,
	message: em,
},{
	type: type,
	placement: {
		from: from,
		align: align
	},
	delay: 10,
	timer: timex,
	animate: {
        enter: 'animated fadeInDown',
        exit: 'animated fadeOutRight'
    }
});
}, Settime);    
}



function delete_item(id,link,title){
		swal({
              title: "Are you sure?",
              text: title,
              type: "warning",
              buttons: {
                cancel: {
                  visible: true,
                  text: "No, cancel!",
                  className: "btn btn-danger",
                },
                confirm: {
                  text: "Yes, do it!",
                  className: "btn btn-success",
                },
              },
            }).then((willDelete) => {
              if (willDelete) {
				if(window.location.href = link+id){  
                swal("The commands completed successfully", {
                  icon: "success",
                  buttons: {
                    confirm: {
                      className: "btn btn-success",
                    },
                  },
                });
				}
              }/*  else {
                swal("Your imaginary file is safe!", {
                  buttons: {
                    confirm: {
                      className: "btn btn-success",
                    },
                  },
                });
              } */
            });
          
}

		jQuery(document).ready(function(){
		    
<?php if($page_ttl == 'Create Orders') {?>		    
		    		 $(document).keydown(function(e) {
    // Check if 'Ctrl' key and 'F' key are pressed
    if (e.ctrlKey && (e.key === "F" || e.key === "f")) {
        e.preventDefault();  // Prevent the default browser 'find' action
        $("input[name='product_name']").focus();  // Focus the input field
    }
});

$(document).keydown(function(e) {
    // Check if 'Ctrl' key and 'I' key are pressed
    if (e.ctrlKey && (e.key === "I" || e.key === "i")) {
        e.preventDefault();  // Prevent any default action, if necessary
        $("input[name='cu_phone']").focus();  // Focus the input field
    }
});


// item select by tab 

$(document).keydown(function(e) {
    // Check if 'Tab' key is pressed
    //if ($('.product_name').is(':focus') && e.key === "Tab") {
    if (e.key === "Tab") {
        e.preventDefault();  // Prevent the default Tab behavior
        
        // Get all buttons with class 'add_itm'
        var buttons = $(".add_itm");
        var focusedElement = $(document.activeElement);  // Get currently focused element

        // Find the index of the currently focused button
        var currentIndex = buttons.index(focusedElement);

        // Determine the next button to focus (loop back to the first button)
        var nextIndex = (currentIndex + 1) % buttons.length;

        // Focus the next button
        buttons.eq(nextIndex).focus();
    }
});


function NewOrd() {
// Render some text inside the element with the class 'r_token'
        $.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "ResetOrder": '1'
            	},
            	success: function(response) {
            	$(".r_token").html(response);
            	RefCart();
				Refcash_section();
				//$('.card').delay(10000).load();
				$( "html" ).replaceWith( data );
            	}	
					
			});	
        
}



$(document).keydown(function(e) {
    // Check if 'Ctrl' key and 'Enter' key are pressed
    if (e.ctrlKey && e.key === "Enter") {
        e.preventDefault();  // Prevent any default action, if necessary
       NewOrd();
        
    }
});


// Handle newMkOrder button click
$("#newMkOrder").click(function() {
     NewOrd();
});

// Handle newMkOrder button click
$("#ConfirmOrd").click(function() {
   var Discount = $("#Discount").val(); 
   var Paymentby = $("#inputState").val(); 
   var paymentNote = $("#paymentNote").val(); 
   var Given_amnt = $("#Given_amnt").val(); 
   var ordid = $("#ordid").html(); 
   var OrdAmnt = $("#OrdAmnt").html(); 
   $("#loaderx").css("display", "block");
   
 $.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "ConfirmOrd": '1',
                "Discount": Discount,
                "Paymentby": Paymentby,
                "paymentNote": paymentNote,
                "Discount": Discount,
                "ordrid": ordid,
                "Given_amnt": Given_amnt,
                "OrdAmnt": OrdAmnt
            	},
            	success: function(response) {
            	$("#cash_section").html(response);
            	RefCart();
				Refcash_section();
				NewOrd();
				$("#loaderx").css("display", "none");
				//$('.card').delay(10000).load();
				//$( "html" ).replaceWith( data );
            	}	
					
			});	    
    
console.log(Discount);   
    
});


$(document).keydown(function(e) {
    // Check if 'Enter' key is pressed
    if (e.key === "Enter") {
        // Check if the currently focused element has the class 'add_itm'
        if ($(document.activeElement).hasClass("add_itm")) {
            e.preventDefault();  // Prevent any default action
            $(document.activeElement).click();  // Trigger the click event
        }
    }
});


$(document).keydown(function(e) {
    // Check if 'Ctrl' key and 'Arrow Down' or 'Arrow Up' keys are pressed
    if (e.ctrlKey && (e.key === "ArrowDown" || e.key === "ArrowUp")) {
        e.preventDefault();  // Prevent any default action
        
        // Get all buttons with the class 'Remv_itm'
        var buttons = $(".Remv_itm");
        var focusedElement = $(document.activeElement);  // Get currently focused element

        // Find the index of the currently focused button
        var currentIndex = buttons.index(focusedElement);

        // Determine the next or previous button to focus
        if (e.key === "ArrowDown") {
            // Move focus to the next button (loop back to the first if at the end)
            var nextIndex = (currentIndex + 1) % buttons.length;
        } else if (e.key === "ArrowUp") {
            // Move focus to the previous button (loop to the last if at the beginning)
            var nextIndex = (currentIndex - 1 + buttons.length) % buttons.length;
        }

        // Focus the determined button
        buttons.eq(nextIndex).focus();
    }

    // Check if 'Enter' key is pressed while focused on a 'Remv_itm' button
    if (e.key === "Delete" && $(document.activeElement).hasClass("Remv_itm")) {
        e.preventDefault();  // Prevent any default action
        $(document.activeElement).click();  // Trigger the click event on the focused button
    }
});

				
				//var skdj = 'Pusti Soybean';
				var skdj = $(this).val();
				$(".product_nameX").on('change', function() {
				$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "str": skdj
            	},
            	success: function(response) {
            	$("#result").html(response);
            	}	
					
			});
			});
			
	

			
	 $(".Customer_Plus").click(function(){
           	var adnp = $(".cu_phone").val(); 
           	$(".adn_phone").val(adnp); 
           	
            $('#exampleModal').modal('show'); // Bootstrap's modal method
            
        });	
        
	 $(".onOrdAddUser").click(function(){
           	var adn_user = $(".adn_user").val(); 
           	var adn_phone = $(".adn_phone").val(); 
           	console.log('User: ' + adn_user);
           	console.log('Phone: ' + adn_phone);
           	
           		$.ajax({
            	type: 'POST',
            	url: 'bnm-add-user.php',
            	data: {
                "adn_user": adn_user,
                "adn_phone": adn_phone
            	},
            	success: function(response) {
            	$("#result").html(response);
            	}	
					
			});
            
        });			
		
	// Listen for keydown events in the input field
            $('.product_name').on('keydown', function(event) {
                // Check if the Enter key (key code 13) is pressed
                if (event.keyCode === 13) {
                    event.preventDefault(); // Prevent form submission
                    let barcodeValue = $(this).val(); // Get the scanned barcode
                    console.log('Barcode scanned: ' + barcodeValue);

                   
                   	$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "barcode": barcodeValue
            	},
            	success: function(response) {
            	$("#result").html(response);
            	}	
					
			});
                }
            });	
				
			
			
			
			
			function RefCart(){
			//$("#OrCtem").html('response');
			var cart_session = $("#Token").val();
			$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "RefreashCart": '1',
                "cart_session": cart_session
            	},
            	success: function(response) {
            	$("#OrCtem").html(response);
            	
            	}	
					
			});			
			}
			
			
			function Refcash_section(){
			//$("#OrCtem").html('response');
			var cart_session = $("#Token").val();
			$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "RefreashCash": '1',
                "cart_session": cart_session
            	},
            	success: function(response) {
            	$("#cash_section").html(response);
            	
            	var tempDiv = $('<div>').html(response);  // Create a temporary div to parse the response
                var ordidHTML = tempDiv.find("#ordid").html(); 
                var ordidAm = tempDiv.find("#OrdAmnt").html(); 
                var ordidItm = tempDiv.find("#ordItm").html(); 
                var OrdUserBlnc = tempDiv.find("#OrdUserBlnc").html(); 
                var OrdUserName = tempDiv.find("#OrdUserName").html(); 
            	
            	$(".cdOrd").html("ID:"+ordidHTML);
            	$(".cdAmnt").html(ordidAm);
            	$(".cdItm").html("Items:"+ordidItm);
            	$("#cu_balance").val(OrdUserBlnc);
            	$("#cu_name").val(OrdUserName);
            	
              	
            	}	
					
			});			
			}

$(document).keydown(function(e) {
    // Check if the 'Alt' key and 'P' key are pressed together
    if (e.altKey && e.key === "p") {
        e.preventDefault();  // Prevent any default action (optional)
        print_rst();
    }
});

			
$("#printButton").click(function() {
print_rst();
});
			
function print_rst(){
    // Open a new window and load print.php
    var printWindow = window.open("print.php", "PrintWindow", "width=800,height=600");

    // Wait for the new window to load, then trigger the print function
    printWindow.onload = function() {
        printWindow.focus();  // Focus on the new window
        printWindow.print();  // Trigger the print dialog
        
        // Add a delay to allow the print dialog to open before closing the window
        printWindow.onafterprint = function() {
            printWindow.close();  // Close the window after printing or canceling
        };
    };    
    
} 			
			
	$(document).on('click', '.ord_edt_btn', function() {
		var pid = $(this).val();
		var cart_session = $("#Token").val();
		var c_buy_unit = $("#c_buy_unit"+pid).val();
		var c_buy_unit_price = $("#c_buy_unit_price"+pid).val();
		var c_product_unit = $("#c_product_unit"+pid).val();
		$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "ord_edt_btn": pid,
                "ord_edt_buy_unit": c_buy_unit,
                "c_buy_unit_price": c_buy_unit_price,
                "c_product_unit": c_product_unit,
                "cart_session": cart_session
            	},
            	success: function(response) {
				$("#OrCtem").html(response);
				RefCart();
				Refcash_section();
				console.log(c_buy_unit)
            	}	
					
			});
		
		});		
			
		$(document).on('click', '.add_itm', function() {
		var pid = $(this).val();
		var cart_session = $("#Token").val();
		$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "AddToPCart": pid,
                "cart_session": cart_session
            	},
            	success: function(response) {
				$("#OrCtem").html(response);
				RefCart();
				Refcash_section();
            	}	
					
			});
		
		});
	  
	$(document).on('click', '.Remv_itm', function() {
		var CrtITmID = $(this).val();
		var cart_session = $("#Token").val();
		$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "RemoveFrmCrt": CrtITmID,
                "cart_session": cart_session
            	},
            	success: function(response) {
				$("#OrCtem").html(response);
				RefCart();
				Refcash_section();
            	}	
					
			});
		
		});
			
			jQuery(document).on('keyup', 'input.product_name', function(ev) {
				var skdj = $(this).val();
				var cart_session = $("#Token").val();
    
				$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "str": skdj,
                "cart_session": cart_session
            	},
            	success: function(response) {
            	$("#result").html(response);
				RefCart();
				Refcash_section();
            	}	
					
			});		
	
			});
			
			jQuery(document).on('keyup', 'input.Given_amnt', function(ev) {
			//$(document).on('click', '.Given_amnt', function() {
				var Given_amnt = $(this).val();
				var PAybl_amnt = $("#paybl_amnt").val();
				var ccng = Given_amnt-PAybl_amnt;
    			$("#amChange").html(ccng+" .TK");	
			});
	
			jQuery(document).on('keydown', 'input.cu_phone', function(ev) {
				var cu_phone = $(this).val();
				var cart_session = $("#Token").val();
    
				$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "UserPhone": cu_phone,
                "cart_session": cart_session
            	},
            	success: function(response) {
            	$("#datalistOptions").html(response);
				
            	}	
					
			});		
	
	});
	
	
	
	
	$(".cu_phone").keydown(function(e) {
    // Check if the right arrow key (keyCode 39) is pressed
    if (e.key === "ArrowRight") {
        e.preventDefault();  // Prevent default action if necessary
        // Your custom action when right arrow is pressed
        		var cu_phone = $(".cu_phone").val();
				var cart_session = $("#Token").val();
    
				$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "UpdateUser": cu_phone,
                "cart_session": cart_session
            	},
            	success: function(response) {
            	$("#cusIdRtn").html(response);
				Refcash_section();
            	}	
					
			});	
    }
});
	
	
	
	
	
	jQuery(document).on('keydown', function(e) {
    // Check if the focused element is the button with class 'your-button-class'
    if ($('.Customer_PlusX').is(':focus') && e.which === 13) {  // 13 is the key code for Enter
        e.preventDefault();  // Prevent default behavior of Enter (like form submission, if necessary)
        // Trigger button click or any other action
				var cu_phone = $(".cu_phone").val();
				var cart_session = $("#Token").val();
    
				$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "UpdateUser": cu_phone,
                "cart_session": cart_session
            	},
            	success: function(response) {
            	$("#cusIdRtn").html(response);
				Refcash_section();
            	}	
					
			});	
	   
	   
    }
	});
	
	Refcash_section();
	
	$(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  
  
      
    $(document).on('change', '#inputState', function() {    
        if ($(this).val() === "") {
            $('#inputState').show();  // Hide paymentNote if the selected value is empty
            $('#paymentNote').hide();  // Hide paymentNote if the selected value is empty
        } else {
            $('#inputState').hide(); 
            $('#paymentNote').show();  // Show paymentNote if a non-empty value is selected
        }
    });

  
		
			$('table tr').click( function() {
				var $chk = $(this).find('input[type=checkbox]');
				$chk.prop('checked',!$chk.prop('checked'));
				$(this).toggleClass('selected'); // To show something happened
			});
			
		
	<?php } ?>	
	
	
	  <?php if(isset($page_ttl) AND $page_ttl = 'Quantity Update') {?>     
	       // quantity-update.php
		// Listen for keydown events in the input field
            $('.QtBcode').on('keydown', function(event) {
                // Check if the Enter key (key code 13) is pressed
                if (event.keyCode === 13) {
                    event.preventDefault(); // Prevent form submission
                    let barcodeValue = $(this).val(); // Get the scanned barcode
                    console.log('Barcode scanned: ' + barcodeValue);

                   
                   	$.ajax({
            	type: 'POST',
            	url: 'bnm.php',
            	data: {
                "quantity_up_form": barcodeValue
            	},
            	success: function(response) {
            	$(".QtBcode").val('');
            	$("#UpdForm").html(response);
            	}	
					
			});
                }
            });	
			
	<?php } ?>
	
	
			});
    </script>
	
<?php if(isset($_GET['sa_nfy'])){echo "<script>gen_js_notify('".$_GET['sa_nfy']."')</script>";} ?>	
<?php if(isset($sa_nfy)){echo "<script>gen_js_notify('".$sa_nfy."')</script>";} ?>	
	
  </body>
</html>
